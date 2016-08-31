<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/31/16
 * Time: 11:50 AM
 */

require_once 'PersistentDatastore.php';
require_once 'Database.php';
$pd = new PersistentDatastore("current_puzzle");
if($pd->containsKey("puzzle")){
    $puzzle = $pd->get("puzzle");
    $ptitle = $pd->get("title");
    $pimage = $pd->get("image");
}else{
    $pd->set("puzzle", null);
    $pd->set("title", null);
    $pd->set("image", null);
}
if($puzzle){
    $sql = "SELECT username, maxlevel FROM ". $puzzle . " ORDER BY maxlevel DESC;";
    $stmt = Database::connect()->prepare($sql);
    $stmt->bindParam(":puzzle", $puzzle);
    $stmt->execute();
    $leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<h3>Current Puzzle &middot; <span><?=$ptitle?></span></h3>
<hr>

<div class="container-fluid" style="padding-left: 0; font-size: 25px">
    <div class="col-sm-6">
        <h4 class="text-inset" style="font-size: 30px">Leaderboard</h4>
        <ol>
            <?php

            foreach($leaderboard as $user){
                echo "<li><a href='/?find=". $user['username'] . "'>" . $user['username'] . "</a>     " . $user['maxlevel'] . "</li><br>";
            }

            ?>
        </ol>
    </div>
    <div class="col-sm-6">
        <img class="img-rounded" style="float:right; width: 150px; height: 150px" src="/assets/img/<?=$pimage?>"/>
    </div>


</div>

