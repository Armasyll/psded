<?php
namespace PSDE;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use PSDE\NetworkController;
use PSDE\MessageRouter;
use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\RespondTo;

/*
    ID is ConnectionInterface->resourceId
    UUID is Entity->id
*/

class Server {
    protected static $clients = array();
    protected static $entities = array();
    protected static $clientUUID = array();
    protected static $clientPlayer = array();
    protected static $uuidClient = array();
    public static $messageListener = null;
    public static $positionsChanged = true;

    public static function initialize() {
        echo "Server : Initializing\n";
        self::$messageListener = new MessageListener();
    }
    public static function setClientUUID(ConnectionInterface $conn, $uuid = null) {
    	if ($uuid == null) {
    		$uuid = Utils::genUUIDv4();
    	}
        self::$clients[$conn->resourceId] = $conn;
        self::$uuidClient[$uuid] = $conn;
        self::$clientUUID[$conn->resourceId] = $uuid;
        return $uuid;
    }
    public static function setClientPlayer(ConnectionInterface $conn, PlayerEntity $player) {
        self::$entities[$conn->resourceId] = $player;
    }
    public static function hasClientID($id) {
        return array_key_exists($id, self::$entities);
    }
    public static function hasUUID($uuid) {
        return array_key_exists($uuid, self::$uuidClient);
    }
    public static function getPlayerByID($id) {
        if (array_key_exists($id, self::$entities)) {
            return self::$entities[$id];
        }
        return null;
    }
    public static function getPlayerByUUID($uuid) {
        if (self::hasUUID($uuid)) {
            return self::getPlayerByID(self::getClientByUUID($uuid)->resourceId);
        }
        return null;
    }
    public static function getClientByID($id) {
        if (array_key_exists($id, self::$clients)) {
            return self::$clients[$id];
        }
        return null;
    }
    public static function getClientByUUID($uuid) {
    	if (array_key_exists($uuid, self::$uuidClient)) {
    		return self::$uuidClient[$uuid];
    	}
    	return null;
    }
    public static function getUUIDByID($connId) {
    	if (array_key_exists($connId, self::$clientUUID)) {
    		return self::$clientUUID[$connId];
    	}
    	return null;
    }
    public static function getIDByUUID($uuid) {
        if (self::hasUUID($uuid)) {
            return self::getClientByUUID($uuid)->resourceId;
        }
        return null;
    }
    public static function deleteClient($conn) {
        $uuid = self::getUUIDByID($conn->resourceId);
        $player = self::getPlayerByID($conn->resourceId);

        unset(self::$clientPlayer[$conn->resourceId]);
        unset(self::$uuidClient[$uuid]);
        unset(self::$entities[$conn->resourceId]);
        unset($player);
        unset(self::$clients[$conn->resourceId]);
        self::broadcast(json_encode(array("type"=>"S_DESTROY_PLAYER","content"=>$uuid)));
        return null;
    }
    public static function postMessage(ClientInterface $fromClient, int $respondTo, $toClient = null, string $command, int $status = 0, $message = null) {
        $blob = array("cmd"=>$command, "sta"=>$status);
        if ($message != null) {
            $blob["msg"] = $message;
        }
        switch ($respondTo) {
            case RespondTo.RECEIVER: {
                $toClient->send(json_encode($blob, true));
            }
            case RespondTo.SENDER: {
                $fromClient->send(json_encode($blob, true));
                break;
            }
            case RespondTo.ALL: {
                self::broadcast(json_encode($blob, true));
                break;
            }
        }
        return 0;
    }
    public static function sendMessage(ConnectionInterface $conn, $msg = "") {
        if ($conn instanceof ConnectionInterface) {
            $conn->send($msg);
        }
        else if ($conn instanceof Traversable && $conn[0] instanceof ConnectionInterface) {
            for($i = 0; $i < count($conn); $i++) {
                self::sendMessage($conn[$i], $msg);
            }
        }
        return 0;
    }
    public static function sendAcceptConnection(ConnectionInterface $conn) {
        self::sendMessage($conn, json_encode(array(
            "type"=>"S_ACCEPT_CONNECTION",
            "content"=>$conn->resourceId
        ), true));
        return 0;
    }
    public static function broadcast($msg = "") {
        foreach (self::$clients as $client) {
            self::sendMessage($client, $msg);
        }
        return 0;
    }
    public static function broadcastPlayerLocRotScales() {
        $arr = array();
        foreach (self::$entities as $player) {
            $arr[] = $player->getLocRotScale();
        }
        self::broadcast(json_encode(array("type"=>"S_UPDATE_LOCROTSCALES_PLAYERS","content"=>$arr), true));
        return 0;
    }
    public static function getClients() {
        return self::$clients;
    }
    public static function getPlayers() {
        return self::$entities;
    }
    public static function handleChatMessageEvent($message) {

    }
}