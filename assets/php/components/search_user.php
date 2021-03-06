<?php
/**
 * Created by PhpStorm.
 * User: Cryotech
 * Date: 8/31/2016
 * Time: 1:04 PM
 */
require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php/StdHeader.php';
require_once 'Database.php';


function searchDatabase($user)
{
    $wild_user = '%' . $user . '%';
    $found_users = array(null);
    foreach (PUZZLE_TABLES as $table)
    {
        $sql = "SELECT username FROM " . $table . " WHERE username LIKE :user LIMIT 5;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":user", $wild_user);
        $stmt->execute();
        if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
            foreach ($result as $player)
                array_push($found_users, $player['username']);
    }
    unset($found_users[0]); // Remove null element
    $found_users = array_unique($found_users);
    if (sizeof($found_users) == 1)
        searchExact($found_users[1]);
    else
        foreach ($found_users as $player)
            echo "<form style='display: inline; margin: 0 auto;' action='' method='get'>
                    <input class='result-link' type='submit' name='find' value=" . $player . " />
                </form>";

    return (sizeof($found_users) == 0 ? false : $found_users);
}

function searchExact($user)
{
    echo "<div style='text-align: left;'><p class='result-head'>" . $user . "</p><br />";
    foreach (PUZZLE_TABLES as $table)
    {
        $sql = "SELECT maxlevel FROM " . $table . " WHERE username=:user;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":user", $user);
        $stmt->execute();
        if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
            foreach ($result as $player)
                echo "<div class='result'><span>" . $table . " - " . ($player['maxlevel'] === null ? 0 : $player['maxlevel']) .
                    "</span><span style='float: right;'>#" . findRank($user, $table) . "</span></div>";
    }
    echo "</div>";
}

function findRank($user, $puzzle)
{
    $sql = "SELECT username, maxlevel FROM " . $puzzle . " ORDER BY maxlevel DESC";
    $stmt = Database::connect()->prepare($sql);
    $stmt->bindparam(":user", $user);
    $stmt->execute();
    $prev_level = -1;
    $rank = 0;
    if ($result = $stmt->FetchAll(PDO::FETCH_ASSOC))
        foreach ($result as $player)
        {
            if ($player['maxlevel'] != $prev_level)
            {
                $prev_level = $player['maxlevel'];
                $rank += 1;
            }
            if ($player['username'] == $user) return $rank;
        }
}

echo '<link rel="stylesheet" href="/assets/css/search_user.css">';

if (isset($_GET['find']) and $_GET['find'] !== '')
{
    $result = searchDatabase($_GET['find']);
    if (!$result) echo "<p class='result'>Player not found!</p>";
}
                