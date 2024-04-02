<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Credential;
use Inertia\Inertia;

class ProjectController extends CRUDController
{
    function __construct()
    {
        $this->setModel(Project::class);
        $this->setEntity('Progetti');
        $this->setSubject('project');
        $this->setIndexPage('Project/Index');
        $this->setShowPage('Project/Show');
        //$this->setUpdatePage('People/Edit')
        //$this->disableCreate();
        //$this->disableUpdate();
        //$this->disableDelete();
        parent::__construct();
    }

    public function setupShowPageData($itemId)
    {
        $data = parent::setupShowPageData($itemId);
        $data['item']->load('credentials', 'todos');
        return $data;
    }

    public function detail($id)
    {
        $project = Project::find($id);
        return Inertia::render('Project/Detail', [
            'project' => $project->load('credentials'),
            'projectFields' => Project::CRUD_Fields(),
            'credentialsFields' => Credential::CRUD_Fields(),
            'categories' => [
                ['name' => 'credentials'],
                [
                    'name' => 'api',
                    'children' => [
                        [
                            'name' => 'roba1',
                            'children' => [
                                ['name' => 'roba1'],
                                ['name' => 'roba1'],
                            ]
                        ],
                        ['name' => 'roba1'],
                    ]
                ],
            ]
        ]);
    }
}
