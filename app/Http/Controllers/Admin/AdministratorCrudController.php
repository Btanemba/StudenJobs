<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class AdministratorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Administrator::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administrator');
        CRUD::setEntityNameStrings('administrator', 'administrators');


                   $this->crud->setHeading('
        <style>
            .sds-heading {
                font-size: 2.3vw; /* Use viewport width for scaling */
                font-weight: bold;
                color: rgb(247, 108, 131);
                text-align: center;
                padding: 1%; /* Relative padding */
                margin: 0;
            }

            @media (max-width: 1024px) {
                .sds-heading {
                    font-size: 2vw; /* Adjust size for tablets */
                    padding: 4%; /* Adjust padding */
                }
            }

            @media (max-width: 768px) {
                .sds-heading {
                    font-size: 2vw; /* Even smaller size for mobile */
                    padding: 6%; /* Adjust padding for mobile */
                }
            }
        </style>
        <h1 class="sds-heading">SKILL PRO FINDER</h1>
    ');
    }

    protected function setupListOperation()
    {

        CRUD::disableResponsiveTable();
        CRUD::enablePersistentTable();

        CRUD::addColumn([
            'name' => 'custom_actions',
            'type' => 'view',
            'view' => 'vendor.backpack.crud.columns.custom_button',
            'label' => __('actions'),
            'orderable' => false,
            'searchable' => false,
        ]);
        // Display user email instead of ID
        CRUD::column('user.email')->label('Email');
        CRUD::column('remark');
        CRUD::column('created_at');
        CRUD::column('updated_at');

         $this->crud->removeButton('preview');
        $this->crud->removeButton('update');
         $this->crud->removeButton('revisions');
         $this->crud->removeButton('delete');
         $this->crud->removeButton('show');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation([
            'id' => 'required|exists:users,id|unique:administrators,id',
            'remark' => 'nullable|string|max:255'
        ]);

         CRUD::field('id')
            ->label('User')
            ->type('select')
            ->entity('user')
            ->model(User::class)
            ->attribute('email')
            ->options(function ($query) {
                return $query->whereDoesntHave('administrator')->get();
            });

        CRUD::field('remark')
            ->type('text')
            ->label('Remark');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        // Display user email but make it read-only
    CRUD::addField([
        'name' => 'id',
        'type' => 'text',
        'label' => 'User',
        'value' => function ($entry) {
            return $entry->user->email ?? '';
        },
        'attributes' => ['readonly' => 'readonly'],
    ]);

    // You can optionally store the user_id in a hidden field if needed
    CRUD::addField([
        'name' => 'id',
        'type' => 'hidden',
    ]);

    CRUD::field('remark')
        ->type('text')
        ->label('Remark');

        // Don't allow changing the user after creation
        CRUD::field('id')->attributes(['readonly' => 'readonly']);
    }
}
