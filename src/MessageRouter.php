<?php
namespace PSDE;

use PSDE\MessageListener;
use PSDE\Utils;

class MessageRouter {
    public static function incoming($event) {
        $time = time();
        switch ($event["request"]["type"]) {
            case "P_REQUEST_JOIN_SERVER" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_JOIN_SERVER with `" . json_encode($event["request"]["content"], true) . "`\n");
                return array(
                    "respondTo"=>"sender",
                    "response"=>array(
                        "type"=>"S_ACCEPT_JOIN_SERVER",
                        "content"=>Utils::genUUIDv4()
                    )
                );
                break;
            }
            case "P_REQUEST_UUID" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_UUID with `" . json_encode($event["request"]["content"], true) . "`\n");
                Server::setClientUUID($event["client"], $event["request"]["content"]);
                return array(
                    "respondTo"=>"sender",
                    "response"=>array(
                        "type"=>"S_ACCEPT_UUID",
                        "content"=>array(
                            "uuid"=>$event["request"]["content"],
                            "nid"=>$event["client"]->resourceId
                        )
                    )
                );
                break;
            }
            case "P_CHAT_MESSAGE" : {
                echo sprintf("MessageRouter::incoming :     P_PUBLIC_CHAT_MESSAGE with `" . json_encode($event["request"]["content"], true) . "`\n");
                if (mb_substr($event["request"]["content"], 0, 1) == '/') {
                    Server::handleChatMessageEvent($event);
                }
                else {
                    return array(
                        "respondTo"=>"all",
                        "response"=>array(
                            "type"=>"S_CHAT_MESSAGE",
                            "content"=>array(
                                "time"=>$time,
                                "from"=>Server::getUUIDByClientID($event["client"]->resourceId),
                                "to"=>"all",
                                "message"=>Utils::sanitizeString($event["request"]["content"])
                            )
                        )
                    );
                }
                break;
            }
            case "P_INIT_SELF" : {
                echo sprintf("MessageRouter::incoming :     P_INIT_SELF with `" . json_encode($event["request"]["content"], true) . "`\n");
                $player = new Player(
                    $event["request"]["content"]["id"],
                    $event["client"]->resourceId,
                    $event["request"]["content"]["name"],
                    $event["request"]["content"]["age"],
                    $event["request"]["content"]["sex"],
                    $event["request"]["content"]["species"],
                    $event["request"]["content"]["mesh"],
                    $event["request"]["content"]["skin"]
                );
                $player->setLocRotScale(
                    $event["request"]["content"]["position"],
                    $event["request"]["content"]["rotation"],
                    $event["request"]["content"]["scaling"]
                );
                if ($player instanceof Player) {
                    $player->setMovementKeys($event["request"]["content"]["movementKeys"]);
                    Server::setClientPlayer($event["client"], $player);
                    Server::$positionsChanged = true;
                    return array(
                        "respondTo"=>"sender",
                        "response"=>array(
                            "type"=>"S_ACCEPT_INIT_SELF",
                            "content"=>$player
                        )
                    );
                }
                return null;
                break;
            }
            case "P_UPDATE_LOCROTSCALE_SELF" : {
                //echo sprintf("MessageRouter::incoming :     P_UPDATE_PLAYER_LOCROT with `" . json_encode($event["request"]["content"], true) . "`\n");
                $player = Server::getPlayerByID($event["client"]->resourceId);
                if ($player instanceof Player) {
                    $player->setPosition($event["request"]["content"][0]);
                    $player->setRotation($event["request"]["content"][1]);
                    $player->setScaling($event["request"]["content"][2]);
                    $player->setMovementKeys($event["request"]["content"][3]);
                    Server::$positionsChanged = true;
                }
                return null;
                break;
            }
            case "P_UPDATE_MOVEMENTKEYS_SELF" : {
                //echo sprintf("MessageRouter::incoming :     P_UPDATE_MOVEMENTKEYS_SELF with `" . json_encode($event["request"]["content"], true) . "`\n");
                $player = Server::getPlayerByID($event["client"]->resourceId);
                if ($player instanceof Player) {
                    $player->setMovementKeys($event["request"]["content"]);
                    Server::$positionsChanged = true;
                }
                return null;
                break;
            }
            case "P_REQUEST_PLAYER" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_PLAYER with `" . json_encode($event["request"]["content"], true) . "`\n");
                $player = Server::getPlayerByID($event["request"]["content"]);
                if ($player instanceof Player) {
                    return array(
                        "respondTo"=>"sender",
                        "response"=>array(
                            "type"=>"S_SEND_PLAYER",
                            "content"=>$player->getAll()
                        )
                    );
                }
                break;
            }
            case "P_REQUEST_ALL_PLAYERS" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_ALL_PLAYERS with `" . json_encode($event["request"]["content"], true) . "`\n");
                $players = [];
                foreach (Server::getPlayers() as $player) {
                    if ($player->getNetworkID() != $event["client"]->resourceId) {
                        $players[] = $player->getAll();
                    }
                }
                return array(
                    "respondTo"=>"sender",
                    "response"=>array(
                        "type"=>"S_SEND_ALL_PLAYERS",
                        "content"=>$players
                    )
                );
                break;
            }
            default : {
                echo sprintf("MessageRouter::incoming :     NOTHING with `" . json_encode($event["request"]["content"], true) . "`\n");
                return null;
            }
        }
    }
}
