<?php
header('Content-Type: application/json');

// URL-ul API-ului pentru a obține informațiile despre cursele F1
$url = "https://ergast.com/api/f1/current/last/results.json";

// Inițializează cURL
$ch = curl_init();

// Setează opțiunile cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execută cURL
$response = curl_exec($ch);

// Verifică dacă a apărut o eroare
if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    exit;
}

// Închide cURL
curl_close($ch);

// Decodează răspunsul JSON
$data = json_decode($response, true);

// Verifică dacă datele sunt disponibile
if (isset($data['MRData']['RaceTable']['Races'][0])) {
    $race = $data['MRData']['RaceTable']['Races'][0];
    echo json_encode([
        'date' => $race['date'],
        'Results' => $race['Results']
    ]);
} else {
    echo json_encode(['error' => 'No race data found']);
}
?>