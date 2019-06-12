<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class Item extends Enum {
    const NONE = 0;
    const GENERAL = 1;
    const APPAREL = 2;
    const KEY = 3;
    const WEAPON = 4;
    const CONSUMABLE = 5;
    const BOOK = 6;
    const TRASH = 7;
}
