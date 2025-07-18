<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SelectionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SelectionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SelectionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Selection::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/selection');
        CRUD::setEntityNameStrings('selection', 'selections');


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

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
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
        CRUD::setFromDb(); // set columns from db columns.
           $this->crud->removeButton('preview');
        $this->crud->removeButton('update');
        $this->crud->removeButton('revisions');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('show');
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SelectionRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
