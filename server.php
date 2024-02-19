<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// Make sure composer dependencies have been installed
require __DIR__ . '/vendor/autoload.php';



// $buf = fopen('logger.txt', 'a+');
$data = [];
/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class MyChat implements MessageComponentInterface
{
    protected $clients;
    private $clientIdentifiers;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->clientIdentifiers = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "New connection!\n";
        // $color = "rgb(" . random_int(0, 255) . "," . random_int(0, 255) . "," . random_int(0, 255). ")";
        // $init = ['x' => random_int(0, 100), 'y' => random_int(0, 100), 'color' => $color];
        // $this->clientIdentifiers[spl_object_id($conn)] = $init;
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection sending message "%s" to %d other connection%s' . "\n"
        , $msg, $numRecv, $numRecv == 1 ? '' : 's');
        foreach ($this->clients as $key => $client) {
            // $data = json_decode($msg, true);
            // $this->clientIdentifiers[spl_object_id($from)]['x'] = $data['x'];
            // $this->clientIdentifiers[spl_object_id($from)]['y'] = $data['y'];
            // $client->send(json_encode($this->clientIdentifiers));
            $client->send($msg);
        }
        // fwrite($GLOBALS['buf'], json_encode($this->clientIdentifiers) . "\n");
    }

    public function onClose(ConnectionInterface $conn)
    {
        echo "Connection has disconnected\n";
    
        // $clientId = $this->clientIdentifiers[spl_object_id($conn)] ?? null;
        // if ($this->clients === null) {
            // fclose($GLOBALS['buf']);
        // }

        // if ($clientId !== null) {
        //     unset($this->clientIdentifiers[spl_object_id($conn)]);
        //     $this->clients->detach($conn);
        // }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        // $clientId = $this->clientIdentifiers[spl_object_id($conn)] ?? null;

        // if ($this->clients === null) {
            // fclose($GLOBALS['buf']);
        // }

        // if ($clientId !== null) {
        //     unset($this->clientIdentifiers[spl_object_id($conn)]);
        //     $this->clients->detach($conn);
        // }

        $conn->close();
    }
}

// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('localhost', 8080, '172.19.16.1' );
$app->route('/chat', new MyChat, array('*'));
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
$app->run();
