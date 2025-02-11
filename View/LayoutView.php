<?php


    function LayoutView($container) {


        ob_start();
        ?>

        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <title>Metio MAP</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="/app.css">

        </head>
        <body>
        <?= $container ?>
        </body>
        </html>
        <?php

        $result = ob_get_clean();

        return $result;
    }
