<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrganizationCadryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrganizationCadryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrganizationCadryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\OrganizationCadry');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/organizationcadry');
        $this->crud->setEntityNameStrings('Ходимлар сонини', 'Умумий ходимлар сони');
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
            'name' => 'count_cadriez',
            'label' => 'Ходимлар сони'
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        
        $this->crud->addColumn([
            'name' => 'count_cadriez',
            'label' => 'Ходимлар сони'
        ]);
    }

    protected function setupCreateOperation()
    {
        $user = auth()->user()->userorganization;

        $this->crud->setValidation(OrganizationCadryRequest::class);

        $this->crud->addField(
            [
                'label' => 'Ходимлар сони',
                'type' => 'text',
                'name' => 'count_cadriez'
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
