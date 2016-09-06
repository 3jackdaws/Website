<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 9/5/2016
 * Time: 1:08 PM
 */

?>

<html>
<head>
    <title>Algorithms Club</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/css/search_user.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body style="background-color: #eee">

<div class="container">
    <div class="col-lg-12">
        <div class="card">
            <center>
                <h1 style="font-size: 3.5em; font-weight: 100">AA Testing</h1>
            </center>

        </div>

    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="list-group">
                <a onclick="runAllTests()" href="#" class="list-group-item list-group-item-heading"><b>Run all tests</b></a>
            <?php
            $files = glob("./tests/*");
            foreach ($files as $testfile){
                echo "<a href='#' name=\"test\" onclick='runTest(\"". basename($testfile) . "\", this)' class='list-group-item'>" . basename($testfile) . "</a>";
            }
            ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div id="console" class="card" style="color: #CCC; background-color: #333; font-family: monospace; height: 70vh; overflow-y: scroll;">
        </div>
    </div>
</div>
</body>
<script>
    function runAllTests(){
        var tests = document.getElementsByName("test");
        for(var i = 0; i<tests.length; i++){
            runTest(tests[i].innerHTML, tests[i]);
        }
    }

    function runTest(testScript, element){
        var base = "/assets/php/components/test_wrapper.php?test=";
        var div = element;
        div.style.fontWeight = "bold";
        get(base + testScript, "", function (data, responsetype) {
            var newstuff = "";
            newstuff += "<span style=\"color: #fff\">" + testScript + "</span> &middot; ";
            if(responsetype == 500){
                div.className += " list-group-item-danger";
                newstuff += "<span style=\"color: #FF5555\">Test Failed</span><br>";
            }
            else if(responsetype == 200){
                div.className += " list-group-item-success";
                newstuff += "<span style=\"color: #55FF55\">Test Succeeded</span><br>";
            }

            newstuff+= data + "<hr style='border-color: #444'>";

            document.getElementById("console").innerHTML = newstuff + document.getElementById("console").innerHTML
        })
    }

    function get(resource, parameters, callback){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4){
                callback(xhr.responseText, xhr.status);
            }
        };
        xhr.open("GET", resource + parameters, true);
        xhr.send();
    }
</script>
