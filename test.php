<?php
    $substr = $_GET["substr"];
    $regionum = $_GET["regionum"];
    if (!file_exists("city_region.csv")) echo "Файл данных отсутствует";
    else
    {
        $cities_regs = array();
        echo "Файл данных найден";
        $f = fopen("city_region.csv", 'r');
        fseek($f, SEEK_SET);
        flock($f, LOCK_EX);
        $line = fgets($f);
        while ($line != false){
            echo $line;
            $line = fgets($f);
        }
        fclose($f);
    }

?>