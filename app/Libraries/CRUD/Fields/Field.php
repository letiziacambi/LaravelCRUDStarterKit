<?php

namespace App\Libraries\CRUD\Fields;

class Field
{
    public $name;
    public $wrapper_binds = [];
    public $field_binds = [];
    public $required = false;
    public $rules = false;

    /**
     * Define the name of the field
     *
     * @param  String $value
     *
     * @return Field|Text|Select|Date|Number|Checkbox
     */
    public function name(String $value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * Define the label of the field
     *
     * @param  String $value
     *
     * @return Field|Text|Select|Date|Number|Checkbox
     */
    public function label(String $value)
    {
        $this->field_binds['label'] = $value;
        return $this;
    }

    /**
     * Define the type of the field
     *
     * @param  String $value
     *
     * @return Field|Text|Select|Date|Number|Checkbox
     */
    public function type(String $value)
    {
        $this->field_binds['type'] = $value;
        return $this;
    }

    /**
     * Add icon to the field
     *
     * @param  String $icon Name of icon
     * @param  Bool $before True if before field, false if after
     * @param  Bool $inset True if inside the field, false if outside
     *
     * @return Field|Text|Select|Date|Number|Checkbox
     */
    public function icon(String $icon, Bool $before = true, Bool $inset = true)
    {
        if ($before) {
            if ($inset)
                $this->field_binds['prepend-inner-icon'] = $icon;
            else
                $this->field_binds['prepend-icon'] = $icon;
        } else {
            if ($inset)
                $this->field_binds['append-inner-icon'] = $icon;
            else
                $this->field_binds['append-icon'] = $icon;
        }
        return $this;
    }

    /**
     * Adds v-bind values to the wrapper of the field
     *
     * @param  Array $binds
     *
     * @return Field|Text|Select|Date|Number|Checkbox
     */
    public function wrapper_binds(array $binds)
    {
        $this->wrapper_binds = $binds;
        return $this;
    }

    /**
     * Adds v-bind values to the field
     *
     * @param  Array $binds
     *
     * @return Field|Text|Select|Date|Number|Checkbox
     */
    public function field_binds(array $binds)
    {
        $this->field_binds = array_merge($this->field_binds, $binds);
        return $this;
    }

    /**
     * Define if the field is required
     *
     * @return Field|Text|Select|Date|Number|Checkbox
     */
    public function required()
    {
        $this->rules[] = "required";
        return $this;
    }
}
