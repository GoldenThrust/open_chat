<?php

require 'vendor/autoload.php';

use WebSocket\Client;

// WebSocket server URL
$serverUrl = 'ws://localhost:8080/echo';

// Create a WebSocket client
$client = new Client($serverUrl);

// Send a message to the server
$message = 'Hello Me!';
$client->send($message);

// Receive and display the server's response
$response = $client->receive();
echo "Server says: $response\n";

// Close the WebSocket connection
$client->close();
