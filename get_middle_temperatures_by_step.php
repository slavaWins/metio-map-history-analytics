<?php


    require "./UseCases/GetTemperatureByDateUseCase.php";
    require "./UseCases/GetTemperatureForAllYearUseCase.php";

    use UseCases\GetTemperatureForAllYearUseCase;

    require_once "Repositories/FileStorageRepositoryDriver.php";
    require_once "Repositories/WehterApiRepository.php";
    require_once "Repositories/PointsDataStorage.php";

    include "View/LayoutView.php";
    include "View/MapView.php";


    $step = intval($_GET['step'] ?? 1)  ;
    $step = min($step, 50);
    $step = max($step, 1);


    $pointsDataStorage = new PointsDataStorage();
    $wehterApiRepository = new WehterApiRepository(new FileStorageRepositoryDriver());
    $getTemperatureByDateUseCase = new GetTemperatureForAllYearUseCase($pointsDataStorage, $wehterApiRepository);


    $from = 1960;
    $to = 2025;
    $years = [];


    for ($year = $from; $year <= $to; $year += $step) {
        $years[] = $year;
    }

    $mapDataWithYear = $getTemperatureByDateUseCase->GetData($years);

    foreach ($mapDataWithYear as $year=>$cities) {
        $cityOne = [];

        $tAll= 0;
        foreach ($cities as $city) {
            $tAll+=$city['t'];
        }

        $mapDataWithYear[$year] = [
                [
                        'customName'=>"all",
                        't'=>$tAll / count($cities),

                ]
        ];
      //  print_r($cities);
      //  exit;

    }

    // die( json_encode($mapDataWithYear));


    $html = "";


    ob_start();
?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #111 !important;
            color: #fff;
        }

        canvas {
            width: 100%;
            margin: 20px auto;
            display: block;
        }
    </style>

    <canvas id="myChart"></canvas>


    <script>
        const data = JSON.parse('<?= json_encode($mapDataWithYear) ?>');

        const years = Object.keys(data);

        // Создаем объект для городов
        const cities = {};
        data[years[0]].forEach(item => (cities[item.customName] = []));

        // Собираем данные для каждого города по годам
        years.forEach(year => {
            data[year].forEach(item => {
                cities[item.customName].push({ x: year.toString(), y: item.t }); // Используем строку для года
            });
        });

        // Создаем массив датасетов
        const datasets = Object.keys(cities).map(city => {
            return {
                label: city,
                data: cities[city],
               // borderColor: getRandomColor(),
                fill: false
            };
        });

        Chart.defaults.color = '#fff';

        // Создаем график
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: years, // Указываем годы как метки на оси X
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                        type: 'category', // Указываем категориальный тип оси
                        position: 'bottom',
                        title: {
                            display: true,
                            text: 'Год'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Температура (°C)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

    </script>

<?php


    $html = ob_get_clean();


    $html = LayoutView($html);

    echo $html;
