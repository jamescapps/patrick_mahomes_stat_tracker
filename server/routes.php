<?php

    require_once("./process.php");

    $action = "";
    $API = new API;

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }

    if ($action == "read") {
        echo $API -> selectAllData();
    }

    if ($action == "create") {
        echo $API -> addGame();
    }

    if ($action == "update") {
        echo $API -> updateGame();
    }

    if ($action == "delete") {
        echo $API -> deleteGame();
    }

?>