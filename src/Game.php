<?php
namespace Gem;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Game implements MessageComponentInterface
{
    protected $clients;
    private $clientIdentifiers;
    private $buf;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->clientIdentifiers = [];
        $this->buf;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "New connection! (" . spl_object_id($conn) . ")\n";
        // $this->buf[spl_object_id($conn)] = fopen('logger_'. spl_object_id($conn) .'.txt', 'a+');

        $color = "rgb(" . random_int(0, 255) . "," . random_int(0, 255) . "," . random_int(0, 255). ")";
        $init = ['x' => random_int(0, 100), 'y' => random_int(0, 100), 'color' => $color];
        $this->clientIdentifiers[spl_object_id($conn)] = $init;
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        var_dump($msg);
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , spl_object_id($from), $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            $data = json_decode($msg, true);
            $this->clientIdentifiers[spl_object_id($from)]['x'] = $data['x'];
            $this->clientIdentifiers[spl_object_id($from)]['y'] = $data['y'];
            $client->send(json_encode($this->clientIdentifiers));
        }

        // fwrite($this->buf, json_encode($this->clientIdentifiers) . "\n");
    }

    public function onClose(ConnectionInterface $conn)
    {
        echo "Connection " . spl_object_id($conn) . " has disconnected\n";

        $clientId = $this->clientIdentifiers[spl_object_id($conn)] ?? null;


        if ($clientId !== null) {
            unset($this->clientIdentifiers[spl_object_id($conn)]);
            $this->clients->detach($conn);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $clientId = $this->clientIdentifiers[spl_object_id($conn)] ?? null;


        // fclose($this->buf[spl_object_id($conn)]);

        if ($clientId !== null) {
            unset($this->clientIdentifiers[spl_object_id($conn)]);
            $this->clients->detach($conn);
        }

        $conn->close();
    }
}