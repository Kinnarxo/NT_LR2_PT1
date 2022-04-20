<?php
    if (array_key_exists("substr", $_GET)) $substr = $_GET["substr"];
    else $substr = "";
    if (array_key_exists("regionum", $_GET)) $regionum = $_GET["regionum"];
    else $regionum = "2";
    if (!ctype_digit($regionum))
    {
        echo "В поле <em>Регион</em> введено неверное значение.<br>";
    }
    if (!ctype_alpha($substr))
    {
        echo "В поле <em>Подстрока</em> введено неверное значение.<br>";
    }
    if (!file_exists("city_region.csv")) echo "Файл данных отсутствует<br>";
    else
    {
        $cities_regs = array();
        echo "Файл данных найден<br>";
        $f = fopen("city_region.csv", 'r');
        fseek($f, SEEK_SET);
        flock($f, LOCK_EX);
        $line = fgets($f);
        while ($line != false){         //Помещаем данные из файла в массив[регион][город]
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
                if ($substr == "" OR strpos($cities_regs[$regionum][$i], $substr) != false) $strout .= "<option>" . $cities_regs[$regionum][$i] . "</option>";
            }
            if ($strout == "<br><select><option disabled selected>Выберите город</option>") echo "В $regionum регионе не найдено городов.<br>";
            else {$strout .= "</select><br>";echo $strout;}
        }
        else
        {
            echo "В $regionum регионе не найдено городов.<br>";
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