<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\DamageEnum;
use PSDE\Enum\EntityEnum;
use PSDE\Player;
use PSDE\Vector2;
use PSDE\Vector3;

class Game {
    function __constructor() {}
    static function roll($die = 1, $faces = 6, $rollType = 0) {
        switch ($rollType) {
            case 0: {
                $total = 0;
                for ($i = 0; $i < $die; $i++) {
                    $total += rand(1, $faces);
                }
                return number_format($total, 1);
            }
            case 1: {
                $min = 1;
                $roll = 0;
                for ($i = 0; $i < $die; $i++) {
                    $roll = rand(1, $faces);
                    if ($roll < $min) {
                        $min = $roll;
                    }
                }
                return number_format($min, 1);
            }
            case 2: {
                $total = 0;
                for ($i = 0; $i < $die; $i++) {
                    $total += rand(1, $faces);
                }
                return number_format($total/$die, 4);
            }
            case 3: {
                $max = 1;
                $roll = 0;
                for ($i = 0; $i < $die; $i++) {
                    $roll = rand(1, $faces);
                    if ($roll > $max) {
                        $max = $roll;
                    }
                }
                return number_format($max, 1);
            }
        }
        return 1.0;
    }

    static function withinRange($entityA, $entityB, $distance = 0.6) {
        if ($distance <= 0) {
            $distance = $entityA.getHeight();
            if ($entityB.getHeight() > $distance) {
                $distance = $entityB.getHeight();
            }
            $distance = $distance * 0.75; // assuming arm length is half of the body length, idk
        }
        return $entityA->getPosition()->equalsWithEpsilon($entityB->getPosition(), $distance);
    }
    static function inFrontOf($entityA, $entityB, $epsilon = Utils::EPSILON) {
        $rotV = new Vector2(cos($entityA->getRotation()->y), sin($entityA->getRotation()->y));
        $radFace = acos((($rotV->y * ($entityB->getPosition()->z - $entityA->getPosition()->z)) + ($rotV->x * ($entityB->getPosition()->x - $entityA->getPosition()->x))) / sqrt(pow($entityB->getPosition()->z - $entityA->getPosition()->z, 2) + pow($entityB->getPosition()->x - $entityA->getPosition()->x, 2))) - 1;
        return ($epsilon/2 >= $radFace);
    }
    static function calculateDamage($defender, $attacker) {
        $didHit = false;
        $attackRoll = Game::roll(1, 20);
        if (Game::withinRange($attacker, $defender) && Game::inFrontOf($attacker, $defender)) {
            $didHit = $attackRoll > $defender->getArmourClass();
        }
        if ($didHit) {
            return 1;
            /*$damageRollCount = 1;
            $damageRoll = 0;
            $damageType = DamageEnum::BLUDGEONING;
            $unarmed = true;
            if ($attacker->isRightHanded() && $attacker->getEquipment()["HAND_R"] instanceof InstancedWeaponEntity) {
                $damageRollCount = $attacker->getEquipment()["HAND_R"].getDamageRollCount();
                $damageRoll = $attacker->getEquipment()["HAND_R"].getDamageRoll();
                $damageType = $attacker->getEquipment()["HAND_R"].getDamageType();
            }
            else if ($attacker->isLeftHanded() && $attacker->getEquipment()["HAND_L"] instanceof InstancedWeaponEntity) {
                $damageRollCount = $attacker->getEquipment()["HAND_L"].getDamageRollCount();
                $damageRoll = $attacker->getEquipment()["HAND_L"].getDamageRoll();
                $damageType = $attacker->getEquipment()["HAND_L"].getDamageType();
            }
            else {
                $unarmed = true;
            }
            if ($unarmed) {
                $damageRoll = 1 + Game::calculateAbilityModifier($attacker->getStrength());
                if ($damageRoll < 0) {
                    $damageRoll = 0;
                }
                return $damageRoll;
            }
            else {
                return Game::roll($damageRollCount, $damageRoll);
            }*/
        }
        return 0;
    }
}