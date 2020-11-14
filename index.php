<!DOCTYPE html>
<html>
    <head>
        <script src="jquery-1.7.min.js"></script>
        <script src="common.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">

        <meta charset="UTF-8">
        <title>Task System</title>
    </head>
    <body>
        <?php
            error_reporting(E_ALL & ~ E_NOTICE);
        ?>

    <div class='shortnew'>
    <div class='main_cta'>SHORT your URL</div>
    <div class='shortnew_input'>
       <input type='text' placeholder='Paste a link here to shorten' id='longurltext' />
       <button id='shortbut'>SHORT URL</button>
    </div>
    <div id='short_result'>
        <p id='result_long'>long url</p>
        <p style='display:block;'>
            <div id='result_short'>short url</div>
            <button id='result_copy'>COPY</button>
        </p>
    </div>
    </div>

    <script>
        function copyToClipboard(elem)
        {
                // create hidden text element, if it doesn't already exist
            var targetId = "_hiddenCopyText_";
            var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
            var origSelectionStart, origSelectionEnd;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    var target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);
            
            // copy the selection
            var succeed;
            try {
                    succeed = document.execCommand("copy");
            } catch(e) {
                succeed = false;
            }
            // restore original focus
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }

            if (isInput) {
                // restore prior selection
                elem.setSelectionRange(origSelectionStart, origSelectionEnd);
            } else {
                // clear temporary content
                target.textContent = "";
            }
            return succeed;
        }

        function initDefaultPage()
        {
            $("#longurltext").keyup(function(e)
            {
                var code = e.keyCode || e.which;
                if(code == 13) { //Enter keycode
                    $("#shortbut").click();
                }
            });

            $('#shortbut').click(function()
            {
                let _longurl = $("#longurltext").val();
                let _title = "some title";
                let _notes = "some notes";

                $.post( 'add_pair.php' , {securitytoken: '<?php include 'sec_token.php'; ?>', baseurl: _longurl, title: _title, notes: _notes}).done(function( data )
                {
                    let sshort = window.location.protocol + "//" + window.location.hostname + window.location.pathname + "r/?r=" + data;

                    $("#short_result").fadeIn();
                    $("#result_long").text($("#longurltext").val());
                    $("#result_short").html("<a href='"+sshort+"' target='_blank'>"+sshort+"</a>");

                    $("#result_copy").click(function(){
                        copyToClipboard(document.getElementById("result_short"));
                    });
                    
                });

            });
            
        }

        $(document).ready(function(){
            initDefaultPage();
        });
    </script>

        

    </body>
</html>