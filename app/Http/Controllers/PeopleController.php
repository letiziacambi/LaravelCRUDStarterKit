<?php

namespace App\Http\Controllers;

use App\Libraries\CRUD\CRUD;
use App\Libraries\CRUD\Fields\Checkbox;
use App\Libraries\CRUD\Fields\Number;
use App\Models\People;
use App\Libraries\CRUD\Fields\Select;
use App\Libraries\CRUD\Fields\Text;
use Illuminate\Http\Request;

class PeopleController extends CRUDController
{
    function __construct()
    {
        $this->setModel(People::class);
        $this->setEntity('Persone');
        $this->setSubject('people');
        //$this->setIndexPage('People/Index');
        //$this->setCreatePage('People/Create');
        //$this->setUpdatePage('People/Edit')
        //$this->disableCreate();
        //$this->disableUpdate();
        //$this->disableDelete();
        parent::__construct();
    }

    public function setupCreateFields()
    {
        $options = [
            [
                'label' => 'Ciao',
                'value' => '2'
            ],
            [
                'label' => 'Ciao1',
                'value' => '1'
            ]
        ];
        $a = CRUD::setFields(
            [
                Text::field('name')
                    ->label('Name')
                    ->required()
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
                Text::field('email')
                    ->label('email')
                    ->type('date')
                    ->required()
                    ->icon('mdi-lock-outline')
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ]),
                Select::field('phone')
                    ->label('Phone')
                    ->options($options, 'label', 'value')
                    ->required()
                    ->wrapper_binds([
                        'md' => 4,
                        'lg' => 4
                    ])
                    ->icon('mdi-lock-outline', true, false)
                    ->icon('mdi-eye', false),
                Text::field('address')
                    ->label('address')
                    ->type('textarea')
                    ->wrapper_binds([
                        'md' => 12,
                        'lg' => 12
                    ]),
                Checkbox::field('aaaa'),
                Number::field('bbbb')
            ]

        );
        return $a;
    }
}
