<?php

$url = "https://social-download-all-in-one.p.rapidapi.com/v1/social/autolink";
$apiKey = "AeqqKB3Ae8mshyHRazfZd31aMzIGp1dETm8jsnTaQFN9LxdwYE";
$host = "social-download-all-in-one.p.rapidapi.com";

$videoUrl = "https://www.youtube.com/watch?v=54ppjEkWez0";

echo "Testing 4K Video URL (Clean): $videoUrl\n";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode(["url" => $videoUrl]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-RapidAPI-Host: $host",
        "X-RapidAPI-Key: $apiKey"
    ],
]);

$response = curl_exec($curl);
echo "Raw Response: $response\n";
curl_close($curl);
