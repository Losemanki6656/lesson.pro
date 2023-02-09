<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ThemeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Department;
use App\Models\CheckCadry;
use App\Models\Theme;
use App\Models\Cadry;

use Alert;

use Illuminate\Http\Request;
/**
 * Class ThemeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ThemeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Theme');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/theme');
        $this->crud->setEntityNameStrings('Машғулот', 'Машғулотлар');

        $this->crud->addButtonFromModelFunction('line', 'send-sms', 'cadries', 'beginning');
        $this->crud->enableDetailsRow();
        $this->crud->enableExportButtons();
    }

    public function theme_cadries($id)
    {
        $themes = CheckCadry::where('theme_id', $id)->with(['cadry', 'department' ])->paginate(10);

        $them = Theme::find($id);

        return view('backpack::themes', [
            'themes' => $themes,
            'them' => $them
        ]);
    }
    
    public function edit_cadry_theme($check_id, Request $request)
    {

        if($request->status_theme) {
            $checkcadry = CheckCadry::find($check_id);
            $checkcadry->status = false;
            if($request->status_dont_check)
            $checkcadry->status_dont_check = true;
            $checkcadry->comment = $request->comment;

            $checkcadry->save();
        }
        Alert::success('Муваффаққиятли амалга оширилди!')->flash();
        return redirect()->back();
    }

    protected function setupListOperation()
    {
        if (backpack_auth()->check()) {
            $this->crud->query = $this->crud->query->where('user_id', backpack_user()->id);
        }


        $this->crud->addColumn([
            'name' => 'id',
            'label' => '№'
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Машғулот номи'
        ]);

        $this->crud->addColumn([
            'name' => 'department_id',
            'label' => 'Бўлим'
        ]);

        $this->crud->addColumn([
            'name' => 'date_theme',
            'label' => 'Машғулот санаси'
        ]);  
       
    }
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Машғулот номи'
        ]);
        $this->crud->addColumn([
            'name' => 'department_id',
            'label' => 'Бўлим'
        ]);

        $this->crud->addColumn([
            'name' => 'date_theme',
            'label' => 'Машғулот санаси'
        ]);
        
    }
    protected function setupCreateOperation()
    {
        $user = auth()->user()->userorganization;
        $this->crud->setValidation(ThemeRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Машғулот номи',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'date_theme',
            'label' => 'Машғулот санаси',
            'wrapper' => [
                'class' => 'form-group col-lg-6'
            ]
        ]);

        $this->crud->addField([
                'label' => 'Бўлим',
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

        $this->crud->getRequest()->request->add(['railway_id'=> $user->railway_id]);
        $this->crud->getRequest()->request->add(['user_id'=> backpack_user()->id]);
        $this->crud->getRequest()->request->add(['organization_id'=> $user->organization_id]);

        $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
        
    }

    public function store()
    {

        $response = $this->traitStore();

        $checkcadries = CheckCadry::where('theme_id', $this->crud->entry->id)->count();

        if(!$checkcadries) {
            
            $cadries = Cadry::where('department_id', $this->crud->entry->department_id)->where('status', true)->get();

            $theme = Theme::find($this->crud->entry->id);
            
            foreach($cadries as $item) {
                $newItem = new CheckCadry();
                $newItem->railway_id = $this->crud->entry->railway_id;
                $newItem->organization_id = $this->crud->entry->organization_id;
                $newItem->department_id = $this->crud->entry->department_id;
                $newItem->theme_id = $this->crud->entry->id;
                $newItem->cadry_id = $item->id;
                $newItem->date_theme = $theme->date_theme;
                $newItem->save();
            }

        }
        
        return $response;
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function destroy($id)
    {
        CheckCadry::where('theme_id', $id)->delete();
        $cadry = Theme::find($id)->delete();
        return true;
    }
}
