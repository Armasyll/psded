<?php
namespace PSDE;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use PSDE\Server;
use PSDE\MessageRouter;
use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\RespondTo;

class MessageListener implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        echo "MessageListener : Initializing\n";
        $this->clients = new \SplObjectStorage;
    }

    public function getClients() {
        return $this->clients;
    }

    public function onOpen(ConnectionInterface $conn, $msg = "") {
        $this->clients->attach($conn);
        Server::sendAcceptConnection($conn);

        echo "MessageListener::onOpen : New connection! ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn, $msg = "") {
        Server::deleteClient($conn);
        $this->clients->detach($conn);

        echo "MessageListener::onClose : Connection {$conn->resourceId} has disconnected.\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "MessageListener::onError : An error has occurred: {$e->getMessage()}\n";

        $this->clients->detach($conn);
        $conn->close();
    }

    public function onMessage(ConnectionInterface $conn, $msg = "") {
        //echo sprintf("\nMessageListener::onMessage : Connection %d (%s) sending message `%s`\n", $conn->resourceId, Server::getUUIDByID($conn->resourceId), $msg);
        $msg = (array) json_decode(html_entity_decode($msg), true);
        if (!isset($msg["cmd"])) {
            echo sprintf("MessageListener::onMessage :     Client %d attempt to send an invalid message.\n", $conn->resourceId);
            return null;
        }
        //echo sprintf("MessageListener::onMessage :     Client %d sent `%s` with a request type of `%s`\n", $conn->resourceId, json_encode($msg["msg"], true), $msg["cmd"]);
        return MessageRouter::incoming(array("client"=>$conn,"message"=>$msg));
    }
}
