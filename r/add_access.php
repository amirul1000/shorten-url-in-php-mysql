<?php
    error_reporting(E_ALL & ~ E_NOTICE);

    function makeInputSafer($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    if (    isset($_POST['short']) && !empty($_POST['short'])    )
    {
        $pdo_query = new PDO("mysql:host=localhost;dbname=shortme;charset=utf8mb4", "root", "secret");
        $stmt = $pdo_query->prepare('INSERT INTO `accesslog` (`id`, `shorturl`, `ip`, `timestamp`) VALUES (NULL, :sqlshorturl, :sqlip, :sqltimestamp);');

        $in_shorturl = makeInputSafer($_POST['short']);

        $muhDate = new DateTime();
        $muhTimeStamp = $muhDate->getTimestamp();

        $stmt->execute([':sqlshorturl' => $in_shorturl, ':sqlip' => $_SERVER['REMOTE_ADDR'], ':sqltimestamp' => $muhTimeStamp]);

        echo $_SERVER['REMOTE_ADDR'];
    }


?> 