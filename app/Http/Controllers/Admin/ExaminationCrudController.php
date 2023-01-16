<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExaminationRequest;
use App\Models\Cadry;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ExaminationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExaminationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Examination');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/examination');
        $this->crud->setEntityNameStrings('Имтихон', 'Имтихонлар');
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
            'name' => 'year_exam',
            'label' => 'Йил'
        ]);

        $this->crud->addColumn([
            'name' => 'year_quarter',
            'label' => 'Чорак'
        ]);
   

        $this->crud->addColumn([
            'name' => 'ball',
            'label' => 'Фоиз'
        ]);

        $this->crud->addColumn([
            'name' => 'cadry_id',
            'label' => 'ФИО'
        ]);

        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Статус',
            'type' => 'view',
            'view' => 'backpack::crud.status',
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
    
        $this->crud->addColumn([
            'name' => 'cadry_id',
            'label' => 'ФИО'
        ]);
        
        $this->crud->addColumn([
            'name' => 'ball',
            'label' => 'Фоиз'
        ]);
        $this->crud->addColumn([
            'name' => 'year_exam',
            'label' => 'Йил'
        ]); 
        $this->crud->addColumn([
            'name' => 'year_quarter',
            'label' => 'Чорак'
        ]); 
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Статус'
        ]); 
        
        
    }

    protected function setupCreateOperation()
    {
        $user = auth()->user()->userorganization;
        $this->crud->setValidation(ExaminationRequest::class);
       
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
                }),
                'wrapper' => [
                    'class' => 'form-group col-lg-6'
                ],
            ]);

            $this->crud->addField([
                'name' => 'ball',
                'label' => 'Имтихон натижаси(Фоиз)',
                'wrapper' => [
                    'class' => 'form-group col-lg-6'
                ],
            ]);
        
        $this->crud->addField([
            'name' => 'year_exam',
            'type' => 'number',
            'label' => 'Йил',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ],
            'value' => now()->format('Y')
        ]);
        $this->crud->addField([
            'name' => 'year_quarter',
            'type' => 'number',
            'label' => 'Чорак',
            'value' => 1,
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
    
        $this->crud->addField([
            'name' => 'status',
            'label' => 'Имтихонданда намунали натижа кўрсатилдими ?'
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
