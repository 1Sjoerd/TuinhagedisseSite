<?php
$eventid = $_POST['eventid'];
$eventName = '';

$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eventid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventName = $row['title'];
    $eventDate = date("d-m-Y", strtotime($row['date']));
}

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bevestiging</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #0c4211;
            color: #ffffff;
        }
        table {
            border-spacing: 0;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            color: #333333;
        }
        td {
            padding: 20px;
        }
        .header {
            background-color: #36a141;
            text-align: center;
            padding: 10px 20px;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            background-color: #2b9435;
            text-align: center;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 14px;
        }
        .footer a {
            color: #ffffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td class="header">
                <img src="https://vvdetuinhagedisse.nl/assets/images/TuinhagedisseLogo.png" alt="Logo van V.V. de Tuinhagedisse">
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Beste <?php echo $_POST['firstname']; ?>,</p>
                <p>Hartelijk dank veur <?php if ($_POST['amount_people'] > 1) { echo "uch"; } else { echo "dien"; } ?> insjrieving veur de <?php echo $eventName; ?>! Veer kieke der nao oet <?php if ($_POST['amount_people'] > 1) { echo "uch"; } else { echo "dich"; } ?> te zeen op: <?php echo $eventDate; ?></p>
                <p>Höbt geer nog vraoge? Naem den gerust kóntak mit os op.</p>
                <p>Groet,
                VV de Tuinhagedisse</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>
                    <a href="https://www.facebook.com/vvdetuinhagedisse" target="_blank">Facebook</a> | 
                    <a href="https://www.instagram.com/vvdetuinhagedisse/" target="_blank">Instagram</a>
                </p>
                <p>© 2024 V.V. de Tuinhagedisse</p>
            </td>
        </tr>
    </table>
</body>
</html>
<?php
$message = ob_get_clean();
include './confirmationTemplate.php';
?>