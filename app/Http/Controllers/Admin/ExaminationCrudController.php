<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExaminationRequest;
use App\Models\Cadry;
use App\Models\ExamCadry;
use App\Models\Organization;
use App\Models\Examination;
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

        
        $this->crud->allowAccess('send-sms-to-worker');
        $this->crud->addButtonFromModelFunction('line', 'send-sms', 'cadries', 'beginning');
        $this->crud->enableDetailsRow();
        $this->crud->enableExportButtons();
    }

    public function cadries($id)
    {
        $organizations = Organization::get();
        $exam_cadries = ExamCadry::where('examination_id', $id)->get();

        $exam = Examination::find($id);

        return view('backpack::exam_cadries', [
            'exam_cadries' => $exam_cadries,
            'exam' => $exam,
            'organizations' => $organizations
        ]);
    }

    public function loadCadry($id)
    {
        $cadries = ExamCadry::where('examination_id', $id)->get();

        $exam = Examination::find($id);

        return view('backpack::exam_cadries', [
            'exam_cadries' => $exam_cadries,
            'exam' => $exam,
            'organizations' => $organizations
        ]);
    }


    public function postAddCadry(Request $request)
    {
        Alert::success('Successfully send')->flash();
        return redirect()
            ->route('message.index')
            ->with([
                'status' => 'success',
                'message' => 'successfully sanded'
            ]);
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Имтихон номи'
        ]);

        
        $this->crud->addColumn([
            'name' => 'date_exam',
            'label' => 'Имтихон санаси'
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
            'label' => 'Статус',
            'type' => 'view',
            'view' => 'backpack::crud.status_exam',
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
    
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Имтихон номи'
        ]);
        
        $this->crud->addColumn([
            'name' => 'date_exam',
            'label' => 'Имтихон санаси'
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
            'name' => 'name',
            'type' => 'text',
            'label' => 'Имтихон номи',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'date_exam',
            'type' => 'date',
            'label' => 'Имтихон санаси',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ],
            'value' => now()->format('Y')
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
            'label' => 'Имтихон якунландими ?'
        ]);

        $this->crud->getRequest()->request->add(['railway_id'=> $user->railway_id]);
        $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
        
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
