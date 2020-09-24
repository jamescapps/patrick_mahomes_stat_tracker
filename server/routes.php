<?php

require_once("./process.php");

    $action = "";

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }


    // Routes

    if ($action == "read") {

        $API = new API;
        header('Content-Type: application/json');

        echo $API -> selectAllData();

    }

    if ($action == "create") {

        $API = new API;
        header('Content-Type: application/json');

        echo $API -> addGame();
    }

    if ($action == "update") {

        $API = new API;
        header('Content-Type: application/json');

        echo $API -> updateGame();
    }

    if ($action == "delete") {
        
        $API = new API;
        header('Content-Type: application/json');

        echo $API -> deleteGame();

    }

?>