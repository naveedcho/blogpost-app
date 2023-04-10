<?php
    require_once 'twitterdblogin.php';
    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error) die ("Fatal error.");

    $tweet = $_POST['newentry'];
    $query = "INSERT INTO `TWEETS` (`tweet`) VALUES ('$tweet');";

    $result = $connection->query($query);
    if (!$result) die("Fatal error");

    $result->close();
    $connection->close();
?>