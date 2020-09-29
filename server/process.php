<?php

    require_once("./config.php");

    class API {

        function selectAllData($tableName) {
          
            $games = array();
            $db = new Connect;

            $sql  = $db -> prepare("SELECT * FROM $tableName ORDER BY id");
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

        // Need to adjust for all seasons
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
            $sql = $db -> prepare("INSERT INTO twentytwenty (
                                    date, 
                                    week, 
                                    opp, 
                                    result, 
                                    score, 
                                    comp, 
                                    att, 
                                    compPerc, 
                                    yds, 
                                    td, 
                                    ints, 
                                    rate, 
                                    rushyds
                                 )
                                 VALUES(
                                    '$date', 
                                    '$week', 
                                    '$opp', 
                                    '$result', 
                                    '$score', 
                                    '$comp', 
                                    '$att', 
                                    '$compPerc', 
                                    '$yds', 
                                    '$td', 
                                    '$int', 
                                    '$rate', 
                                    '$rushyds'
                                )
                                ");

            try {
                $sql -> execute();
                return "Game added successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }

        }

        // Need to adjust for all seasons
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
            $sql = $db -> prepare("UPDATE twentytwenty SET
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

            try {
                $sql -> execute();
                return "Game updated successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }

        }

        // Need to adjust for all seasons
        function deleteGame() {

            $id = $_POST["id"];

            $db   = new Connect;
            $sql  = $db -> prepare("DELETE FROM twentytwenty WHERE id = '$id'");
            
            try {
                $sql -> execute();
                return "Game deleted successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }
            
        }
    }

?>