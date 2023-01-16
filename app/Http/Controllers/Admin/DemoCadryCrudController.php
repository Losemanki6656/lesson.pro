<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DemoCadryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Cadry;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DemoCadryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DemoCadryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\DemoCadry');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/democadry');
        $this->crud->setEntityNameStrings('Машғулот', "Машғулотларга иштирок этмаган ходимлар");
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'cadry_id',
            'label' => 'ФИО'
        ]);

        $this->crud->addColumn([
            'name' => 'date_demo',
            'label' => 'Машғулот санаси'
        ]);

    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
    
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'cadry_id',
            'label' => 'ФИО'
        ]);

        $this->crud->addColumn([
            'name' => 'date_demo',
            'label' => 'Машғулот санаси'
        ]);
        
        
    }

    protected function setupCreateOperation()
    {
        $user = auth()->user()->userorganization;
        $this->crud->setValidation(DemoCadryRequest::class);
       
        $this->crud->addField([
                'label' => 'ФИО',
                'type' => 'select2',
                'name' => 'cadry_id',
                'entity' => 'cadry',
                'model' => Cadry::class,
                'attribute' => 'fullname',
                'default'   => 1,
                'options'   => (function ($query) {
                    return $query->where('organization_id', auth()->user()->userorganization->organization_id)->get();
                })
            ]);

            $this->crud->addField([
                'name' => 'date_demo',
                'label' => 'Машғулот санаси'
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
