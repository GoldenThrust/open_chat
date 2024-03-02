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
            'id' => spl_object_id($conn),
            'type' => 'created',
            'data' => '',
        ];
        $this->clientIdentifiers[spl_object_id($conn)] = $init;
        $this->clients->attach($conn);
        var_dump($this->clientIdentifiers[spl_object_id($conn)]);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg, true);
        // var_dump($msg);

        $this->clientIdentifiers[spl_object_id($from)]['type'] = $msg['type'];
        $this->clientIdentifiers[spl_object_id($from)]['data'] = $msg['data'];

        foreach ($this->clients as $client) {
            $client->send(json_encode($this->clientIdentifiers));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $init = [
            'id' => spl_object_id($conn),
            'type' => 'terminate',
        ];
        $clientId = $this->clientIdentifiers[spl_object_id($conn)] ?? null;


        if ($clientId !== null) {
            unset($this->clientIdentifiers[spl_object_id($conn)]);
            $this->clients->detach($conn);
        }

        foreach ($this->clients as $client) {
            $client->send(json_encode($init));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}