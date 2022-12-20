<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RailwayRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RailwayCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RailwayCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Railway');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/railway');
        $this->crud->setEntityNameStrings('предприятие', 'предприятие');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
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
        $this->crud->setValidation(RailwayRequest::class);

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
