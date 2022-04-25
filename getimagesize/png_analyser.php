<?php

require_once './image_analyser_base.php';

class PngAnalysis extends ImageAnalysisBase
{
    public function get_image_size($bin): array
    {
        $section = new MediaSection();
        $section->pos = 16;
        return [
            "width" => $this->get_long_param($bin, $section, 16),
            "height"  => $this->get_long_param($bin, $section, 24),
        ];
    }
}