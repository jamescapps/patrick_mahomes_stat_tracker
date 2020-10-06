 
<?php

    require_once("./API.php");

    $action = "";
    $API    = new API;

    function getYear($action) {
        $target = json_encode(parse_url($action));
        $url    = substr($target, strpos($target, "/") + 1);

        return substr($url, 0, -2);
    }


    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }

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

    if (strpos($action, "totals") !== false) {
        $year = getYear($action);
        echo $API -> getTotals($year);
    }

    if (strpos($action, "averages") !== false) {
        $year = getYear($action);
        echo $API -> getAverages($year);
    }

    if (strpos($action, "results") !== false) {
        $year = getYear($action);
        echo $API -> getResults($year);
    }


