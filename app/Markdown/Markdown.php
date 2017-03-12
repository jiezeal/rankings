<?php

namespace App\MarkDown;

class MarkDown
{
    protected $parser;

    /**
     * MarkDown constructor.
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param $text
     * @return string
     */
    public function markdown($text){
        $html = $this->parser->makeHtml($text);
        return $html;
    }
}