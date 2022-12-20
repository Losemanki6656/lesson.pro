<?php

namespace App\Http\Controllers\Admin;


use App\Models\Railway;

use App\Http\Requests\OrganizationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrganizationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrganizationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Organization');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/organization');
        $this->crud->setEntityNameStrings('организация', 'организации');

        $this->crud->addFilter([
            'name'  => 'railway_id',
            'type'  => 'select2',
            'label' => 'Предприятия'
          ], function() {
              return \App\Models\Railway::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
              $this->crud->addClause('where', 'railway_id', $value);
          });
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'railway_id',
            'label' => 'Предприятия'
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Наименование'
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Наименование',
            'type' => 'text'
        ]);
        
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(OrganizationRequest::class);

        // TODO: remove setFromDb() and manually define Fields
       // $this->crud->setFromDb();

        $this->crud->addField(
            [
                'label' => 'Предприятия',
                'type' => 'select2',
                'name' => 'railway_id',
                'entity' => 'railway',
                'model' => Railway::class,
                'attribute' => 'name',
                'default'   => 1
            ]);

        $this->crud->addField(
            [
                'label' => 'Наименование',
                'type' => 'text',
                'name' => 'name'
            ]);
            
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
