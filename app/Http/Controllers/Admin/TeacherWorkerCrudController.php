<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cadry;

use App\Http\Requests\TeacherWorkerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TeacherWorkerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TeacherWorkerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\TeacherWorker');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/teacherworker');
        $this->crud->setEntityNameStrings('учитель-ученик', 'учитель-ученик');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'teacher_id',
            'label' => 'Учитель'
        ]);

        $this->crud->addColumn([
            'name' => 'worker_id',
            'label' => 'Ученик'
        ]);
        $this->crud->addColumn([
            'name' => 'from_date',
            'label' => 'Дата контракта'
        ]);
        $this->crud->addColumn([
            'name' => 'exam_date',
            'label' => 'Дата экзамена'
        ]);
        $this->crud->addColumn([
            'name' => 'exam_status',
            'label' => 'Результат экзамена'
        ]);
        $this->crud->addColumn([
            'name' => 'price',
            'label' => 'Деньги'
        ]);
    }

    protected function setupCreateOperation()
    {
        $user = auth()->user()->userorganization;

        $this->crud->setValidation(TeacherWorkerRequest::class);

        $this->crud->addField([
                'label' => 'Учитель',
                'type' => 'select2',
                'name' => 'teacher_id',
                'entity' => 'teachers',
                'model' => Cadry::class,
                'attribute' => 'fullname',
                'default'   => 1,
                'options'   => (function ($query) {
                    return $query->where('status_position', true)->where('status',true)->get();
                }),
                'allows_null' => false,
                'wrapper' => [
                    'class' => 'form-group col-lg-6'
                ]
            ]);
        $this->crud->addField(
            [
                'label' => 'Ученик',
                'type' => 'select2',
                'name' => 'worker_id',
                'entity' => 'workers',
                'model' => Cadry::class,
                'attribute' => 'fullname',
                'default'   => 1,
                'options'   => (function ($query) {
                    return $query->where('status_position', false)->where('status',true)->get();
                }),
                'wrapper' => [
                    'class' => 'form-group col-lg-6'
                ]
            ]); 

        $this->crud->addField([
            'name' => 'from_date',
            'label' => 'Дата контракта',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'to_date',
            'label' => 'Дата окончания контракта',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'exam_date',
            'label' => 'Дата экзамена',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'ball',
            'label' => 'Результат экзамена (Балл)',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'price',
            'label' => 'Деньги',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'status_exam',
            'label' => 'Статус',
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
