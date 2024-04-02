<?php

namespace App\Libraries\CRUD\Fields;

use App\Libraries\CRUD\Fields\Field;

class Date extends Field
{
    /**
     * Create a new date field and sets name, label and type
     *
     * @param  String $name
     *
     * @return Text
     */
    public static function field($name): Date
    {
        $a = new self();
        $a->name($name);
        $a->label($name);
        $a->type('date');
        return $a;
    }
}
