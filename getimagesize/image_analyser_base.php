<?php

require_once './media_section.php';
require_once './media_type.php';

class ImageAnalysisBase
{
    public function get_image_size($bin) : array
    {
        return [];
    }

    protected function get_int_param(string $bin, MediaSection $section, int $offset = 0)
    {
        return $this->read_byte($bin, $section->pos + $offset * 2, 'n1');
    }

    protected function get_int_param_le(string $bin, MediaSection $section, int $offset = 0)
    {
        return $this->read_byte($bin, $section->pos + $offset * 2, 'v1');
    }

    protected function get_long_param(string $bin, MediaSection $section, int $offset = 0)
    {
        return $this->read_byte($bin, $section->pos + $offset * 2, 'N1');
    }

    protected function get_long_param_le(string $bin, MediaSection $section, int $offset = 0)
    {
        return $this->read_byte($bin, $section->pos + $offset * 2, 'L1');
    }

    protected function get_double_param(string $bin, MediaSection $section, int $offset = 0)
    {
        return $this->read_byte($bin, $section->pos + $offset * 2, 'J1');
    }

    protected function get_double_param_le(string $bin, MediaSection $section, int $offset = 0)
    {
        return $this->read_byte($bin, $section->pos + $offset * 2, 'P1');
    }

    protected function read_byte(string $bin, int $offset, string $format)
    {
        $data = unpack(sprintf("H%dskip/%sdata", $offset, $format), $bin);
        return $data['data'];
    }
}