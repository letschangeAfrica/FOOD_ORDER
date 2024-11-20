<?php
// process_payment.php

header('Content-Type: application/json');

// Step 1: Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$paymentMethod = $_POST['paymentMethod'] ?? null;
$mobileNumber = $_POST['mobileNumber'] ?? null;
$amount = $_POST['amount'] ?? null;

if (!$paymentMethod || !$mobileNumber || !$amount) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

// Step 2: Basic Validation
if (!preg_match('/^[67]\d{8}$/', $mobileNumber)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid mobile number']);
    exit;
}

if (!in_array($paymentMethod, ['mtn', 'orange'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid payment method']);
    exit;
}

// Step 3: Handle Payment via API
$paymentStatus = false;
switch ($paymentMethod) {
    case 'mtn':
        $paymentStatus = processMTNMobileMoney($mobileNumber, $amount);
        break;

    case 'orange':
        $paymentStatus = processOrangeMoney($mobileNumber, $amount);
        break;
}

// Step 4: Return Response
if ($paymentStatus) {
    echo json_encode(['status' => 'success', 'message' => 'Payment processed successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Payment failed. Please try again.']);
}

// Function to simulate MTN Mobile Money API request
function processMTNMobileMoney($mobileNumber, $amount)
{
    // API Integration for MTN Mobile Money
    // Example payload for a POST request to MTN API
    $apiUrl = "https://sandbox.mtn.com/momapi/v1/transactions";
    $payload = [
        'mobileNumber' => $mobileNumber,
        'amount' => $amount,
        'currency' => 'XAF',
        'description' => 'Food Order Payment',
    ];

    $response = makeApiRequest($apiUrl, $payload);
    return $response['status'] === 'success';
}

// Function to simulate Orange Money API request
function processOrangeMoney($mobileNumber, $amount)
{
    // API Integration for Orange Money
    // Example payload for a POST request to Orange API
    $apiUrl = "https://sandbox.orange.com/orangemoney/v1/transactions";
    $payload = [
        'mobileNumber' => $mobileNumber,
        'amount' => $amount,
        'currency' => 'XAF',
        'description' => 'Food Order Payment',
    ];

    $response = makeApiRequest($apiUrl, $payload);
    return $response['status'] === 'success';
}

// Function to make an API request
function makeApiRequest($url, $payload)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer YOUR_API_KEY' // Replace with your API key
    ]);

    $response = curl_exec($ch);

    // Log any curl errors
    if (curl_errno($ch)) {
        error_log('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    // Log the raw API response for debugging
    error_log('API Response: ' . $response);

    return json_decode($response, true);
}

?>
