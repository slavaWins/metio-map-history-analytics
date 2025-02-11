<?php


    namespace UseCases;
    use IPointsDataStorage;
    use IWehterApiRepository;

    require_once "./Interfaces/IWehterApiRepository.php";
    require_once "./Interfaces/IFileStorageRepositoryDriver.php";
    require_once "./Interfaces/IPointsDataStorage.php";

    class  GetTemperatureByDateUseCase
    {

        public function __construct(
            readonly IPointsDataStorage $_pointsDataStorage,
            readonly IWehterApiRepository $_wehterApiRepository,
        ) {

        }

        public function GetDateByYear( int $year) {


            $mapPoints = $this->_pointsDataStorage->getPoints();

            $wehterApiRepository = $this->_wehterApiRepository;


            $mapDataWithYear = [

            ];


            foreach ($mapPoints as $point) {
                $result = $wehterApiRepository->GetTemperatureByYear($point['lat'], $point['long'], $year);

                $point['t'] = $result;

                $mapDataWithYear[] = $point;
            }


            return $mapDataWithYear;

        }

    }
