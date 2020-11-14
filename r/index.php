<!DOCTYPE html>
<html>
    <head>
        <script src="../jquery-1.7.min.js"></script>
        <script src="../common.js"></script>

        <meta charset="UTF-8">
        <title>SHORT ME</title>
    </head>
    <body>


        <?php
            error_reporting(E_ALL & ~ E_NOTICE);
            session_start();

            function makeInputSafer($data)
            {
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            echo "rpage";

            if (isset($_GET['r']) && !empty($_GET['r']))
            {
                echo "
                <script>
                var _key = '".makeInputSafer($_GET['r'])."';
                $.post( '../get_url.php' , {r: _key}).done(function( data )
                {
                    if (!isEmpty(data) && !isBlank(data))
                    {
                        $.post( 'add_access.php' , {short: _key}).done(function( data2 )
                        {
                            //alert(data2);
                        });
                        window.location = data;
                    }
                    else
                    {
                        window.location = window.location.protocol + '//' + window.location.hostname + window.location.pathname.split('r/')[0];
                    }
                });
                </script>
                ";
            }
            else
            {
                echo "
                <script>
                    window.location = window.location.protocol + '//' + window.location.hostname + window.location.pathname.split('r/')[0];
                </script>";
            }
            
            
        ?>

        

    </body>
</html>