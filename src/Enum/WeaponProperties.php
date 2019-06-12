<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class WeaponProperties extends Enum {
    const NONE = 0;
    const AMMUNITION = 1;
    const FINESSE = 2;
    const HEAVY = 3;
    const LIGHT = 4;
    const LOADING = 5;
    const RANGE = 6;
    const REACH = 7;
    const SPECIAL = 8;
    const THROWN = 9;
    const TWOHANDED = 10;
    const VERSATILE = 11;
}
