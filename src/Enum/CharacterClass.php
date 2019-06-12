<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class CharacterClass extends Enum {
    const NONE = 0;
    const BARD = 1;
    const CLERIC = 2;
    const DRUID = 3;
    const PALADIN = 4;
    const RANGER = 5;
    const SORCERER = 6;
    const WARLOCK = 7;
    const WIZARD = 8;
    const CLASSLESS = 9;
    const COMMONER = 10;
    const EXPERT = 11;
    const NOBLE = 12;
}
