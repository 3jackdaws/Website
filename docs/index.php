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
<body style="background-color: #eee; min-height: 100%;">
    <div class="container" style="min-height: 100%">
        <div class="col-lg-12 nopad" style="">
            <div class="card" style="margin-top: 40px; padding: 30px;">
                <center><h1 style="font-size: 3.5em; font-weight: 100">Help Documents</h1></center>
            </div>
        </div>
        <div class="col-lg-4 nopad">
            <div class="card" style="padding: 20px 50px 20px 50px; ">
                <h3>Directory</h3>
                <hr>
                <ul>
                    <?php
                    $link_file = file_get_contents("https://raw.githubusercontent.com/wiki/AutonomousAlgorithms/Documentation/Home.md");
                    preg_match_all("#(?<=\[\[).+?(?=\]\])#", $link_file, $links);
                    foreach ($links[0] as $link){
                        echo "<a href='#' onclick='getdoc(\"" . $link . "\")'>" . $link . "</a>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-8 nopad" >
            <div id="content" class="card" style="padding: 20px 50px 20px 50px; ">
                <h3>Welcome to the Help Pages</h3>
                The documents on the left should help you get started solving puzzles.
            </div>
        </div>

    </div>
    <a href="/" class="circle" style="position: fixed; top: 0; left: 0;background-color: #1E90FF; margin: 10%; margin-top: 50px; width: 50px; height: 50px; box-shadow: 1px 1px 5px rgba(0,0,0,.5); border: 1px solid white">
        <span class="glyphicon glyphicon-home" style="font-size: 2em; color: white; margin: 20%;"></span>
    </a>


</body>
<script>
    function getdoc(res){
        var xhr = new XMLHttpRequest();
        var link = res.replace(/ /g, "-");
        var title = link.replace(/-/g, " ");
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
                var cdiv = document.getElementById("content");
                cdiv.innerHTML = "<h2>" + title + "</h2><hr>";
                cdiv.innerHTML += xhr.responseText;
                document.title = title;
            }
        };
        xhr.open("GET", "/docs/get_wiki.php?page="+ link);
        xhr.send();
    }

    window.onload = function () {
        var doc = "<?=$doc?>";
        if(doc.length > 2){
            getdoc(doc);
        }
    }

</script>
<script src="/assets/js/bootstrap.js"
</html>
