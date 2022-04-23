<?php
    $Glob_Arr = array();
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $Glob_Arr = &$_GET;
        $methodInfo = "<span style='margin: 15px 10px 15px;'>Выполнено методом GET.</span><br><br>";
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $Glob_Arr = &$_POST;
        $methodInfo = "<span style='margin: 15px 10px 15px;'>Выполнено методом POST.</span><br><br>";
    }
    if (array_key_exists("substr", $Glob_Arr)) $substr = $Glob_Arr["substr"];
    else $substr = "";
    if (array_key_exists("regionum", $Glob_Arr)) $regionum = $Glob_Arr["regionum"];
    else $regionum = "";
    if (!ctype_digit($regionum))
    {
        echo "В поле <em>Регион</em> введено неверное значение $regionum, $substr.<br>";
    }
    if (!file_exists("city_region.csv")) echo "Файл данных отсутствует<br>";
    else
    {
        $cities_regs = array();
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
            $initialstr = "<select style='margin: 15px 10px 15px;background-color: mediumaquamarine; color: white; float: left;'><option disabled selected>Выберите город</option>";
            $strout = $initialstr;
            $len = count($cities_regs[$regionum]);
            for ($i = 0; $i < $len; $i++)
            {
                if ($substr == "" OR strpos(mb_strtolower($cities_regs[$regionum][$i]), mb_strtolower($substr)) !== false) $strout .= "<option>" . $cities_regs[$regionum][$i] . "</option>";
            }
            if ($strout == $initialstr)
                echo "<br><span style='margin: 10px;'>В $regionum регионе не найдено городов, название которых содержит '$substr'.</span><br><br>";
            else echo $strout . "</select><br><script>\$('select').mouseover(function (){\$('select').css('background-color', 'white').css('color', 'black')})</script>";
        }
        else
        {
            echo "<span style='margin: 15px 10px 15px;'>В $regionum регионе не найдено городов.</span><br>";
        }
        echo $methodInfo;
        fclose($f);
    }
?>