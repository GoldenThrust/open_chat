<?php
namespace Gem;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Stream implements MessageComponentInterface
{
    protected $clients;
    private $clientIdentifiers;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $init = [
            'type' => 'stream',
            'data' => 'stream',
        ];
        $this->clientIdentifiers[spl_object_id($conn)] = $init;
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg, true);

        $this->clientIdentifiers[spl_object_id($from)] = $msg;

        foreach ($this->clients as $client) {
            $client->send(json_encode($this->clientIdentifiers));
        }

    }

    public function onClose(ConnectionInterface $conn)
    {
        $clientId = $this->clientIdentifiers[spl_object_id($conn)] ?? null;


        if ($clientId !== null) {
            unset($this->clientIdentifiers[spl_object_id($conn)]);
            $this->clients->detach($conn);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}