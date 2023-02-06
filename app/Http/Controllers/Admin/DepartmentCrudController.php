<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DepartmentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
/**
 * Class DepartmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DepartmentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Department');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/department');
        $this->crud->setEntityNameStrings('Бўлим', 'Бўлимлар');
    }

    protected function setupListOperation()
    {
        if (backpack_auth()->check()) {
            $this->crud->query = $this->crud->query->where('organization_id', backpack_user()->userorganization->organization_id);
        }
        
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
        $user = auth()->user()->userorganization;

        $this->crud->setValidation(DepartmentRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->addField(
            [
                'label' => 'Номи',
                'type' => 'text',
                'name' => 'name'
            ]);

        $this->crud->getRequest()->request->add(['railway_id'=> $user->railway_id]);
        $this->crud->getRequest()->request->add(['organization_id'=> $user->organization_id]);
        $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

}
