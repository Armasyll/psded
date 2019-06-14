<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class ActionEnum extends Enum {
    const NONE = 0;
    const LAY = 1;
    const SIT = 2;
    const CROUCH = 3;
    const STAND = 4;
    const FLY = 5;
    const SLEEP = 6;
    const MOVE = 7;
    const CLOSE = 8;
    const CONSUME = 9;
    const DROP = 10;
    const EQUIP = 11;
    const HOLD = 12;
    const LOOK = 13;
    const OPEN = 14;
    const RELEASE = 15;
    const TAKE = 16;
    const TALK = 17;
    const TOUCH = 18;
    const UNEQUIP = 19;
    const USE = 20;
    const ATTACK = 21;
}
