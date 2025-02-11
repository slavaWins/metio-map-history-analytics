<?php


    function TemperatureToColor($t) {
        // Ограничиваем температуру в диапазоне от -50 до +50
        $t = max(-40, min(5, $t));

        // Нормализуем температуру в диапазоне от 0 до 1
        $normalized = ($t + 45) / 100;

        // Интерполируем между синим (0, 0, 255) и красным (255, 0, 0)
        $red = (int)(255 * $normalized);
        $green = 0;
        $blue = (int)(255 * (1 - $normalized));

        // Возвращаем цвет в формате RGB
        return sprintf("#%02x%02x%02x", $red, $green, $blue);
    }


    function MapView($dataPoints, $scale = 0.81) {



        ob_start();
        ?>


        <div class="map">

            <? foreach ($dataPoints as $point) {

                $left = ($point['long'] + 180) * $scale-170; // Нормализация долготы
                $top = (90 - $point['lat']) * $scale;    // Нормализация широты


                ?>

                <div class="point" style="top: <?=$top ;?>%; left: <?=$left ;?>%; background: <?=TemperatureToColor($point['t']);?>">

                    <?=$point['customName'] ?? ""?>
                    <BR>
                    <?=round($point['t'])?>
                    <div class="hover">
                        <?=$point['customName'] ?? ""?>

                        <BR> lat: <?=$point['lat'];?>
                        <BR> long: <?=$point['long'];?>
                        <BR> t: <?=$point['t'];?>
                    </div>
                </div>

            <?
            } ?>

        </div>



        <?php


        $result = ob_get_clean();

        return $result;
    }
