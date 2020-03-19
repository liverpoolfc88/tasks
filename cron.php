<?php
/**
 * Created by PhpStorm.
 * Author: Dehqonov Sardor
 * Telegram: https://t.me/Liverpoolfc_88
 * Web: http://www.websar.uz
 * Project: bot-telegram
 * Date: 08.02.2020 23:25
 */

header('Content-Type: multipart/form-data; charset=utf-8');

// подключаемся к API
require_once("vendor/autoload.php");
require_once "pChart/pData.class";
require_once "pChart/pChart.class";
require_once "function.php";

$gitpic = getPic();
sleep(1);
$pic = "https://kredit.websar.uz/telegram/$gitpic.png";
sendPhoto($gitpic."png",298816692);
@unlink($gitpic.".png");