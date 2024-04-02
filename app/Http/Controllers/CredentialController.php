<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Credential;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CredentialController extends CRUDController
{
    function __construct()
    {
        $this->setModel(Credential::class);
        $this->setEntity('Credenziali');
        $this->setSubject('credential');
        //$this->disableCreate();
        //$this->disableUpdate();
        //$this->disableDelete();
        $this->disableShow();
        parent::__construct();
    }

    public function records(Request $request)
    {
        return $this->setupListPageData($request)['data'];
    }

    public function info()
    {
        return [
            'fields' => $this->setupListFields(),
            'actions' => $this->actions
        ];
    }
}
