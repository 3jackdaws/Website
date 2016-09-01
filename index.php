<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 9:09 AM
 */
require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php/StdHeader.php';
if (isset($_GET['find']))
{
    $query = $_GET['find'];
}
else
{
    $result = "";
}
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
    <div class="col-lg-12 nopad" style="">
        <div class="card" style="margin-top: 40px; padding: 30px;">
            <center>
                <h1 style="font-size: 3.5em; font-weight: 100">Autonomous Algorithms</h1>
                <h4>Sharpen your skills, solve puzzles with code</h4>
            </center>
        </div>
    </div>

    <div class="col-lg-4 nopad">
        <div class="card" style="padding: 20px 50px 20px 50px;">
            <h3>Links</h3>
            <hr>
            <ul>
                <!--                    <h4 class="section-header">Getting Started</h4>-->
                <?php
                $wiki_base = "https://raw.githubusercontent.com/wiki/AutonomousAlgorithms/Documentation/";
                $link_file = file_get_contents($wiki_base . "Home.md");
                preg_match_all("#(?<=\[\[).+?(?=\]\])#", $link_file, $links);
                foreach ($links[0] as $title)
                {
                    $link = str_replace(" ", "-", $title);
                    echo "<a href=\"/docs/?doc=" . $link . "\">" . $title . "</a>";
                }
                ?>
            </ul>
        </div>

        <!--        User search         -->
        <div class="card" style="padding: 20px 50px 20px 50px;">
            <h3>Search for player</h3>
            <hr>
            <form action="" method="get">
                <input class="form-control" name="find" placeholder="username"/>
            </form>
            <div id="search-results">
                <?php
                require_once "assets/php/search_user.php";
                if (isset($_GET['find']) and $_GET['find'] !== '')
                {
                    $result = searchDatabase($_GET['find']);
                    if (!$result) echo "<p class='result'>Player not found!</p>";
                }
                ?>
                <?=$results?>
            </div>
        </div>
        <div class="col-lg-8 nopad">
            <div class="card" style="padding: 20px 50px 20px 50px; ">

                <?php
                include "components/current_puzzle.php";
                ?>

            </div>
        </div>


    </div>

</body>

<script src="/assets/js/bootstrap.js"
</html>
