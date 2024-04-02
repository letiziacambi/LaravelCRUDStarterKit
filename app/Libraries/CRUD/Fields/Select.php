<?php

namespace App\Libraries\CRUD\Fields;

use App\Libraries\CRUD\Fields\Field;

class Select extends Field
{
    public $options;
    public $item_title;
    public $item_value;

    /**
     * Create a new select field and sets name, label and type
     *
     * @param  String $name
     *
     * @return Select
     */
    public static function field($name): Select
    {
        $a = new self();
        $a->name($name);
        $a->label($name);
        $a->type('select');
        return $a;
    }


    /**
     * Sets the options of the select
     *
     * @param  Array $options Items
     * @param  String $item_title Item element to display
     * @param  String $item_value Item element value
     *
     * @return Select
     */
    public function options(Array $options, String $item_title = null, String $item_value = null)
    {
        $this->field_binds['items'] = $options;
        $this->field_binds['item-title'] = $item_title ?? 'name';
        $this->field_binds['item-value'] = $item_value ?? 'id';
        return $this;
    }
}
