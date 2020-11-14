<?php
    function makeInputSafer($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    if (isset($_POST['r']) && !empty($_POST['r']))
    {
        error_reporting(E_ALL & ~ E_NOTICE);

        $pdo_r = new PDO("mysql:host=localhost;dbname=shortme;charset=utf8mb4", "root", "secret");
        $r = makeInputSafer($_POST['r']);
        $q = "SELECT * FROM `urlmap` WHERE `shorturl` = '$r';";
        //echo $q;
        foreach($pdo_r->query($q) as $rows)
        {
            echo $rows['baseurl'];
        }
    }
?> 