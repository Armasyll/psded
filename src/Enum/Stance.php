<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class Stance extends Enum {
    const NONE = 0;
    const LAY = 1;
    const SIT = 2;
    const CROUCH = 3;
    const STAND = 4;
    const FLY = 5;
    const FALL = 6;
    const SWIM = 7;
}
