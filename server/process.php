<?php

    require_once("./config.php");

    class API {

        public function selectAllData($tableName) {
          
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
        public function addGame() {

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
            $ints      = $_POST["int"];
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
                                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $sql -> bindParam(1,  $date,     PDO::PARAM_STR);
            $sql -> bindParam(2,  $week,     PDO::PARAM_STR);
            $sql -> bindParam(3,  $opp,      PDO::PARAM_STR);
            $sql -> bindParam(4,  $result,   PDO::PARAM_STR);
            $sql -> bindParam(5,  $score,    PDO::PARAM_STR);
            $sql -> bindParam(6,  $att,      PDO::PARAM_INT);
            $sql -> bindParam(7,  $comp   ,  PDO::PARAM_INT);
            $sql -> bindParam(8,  $compPerc, PDO::PARAM_INT);
            $sql -> bindParam(9,  $yds,      PDO::PARAM_INT);
            $sql -> bindParam(10, $td,       PDO::PARAM_INT);
            $sql -> bindParam(11, $ints,     PDO::PARAM_INT);
            $sql -> bindParam(12, $rate ,    PDO::PARAM_STR);
            $sql -> bindParam(13, $rushyds,  PDO::PARAM_INT);

            try {
                $sql -> execute();
                return "Game added successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }

        }

        // Need to adjust for all seasons
        public function updateGame() {

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
            $ints      = $_POST["int"];
            $rate     = $_POST["rate"];
            $rushyds  = $_POST["rushyds"];

            $db = new Connect;
            $sql = $db -> prepare("UPDATE twentytwenty SET
                                 date     = ?,
                                 week     = ?,
                                 opp      = ?,
                                 result   = ?,
                                 score    = ?,
                                 comp     = ?,
                                 att      = ?,
                                 compPerc = ?,
                                 yds      = ?,
                                 td       = ?,
                                 ints     = ?,
                                 rate     = ?,
                                 rushyds  = ?
                                 WHERE id = ?
                                 ");

            $sql -> bindParam(1,  $date,     PDO::PARAM_STR);
            $sql -> bindParam(2,  $week,     PDO::PARAM_STR);
            $sql -> bindParam(3,  $opp,      PDO::PARAM_STR);
            $sql -> bindParam(4,  $result,   PDO::PARAM_STR);
            $sql -> bindParam(5,  $score,    PDO::PARAM_STR);
            $sql -> bindParam(6,  $att,      PDO::PARAM_INT);
            $sql -> bindParam(7,  $comp   ,  PDO::PARAM_INT);
            $sql -> bindParam(8,  $compPerc, PDO::PARAM_INT);
            $sql -> bindParam(9,  $yds,      PDO::PARAM_INT);
            $sql -> bindParam(10, $td,       PDO::PARAM_INT);
            $sql -> bindParam(11, $ints,     PDO::PARAM_INT);
            $sql -> bindParam(12, $rate ,    PDO::PARAM_STR);
            $sql -> bindParam(13, $rushyds,  PDO::PARAM_INT);
            $sql -> bindParam(14, $id,       PDO::PARAM_INT);

            try {
                $sql -> execute();
                return "Game updated successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }

        }

        // Need to adjust for all seasons
        public function deleteGame($season) {

            switch($season) {
                case "twentytwenty":
                    $table = "twentytwenty";
                    break;
            }

            $id = $_POST["id"];

            $db   = new Connect;
            $sql  = $db -> prepare("DELETE FROM {table WHERE id = '$id'");
            
            try {
                $sql -> execute();
                return "Game deleted successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }
            
        }
    }

