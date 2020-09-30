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

            $sql -> bindParam(1,  $_POST["date"],     PDO::PARAM_STR);
            $sql -> bindParam(2,  $_POST["week"],     PDO::PARAM_STR);
            $sql -> bindParam(3,  $_POST["opp"],      PDO::PARAM_STR);
            $sql -> bindParam(4,  $_POST["result"],   PDO::PARAM_STR);
            $sql -> bindParam(5,  $_POST["score"],    PDO::PARAM_STR);
            $sql -> bindParam(6,  $_POST["att"],      PDO::PARAM_INT);
            $sql -> bindParam(7,  $_POST["comp"]   ,  PDO::PARAM_INT);
            $sql -> bindParam(8,  $_POST["compPerc"], PDO::PARAM_INT);
            $sql -> bindParam(9,  $_POST["yds"],      PDO::PARAM_INT);
            $sql -> bindParam(10, $_POST["td"],       PDO::PARAM_INT);
            $sql -> bindParam(11, $_POST["int"],     PDO::PARAM_INT);
            $sql -> bindParam(12, $_POST["rate"] ,    PDO::PARAM_STR);
            $sql -> bindParam(13, $_POST["rushyds"],  PDO::PARAM_INT);

            try {
                $sql -> execute();
                return "Game added successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }

        }

        // Need to adjust for all seasons
        public function updateGame() {

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

            $sql -> bindParam(1,  $_POST["date"],     PDO::PARAM_STR);
            $sql -> bindParam(2,  $_POST["week"],     PDO::PARAM_STR);
            $sql -> bindParam(3,  $_POST["opp"],      PDO::PARAM_STR);
            $sql -> bindParam(4,  $_POST["result"],   PDO::PARAM_STR);
            $sql -> bindParam(5,  $_POST["score"],    PDO::PARAM_STR);
            $sql -> bindParam(6,  $_POST["att"],      PDO::PARAM_INT);
            $sql -> bindParam(7,  $_POST["comp"]   ,  PDO::PARAM_INT);
            $sql -> bindParam(8,  $_POST["compPerc"], PDO::PARAM_INT);
            $sql -> bindParam(9,  $_POST["yds"],      PDO::PARAM_INT);
            $sql -> bindParam(10, $_POST["td"],       PDO::PARAM_INT);
            $sql -> bindParam(11, $_POST["int"],     PDO::PARAM_INT);
            $sql -> bindParam(12, $_POST["rate"] ,    PDO::PARAM_STR);
            $sql -> bindParam(13, $_POST["rushyds"],  PDO::PARAM_INT);
            $sql -> bindParam(14, $_POST["id"],       PDO::PARAM_INT);

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

