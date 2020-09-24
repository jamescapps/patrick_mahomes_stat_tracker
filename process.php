<?php

    require_once("./config.php");

    class API {
        public $result = array('error' => false);

        function selectAllData() {

            $games = array();

            $db   = new Connect;
            $sql  = $db -> prepare("SELECT * FROM games ORDER BY id");
            $sql -> execute();

            while ($outputData = $sql -> fetch(PDO::FETCH_ASSOC)) {

                $games[$outputData["id"]] = array(

                    "id"         => $outputData["id"],
                    "date"       => $outputData["date"],
                    "week"       => $outputData["week"],
                    "opp"        => $outputData["opp"],
                    "result"     => $outputData["result"],
                    "score"      => $outputData["score"],
                    "comp"       => $outputData["comp"],
                    "att"        => $outputData["att"],
                    "compPerc"   => $outputData["compPerc"],
                    "yds"        => $outputData["yds"],
                    "td"         => $outputData["td"],
                    "int"        => $outputData["ints"],
                    "rate"       => $outputData["rate"],
                    "rushyds"    => $outputData["rushyds"]

                );
            }

            return json_encode($games);
        }

        function addGame() {

            $date     = $_POST["date"];
            $week     = $_POST["week"];
            $opp      = $_POST["opp"];
            $result   = $_POST["result"];
            $score    = $_POST["score"];
            $comp     = $_POST["comp"];
            $att      = $_POST["att"];
            $compPerc = $_POST["compPerc"];
            $yds      = $_POST["yds"];
            $td       = $_POST["td"];
            $int      = $_POST["int"];
            $rate     = $_POST["rate"];
            $rushyds  = $_POST["rushyds"];

            $db  = new Connect;
            $sql = $db -> query("INSERT INTO games (date, week, opp, result, score, comp, att, compPerc, yds, td, ints, rate, rushyds)
                                 VALUES('$date', '$week', '$opp', '$result', '$score', '$comp', '$att', '$compPerc', '$yds', '$td', '$int', '$rate', '$rushyds')");

            return $sql ? "Game added successfully!" : "Failed to add game...";

        }

        function updateGame() {

            $id       = $_POST["id"];
            $date     = $_POST["date"];
            $week     = $_POST["week"];
            $opp      = $_POST["opp"];
            $result   = $_POST["result"];
            $score    = $_POST["score"];
            $comp     = $_POST["comp"];
            $att      = $_POST["att"];
            $compPerc = $_POST["compPerc"];
            $yds      = $_POST["yds"];
            $td       = $_POST["td"];
            $int      = $_POST["int"];
            $rate     = $_POST["rate"];
            $rushyds  = $_POST["rushyds"];

            $db = new Connect;
            $sql = $db -> query("UPDATE games SET

                                 date     = '$date',
                                 week     = '$week',
                                 opp      = '$opp',
                                 result   = '$result',
                                 score    =  '$score',
                                 comp     = '$comp',
                                 att      = '$att',
                                 compPerc = '$compPerc',
                                 yds      = '$yds',
                                 td       = '$td',
                                 ints     = '$int',
                                 rate     = '$rate',
                                 rushyds  = '$rushyds'

                                 WHERE id = '$id'
                                 ");
                                 
            return $sql ? "Game updated successfully!" : "Failed to update game...";

        }

        function deleteGame() {

            $id = $_POST["id"];

            $db    = new Connect;
            $sql  = $db -> query("DELETE FROM games WHERE id = '$id'");
            
            return $sql ? "Game deleted successfully!" : "Failed to delete game...";

        }
    }


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