<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\CRUD\CRUD;
use App\Libraries\CRUD\Fields\Select;
use App\Libraries\CRUD\Fields\Text;

class Todo extends Model
{
    use HasFactory;

    protected $table = "todos";
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'project_id',
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
                        'md' => 4,
                        'lg' => 4
                    ]),

                Text::field('name')
                    ->label('Nome')
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
