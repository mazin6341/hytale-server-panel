<?php

namespace App\Models;

use App\Models\Enums\SettingTypes;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model {
    protected $fillable = [
        'section_id',
        'name',
        'detail',
        'type',
        'value',
        'options',
        'depends_on',
    ];

    protected $casts = [
        'type' => SettingTypes::class,
    ];

    public function getValue() {
        if($this->type == SettingTypes::Encrypted)
            if($this->value)
                return decrypt($this->value);
            else
                return null;
        else
            if($this->type == SettingTypes::Boolean)
                return boolval($this->value);
            else
                return $this->value;
    }

    public function getDropdown(): array {
        if($this->type == SettingTypes::Dropdown) {
            if($this->options)
                return (array)json_decode($this->options);
            else
                return [];
        } else
            return [];
    }
}
