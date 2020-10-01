<?php
namespace PSDE\Enum;

use PSDE\Enum;

abstract class RespondTo extends Enum {
    const NONE = 0;
    const ALL = 1;
    const SENDER = 2;
    const SENDER_RECEIVER = 3;
    const RECEIVER = 3;
}
