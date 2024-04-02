<?php

namespace App\Libraries\CRUD\Fields;

use App\Libraries\CRUD\Fields\Field;

class Number extends Field
{
    /**
     * Create a new checkbox field and sets name, label and type
     *
     * @param  String $name
     *
     * @return Number
     */
    public static function field($name): Number
    {
        $a = new self();
        $a->name($name);
        $a->label($name);
        $a->type('number');
        $a->step();
        return $a;
    }

    /**
     * Define the step of the number field
     *
     * @param  String $value
     *
     * @return Number
     */
    public function step(String $value = "any")
    {
        $this->field_binds['step'] = $value;
        return $this;
    }

    /**
     * Define the range of the number field
     *
     * @param  String $min
     * @param  String $max
     *
     * @return Number
     */
    public function range(String $min = "any", String $max = 'any')
    {
        $this->field_binds['min'] = $min;
        $this->field_binds['max'] = $max;
        return $this;
    }
}
