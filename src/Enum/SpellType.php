<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class SpellType extends Enum {
    const NONE = 0;
    const ABJURATION = 1;
    const CONJURATION = 2;
    const DIVINATION = 3;
    const ENCHANTMENT = 4;
    const EVOCATION = 5;
    const ILLUSION = 6;
    const NECROMANCY = 7;
    const TRANSMUTATION = 8;
    const UNIVERSAL = 9;
}
