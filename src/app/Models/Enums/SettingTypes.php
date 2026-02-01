<?php

namespace App\Models\Enums;

enum SettingTypes:int {
    case String = 0;
    case Boolean = 1;
    case Encrypted = 2;
    case Dropdown = 3;
}