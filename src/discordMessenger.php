<?php

/*
Connects to a Discord webhook and sends article to corresponding webhook.
*/

class discordMessenger
{
    private $url;

    /*
    Given a webhook URL this constructor sets the URL to the given webhook. 
    */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /*
    Encodes the article into JSON and POSTS it to the Discord webhook.
    */
    public function sendArticle($article)
    {

        $timestamp = date("c", strtotime("now"));

        $json_data = json_encode([
            // Username
            "username" => "NoWos NuWus",

            // Avatar URL.
            "avatar_url" => "https://pbs.twimg.com/profile_images/1428367953485975558/CvHRflwS_400x400.jpg", // Default is NoWoS logo 

            // Text-to-speech
            "tts" => false,

            // Embeds Array
            "embeds" => [
                [
                    // Embed Title
                    "title" => "$article->title",

                    // Embed Type
                    "type" => "rich",

                    // URL of title link
                    "url" => "$article->link",

                    // Timestamp of embed must be formatted as ISO8601
                    "timestamp" => $timestamp,

                    // Embed left border color in HEX
                    "color" => hexdec("FF0000"),

                    // Image to send
                    "image" => [
                        "url" => "$article->mediaEnclosure",
                    ],

                    // Author
                    "author" => [
                        "name" => "OwO Nieuws",
                        "url" => "https://twitter.com/OwONieuws", // default is twitter of NoWoS
                    ],
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Send the POST request with curl
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
        // echo "reponse from discord: $response \n";
        curl_close($ch);
    }
}
