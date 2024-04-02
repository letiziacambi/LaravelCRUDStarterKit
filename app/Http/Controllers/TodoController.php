<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;

class TodoController extends CRUDController
{
    function __construct()
    {
        $this->setModel(Todo::class);
        $this->setEntity('Todo');
        $this->setSubject('todo');
        //$this->disableCreate();
        //$this->disableUpdate();
        //$this->disableDelete();
        $this->disableShow();
        parent::__construct();
    }

    public function records()
    {
        return Todo::paginate(20);
    }

    public function info()
    {
        return [
            'fields' => $this->setupListFields(),
            'actions' => $this->actions
        ];
    }
}
