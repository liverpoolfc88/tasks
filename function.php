<?php
/**
 * Created by PhpStorm.
 * Author: Dehqonov Sardor
 * Telegram: https://t.me/Liverpoolfc_88
 * Web: http://www.websar.uz
 * Project: bot-telegram
 * Date: 08.02.2020 23:25
 */

define("BOT_TOKEN", ""); //bot token
function getOrderInfo($git='liverpoolfc88/invest'){
    $url = "https://api.github.com/repos/$git/stats/contributors";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_USERAGENT,'User-Agent: Awesome-Octocat-App');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result);
}
// echo getOrderInfo();
// var_dump(getOrderInfo())
function getItem($name){
    $massiv = getOrderInfo($name);
    if (is_array($massiv)){
        $kalit=[];
        $i=0; foreach ($massiv as $value) {$i++;
            if ($i==6) break;
            foreach ($value->weeks as $item) {
                # code...
            }
            $kalit[]=['login'=>$value->author->login, 'week'=>$item->w, "count"=>$item->c];
        }
        return $kalit;
    }else return "Repozitory hato kiritildi.";
}

function getPic($name = "liverpoolfc88/invest"){
    $DataSet = new pData(); // Создаём объект pData
    $array = getItem($name);
    if (is_array($array)) {
        $i=0; foreach ($array as $commit){ $i++;
            $DataSet->AddPoint(array(0, $commit['count']), "Serie$i"); // Загружаем данные графика 1
            $DataSet->SetSerieName($commit['login'],"Serie$i");

        }
        $DataSet->AddAllSeries(); // Добавить все данные для построения
        $Test = new pChart(700, 230); // Рисуем графическую плоскость
        $Test->setFontProperties("Fonts/tahoma.ttf", 8); // Установка шрифта
        $Test->setGraphArea(50, 30, 585, 200); // Установка области графика
        $Test->drawFilledRoundedRectangle(7, 7, 693, 223, 5, 240, 240, 240); // Выделяем плоскость прямоугольником
        $Test->drawRoundedRectangle(5, 5, 695, 225, 5, 230, 230, 230); // Делаем контур графической плоскости
        $Test->drawGraphArea(255, 255, 255, true); // Рисуем графическую плоскость
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, true, 0, 2); // Рисуем оси и график
        $Test->drawGrid(4, true, 230, 230, 230, 50); // Рисуем сетку
        $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription()); // Соединяем точки графика линиями
        $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(), 3, 2, 255, 255, 255); // Рисуем точки
        // Finish the graph
        $Test->drawLegend(75,35,$DataSet->GetDataDescription(),255,255,255);
        $Test->drawTitle(50, 22, "репозитарий $name на Github", 50, 50, 50, 585); // Выводим заголовок графика
        $vercode = substr(rand(), 0, 4);
        $Test->Render("$vercode.png"); // Выводим график в окно браузера;
        return $vercode;
    }else return [];
}

function sendPhoto($filename,$chat_id){
    $bot_url    = 'https://api.telegram.org/bot'.BOT_TOKEN.'/';
    $url        = $bot_url . "sendPhoto?chat_id=" . $chat_id ;

    $post_fields = array('chat_id'   => $chat_id,
        'photo'     => new CURLFile($filename)
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type:multipart/form-data"
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $output = curl_exec($ch);
    curl_close($ch);
}