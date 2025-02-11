<?php


    require "./UseCases/GetTemperatureByDateUseCase.php";
    use UseCases\GetTemperatureByDateUseCase;

    require_once "Repositories/FileStorageRepositoryDriver.php";
    require_once  "Repositories/WehterApiRepository.php";
    require_once  "Repositories/PointsDataStorage.php";

    include "View/LayoutView.php";
    include "View/MapView.php";



    $year = intval($year ?? 2025) ?? 2025;
    $year = min($year, 2025);
    $year = max($year, 1960);


    $pointsDataStorage = new PointsDataStorage();
    $wehterApiRepository = new WehterApiRepository(new FileStorageRepositoryDriver());
    $getTemperatureByDateUseCase = new GetTemperatureByDateUseCase($pointsDataStorage, $wehterApiRepository);
    $mapDataWithYear = $getTemperatureByDateUseCase->GetDateByYear($year);



    echo json_encode($mapDataWithYear);
