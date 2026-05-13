<?php

$url = "https://social-download-all-in-one.p.rapidapi.com/v1/social/autolink";
$apiKey = "AeqqKB3Ae8mshyHRazfZd31aMzIGp1dETm8jsnTaQFN9LxdwYE";
$host = "social-download-all-in-one.p.rapidapi.com";

// YouTube URLs to test
$testUrls = [
    "https://www.youtube.com/watch?v=dQw4w9WgXcQ", // Regular video
    "https://youtu.be/dQw4w9WgXcQ", // Shortened URL
    "https://www.youtube.com/shorts/sTfI_o7o-0w" // Shorts
];

foreach ($testUrls as $videoUrl) {
    echo "Testing URL: $videoUrl\n";
    
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode(["url" => $videoUrl]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-RapidAPI-Host: $host",
            "X-RapidAPI-Key: $apiKey"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err . "\n";
    } else {
        $decoded = json_decode($response, true);
        echo "Response Status: " . ($decoded['status'] ?? 'unknown') . "\n";
        echo "Response Body: " . json_encode($decoded, JSON_PRETTY_PRINT) . "\n";
    }
    echo "--------------------------------------------------\n";
}
