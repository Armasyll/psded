<?php
namespace PSDE;

use PSDE\MessageListener;
use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\ActionEnum;
use PSDE\Enum\EntityEnum;
use PSDE\Enum\RespondTo;
use PSDE\Game;

class MessageRouter {
    public static function incoming($event) {
        $time = time();
        if (!isset($event["client"])) {
            return 2;
        }
        $client = $event["client"];
        if (!isset($event["message"]["cmd"])) {
            return 2;
        }
        $command = $event["message"]["cmd"];
        if (isset($event["message"]["sta"])) {
            $status = $event["message"]["sta"];
        }
        else {
            $status = 0;
        }
        if (isset($event["message"]["msg"])) {
            $message = $event["message"]["msg"];
        }
        else {
            $message = null;
        }
        if (isset($event["message"]["callbackID"])) {
            $callbackID = $event["message"]["callbackID"];
        }
        else {
            $callbackID = "";
        }
        switch ($command) {
            case "P_REQUEST_JOIN_SERVER" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_JOIN_SERVER with `" . json_encode($message, true) . "`\n");
                Server::postMessage($client, RespondTo.SENDER, null, "S_ACCEPT_JOIN_SERVER", 0, array(Utils::genUUIDv4()));
                break;
            }
            case "P_REQUEST_UUID" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_UUID with `" . json_encode($message, true) . "`\n");
                Server::setClientUUID($client, $message);
                Server::postMessage($client, RespondTo.SENDER, null, "S_ACCEPT_UUID", 0, array("uuid"=>$message, "nid"=>$client->resourceId));
                break;
            }
            case "P_CHAT_MESSAGE" : {
                echo sprintf("MessageRouter::incoming :     P_PUBLIC_CHAT_MESSAGE with `" . json_encode($message, true) . "`\n");
                if (mb_substr($message, 0, 1) == '/') {
                    Server::handleChatMessageEvent($event);
                }
                else {
                    Server::postMessage($client, RespondTo.ALL, null, "S_CHAT_MESSAGE", 0, array("time"=>$time, "from"=>Server::getUUIDByID($client->resourceId), "to"=>"all", "message"=>Utils::sanitizeString($message)));
                }
                break;
            }
            case "P_INIT_SELF" : {
                echo sprintf("MessageRouter::incoming :     P_INIT_SELF with `" . json_encode($message, true) . "`\n");
                $player = new PlayerEntity(
                    $message[0],
                    $client->resourceId,
                    $message[1],
                    $message[2],
                    $message[3],
                    $message[4],
                    $message[5],
                    $message[6],
                    $message[7],
                    $message[8],
                    $message[9]
                );
                if ($player instanceof PlayerEntity) {
                    echo sprintf("    PlayerEntity created successfully.");
                    $player->setMovementKeys($message[10]);
                    Server::setClientPlayer($client, $player);
                    Server::$positionsChanged = true;
                    Server::postMessage($client, RespondTo.SENDER, null, "S_ACCEPT_INIT_SELF", 0, $player);
                }
                break;
            }
            case "P_UPDATE_LOCROTSCALE_SELF" : {
                //echo sprintf("MessageRouter::incoming :     P_UPDATE_PLAYER_LOCROT with `" . json_encode($message, true) . "`\n");
                $player = Server::getPlayerByID($client->resourceId);
                if ($player instanceof PlayerEntity) {
                    $player->setPosition($message[0]);
                    $player->setRotation($message[1]);
                    $player->setScaling($message[2]);
                    $player->setMovementKeys($message[3]);
                    Server::$positionsChanged = true;
                }
                break;
            }
            case "P_UPDATE_MOVEMENTKEYS_SELF" : {
                //echo sprintf("MessageRouter::incoming :     P_UPDATE_MOVEMENTKEYS_SELF with `" . json_encode($message, true) . "`\n");
                $player = Server::getPlayerByID($client->resourceId);
                if ($player instanceof PlayerEntity) {
                    $player->setMovementKeys($message);
                    Server::$positionsChanged = true;
                }
                break;
            }
            case "P_REQUEST_PLAYER" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_PLAYER with `" . json_encode($message, true) . "`\n");
                $player = Server::getPlayerByID($message);
                if ($player instanceof PlayerEntity) {
                    Server::postMessage($client, RespondTo.SENDER, null, "S_SEND_PLAYER", 0, $player->getAll());
                }
                break;
            }
            case "P_REQUEST_ALL_PLAYERS" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_ALL_PLAYERS with `" . json_encode($message, true) . "`\n");
                $players = [];
                foreach (Server::getPlayers() as $player) {
                    if ($player->getNetworkID() != $client->resourceId) {
                        $players[] = $player->getAll();
                    }
                }
                Server::postMessage($client, RespondTo.SENDER, null, "S_SEND_ALL_PLAYERS", 0, $players);
                break;
            }
            case "P_REQUEST_ENTITY_ACTION" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_ENTITY_ACTION with `" . json_encode($message, true) . "`\n");
                if ($message[0] == EntityEnum::CHARACTER && Server::hasUUID($message[1])) {
                    $entity = Server::getPlayerByUUID($message[1]);
                }
                else {
                    $entity = null;
                }
                if ($message[2] == EntityEnum::CHARACTER && Server::hasUUID($message[3])) {
                    $subEntity = Server::getPlayerByUUID($message[3]);
                }
                else {
                    echo "\tSubEntity does not exist.";
                    return 2;
                }
                $content = array(
                    $message[0],
                    $message[1],
                    $message[2],
                    $message[3],
                    $message[4]
                );
                if ($message[4] == ActionEnum::ATTACK && $entity instanceof PlayerEntity) {
                    array_push($content, Game::calculateDamage($entity, $subEntity));
                }
                Server::postMessage($client, RespondTo.ALL, null, "S_DO_ENTITY_ACTION", 0, $content);
            }
            default : {
                echo sprintf("MessageRouter::incoming :     NOTHING with `" . json_encode($message, true) . "`\n");
                return 2;
            }
        }
    }
}
