<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\Damage;
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

    static function withinRange($entityA, $entityB) {

    }
    static function inFrontOf($entityA, $entityB, $epsilon = Utils::EPSILON) {

    }
    static function calculateDamage($defender, $attacker) {
        $didHit = false;
        $attackRoll = Game::roll(1, 20);
        if (Game::withinRange($attacker, $defender) && Game::inFrontOf($attacker, $defender)) {
            $didHit = $attackRoll > $defender.getArmourClass();
        }
        if (didHit) {
            $damageRollCount = 1;
            $damageRoll = 0;
            $damageType = Damage::BLUDGEONING;
            $unarmed = false;
            if ($attacker.isRightHanded() && $attacker.getEquipment()["HAND_R"] instanceof InstancedWeaponEntity) {
                $damageRollCount = $attacker.getEquipment()["HAND_R"].getDamageRollCount();
                $damageRoll = $attacker.getEquipment()["HAND_R"].getDamageRoll();
                $damageType = $attacker.getEquipment()["HAND_R"].getDamageType();
            }
            else if ($attacker.isLeftHanded() && $attacker.getEquipment()["HAND_L"] instanceof InstancedWeaponEntity) {
                $damageRollCount = $attacker.getEquipment()["HAND_L"].getDamageRollCount();
                $damageRoll = $attacker.getEquipment()["HAND_L"].getDamageRoll();
                $damageType = $attacker.getEquipment()["HAND_L"].getDamageType();
            }
            else {
                $unarmed = true;
            }
            if ($unarmed) {
                $damageRoll = 1 + Game::calculateAbilityModifier($attacker.getStrength());
                if ($damageRoll < 0) {
                    $damageRoll = 0;
                }
                return $damageRoll;
            }
            else {
                return Game::roll($damageRollCount, $damageRoll);
            }
        }
        return 0;
    }
}