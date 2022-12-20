<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Position;
use App\Models\Education;
use App\Models\Cadry;

use Prologue\Alerts\Facades\Alert;
use App\Http\Requests\CadryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CadryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CadryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation  { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Cadry');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cadry');
        $this->crud->setEntityNameStrings('сотрудник', 'Сотрудники');
        $this->crud->enableDetailsRow();
        $this->crud->enableExportButtons();

        $this->crud->addFilter([
            'name'  => 'department_id',
            'type'  => 'select2',
            'label' => 'Отделы'
          ], function() {
              return \App\Models\Department::where('organization_id', auth()->user()->userorganization->organization_id)->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
              $this->crud->addClause('where', 'department_id', $value);
          });

          $this->crud->addFilter([
            'name'  => 'position_id',
            'type'  => 'select2',
            'label' => 'Должности'
          ], function() {
              return \App\Models\Position::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
              $this->crud->addClause('where', 'position_id', $value);
          });

          $this->crud->addFilter([
            'name'  => 'education_id',
            'type'  => 'select2',
            'label' => 'Образование'
          ], function() {
              return \App\Models\Education::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
              $this->crud->addClause('where', 'education_id', $value);
          });

          $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'job_date',
            'label' => 'Дата приема на работу'
          ],
          false,
          function ($value) { // if the filter is active, apply these constraints
              $dates = json_decode($value);
              $this->crud->addClause('where', 'job_date', '>=', $dates->from);
              $this->crud->addClause('where', 'job_date', '<=', $dates->to . ' 23:59:59');
          });

          $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'birth_date',
            'label' => 'Дата рождения'
          ],
          false,
          function ($value) { // if the filter is active, apply these constraints
              $dates = json_decode($value);
              $this->crud->addClause('where', 'birth_date', '>=', $dates->from);
              $this->crud->addClause('where', 'birth_date', '<=', $dates->to . ' 23:59:59');
          });

          $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'status_position',
            'label' => 'Учители'
          ],
          true, // the simple filter has no values, just the "Draft" label specified above
          function() { // if the filter is active (the GET parameter "draft" exits)
            $this->crud->addClause('where', 'status_position', '1'); 
          });
          $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'status_work',
            'label' => 'Основное занятие'
          ],
          true, // the simple filter has no values, just the "Draft" label specified above
          function() { // if the filter is active (the GET parameter "draft" exits)
            $this->crud->addClause('where', 'status_work', '1'); 
          });

          
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'fullname',
            'label' => 'ФИО'
        ]);
        
        $this->crud->addColumn([
            'name' => 'department_id',
            'label' => 'Отдел',
            'disable' => true,
            'visibleInTable' => false
        ]);
        $this->crud->addColumn([
            'name' => 'position_id',
            'label' => 'Должность'
        ]);
        $this->crud->addClause('where', 'status', '=', true);
       
    }

    public function showDetailsRow($id) 
    {
        
    }
    
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        
        $this->crud->addColumn([
            'name' => 'fullname',
            'label' => 'ФИО'
        ]);
        $this->crud->addColumn([
            'name' => 'department_id',
            'label' => 'Отдел'
        ]);
        $this->crud->addColumn([
            'name' => 'position_id',
            'label' => 'Должность'
        ]); 
        $this->crud->addColumn([
            'name' => 'education_id',
            'label' => 'Образования'
        ]);

        $this->crud->addColumn([
            'name' => 'position_date',
            'label' => 'Дата вступления в должность'
        ]);
        $this->crud->addColumn([
            'name' => 'job_date',
            'label' => 'Дата приема на работу'
        ]);
        $this->crud->addColumn([
            'name' => 'rail_date',
            'label' => 'Дата ЖД'
        ]);
        $this->crud->addColumn([
            'name' => 'birth_date',
            'label' => 'Дата рождения'
        ]);
        $this->crud->addColumn([
            'name' => 'status_position',
            'label' => 'Основное занятие'
        ]); 
        $this->crud->addColumn([
            'name' => 'status_work',
            'label' => 'Учитель'
        ]);
        
    }
    protected function setupCreateOperation()
    {
        $user = auth()->user()->userorganization;

        $this->crud->setValidation(CadryRequest::class);

       
        $this->crud->addField([
            'name' => 'fullname',
            'label' => 'ФИО',
            'type' => 'text',
        ]);
        $this->crud->addField([
                'label' => 'Отдел',
                'type' => 'select2',
                'name' => 'department_id',
                'entity' => 'department',
                'model' => Department::class,
                'attribute' => 'name',
                'default'   => 1,
                'options'   => (function ($query) {
                    return $query->where('organization_id', auth()->user()->userorganization->organization_id)->get();
                }),
            ]);
        $this->crud->addField(
            [
                'label' => 'Должность',
                'type' => 'select2',
                'name' => 'position_id',
                'entity' => 'position',
                'model' => Position::class,
                'attribute' => 'name',
                'default'   => 1
            ]); 
        $this->crud->addField(
            [
                'label' => 'Образования',
                'type' => 'select2',
                'name' => 'education_id',
                'entity' => 'education',
                'model' => Education::class,
                'attribute' => 'name',
                'default'   => 1
            ]);

        $this->crud->addField([
            'name' => 'position_date',
            'label' => 'Дата вступления в должность',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'job_date',
            'label' => 'Дата приема на работу',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'rail_date',
            'label' => 'Дата ЖД',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'birth_date',
            'label' => 'Дата рождения',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'status_position',
            'label' => 'Учитель'
        ]); 
        $this->crud->addField([
            'name' => 'status_work',
            'label' => 'Основное занятие'
        ]);

        $this->crud->getRequest()->request->add(['railway_id'=> $user->railway_id]);
        $this->crud->getRequest()->request->add(['organization_id'=> $user->organization_id]);
        $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function destroy($id)
    {
        $cadry = Cadry::find($id);
        $cadry->status = false;
        $cadry->save();
        
        return true;
    }
}
