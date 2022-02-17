<?php

/*
Written by:
    https://github.com/Artemixed
    copyright (c) 2022
*/

require 'connectionManager.php';
require 'newsGetter.php';
require 'translator.php';
require 'logger.php';
require 'discordMessenger.php';

$newsgetter = new newsGetter();
$trans = new translator();
$conns = new connectionManager();
$logger = new logger();

// program supports muttiple hooks ie $conns->addHook("https://discord.com/api/webhooks/yourSecondHook")
$conns->addHook("https://discord.com/api/webhooks/xyz/xyz");

while (true) {
    try {
        $article = $newsgetter->getNews();

        if ($article != false) {
            $translated = $trans->translate($article);
            $logger->logToConsole($translated);
            $logger->LogToFile($translated);
            $conns->sendArticle($translated);
        }
    } catch (Exception $e) {
        $logger->logException($e);
    }
    sleep(60);
}
