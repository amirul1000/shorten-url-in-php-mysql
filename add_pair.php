<?php
    error_reporting(E_ALL & ~ E_NOTICE);

    function makeInputSafer($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    if (isset($_POST['securitytoken']) && $_POST['securitytoken'] == "65d81169-e0db-4e33-b706-7f3b0b14bc88")
    {
        if (    isset($_POST['baseurl']) && !empty($_POST['baseurl'])    )
        {
            $pdo_query = new PDO("mysql:host=localhost;dbname=shortme;charset=utf8mb4", "root", "secret");
            $stmt = $pdo_query->prepare('INSERT INTO `urlmap` (`id`, `baseurl`, `shorturl`, `notes`, `title`) VALUES (NULL, :sqlbaseurl, :sqlshorturl, :sqlnotes, :sqltitle);');

            $myroot = $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
            $myroot = explode("add_pair.php", $myroot)[0];

            $in_baseurl  = makeInputSafer($_POST['baseurl']);
            //$in_shorturl = "http://".$myroot."?r=".generateRandomString();
            $in_shorturl = generateRandomString();
            $in_notes = makeInputSafer($_POST['notes']);
            $in_title = makeInputSafer($_POST['title']);

            if (!startsWith( $in_baseurl, "http" ) )
            {
                $in_baseurl = "http://".$in_baseurl;
            }

            //$muhDate = new DateTime();
            //$muhTimeStamp = $muhDate->getTimestamp();

            $stmt->execute([':sqlbaseurl' => $in_baseurl, 
            ':sqlshorturl' => $in_shorturl, 
            ':sqlnotes' => $in_notes, 
            ':sqltitle' => $in_title]);

            echo $in_shorturl;
        }
    }


?> 