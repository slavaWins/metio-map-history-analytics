<?php


    require "./UseCases/GetTemperatureByDateUseCase.php";

    use UseCases\GetTemperatureByDateUseCase;

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
    $getTemperatureByDateUseCase = new GetTemperatureByDateUseCase($pointsDataStorage, $wehterApiRepository);
    $mapDataWithYear = $getTemperatureByDateUseCase->GetDateByYear($year);


    $html = "";
    $html .= "<h1>$year-02-04</h1>";
    $html .= "<div class='nav'>
<a href='?year=1960'>1960 </a>
<a href='?year=".($year + 1)."'>Next +1 ></a>
<a href='?year=".($year + 5)."'>Next +5 ></a>
</div>";
    $html .= MapView($mapDataWithYear);

    $html = LayoutView($html);

    echo $html;
