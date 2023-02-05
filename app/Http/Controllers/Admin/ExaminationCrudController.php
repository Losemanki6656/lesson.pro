<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExaminationRequest;
use App\Models\Cadry;
use App\Models\ExamCadry;
use App\Models\Organization;
use App\Models\Examination;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Alert;

use Illuminate\Http\Request;
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

    public function add_cadry_to_exam($id, Request $request)
    {
        $user = auth()->user()->userorganization->railway_id;
        $cadry = Cadry::find($request->cadry_id);

        $examination = Examination::find($id);
        $examinations = Examination::where('year_exam', $examination->year_exam)->where('year_quarter', $examination->year_quarter)->get();
        $status = false;

        foreach($examinations as $item ) {

            $examcadries = ExamCadry::where('examination_id', $item->id)->where('cadry_id', $request->cadry_id)->count();

            if($examcadries > 0) {
                $status = true;
                break;
            } 
        }

        if($status == true) {
            Alert::error('Ушбу ходим имтихонда қатнашган!')->flash();
            return redirect()->back();
        }
        
        if($cadry->management_id) {
            $examCadry = new ExamCadry();
            $examCadry->railway_id = $user;
            $examCadry->organization_id = $request->organization_id;
            $examCadry->management_id = $cadry->management_id;
            $examCadry->examination_id = $id;
            $examCadry->cadry_id = $request->cadry_id;
            $examCadry->ball = $request->ball;
            $examCadry->year_exam = $examination->year_exam;
            $examCadry->year_quarter = $examination->year_quarter;

            if($request->status_exam) {
                $examCadry->status_exam = false;
                if($request->status_dont_exam)
                    $examCadry->status_dont_exam = true; else $examCadry->status_dont_exam = false;
                $examCadry->comment = $request->comment;
            } else 
                $examCadry->status_exam = true;
            
            $examCadry->department_id = $cadry->department_id;
            $examCadry->position_id = $cadry->position_id;
            $examCadry->user_id = backpack_user()->id;

            $examCadry->save();

            Alert::success('Муваффаққиятли амалга оширилди!')->flash();
            return redirect()->back();
        } else {
            Alert::error('Хўжалик топилмади!')->flash();
            return redirect()->back();
        }
       
    }

    public function delete_exam_cadry(ExamCadry $id)
    {
        $id->delete();
        Alert::success('Муваффаққиятли амалга оширилди!')->flash();
        return redirect()->back();
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

    public function load_cadries(Request $request)
    {
        $data = Cadry::where('organization_id',$request->organization_id)->where('status', true)->get();
        return response()->json($data);
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
            'name' => 'exams_count',
            'label' => 'Ходимлар'
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
