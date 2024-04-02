<?php

namespace App\Libraries\CRUD;

class CRUD
{
    public static function setFields($fields)
    {
        return collect($fields)->map(function ($obj) {
            return get_object_vars($obj);
        })->toArray();
    }
}
