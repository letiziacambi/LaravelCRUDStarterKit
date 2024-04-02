<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\CRUD\CRUD;
use App\Libraries\CRUD\Fields\Select;
use App\Libraries\CRUD\Fields\Text;
use App\Models\CredentialType;
use App\Models\Project;

class Credential extends Model
{
    use HasFactory;

    protected $table = "credentials";
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'type_id',
        'endpoint',
        'user',
        'password',
        'description'
    ];

    public static function CRUD_Fields()
    {
        return CRUD::setFields(
            [
                Select::field('project_id')
                    ->label('Progetto')
                    ->options(Project::all()->toArray(), 'name', 'id')
                    ->required()
                    ->wrapper_binds([
                        'md' => 6,
                        'lg' => 6
                    ]),
                Select::field('type_id')
                    ->label('Tipo')
                    ->options(CredentialType::all()->toArray(), 'name', 'id')
                    ->required()
                    ->wrapper_binds([
                        'md' => 6,
                        'lg' => 6
                    ]),

                Text::field('endpoint')
                    ->label('Endpoint')
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),

                Text::field('user')
                    ->label('Utente')
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
                Text::field('password')
                    ->label('Password')
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
                Text::field('description')
                    ->label('Descrizione')
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
            ]

        );
    }
}
