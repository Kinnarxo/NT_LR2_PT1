<?php
    if (array_key_exists("substr", $_GET)) $substr = $_GET["substr"];
    else $substr = "";
    if (array_key_exists("regionum", $_GET)) $regionum = $_GET["regionum"];
    else $regionum = "";
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
            $buf = explode(",", $line);
            $cities_regs[intval($buf[1])][] = $buf[0];
            echo $line;
            $line = fgets($f);
        }
        fclose($f);
    }

?>