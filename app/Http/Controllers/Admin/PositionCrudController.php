<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PositionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PositionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PositionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Position');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/position');
        $this->crud->setEntityNameStrings('Лавозим', 'Лавозимлар');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Номи'
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Номи',
            'type' => 'text'
        ]);
        
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PositionRequest::class);

        $this->crud->addField(
            [
                'label' => 'Номи',
                'type' => 'text',
                'name' => 'name'
            ]);
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
