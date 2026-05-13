<?php

$url = "https://social-download-all-in-one.p.rapidapi.com/v1/social/autolink";
$apiKey = "AeqqKB3Ae8mshyHRazfZd31aMzIGp1dETm8jsnTaQFN9LxdwYE";
$host = "social-download-all-in-one.p.rapidapi.com";

// Testing Shorts ID in regular format
$shortsId = "sTfI_o7o-0w";
$testUrl = "https://www.youtube.com/watch?v=$shortsId";

echo "Testing Shorts ID as regular URL: $testUrl\n";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode(["url" => $testUrl]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-RapidAPI-Host: $host",
        "X-RapidAPI-Key: $apiKey"
    ],
]);

$response = curl_exec($curl);
$decoded = json_decode($response, true);
echo "Response Status: " . ($decoded['status'] ?? 'unknown') . "\n";
echo "Response Message: " . ($decoded['message'] ?? 'N/A') . "\n";
if (isset($decoded['data']['medias']) && count($decoded['data']['medias']) > 0) {
    echo "Medias found: " . count($decoded['data']['medias']) . "\n";
} else {
    echo "No medias found.\n";
}
curl_close($curl);
