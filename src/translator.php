<?php

/*
responsible for translating the article title into 'owo speak'
*/

class translator
{
    /*
    responsible for adding stutter to the article title.
    This stutter has a 30% chance of occurring on the first word of the title
    and voids the chance if the first word of the title starts with a illegal character ie " ' " or ' " ' .
    */
    public function stutter($str)
    {
        if (mt_rand(1, 100) <= 30) {
            $split = explode(" ", $str);
            $firstLetter = substr($split[0], 0, 1);

            if (!preg_match("/[a-zA-Z]/", $firstLetter)) {
                return $str;
            }

            $generate = join(" ", $split);
            $str = "$firstLetter-$firstLetter-$generate";
        }
        return $str;
    }

    /*
    responsible for translating the article title into 'uwu speak'.
    This is simply done by replacing all occurrences of 'r' and 'l' with a 'w' respectively.
    */
    public function translateToUWU($str)
    {
        $patterns = ['/[lr]/', '/[RL]/']; // Should have as many elements as array below
        $replacements = ['w', 'W']; // Appear within the same order as the patterns above
        return preg_replace($patterns, $replacements, $str);
    }

    /* 
    responsible for selecting a random 'emote' and 'owo' from the content.json file found in ./assets/. 
    */
    private function randomFromArray(array $inputArray)
    {
        if (gettype($inputArray) != "array") {
            throw new Exception("Input is not an array");
        }

        return $inputArray[array_rand($inputArray, 1)];
    }

    /* 
    responsible for adding the emotes and uwu to the article title using the random from array function. 
    */
    public function addEmoji($str)
    {
        $content = file_get_contents("assets/content.json");
        $content = json_decode($content, true);

        $owo = $this->randomFromArray($content['owo']);
        $emote = $this->randomFromArray($content['emote']);

        return $owo . " " . $str . " " . $emote;
    }

    /*
    responsible for translating the article title into 'uwu speak' by bringing everything together.
    */
    public function translate($article)
    {
        $article->title = $this->translateToUWU($article->title);
        $article->title = $this->stutter($article->title);
        $article->title = $this->addEmoji($article->title);

        return $article;
    }
}
