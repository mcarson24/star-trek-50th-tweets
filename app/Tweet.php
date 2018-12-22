<?php

namespace App;

use Carbon\Carbon;

class Tweet
{
    protected $time;
    protected $text;

    public function __construct($items)
    {

        $this->text = $items->body;
        $this->time = Carbon::parse($items->time)->setTimezone('America/Los_Angeles');
    }

    /**
     * Return the time in the desired format.
     *
     * @return string
     */
    public function time()
    {
        return $this->time->format('l, F jS, g:ia');
    }

    /**
     * Return the time in the shorter format.
     *
     * @return string
     */
    public function shortTime()
    {
        return $this->time->format('M jS');
    }

    /**
     * Return the text of the tweet.
     *
     * @return string
     */
    public function formattedText()
    {
        $this->formatText();

        return $this->text;
    }

    /**
     * Completely format the text of the tweet.
     *
     * @return void
     */
    public function formatText()
    {
        $this->linksToAnchorTags()
             ->twitterHandlesToAnchorTags()
             ->hashtagsToAnchorTags();
    }

    /**
     * Convert links to anchor tags for displaying in a web browser.
     *
     * @return App\Tweet
     */
    private function linksToAnchorTags()
    {
        $this->text = preg_replace('/(http[s]?:\/\/[a-z.\/0-9_?=-]*)/i', '<a target="_blank" href="$1">$1</a>', $this->text);

        return $this;
    }

    /**
     * Convert twitter handles to anchor tags for displaying in a web browser.
     *
     * @return App\Tweet
     */
    private function twitterHandlesToAnchorTags()
    {
        $this->text =  preg_replace('/@(\w+)/', '<a target="_blank" href="https://twitter.com/$1">@$1</a>', $this->text);

        return $this;
    }

    /**
     * Convert hash tags to anchor tags for displaying in a web browser.
     *
     * @return string
     */
    private function hashtagsToAnchorTags()
    {
        $this->text = preg_replace('/#([a-z0-9]+)/i', '<a target="_blank" href="https://twitter.com/hashtag/$1?src=hash">#$1</a>', $this->text);

        return $this;
    }
}
