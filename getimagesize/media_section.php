<?php

class MediaSection {
    public $name;
    public $length;
    public $body;
    public $pos;

    public function __construct($args = [])
    {
        $this->name = $args['name'] ?? '';
        $this->length = $args['length'] ?? 0;
        $this->body = $args['body'] ?? '';
        $this->pos = $args['pos'] ?? 0;
    }
}