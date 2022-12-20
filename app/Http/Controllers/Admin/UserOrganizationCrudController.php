<?php

namespace App\Http\Controllers\Admin;


use App\Models\Railway;
use App\Models\Organization;
use App\Models\User;

use App\Http\Requests\UserOrganizationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserOrganizationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserOrganizationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\UserOrganization');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/userorganization');
        $this->crud->setEntityNameStrings('прикрепления', 'прикрепление');

        $this->crud->addFilter([
            'name'  => 'railway_id',
            'type'  => 'select2',
            'label' => 'Предприятия'
          ], function() {
              return \App\Models\Railway::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
              $this->crud->addClause('where', 'railway_id', $value);
          });

          $this->crud->addFilter([
            'name'  => 'organization_id',
            'type'  => 'select2',
            'label' => 'Организация'
          ], function() {
              return \App\Models\Organization::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
              $this->crud->addClause('where', 'organization_id', $value);
          });

          $this->crud->addFilter([
            'name'  => 'user_id',
            'type'  => 'select2',
            'label' => 'Пользователъ'
          ], function() {
              return \App\Models\User::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
              $this->crud->addClause('where', 'user_id', $value);
          });
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('railway_id');
        CRUD::column('organization_id');
        CRUD::column('user_id');
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(UserOrganizationRequest::class);
          
        $this->crud->addField(
            [
                'label' => 'Предприятия',
                'type' => 'select2',
                'name' => 'railway_id',
                'entity' => 'railway',
                'model' => Railway::class,
                'attribute' => 'name',
                'default'   => 1
            ]);
            $this->crud->addField(
                [
                    'label' => 'Организация',
                    'type' => 'select2',
                    'name' => 'organization_id',
                    'entity' => 'organization',
                    'model' => Organization::class,
                    'attribute' => 'name',
                    'default'   => 1
                ]);
                $this->crud->addField(
                    [
                        'label' => 'Пользователъ',
                        'type' => 'select2',
                        'name' => 'user_id',
                        'entity' => 'user',
                        'model' => User::class,
                        'attribute' => 'name',
                        'default'   => 1
                    ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
