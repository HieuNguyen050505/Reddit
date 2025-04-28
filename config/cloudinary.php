<?php
use Cloudinary\Configuration\Configuration;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Retrieve environment variables with fallbacks
$cloudName = $_ENV['CLOUDINARY_CLOUD_NAME'];
$apiKey = $_ENV['CLOUDINARY_API_KEY'];
$apiSecret = $_ENV['CLOUDINARY_API_SECRET'];

try {
    $config = Configuration::instance([
        'cloud' => [
            'cloud_name' => $cloudName,
            'api_key' => $apiKey,
            'api_secret' => $apiSecret
        ],
        'url' => [
            'secure' => true
        ]
    ]);
    return $config; // Return the configuration instance
} catch (Exception $e) {
    error_log("Cloudinary configuration failed: " . $e->getMessage());
    http_response_code(500);
    exit('Internal Server Error: Unable to configure Cloudinary');
}
?>