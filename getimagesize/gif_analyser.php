<?php

require_once './image_analyser_base.php';

class GifAnalysis extends ImageAnalysisBase
{
    public function get_image_size($bin): array
    {
        $section = new MediaSection();
        $section->pos = 0;
        return [
            "width" => $this->get_int_param_le($bin, $section, 6),
            "height"  => $this->get_int_param_le($bin, $section, 8),
        ];
    }
}