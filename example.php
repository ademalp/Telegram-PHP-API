<?php

$token ="5290839350:AAEm78yPS4v4-nS4YPdBahTi7zuWPnP0iKw";
include 'telebot.php';
$teleBot = new TeleBotLib($token);
$chatId = $teleBot->findChatId();
$result = $teleBot->sendMessage($chatId, "Test Mesaj");
var_export($result);