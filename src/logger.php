<?php
/*
    Logs the articles to the console and to a file. 
    and is responsible for logging exceptions to file.
*/
class logger
{

    /*
    Logs the article to the console.
    */
    public function logToConsole($article)
    {
        echo date('Y/m/d H:i:s') . " " . $article->title . " " . $article->link . "\n";
    }

    /*
    Logs the article to the file. found in ./logs/pastMessages.log.
    */
    public function logToFile($article)
    {
        $message = date('Y/m/d H:i:s') . " " . $article->title . " " . $article->link . "\n";
        file_put_contents("./logs/pastMessages.log", $message, FILE_APPEND);
    }

    /*
    Logs the exception to the file found in ./logs/exceptions.log.
    */
    public function logException($exception)
    {
        $message = date('Y/m/d H:i:s') . " " . $exception->getMessage() . "\n";
        file_put_contents("./logs/exceptions.log", $message, FILE_APPEND);
    }
}
