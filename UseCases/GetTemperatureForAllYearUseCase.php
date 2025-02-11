<?php


    namespace UseCases;

    use IPointsDataStorage;
    use IWehterApiRepository;

    require_once "./Interfaces/IWehterApiRepository.php";
    require_once "./Interfaces/IFileStorageRepositoryDriver.php";
    require_once "./Interfaces/IPointsDataStorage.php";

    class  GetTemperatureForAllYearUseCase
    {

        public function __construct(
            readonly IPointsDataStorage   $_pointsDataStorage,
            readonly IWehterApiRepository $_wehterApiRepository,
        ) {

        }

        public function GetData($from, $to) {


            $mapPoints = $this->_pointsDataStorage->getPoints();

            $wehterApiRepository = $this->_wehterApiRepository;


            $mapDataWithYear = [];

            for ($year = $from; $year <= $to; $year++) {


                $mapDataWithYear[$year] = [];


                foreach ($mapPoints as $point) {
                    $result = $wehterApiRepository->GetTemperatureByYear($point['lat'], $point['long'], $year);

                    $point['t'] = $result;

                    $mapDataWithYear[$year] [] = $point;
                }


            }

            return $mapDataWithYear;
        }

    }
