<?php

require_once './media_type.php';
require_once './jpg_analyser.php';
require_once './png_analyser.php';
require_once './gif_analyser.php';

function measure_run_time($f) : array
{
    $time_start = microtime(true);
    $ret = $f();
    return [
        "time" => microtime(true) - $time_start,
        "result" => $ret
    ];
}

function curl_vs_getimagesize (string $url)
{
    $curl_result = measure_run_time(function () use ($url) {
        $analyser_map = [
            MediaType::PNG => PngAnalysis::class,
            MediaType::JPG => JpgAnalysis::class,
            MediaType::GIF => GIFAnalysis::class,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RANGE, "0-6000");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $s3_header_bin = curl_exec($ch);
        curl_close($ch);
        if ($s3_header_bin !== false) {
            $filetype_bin = join("", unpack("H6", $s3_header_bin));
            $filetype = MediaType::judge_file_type($filetype_bin);
            if (empty($analyser_map[$filetype])) {
                echo "!!error!! unknown file type. {$filetype_bin}" . PHP_EOL;
                return;
            }
            return (new $analyser_map[$filetype])->get_image_size($s3_header_bin);
        }
    });

    $getimagesize_result = measure_run_time(function () use ($url) {
        list($w, $h) = getimagesize($url);
        return [$w, $h];
    });

    return [
        "curl" => $curl_result,
        "getimagesize" => $getimagesize_result
    ];
}

$urls = [
    "http://localhost:8080/test/1280x720.jpg",
    "http://localhost:8080/test/2000x3000.jpg",
    "http://localhost:8080/test/1084x501.png",
    "http://localhost:8080/test/300x168_anim.gif",
    "http://localhost:8080/test/78x78.gif"
];

foreach ($urls as $url) {
    echo "url: {$url}" . PHP_EOL;
    $reslut = curl_vs_getimagesize($url);
    print_r($reslut);
}
