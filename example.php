<?php

$token ="";
include 'telebot.php';
$teleBot = new TeleBotLib($token);
$chatId = $teleBot->findChatId();
$result = $teleBot->sendMessage($chatId, "Test Mesaj");
var_export($result);