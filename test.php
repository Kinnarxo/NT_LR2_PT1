<?php
    if (array_key_exists("substr", $_GET)) $substr = $_GET["substr"];
    else $substr = "";
    if (array_key_exists("regionum", $_GET)) $regionum = $_GET["regionum"];
    else $regionum = "1";
    if (!file_exists("city_region.csv")) echo "Файл данных отсутствует";
    else
    {
        $cities_regs = array();
        echo "Файл данных найден<br>";
        $f = fopen("city_region.csv", 'r');
        fseek($f, SEEK_SET);
        flock($f, LOCK_EX);
        $line = fgets($f);
        while ($line != false){
            $buf = explode(",", $line);
            $cities_regs[intval($buf[1])][] = $buf[0];
            $line = fgets($f);
        }
        ksort($cities_regs);
        if (key_exists($regionum, $cities_regs))
        {
            $strout = "<br><select><option disabled selected>Выберите город</option>";
            $len = count($cities_regs[$regionum]);
            for ($i = 0; $i < $len; $i++)
            {
                $strout .= "<option>" . $cities_regs[$regionum][$i] . "</option>";
            }
            $strout .= "</select><br>";
            echo $strout;
        }
        else
        {
            echo "В $regionum регионе не найдено городов.";
        }
        foreach ($cities_regs as $k => $v)
        {
            echo $k . ". ";
            foreach ($v as $val) echo $val . " ";
            echo "<br>";
        }

        fclose($f);
    }

?>