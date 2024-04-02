<?php

namespace App\Libraries\CRUD\Fields;

use App\Libraries\CRUD\Fields\Field;

class Text extends Field
{
    /**
     * Create a new text field and sets name, label and type
     *
     * @param  String $name
     *
     * @return Text
     */
    public static function field($name): Text
    {
        $a = new self();
        $a->name($name);
        $a->label($name);
        $a->type('text');
        return $a;
    }
}
