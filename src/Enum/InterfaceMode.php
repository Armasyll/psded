<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class InterfaceMode extends Enum {
    const NONE = 0;
    const CHARACTER = 1;
    const DIALOGUE = 2;
    const MENU = 3;
    const EDIT = 4;
    const WRITING = 5;
}
