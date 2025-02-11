<?php


    require_once "./Interfaces/IWehterApiRepository.php";
    require_once "./Interfaces/IFileStorageRepositoryDriver.php";

    class  WehterApiRepository implements IWehterApiRepository
    {

        public function __construct(
            readonly IFileStorageRepositoryDriver $_fileStorageRepositoryDriver
        ) {

        }

        public  function GetTemperatureByYear(float $lat, float $long, int $year) {

            $date = $year."-02-04";

            $response = $this->GetTemperatureByDate($lat, $long, $date);

            return $response;

        }

        public  function GetTemperatureByDate(float $lat, float $long, $date) {

            $response = $this->GetRawRequest($lat, $long, $date);

            $response = json_decode($response, true);

            $amount = 0;
            foreach ($response['hourly']['temperature_2m'] as $val) $amount += $val;

            if ($amount !== 0) {
                $amount = $amount / count($response['hourly']['temperature_2m']);
            }


            return $amount;

        }

        public  function GetRawRequest(float $lat, float $long, $date) {


            $url = 'https://archive-api.open-meteo.com/v1/era5?latitude={lat}&longitude={long}&start_date={date}&end_date={date}&hourly=temperature_2m';

            $url = str_replace("{lat}", $lat, $url);
            $url = str_replace("{long}", $long, $url);
            $url = str_replace("{date}", $date, $url);

            $key = "apiwither__".$lat.'__'.$long.'__'.$date;


            $result = $this->_fileStorageRepositoryDriver->Get($key, function() use ($url) {
                $response = file_get_contents($url);

                return $response;
            });

            return $result;
        }
    }
