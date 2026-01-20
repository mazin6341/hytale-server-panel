<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model {
    protected $fillable = [
        'name',
        'detail',
        'section',
        'value',
        'is_boolean',
        'is_encrypted',
    ];

    public function getValue() {
        if($this->is_encrypted)
            if($this->value)
                return decrypt($this->value);
            else
                return null;
        else
            if($this->is_boolean)
                return boolval($this->value);
            else
                return $this->value;
    }
}
