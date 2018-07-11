<?php
namespace PSDE;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use PSDE\NetworkController;
use PSDE\MessageRouter;
use PSDE\Utils;

class Server {
    protected static $clients = array();
    protected static $players = array();
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
    public static function setClientPlayer(ConnectionInterface $conn, Player $player) {
        self::$players[$conn->resourceId] = $player;
    }
    public static function getPlayerByID($id) {
        if (array_key_exists($id, self::$players)) {
            return self::$players[$id];
        }
        else {
            return null;
        }
    }
    public static function getClientByUUID($uuid) {
    	if (array_key_exists($uuid, self::$uuidClient)) {
    		return self::$uuidClient[$uuid];
    	}
    	else {
    		return "";
    	}
    }
    public static function getClientByID($id) {
        if (array_key_exists($id, self::$clients)) {
            return self::$clients[$id];
        }
        else {
            return "";
        }
    }
    public static function getUUIDByClient($conn) {
    	if ($conn instanceof ConnectionInterface) {
    		return self::getUUIDByClientID($conn->resourceId);
    	}
    	else if (is_int($conn)) {
            return self::getUUIDByClientID($conn);
    	}
    }
    public static function getUUIDByClientID($connId) {
    	if (array_key_exists($connId, self::$clientUUID)) {
    		return self::$clientUUID[$connId];
    	}
    	else {
    		return "";
    	}
    }
    public static function deleteClient($conn) {
        $uuid = self::getUUIDByClientID($conn->resourceId);
        $player = self::getPlayerByID($conn->resourceId);

        unset(self::$clientPlayer[$conn->resourceId]);
        unset(self::$uuidClient[$uuid]);
        unset(self::$players[$conn->resourceId]);
        unset($player);
        unset(self::$clients[$conn->resourceId]);
        self::broadcast(json_encode(array("type"=>"S_DESTROY_PLAYER","content"=>$uuid)));
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
        else {
            return null;
        }
    }
    public static function sendAcceptConnection(ConnectionInterface $conn) {
        Server::sendMessage($conn, json_encode(array(
            "type"=>"S_ACCEPT_CONNECTION",
            "content"=>$conn->resourceId
        ), true));
    }
    public static function broadcast($msg = "") {
        foreach (self::$clients as $client) {
            self::sendMessage($client, $msg);
        }
    }
    public static function broadcastPlayerLocRotScales() {
        $arr = array();
        foreach (self::$players as $player) {
            $arr[] = $player->getLocRotScale();
        }
        self::broadcast(json_encode(array("type"=>"S_UPDATE_LOCROTSCALES_PLAYERS","content"=>$arr), true));
    }
    public static function getClients() {
        return self::$clients;
    }
    public static function getPlayers() {
        return self::$players;
    }
    public static function handleChatMessageEvent($message) {

    }
}