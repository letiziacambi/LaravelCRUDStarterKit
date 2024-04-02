<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\CRUD\CRUD;
use App\Libraries\CRUD\Fields\Select;
use App\Libraries\CRUD\Fields\Text;
use App\Models\CredentialType;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";
    public $timestamps = false;

    public static function CRUD_Fields()
    {
        return CRUD::setFields(
            [
                Text::field('name')
                    ->label('Nome')
                    ->required()
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
                Text::field('description')
                    ->label('Descrizione')
                    ->required()
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
            ]
        );
    }
}
