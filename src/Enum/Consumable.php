<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class Consumable extends Enum {
    const NONE = 0;
    const FOOD = 1;
    const DRINK = 2;
    const MEDICINE = 3;
}
