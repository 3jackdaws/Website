<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 9:09 AM
 */
$doc = $_GET['doc'];
?>
<html>
<head>
    <title>Algorithms Club - Docs</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body style="background-color: #eee">
    <div class="container">
        <div class="col-lg-12" style="">
            <div class="card" style="margin-top: 40px; padding: 30px;">
                <center><h1 style="font-size: 3.5em; font-weight: 100">Help Documents</h1></center>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card" style="padding: 20px 50px 20px 50px; margin-right: 0">
                <h3>Directory</h3>
                <hr>
                <ul>
                    <?php
                        $files = glob(__DIR__ . "/files/*");
//                    var_dump("/*", __DIR__ . "/files/");
//                    var_dump($files);
                        foreach($files as $file){
                            $handle = fopen($file, "r");
                            preg_match("/(?<=\>)[A-Za-z ]+(?=<)/", fread($handle, filesize($file)), $match);
                            $title = $match[0];
                            echo "<a onclick='openhelpdoc(\"". basename($file) ."\")'>" . $title . "</a>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-8" >
            <div id="content" class="card" style="padding: 20px 50px 20px 50px; margin-left:0">
                
            </div>
        </div>
    </div>

</body>
<script>
    function openhelpdoc(res){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
                document.getElementById("content").innerHTML = xhr.responseText;
            }
        }
        xhr.open("GET", "/docs/files/" + res);
        xhr.send();
    }

    window.onload = function(){
        var doc = "<?=$doc?>";
        if(doc.length < 2){
            doc = "how-to-join.html";
        }
        openhelpdoc(doc);
    }
</script>
<script src="/assets/js/bootstrap.js"
</html>
