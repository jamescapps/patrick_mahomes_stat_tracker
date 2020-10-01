 
<?php

    require_once("./process.php");

    $action = "";
    $API = new API;

    function getYear($action) {
        $target_url = json_encode(parse_url($action));
        $url = substr($target_url, strpos($target_url, "/") + 1);

        return substr($url, 0, -2);
    }

    if (isset($_GET['action'])) $action = $_GET['action'];

    if (strpos($action, "read") !== false) {
        $year = getYear($action);
        echo $API -> selectAllData($year);
    }

    if (strpos($action, "create") !== false) {
        $year = getYear($action);
        echo $API -> addGame($year);
    }

    if (strpos($action, "update") !== false) {
        $year = getYear($action);
        echo $API -> updateGame($year);
    }

    if (strpos($action, "delete") !== false) {
        $year = getYear($action);
        echo $API -> deleteGame($year);
    }
