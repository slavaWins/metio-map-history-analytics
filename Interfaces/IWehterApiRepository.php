<?php

    interface IWehterApiRepository
    {
        public function GetTemperatureByYear(float $lat, float $long, int $year);

        public function GetTemperatureByDate(float $lat, float $long, $date);

        public function GetRawRequest(float $lat, float $long, $date);
    }
