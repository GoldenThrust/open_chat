<?php
namespace Gem;
$db = new Database('localhost', 'game', 'root', '');

define('USER', new User($db));
define('UPLOADDIR', "public" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR);


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $names;
    protected $clientIdentifiers;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg, true);

        var_dump($msg);

        if (isset($msg['username'])) {
            $picture = USER->getPicture($msg['username']);
            $this->clientIdentifiers[spl_object_id($from)] = ['name' => $msg['username'], 'picture' => UPLOADDIR . $picture];
        }

        if (!isset($this->clientIdentifiers[spl_object_id($from)])) {
            $from->close();
        }

        $msg['user'] = $this->clientIdentifiers[spl_object_id($from)];
        $msg = json_encode($msg);

        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $msg = [
            'user' => $this->clientIdentifiers[spl_object_id($conn)],
            'type' => 'alert',
            'message' => 'has left the chat'
        ];
    
        unset($this->clientIdentifiers[spl_object_id($conn)]);
        $this->clients->detach($conn);


        $msg = json_encode($msg);

        foreach ($this->clients as $client) {
            $client->send($msg);
        }
        
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {        
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
