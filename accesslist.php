<!DOCTYPE html>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="common.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">

        <meta charset="UTF-8">
        <title>SHORT ME</title>
    </head>
    <body>
        <?php
            error_reporting(E_ALL & ~ E_NOTICE);
            function makeInputSafer($data)
            {
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>

        <div class="tablelist" style='font-size: 30px;'>
            <div class='tablelist-row' style='color: black; font-size: 40px;'>
                <div class='tablelist-cell'>shorturl</div>
                <div class='tablelist-cell'>IP</div>
                <div class='tablelist-cell'>timestamp</div>
            </div>
            <div class='tablelist-row'>
                <div class='tablelist-cell'></div>
                <div class='tablelist-cell' style='height: 30px;'></div>
                <div class='tablelist-cell'></div>
            </div>

            <?php
                error_reporting(E_ALL & ~ E_NOTICE);

                $pdo_q = new PDO("mysql:host=localhost;dbname=shortme;charset=utf8mb4", "root", "secret");
                $q = "SELECT * FROM `accesslog` ORDER BY `timestamp` DESC";
                foreach($pdo_q->query($q) as $rows)
                {
                    echo "<div class='tablelist-row'>";
                    echo "<div class='tablelist-cell'>".$rows['shorturl']."</div>";
                    echo "<div class='tablelist-cell'>".$rows['ip']."</div>";
                    echo "<div class='tablelist-cell unix'>".$rows['timestamp']."</div>";
                    echo "</div>";
                }
            ?>

        </div>

        <script>
            $(".unix").each(function (){
                let t = $(this).text();
                $(this).text( timeConverter(t) );
            });
        </script>


    </body>
</html>