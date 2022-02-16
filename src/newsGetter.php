<?php
/*
The newsGetter class is reponsible for getting the news article from the RSS feed 
and checking for duplicates.
*/

include("article.php");

class newsGetter
{

    public $lastlinks;

    public function __construct()
    {

        $this->lastlinks = array();
    }

    /*
    Gets the news article from the RSS feed, Returns false on failure
    */
    public function getNews()
    {

        $rss = file_get_contents("http://feeds.nos.nl/nosnieuwsalgemeen");
        if ($rss === false) {
            throw new Exception("Could not fetch RSS feed");
        }

        $content = new SimpleXMLElement($rss);

        // create a new article and fill the fields
        $art = new article;
        $art->title = $content->channel->item->title;
        $art->link = $content->channel->item->link->__toString();
        $art->mediaEnclosure = $content->channel->item->enclosure['url'];

        if ($this->isDuplicate($art) === true) {
            return false;
        } else {
            array_push($this->lastlinks, $art->link);
            return $art;
        }
    }

    /*
    checks if the most recent article has already been posted.
    */
    private function isDuplicate($art)
    {
        // if the last link is the same as the current link, then it is a duplicate
        if (in_array($art->link, $this->lastlinks)) {
            return true;
        }
    }
}
