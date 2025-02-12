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


    $from = 1960;
    $to = 2025;
    $years = [];
    for ($year = $from; $year <= $to; $year += 1) {
        $years[] = $year;
    }
    //print_r($years);    exit;

    $mapDataWithYear = $getTemperatureByDateUseCase->GetData($years);


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
