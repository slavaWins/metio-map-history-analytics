<?php


    require "./UseCases/GetTemperatureByDateUseCase.php";
    require "./UseCases/GetTemperatureForAllYearUseCase.php";

    use UseCases\GetTemperatureForAllYearUseCase;

    require_once "Repositories/FileStorageRepositoryDriver.php";
    require_once "Repositories/WehterApiRepository.php";
    require_once "Repositories/PointsDataStorage.php";

    include "View/LayoutView.php";
    include "View/MapView.php";


    $year = intval($year ?? 2025) ?? 2025;
    $year = min($year, 2025);
    $year = max($year, 1960);


    $pointsDataStorage = new PointsDataStorage();
    $wehterApiRepository = new WehterApiRepository(new FileStorageRepositoryDriver());
    $getTemperatureByDateUseCase = new GetTemperatureForAllYearUseCase($pointsDataStorage, $wehterApiRepository);
    $mapDataWithYear = $getTemperatureByDateUseCase->GetData(1960, 1973);


    //die( json_encode($mapDataWithYear));


    $html = "";


    ob_start();
?>



<?php


    $html = ob_get_clean();


    $html = LayoutView($html);

    echo $html;
