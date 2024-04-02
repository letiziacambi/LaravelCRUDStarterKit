<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Libraries\CRUD\CRUD;
use App\Libraries\CRUD\Fields\Select;
use App\Libraries\CRUD\Fields\Text;
use App\Models\Credential;
use App\Models\Todo;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";

    protected $fillable = [
        'name',
        'description',
        'parent_id'
    ];

    public function credentials(): HasMany
    {
        return $this->hasMany(Credential::class, 'project_id');
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'project_id');
    }

    public static function CRUD_Fields()
    {
        return CRUD::setFields(
            [
                Text::field('name')
                    ->label('Name')
                    ->required()
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
                Text::field('description')
                    ->label('Description')
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
                Select::field('parent_id')
                    ->label('Progetto genitore')
                    ->options(self::all()->toArray(), 'name', 'id')
            ]

        );
    }
}
