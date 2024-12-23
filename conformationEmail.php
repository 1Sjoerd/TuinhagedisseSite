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
      font-family: "Oswald", sans-serif;
      font-size: 18px;
      color: #333;
    }
    .container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #f9f9f9;
    }
    .header {
      background-color: rgb(43, 148, 53);
      color: white;
      padding: 10px 20px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      height: 100px;
    }
    .header h1 {
      margin: 0;
      flex-grow: 1;
      text-align: center;
    }
    .logo {
      max-width: 100px;
      position: absolute;
      left: 20px;
    }
    .content {
      padding: 20px;
    }
    .footer {
      background-color: rgb(43, 148, 53);
      color: white;
      padding: 10px;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="https://vvdetuinhagedisse.nl/assets/images/TuinhagedisseLogo.png" alt="Tuinhagedisse Logo" class="logo">
      <h1>Bevestiging</h1>
    </div>
    <div class="content">
      <p>Beste <?php echo $_POST['firstname']; ?>,</p>
      <p>Bie deze bevestigen veer det geer ug hubt aangemeld veur de <?php echo $eventName; ?> op:</p>
      <p><strong>Datum:</strong> <?php echo $eventDate; ?></p>
      <p>Bedank!</p>
    </div>
    <div class="footer">
      <p>Groet,</p>
      <p>VV de Tuinhagedisse</p>
    </div>
  </div>
</body>
</html>
<?php
$message = ob_get_clean();
echo $message;
?>