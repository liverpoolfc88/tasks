<?php
header('Content-Type: multipart/form-data; charset=utf-8');

// подключаемся к API
require_once("vendor/autoload.php");
require_once "pChart/pData.class";
require_once "pChart/pChart.class";
require_once "function.php";

$token = ""; // telegram token
$bot = new \TelegramBot\Api\Client($token);

// если бот еще не зарегистрирован - регистрируем
if (!file_exists("registered.trigger")) {
 /**
 * файл registered.trigger будет создаваться после регистрации бота.
 * если этого файла нет существует, значит бот не
 * зарегистрирован в Телеграмм
 */
 // URl текущей страницы
 $page_url = "https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 $result = $bot->setWebhook($page_url);
 if($result){
	file_put_contents("registered.trigger",time()); // создаем файл дабы остановить повторные регистрации
 }
}


$bot->command('start', function ($message) use ($bot) {
 $answer = 'Hush kelibsiz, Github manzilni kiriting!';
 $bot->sendMessage($message->getChat()->getId(), $answer);
});

$bot->command('github', function ($message) use ($bot) {
    $gitpic = getPic();
    if (is_array($gitpic)){
        $answer = "Repozitory hato kiritildi.\nMisol: liverpoolfc88/invest";
        $bot->sendMessage($message->getChat()->getId(), $answer);
    }else{
        sleep(1);
        $pic = "https://kredit.websar.uz/telegram/$gitpic.png";
        $bot->sendPhoto($message->getChat()->getId(), $pic);
        @unlink($gitpic.".png");
    }
});

$bot->on(function($Update) use ($bot){
 $message = $Update->getMessage();
 $mtext = $message->getText();

$gitpic = getPic($mtext);
if (is_array($gitpic)){
    $answer = "Repozitory hato kiritildi.\nMisol: liverpoolfc88/invest";
    $bot->sendMessage($message->getChat()->getId(), $answer);
}else{
    sleep(1);
    $pic = "https://kredit.websar.uz/telegram/$gitpic.png";
    $bot->sendPhoto($message->getChat()->getId(), $pic);
    @unlink($gitpic.".png");
}

}, function($message) use ($name){
 return true; // когда тут true - команда проходит
});

$bot->run();
?>