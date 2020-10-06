<?php

    require_once("./Connect.php");

    class API {

        private function checkSeason($season): string
        {
            $seasonTB = "";

            switch($season) {
                case "twentytwenty":
                    $seasonTB = "twentytwenty";
                    break;
                case "twentynineteen":
                    $seasonTB = "twentynineteen";
                    break;
                case "twentyeighteen":
                    $seasonTB = "twentyeighteen";
                    break;
                case "twentyseventeen":
                    $seasonTB = "twentyseventeen";
                    break;
            }

            return $seasonTB;
        }

        public function selectAllData($season)
        {
            $seasonTB = $this -> checkSeason($season);
          
            $games = array();
            $db = new Connect;

            // Order by does not appear to be working.
            $sql  = $db -> query("SELECT * FROM $seasonTB ORDER BY id DESC");

            while ($outputData = $sql -> fetch(PDO::FETCH_ASSOC)) {
                $games[$outputData["id"]] = array(

                    "id"         => $outputData["id"],
                    "season"     => $outputData["season"],
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

        public function addGame($season)
        {
            $seasonTB = $this -> checkSeason($season);

            $db  = new Connect;
            $sql = $db -> prepare("INSERT INTO $seasonTB (
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
            $sql -> bindParam(2,  $_POST["week"],     PDO::PARAM_INT);
            $sql -> bindParam(3,  $_POST["opp"],      PDO::PARAM_STR);
            $sql -> bindParam(4,  $_POST["result"],   PDO::PARAM_STR);
            $sql -> bindParam(5,  $_POST["score"],    PDO::PARAM_STR);
            $sql -> bindParam(6,  $_POST["att"],      PDO::PARAM_INT);
            $sql -> bindParam(7,  $_POST["comp"]   ,  PDO::PARAM_INT);
            $sql -> bindParam(8,  $_POST["compPerc"], PDO::PARAM_STR);
            $sql -> bindParam(9,  $_POST["yds"],      PDO::PARAM_INT);
            $sql -> bindParam(10, $_POST["td"],       PDO::PARAM_INT);
            $sql -> bindParam(11, $_POST["int"],      PDO::PARAM_INT);
            $sql -> bindParam(12, $_POST["rate"] ,    PDO::PARAM_STR);
            $sql -> bindParam(13, $_POST["rushyds"],  PDO::PARAM_INT);

            try {
                $sql -> execute();
                return "Game added successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }
        }

        public function updateGame($season)
        {
            $seasonTB = $this -> checkSeason($season);

            $db = new Connect;
            $sql = $db -> prepare("UPDATE $seasonTB SET
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
            $sql -> bindParam(2,  $_POST["week"],     PDO::PARAM_INT);
            $sql -> bindParam(3,  $_POST["opp"],      PDO::PARAM_STR);
            $sql -> bindParam(4,  $_POST["result"],   PDO::PARAM_STR);
            $sql -> bindParam(5,  $_POST["score"],    PDO::PARAM_STR);
            $sql -> bindParam(6,  $_POST["att"],      PDO::PARAM_INT);
            $sql -> bindParam(7,  $_POST["comp"]   ,  PDO::PARAM_INT);
            $sql -> bindParam(8,  $_POST["compPerc"], PDO::PARAM_STR);
            $sql -> bindParam(9,  $_POST["yds"],      PDO::PARAM_INT);
            $sql -> bindParam(10, $_POST["td"],       PDO::PARAM_INT);
            $sql -> bindParam(11, $_POST["int"],      PDO::PARAM_INT);
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

        public function deleteGame($season): ?string
        {
            $seasonTB = $this -> checkSeason($season);

            $db   = new Connect;
            $sql  = $db -> prepare("DELETE FROM $seasonTB WHERE id = :id");
            $sql  -> bindParam(":id", $_POST["id"], PDO::PARAM_INT);

            try {
                $sql -> execute();
                return "Game deleted successfully!";
            } catch(PDOException $e) {
                return $e -> getMessage();
            }
        }

        //Need to figure out how to do wins and losses.
        public function getTotals($season)
        {
            $seasonTB = $this -> checkSeason($season);

            $totals = array();
            $db = new Connect;
            $sql = $db -> query("SELECT 
                                                SUM(comp) as 'Comp',
                                                SUM(att) as 'Att',
                                                SUM(yds) as 'Yds',
                                                SUM(td) as 'TD',
                                                SUM(ints) as 'Ints',
                                                SUM(rushyds) as 'RushYds'
                                            FROM $seasonTB");

            $totals   = $sql -> fetch(PDO::FETCH_ASSOC);

            return json_encode($totals);

        }

        public function getAverages($season)
        {
            $seasonTB = $this -> checkSeason($season);

            $averages = array();
            $db = new Connect;
            $sql = $db -> query("SELECT 
                                                ROUND(AVG(comp), 0) as 'Comp',
                                                ROUND(AVG(att), 0) as 'Att',
                                                ROUND(AVG(compPerc), 2) as 'CompPerc',
                                                ROUND(AVG(yds), 0) as 'Yds',
                                                ROUND(AVG(td), 0) as 'TD',
                                                ROUND(AVG(ints), 0) as 'Ints',
                                                ROUND(AVG(rate), 1) as 'Rate',
                                                ROUND(AVG(rushyds), 1) as 'RushYds'
                                            FROM $seasonTB");

            $averages   = $sql -> fetch(PDO::FETCH_ASSOC);

            return json_encode($averages);
        }


       public function getResults($season)
       {
            $seasonTB = $this -> checkSeason($season);

            $results= array();
            $db = new Connect;
            $sql = $db -> query("SELECT result, id FROM $seasonTB");

           while ($outputData = $sql -> fetch(PDO::FETCH_ASSOC)) {
               $results[$outputData["id"]] = array(
                   "result"     => $outputData["result"]
               );
           }

           $wins = 0;
           $losses = 0;

           foreach($results as $result) {
               if ($result['result'] === "W") {
                   $wins++;
               } else {
                   $losses++;
               }
           }

           $winsAndLosses =  array(
               "wins"=> $wins, "losses" => $losses
           );

           return json_encode($winsAndLosses);

        }

    }

