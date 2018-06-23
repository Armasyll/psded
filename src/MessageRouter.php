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
            case "P_PUBLIC_CHAT_MESSAGE" : {
                echo sprintf("MessageRouter::incoming :     P_PUBLIC_CHAT_MESSAGE with `" . json_encode($event["request"]["content"], true) . "`\n");
                return array(
                    "respondTo"=>"all",
                    "response"=>array(
                        "type"=>"S_PUBLIC_CHAT_MESSAGE",
                        "content"=>array(
                            "time"=>$time,
                            "from"=>Server::getUUIDByClientID($event["client"]->resourceId),
                            "to"=>"all",
                            "message"=>Utils::sanitizeString($event["request"]["content"])
                        )
                    )
                );
                break;
            }
            case "P_INIT_SELF" : {
                echo sprintf("MessageRouter::incoming :     P_INIT_PLAYER with `" . json_encode($event["request"]["content"], true) . "`\n");
                $player = new Player(
                    $event["request"]["content"]["id"],
                    $event["client"]->resourceId,
                    $event["request"]["content"]["mesh"],
                    $event["request"]["content"]["position"],
                    $event["request"]["content"]["rotation"],
                    $event["request"]["content"]["scaling"]
                );
                Server::setClientPlayer($event["client"], $player);
                return array(
                    "respondTo"=>"sender",
                    "response"=>array(
                        "type"=>"S_ACCEPT_INIT_SELF",
                        "content"=>$player
                    )
                );
                Server::$positionsChanged = true;
                break;
            }
            case "P_UPDATE_LOCROT_SELF" : {
                //echo sprintf("MessageRouter::incoming :     P_UPDATE_PLAYER_LOCROT with `" . json_encode($event["request"]["content"], true) . "`\n");
                $player = Server::getPlayerByID($event["client"]->resourceId);
                $player->setPosition($event["request"]["content"][0]);
                $player->setRotation($event["request"]["content"][1]);
                $player->setMovementStatus($event["request"]["content"][2],$event["request"]["content"][3],$event["request"]["content"][4],$event["request"]["content"][5],$event["request"]["content"][6],$event["request"]["content"][7],$event["request"]["content"][8],$event["request"]["content"][9],$event["request"]["content"][10]);
                Server::$positionsChanged = true;
                return null;
                break;
            }
            case "P_REQUEST_PLAYER" : {
                echo sprintf("MessageRouter::incoming :     P_REQUEST_PLAYER with `" . json_encode($event["request"]["content"], true) . "`\n");
                if (Server::getPlayerByID($event["request"]["content"]) instanceof Player) {
                    $player = Server::getPlayerByID($event["request"]["content"]);
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
