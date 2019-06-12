<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class Entity extends Enum {
    const NONE = 0;
    const ABSTRACT = 1;
    const ENTIY = 2;
    const CHARACTER = 3;
    const ITEM = 4;
    const FURNITURE = 5;
    const DOOR = 6;
    const SPELL = 7;
}
