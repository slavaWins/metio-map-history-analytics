<?php


    require_once "./Interfaces/IPointsDataStorage.php";
    class  PointsDataStorage implements IPointsDataStorage
    {

        public function GetPoints() {
            $mapPoints = [
                ['lat' => 54.998691, "long" => 82.883043, "customName" => "Nvsb"],
                ['lat' => 54.970867, "long" => 73.398141, "customName" => "Omsk"],
                ['lat' => 53.720482, "long" => 91.442642, "customName" => "Abakan"],
                ['lat' => 55.157297, "long" => 61.402588, "customName" => "Chelyba"],
                ['lat' => 55.758804, "long" => 37.617874, "customName" => "Msk"],
                ['lat' => 51.129384, "long" => 71.443405, "customName" => "Astana"],
                ['lat' => 63.567204, "long" => 53.665466, "customName" => "Uhta"],
                ['lat' => 62.027326, "long" => 129.732056, "customName" => "Yakutsk"],
                ['lat' => 48.480204, "long" => 135.072098, "customName" => "Khb"],
            ];

            return $mapPoints;
        }


    }
