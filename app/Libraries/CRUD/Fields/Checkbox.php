<?php

namespace App\Libraries\CRUD\Fields;

use App\Libraries\CRUD\Fields\Field;

class Checkbox extends Field
{
    /**
     * Create a new checkbox field and sets name, label and type
     *
     * @param  String $name
     *
     * @return Checkbox
     */
    public static function field($name): Checkbox
    {
        $a = new self();
        $a->name($name);
        $a->label($name);
        $a->type('checkbox');
        return $a;
    }
}
