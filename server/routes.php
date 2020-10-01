 
<?php

    require_once("./process.php");

    $action = "";
    $API = new API;

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }

    // Check for which season is wanting to be viewed based on url.
    if (strpos($action, "read") !== false) {;

        $target_url = json_encode(parse_url($action));
        $url = substr($target_url, strpos($target_url, "/") + 1);
        $year = substr($url, 0, -2);

        echo $API -> selectAllData($year);
    }

    if (strpos($action, "create") !== false) {;

        $target_url = json_encode(parse_url($action));
        $url = substr($target_url, strpos($target_url, "/") + 1);
        $year = substr($url, 0, -2);

        echo $API -> addGame($year);
    }

    if (strpos($action, "update") !== false) {;

        $target_url = json_encode(parse_url($action));
        $url = substr($target_url, strpos($target_url, "/") + 1);
        $year = substr($url, 0, -2);

        echo $API -> updateGame($year);
    }

    if (strpos($action, "delete") !== false) {;

        $target_url = json_encode(parse_url($action));
        $url = substr($target_url, strpos($target_url, "/") + 1);
        $year = substr($url, 0, -2);

        echo $API -> deleteGame($year);
    }

