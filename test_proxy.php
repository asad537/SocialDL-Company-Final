<?php
$url = 'https://www.w3schools.com/html/mov_bbb.mp4';
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_RETURNTRANSFER => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_USERAGENT      => 'Mozilla/5.0',
    CURLOPT_HTTPHEADER     => [
        'Referer: https://www.instagram.com/',
        'Accept: video/webm,video/mp4,video/*;q=0.9,*/*;q=0.8',
    ],
    CURLOPT_WRITEFUNCTION  => function ($ch, $chunk) {
        echo $chunk;
        return strlen($chunk);
    },
]);
ob_start();
curl_exec($ch);
$out = ob_get_clean();
curl_close($ch);
echo "Length: " . strlen($out) . "\n";
file_put_contents('test_vid.mp4', $out);
