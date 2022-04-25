<?php

class MediaType {
    const UNKNOWN = 0;
    const PNG = 1;
    const JPG = 2;
    const GIF = 3;
    const PNG_BIN = "89504e470d0a1a0a";
    const JPG_BIN = "ffd8ffe0";
    const GIF_BIN = "474946";
    const PNG_BIN_SHORT = "89504e";
    const JPG_BIN_SHORT = "ffd8ff";
    const GIF_BIN_SHORT = "474946";

    public static function get_media_type_map() : array
    {
        return [
            static::PNG => static::PNG_BIN,
            static::JPG => static::JPG_BIN,
            static::GIF => static::GIF_BIN
        ];
    }

    public static function get_media_type_short_map() : array
    {
        return [
            static::PNG => static::PNG_BIN_SHORT,
            static::JPG => static::JPG_BIN_SHORT,
            static::GIF => static::GIF_BIN_SHORT
        ];
    }

    public static function judge_file_type(string $bin) : int
    {
        switch($bin) {
            case static::PNG_BIN:
            case static::PNG_BIN_SHORT:
                return static::PNG;
            case static::JPG_BIN:
            case static::JPG_BIN_SHORT:
                return static::JPG;
            case static::GIF_BIN:
            case static::GIF_BIN_SHORT:
                return static::GIF;
            default:
                return static::UNKNOWN;
        }
    }
}
