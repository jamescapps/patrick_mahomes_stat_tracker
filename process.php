<?php

    require_once("./config.php");

    class API {

        function selectAllData() {

            $games = array();

            $db    = new Connect;
            $data  = $db -> prepare("SELECT* FROM games ORDER BY id");
            $data -> execute();

            while ($outputData = $data -> fetch(PDO::FETCH_ASSOC)) {

                $games[$outputData["id"]] = array(

                    "id"      => $outputData["id"],
                    "date"    => $outputData["date"],
                    "week"    => $outputData["week"],
                    "opp"     => $outputData["opp"],
                    "result"  => $outputData["result"],
                    "comp"    => $outputData["comp"],
                    "att"     => $outputData["att"],
                    "comp%"   => $outputData["comp%"],
                    "yds"     => $outputData["yds"],
                    "td"      => $outputData["td"],
                    "int"     => $outputData["int"],
                    "rate"    => $outputData["rate"],
                    "rushyds" => $outputData["rushyds"]

                );
            }

            return json_encode($games);
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
    

?>