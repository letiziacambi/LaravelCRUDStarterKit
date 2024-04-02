<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class CRUDController extends Controller
{
    protected $model;
    protected $actions = [
        'create' => true,
        'update' => true,
        'delete' => true,
        'show' => true
    ];
    protected $entity;
    protected $subject;
    protected $views = [
        'list' => 'CRUD/Index',
        'create' => 'CRUD/Create',
        'update' => 'CRUD/Edit',
        'show' => 'CRUD/Show'
    ];

    const DEFAULT_ROUTES = [
        ".index",
        ".create",
        ".store",
        ".edit",
        ".update",
        ".destroy",
        ".show"
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->disableOperationByRoutes();
    }

    /**
     * Disables CRUD operation based on routes
     */
    private function disableOperationByRoutes()
    {
        $routeList = array_keys(Route::getRoutes()->getRoutesByName());
        if (!in_array($this->subject . ".create", $routeList))
            $this->disableCreate();
        if (!in_array($this->subject . ".edit", $routeList))
            $this->disableUpdate();
        if (!in_array($this->subject . ".destroy", $routeList))
            $this->disableDelete();
        if (!in_array($this->subject . ".show", $routeList))
            $this->disableShow();
    }

    /**
     * @param String $subject
     *
     * Set the subject (aka the route name)
     */
    protected function setSubject(String $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param String $entity
     *
     * Set the entity name to be displayed
     */
    protected function setEntity(String $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param String $modelClass
     *
     * Set the model class
     */
    protected function setModel(String $modelClass)
    {
        $this->model = $modelClass;
    }

    /**
     * @param String $viewPath
     *
     * Set the CRUD list page
     */
    protected function setIndexPage(String $viewPath)
    {
        $this->views['list'] = $viewPath;
    }

    /**
     * @param String $viewPath
     *
     * Set the CRUD create page
     */
    protected function setCreatePage(String $viewPath)
    {
        $this->views['create'] = $viewPath;
    }

    /**
     * @param String $viewPath
     *
     * Set the CRUD list page
     */
    protected function setUpdatePage(String $viewPath)
    {
        $this->views['update'] = $viewPath;
    }

    /**
     * @param String $viewPath
     *
     * Set the CRUD list page
     */
    protected function setShowPage(String $viewPath)
    {
        $this->views['show'] = $viewPath;
    }

    /**
     * Disable the CRUD create action
     */
    protected function disableCreate()
    {
        $this->actions['create'] = false;
    }

    /**
     * Disable the CRUD update action
     */
    protected function disableUpdate()
    {
        $this->actions['update'] = false;
    }

    /**
     * Disable the CRUD delete action
     */
    protected function disableDelete()
    {
        $this->actions['delete'] = false;
    }

    /**
     * Disable the CRUD show action
     */
    protected function disableShow()
    {
        $this->actions['show'] = false;
    }

    /**
     * Get fields from DB with CRUD info
     *
     * @return Array
     */
    private function _getFields()
    {
        if (method_exists($this->model, 'CRUD_Fields'))
            return $this->model::CRUD_Fields();

        $tableName = app($this->model)->getTable();
        $rawFields = DB::select('DESCRIBE ' . $tableName);
        $fields = [];
        foreach ($rawFields as $field) {
            $type = null;
            if (str_contains($field->Type, 'char'))
                $type = 'text';
            else if (str_contains($field->Type, 'int'))
                $type = 'number';
            else
                $type = $field->Type;

            $fields[] = [
                'name' => $field->Field,
                'label' => ucfirst($field->Field),
                'type' => $type,
                'required' => $field->Null == 'YES' ? true : false,
                'default' => $field->Default,
            ];
        }
        return $fields;
    }

    /**
     * Get validation rules of fields from DB
     *
     * @return Array
     */
    private function _getValidationRules()
    {
        $arrValidate = [];
        $fields = $this->_getFields();
        foreach ($fields as $field) {
            $arrValidate[$field['name']] = [];
            if ($field['required'])
                $arrValidate[$field['name']][] = 'required';
            else
                $arrValidate[$field['name']][] = 'nullable';
            if ($field['field_binds']['type'] == 'email')
                $arrValidate[$field['name']][] = 'email';
        }
        return $arrValidate;
    }

    /**
     * Prepare breadcrumbs for CRUD Pages
     * @param String $action
     *
     * @return Array
     */
    public function getBreadcrumbs($action = null)
    {
        $breadcrumbs = [
            [
                'title' => 'Dashboard',
                'disabled' =>  false,
                'href' => '/dashboard',
            ],
        ];

        if (!is_null($action)) {
            $breadcrumbs[] = [
                'title' => $this->entity,
                'disabled' =>  false,
                'href' => '/' . $this->subject,
            ];
            $breadcrumbs[] = [
                'title' => $action,
                'disabled' =>  true,
            ];
        } else {
            $breadcrumbs[] = [
                'title' => $this->entity,
                'disabled' =>  true,
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Setup fields for CRUD list
     *
     * @return Array
     */
    public function setupListFields()
    {
        return $this->_getFields();
    }

    /**
     * Setup fields for CRUD create
     *
     * @return Array
     */
    public function setupCreateFields()
    {
        return $this->_getFields();
    }

    /**
     * Setup fields for CRUD edit
     *
     * @return Array
     */
    public function setupUpdateFields()
    {
        return $this->setupCreateFields();
    }

    /**
     * Setup fields for CRUD show
     *
     * @return Array
     */
    public function setupShowFields()
    {
        return $this->_getFields();
    }

    /**
     * Setup CRUD list page data
     *
     * @return Array
     */
    public function setupListPageData(Request $request)
    {
        $fields = $this->setupListFields();
        $query = $this->model::query()
            ->when($request->get('fields'), function ($query, $thisfields) {
                foreach ($thisfields as $field => $value) {
                    $query = $query->where($field, $value);
                }
                return $query;
            })
            ->when($request->get('search'), function ($query, $search) use ($fields) {
                $query = $query->where('id', 'LIKE', "%$search%");
                foreach ($fields as $field) {
                    $query = $query->orWhere($field['name'], 'LIKE', "%$search%");
                }
                return $query;
            })->when($request->get('sort'), function ($query, $sortBy) {
                return $query->orderBy($sortBy['key'], $sortBy['order']);
            });

        $data = $query->paginate($request->get('limit', 10));

        return [
            'actions' => $this->actions,
            'breadcrumbs' => $this->getBreadcrumbs(),
            'data' => $data,
            'entity' => $this->entity,
            'fields' => $fields,
            'subject' => $this->subject
        ];
    }

    /**
     * Setup CRUD create page data
     *
     * @return Array
     */
    public function setupCreatePageData()
    {
        return [
            'breadcrumbs' => $this->getBreadcrumbs('Create'),
            'entity' => $this->entity,
            'fields' => $this->setupCreateFields(),
            'subject' => $this->subject
        ];
    }

    /**
     * Setup CRUD update page data
     *
     * @return Array
     */
    public function setupUpdatePageData($itemId)
    {
        return [
            'breadcrumbs' => $this->getBreadcrumbs('Edit'),
            'entity' => $this->entity,
            'fields' => $this->setupUpdateFields(),
            'item' => $this->model::find($itemId),
            'subject' => $this->subject
        ];
    }

    /**
     * Setup CRUD show page data
     *
     * @return Array
     */
    public function setupShowPageData($itemId)
    {
        return [
            'breadcrumbs' => $this->getBreadcrumbs('Show'),
            'entity' => $this->entity,
            'fields' => $this->setupShowFields(),
            'item' => $this->model::find($itemId),
            'subject' => $this->subject,
        ];
    }

    /**
     * Render CRUD list page
     *
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render($this->views['list'], $this->setupListPageData($request));
    }

    /**
     * Render CRUD create page
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        if ($this->actions['create'] == false) abort(403);
        return Inertia::render($this->views['create'], $this->setupCreatePageData());
    }

    /**
     * Render CRUD edit page
     * @param Integer $itemId
     *
     * @return \Inertia\Response
     */
    public function edit($itemId): \Inertia\Response
    {
        if ($this->actions['update'] == false) abort(403);
        return Inertia::render($this->views['update'], $this->setupUpdatePageData($itemId));
    }

    /**
     * Render CRUD show page
     * @param Integer $itemId
     *
     * @return \Inertia\Response
     */
    public function show($itemId): \Inertia\Response
    {
        if ($this->actions['show'] == false) abort(403);
        return Inertia::render($this->views['show'], $this->setupShowPageData($itemId));
    }

    /**
     * Create new item from CRUD
     * @param Request $request
     *
     * @return InertiaView
     */
    public function store(Request $request)
    {
        if ($this->actions['create'] == false) abort(403);
        $this->validate($request, $this->_getValidationRules());
        $this->model::create($request->all());
        return redirect()->back(303)->with('success', 'Successfully created');
    }


    /**
     * Create new item from CRUD
     * @param Integer $itemId
     * @param Request $request
     *
     * @return InertiaView
     */
    public function update($itemId, Request $request)
    {
        if ($this->actions['update'] == false) abort(403);
        $this->validate($request, $this->_getValidationRules());
        $item = $this->model::find($itemId);
        $item->update($request->all());
        $item->save();
        return redirect()->back(303)->with('success', 'Successfully updated');
    }
    /**
     * Create new item from CRUD
     * @param Integer $itemId
     * @param Request $request
     *
     * @return InertiaView
     */
    public function destroy($itemId)
    {
        if ($this->actions['delete'] == false) abort(403);
        $this->model::find($itemId)->delete();
        return redirect()->back(303)->with('success', 'Successfully deleted');
    }
}
