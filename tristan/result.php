<?php
$paints = [
    "Sikkens Rubbol XD High Gloss" => ["duurzaamheid" => 10, "materiaal" => "Hout", "plek" => "Buiten", "aftrek_no" => 0, "aftrek_zw" => 0, "controle" => 0],
    "Sigma S2U Allure Gloss" => ["duurzaamheid" => 10, "materiaal" => "Hout", "plek" => "Buiten", "aftrek_no" => 0, "aftrek_zw" => 2, "controle" => 0],
    "Sikkens Alphaloxan Flex" => ["duurzaamheid" => 5, "materiaal" => "Beton/Muren", "plek" => "Buiten", "aftrek_no" => 0, "aftrek_zw" => 0, "controle" => 2],
    "Sikkens REDOX PUR FINISH HIGH GLOSS" => ["duurzaamheid" => 6, "materiaal" => "Staal", "plek" => "Buiten", "aftrek_no" => 0, "aftrek_zw" => 0, "controle" => 0],
    "Sigma Sigma Pearl Clean Semi-Matt" => ["duurzaamheid" => 7, "materiaal" => "Muren", "plek" => "Binnen", "aftrek_no" => "nvt", "aftrek_zw" => "nvt", "controle" => 0]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new_paint_name'])) {
        foreach ($_POST['new_paint_name'] as $index => $name) {
            $paints[$name] = [
                "duurzaamheid" => $_POST['new_paint_durability'][$index],
                "materiaal" => $_POST['new_paint_material'][$index],
                "plek" => $_POST['new_paint_location'][$index],
                "aftrek_no" => $_POST['new_paint_aftrek_no'][$index] ?? 0,
                "aftrek_zw" => $_POST['new_paint_aftrek_zw'][$index] ?? 0,
                "controle" => $_POST['new_paint_control'][$index]
            ];
        }
    }

    $surfaces = $_POST['surface'];
    $paints_selected = $_POST['paint'];
    $locations = $_POST['location'];
    $directions = $_POST['direction'];
    $last_maintenances = $_POST['last_maintenance'];

    $results = [];
    foreach ($surfaces as $index => $surface) {
        $paint = $paints_selected[$index];
        if (!isset($paints[$paint])) {
            echo "Verfsoort niet gevonden: " . htmlspecialchars($paint);
            continue;
        }

        $location = $locations[$index];
        $direction = $directions[$index];
        $last_maintenance = $last_maintenances[$index];
        
        $paint_info = $paints[$paint];
        $duurzaamheid = $paint_info["duurzaamheid"];
        $controle_interval = $paint_info["controle"];

        if ($paint_info["plek"] == "Buiten") {
            if ($direction == "noord-oost") {
                $duurzaamheid -= $paint_info["aftrek_no"];
            } elseif ($direction == "zuid-west") {
                $duurzaamheid -= $paint_info["aftrek_zw"];
            }
            
            if ($paint_info["materiaal"] == "Hout") {
                $duurzaamheid -= 2;
                $controle_interval = 3;
            } elseif ($paint_info["materiaal"] == "Staal") {
                $duurzaamheid -= 1;
            } elseif (in_array($paint_info["materiaal"], ["Beton/Muren", "Muren"])) {
                $duurzaamheid -= 2;
                $controle_interval = 5;
            }
        } else {
            if ($paint_info["materiaal"] == "Hout") {
                $controle_interval = 5;
            } elseif ($paint_info["materiaal"] == "Staal") {
                $controle_interval = 4;
            } elseif (in_array($paint_info["materiaal"], ["Beton/Muren", "Muren"])) {
                $controle_interval = 3;
            }
        }

        if (in_array($location, ["Horeca", "Openbare ruimtes", "Industrie"])) {
            $controle_interval = 1;
        }

        $last_date = new DateTime($last_maintenance);
        $maintenance_interval = new DateInterval('P' . $duurzaamheid . 'Y');
        $next_maintenance = clone $last_date;
        $next_maintenance->add($maintenance_interval);
        $next_maintenance_formatted = $next_maintenance->format('Y-m-d');

        $controle_interval_str = 'P' . $controle_interval . 'Y';
        $next_control = clone $last_date;
        $next_control->add(new DateInterval($controle_interval_str));
        $next_control_formatted = $next_control->format('Y-m-d');

        $results[] = [
            "surface" => $surface,
            "paint" => $paint,
            "location" => $location,
            "last_maintenance" => $last_maintenance,
            "next_maintenance" => $next_maintenance_formatted,
            "next_control" => $next_control_formatted
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Herschildering & Controle Tool</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Herschildering & Controle Tool</h1>
        <?php foreach ($results as $result): ?>
            <div class="result-section">
                <h3><?php echo htmlspecialchars($result["surface"]); ?></h3>
                <p>Verfsoort: <?php echo htmlspecialchars($result["paint"]); ?></p>
                <p>Locatie: <?php echo htmlspecialchars($result["location"]); ?></p>
                <p>Laatste onderhoudsdatum: <?php echo htmlspecialchars($result["last_maintenance"]); ?></p>
                <p>Volgende onderhoudsdatum: <?php echo htmlspecialchars($result["next_maintenance"]); ?></p>
                <p>Volgende controledatum: <?php echo htmlspecialchars($result["next_control"]); ?></p>
            </div>
        <?php endforeach; ?>
        <form action="pdf.php" method="post">
            <?php foreach ($results as $result): ?>
                <input type="hidden" name="surface[]" value="<?php echo htmlspecialchars($result["surface"]); ?>">
                <input type="hidden" name="paint[]" value="<?php echo htmlspecialchars($result["paint"]); ?>">
                <input type="hidden" name="location[]" value="<?php echo htmlspecialchars($result["location"]); ?>">
                <input type="hidden" name="last_maintenance[]" value="<?php echo htmlspecialchars($result["last_maintenance"]); ?>">
                <input type="hidden" name="next_maintenance[]" value="<?php echo htmlspecialchars($result["next_maintenance"]); ?>">
                <input type="hidden" name="next_control[]" value="<?php echo htmlspecialchars($result["next_control"]); ?>">
            <?php endforeach; ?>
            <input type="submit" value="Download PDF">
        </form>
    </div>
</body>
</html>
