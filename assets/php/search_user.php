<?php
/**
 * Created by PhpStorm.
 * User: Cryotech
 * Date: 8/31/2016
 * Time: 1:04 PM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once '/Database.php';
echo '<link rel="stylesheet" href="/assets/css/search_user.css">';

function searchDatabase($user)
{
    $wild_user = '%' . $user . '%';
    $dbi = Database::connect()->query("SHOW TABLES"); // Database Index
    $dbi->execute();
    $db = $dbi->fetchAll(PDO::FETCH_COLUMN); // Database
    $found_users = array(null);
    foreach ($db as $table)
    {
        if ($table == "ip_log" or $table == "users") unset($db[$table]);
        else
        {
            $sql = "SELECT username FROM " . $table . " WHERE username LIKE :user LIMIT 5;";
            $stmt = Database::connect()->prepare($sql);
            $stmt->bindParam(":user", $wild_user);
            $stmt->execute();
            if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
                foreach ($result as $player)
                    array_push($found_users, $player['username']);
        }
    }
    unset($found_users[0]); // Remove null element
    $found_users = array_unique($found_users);
    if (sizeof($found_users) == 1)
        searchExact($found_users[1]);
    else
        foreach ($found_users as $player)
            echo "<form style='display: inline; margin: 1em;' action='' method='get'>
                    <input class='result-link' type='submit' name='find' value=" . $player . " />
                </form>";

    return (sizeof($found_users) == 0 ? false : $found_users);
}

function searchExact($user)
{
    $dbi = Database::connect()->query("SHOW TABLES"); // Database Index
    $dbi->execute();
    $db = $dbi->fetchAll(PDO::FETCH_COLUMN); // Database
    echo "<div style='text-align: left;'><p class='result-head'>" . $user . "</p><br />";
    foreach ($db as $table)
    {
        if ($table == "ip_log" or $table == "users" or $table == "kv_store") unset($db[$table]);
        else
        {
            $sql = "SELECT maxlevel FROM " . $table . " WHERE username=:user;";
            $stmt = Database::connect()->prepare($sql);
            $stmt->bindParam(":user", $user);
            $stmt->execute();
            if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
                foreach ($result as $player)
                    echo "<p class='result'>" . $table . " - " . ($player['maxlevel'] === null ? 0 : $player['maxlevel']) . "</p><br />";
        }
    }
    echo "</div>";
}