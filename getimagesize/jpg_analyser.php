<?php

require_once './image_analyser_base.php';

class JpgAnalysis extends ImageAnalysisBase
{
    public function get_image_size($bin) : array
    {
        $section = $this->analysis_bin($bin);
        return [
            "height" => $this->get_int_param($bin, $section, 12),
            "width"  => $this->get_int_param($bin, $section, 14)
        ];
    }

    public function analysis_bin(string $jpg_bin) 
    {
        $offset = 4; // 0xffd8
        $section_data = $this->get_section($jpg_bin, $offset);
        foreach(range(0, 10) as $i) {
            $section_data = $this->get_section($jpg_bin, $section_data['pos']);
            switch($section_data['section']->name) {
                case 'ffc0':
                case 'ffc2':
                // 下記はメジャーではないので念のため
                case 'ffc1':
                case 'ffc3':
                case 'ffc4':
                case 'ffc5':
                case 'ffc6':
                case 'ffc7':
                case 'ffc9':
                case 'ffca':
                case 'ffcb':
                case 'ffcd':
                case 'ffce':
                case 'ffcf':
                    return $section_data['section'];
                default:
                    break;
            }
        }
    }

    protected function get_section(string $jpg_bin, int $offset)
    {
        $section = new MediaSection();
        $section->pos = $offset;
        $section->name = $this->read_byte($jpg_bin, $offset, 'H4');
        $section->length = $this->read_byte($jpg_bin, $offset + 4, 'n1');
        $section->body = $this->read_byte($jpg_bin, $offset + 4, 'H'.($section->length * 2));
        $next_section_pos = $section->length * 2 + $offset + 4;
        return ['section' => $section, 'pos' => $next_section_pos];
    }

}