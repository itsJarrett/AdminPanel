<?php

include '../verifyPanel.php';
masterconnect();

$sql = "SELECT * FROM donations WHERE date_time < DATE_SUB(NOW(), INTERVAL 30 DAY) AND active = 1";
$result = mysqli_query($dbcon, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $uid = $row['uid'];

    $sql = "UPDATE donations SET active = 0 WHERE uid = $uid";
    mysqli_query($dbcon, $sql);

    $sql = "UPDATE players SET donorlevel = '0' WHERE pid = $uid";
    mysqli_query($dbcon, $sql);

}

$sql = "SELECT * FROM donations WHERE date_time < DATE_SUB(NOW(), INTERVAL 25 DAY) AND active = 1";
$result = mysqli_query($dbcon, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $to = $row['email'];
    $date = $row['date_time'];
    $subject = 'Abeloth Gaming - Donation';
    $message = "
<html>
<head>
  <title>Donation Status Ending Soon</title>
</head>
<body>
  <p>Hello, the donation you made on: $date is ending in 5 days.</p>
  <br>
  <p>If you would like to donate again, please visit our website at www.abeloth.com.</p>
</body>
</html>
";

// To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'From: Abeloth Gaming <donations@abeloth.com>';

// Mail it
    mail($to, $subject, $message, implode("\r\n", $headers));

}
