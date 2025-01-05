<?php
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
                <p>Beste,</p>
                <p>Klik <a href="<?php echo $invite_link; ?>">hie</a> om dien wachwoord aan te make.</p>
                <p>Es de link neet werkt kint geer auch deze <?php echo $invite_link; ?> in ugge browser kopiëren.</p>
                <p>PS: De link is 7 daag geldig</p>
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
$mailmessage = ob_get_clean();
?>
