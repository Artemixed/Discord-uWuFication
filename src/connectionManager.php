<?php
/*
The connectionManager class is responsible for connecting to Discord webhooks and sending the article to the corresponding webhook.
*/
class connectionManager
{
    private $hooks = array();

    /* 
    Adds a webhook to the array of hooks.
    */
    public function addHook($hook)
    {
        $this->hooks[] = $hook;
    }

    /*
    Sends the article to each Discord webhooks.
    */
    public function sendArticle($article)
    {
        foreach ($this->hooks as $hook) {
            $msgr = new discordMessenger($hook);
            $msgr->sendArticle($article);
        }
    }
}
