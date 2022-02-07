<?php

// connect to discord webhook
$webhookurl = "YOUR DISCORD WEBHOOK URL HERE";

const sleepTime = 60; // time in seconds to wait between checks
const errorSleepTime = 240; // time in seconds to wait between errors

$pastlink = array();   // to prevent duplicate link

// Case insensitive L&R reggex
$pattern = '/[lr]/i';

function randomFromArray(array $inputArray) {
    if (gettype($inputArray) != "array"){
        throw new Exception("Given variable is not an array");
    }
    return $inputArray[array_rand($inputArray, 1)];
}

while (true) {

    try {
        $content = file_get_contents("http://feeds.nos.nl/nosnieuwsalgemeen"); // Default is National Dutch News (NOS)

        // Instantiate XML element
        $a = new SimpleXMLElement($content);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        echo 'retry in ' . errorSleepTime . " seconds \n";
        sleep(errorSleepTime);
        continue;
    }
    // Get clean content from rss feed (Might be different for your RSS feed)
    $link = $a->channel->item->link;

    // check if link is already posted 
    if (in_array("$link", $pastlink)) {
        sleep(sleepTime);
        continue;
    }

    $pastlink[] = "$link";

    $mediaEnclosure = $a->channel->item->enclosure['url']; // Link with photo (Might be different for your RSS feed)

    // Get the clean title from the rss feed and replace the R&L t-to m-make it c-cute hehe :3       
    $Cleantitle =  $a->channel->item->title;
    $CursedTitle = preg_replace($pattern, 'w', $Cleantitle);

    $CuteContent = file_get_contents("./assets/content.json");
    $CuteContent = json_decode($CuteContent, true);

    // get random word and emote from ./assets/content.json file
    $owo = randomFromArray($CuteContent['owo']);
    $emote = randomFromArray($CuteContent['emote']);

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
                "title" => $owo . " $CursedTitle " . $emote,

                // Embed Type
                "type" => "rich",

                // URL of title link
                "url" => "$link",

                // Timestamp of embed must be formatted as ISO8601
                "timestamp" => "$timestamp",

                // Embed left border color in HEX
                "color" => hexdec("FF0000"),

                // Image to send
                "image" => [
                    "url" => "$mediaEnclosure[0]",
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
    $ch = curl_init($webhookurl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
    // echo $response;
    curl_close($ch);

    // done 
    $result = $owo . " $CursedTitle " . $emote . " " . $link . " $timestamp " . "\n";
    file_put_contents("pastMessages.txt", $result, FILE_APPEND); // add result to file
    echo $result; // print result to console
    sleep(sleepTime);
}
