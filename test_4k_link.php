<?php

$url = "https://social-download-all-in-one.p.rapidapi.com/v1/social/autolink";
$apiKey = "AeqqKB3Ae8mshyHRazfZd31aMzIGp1dETm8jsnTaQFN9LxdwYE";
$host = "social-download-all-in-one.p.rapidapi.com";

$videoUrl = "https://youtu.be/54ppjEkWez0?si=Q2CAzLPH_hbl7oG3";

echo "Testing 4K Video URL: $videoUrl\n";

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
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err . "\n";
} else {
    $decoded = json_decode($response, true);
    echo "Title: " . ($decoded['data']['title'] ?? 'N/A') . "\n";
    
    $medias = $decoded['data']['medias'] ?? [];
    echo "Total Formats Found: " . count($medias) . "\n\n";
    
    echo "Available High Quality Formats:\n";
    foreach ($medias as $media) {
        if (isset($media['height']) && $media['height'] >= 1080) {
            echo "- Quality: {$media['quality']}, Format: {$media['ext']}, Height: {$media['height']}p\n";
        }
    }
}
