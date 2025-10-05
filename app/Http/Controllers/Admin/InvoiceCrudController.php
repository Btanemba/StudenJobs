<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvoiceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;
use App\Mail\InvoiceUploadedMail;
use Illuminate\Support\Facades\Mail;




/**
 * Class InvoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        $this->crud->setModel(\App\Models\Invoice::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/invoice');
        $this->crud->setEntityNameStrings('invoice', 'invoices');

        // Restrict create operation to admins
        if (!backpack_user()->isAdmin()) {
            $this->crud->denyAccess(['create']);

            // Only show invoices that belong to the logged-in user
        $personId = optional(backpack_user()->person)->id;

        $this->crud->addClause('where', 'person_id', $personId);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {


        // If user is admin, allow all columns
        if (backpack_user()->isAdmin()) {
            // Base columns for non-admins
            $this->crud->addColumn([
                'name' => 'person_id',
                'label' => 'Person',
            ]);
            //$this->crud->setFromDb(); // Optional: Load all columns from DB for admins
        }
        // Base columns for non-admins
        $this->crud->addColumn([
            'name' => 'invoice_number',
            'label' => 'Invoice #',
        ]);
        $this->crud->addColumn([
            'name' => 'invoice_file',
            'label' => 'Invoice File',
            'type' => 'upload',
            'disk' => 'public', // Ensure this displays the file name or link
        ]);
        $this->crud->addColumn([
            'name' => 'invoice_date',
            'label' => 'Invoice Date',
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'due_date',
            'label' => 'Due Date',
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'total',
            'label' => 'Amount (€)',
        ]);
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
        ]);
        $this->crud->addColumn([
            'name' => 'invoice_file',
            'label' => 'Invoice File',
            'type' => 'upload',
        ]);

        if (!backpack_user()->isAdmin()) {
            $this->crud->removeButton('preview');
            $this->crud->removeButton('update');
            $this->crud->removeButton('revisions');
            $this->crud->removeButton('delete');
            $this->crud->removeButton('show');
        }


        //CRUD::setFromDb(); // set columns from db columns.

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
        CRUD::setValidation(InvoiceRequest::class);
        $this->crud->addField([
            'name' => 'person_id',
            'label' => 'Person',
            'type' => 'select',
            'wrapper' => ['class' => 'form-group col-md-8'],
            'entity' => 'person', // The relationship name in the Invoice model
            'attribute' => 'full_name', // The attribute to display (add this accessor to Person model if needed)
            'model' => \App\Models\Person::class, // The model to fetch options from
            'allows_null' => true,

        ]);
        // Invoice number (auto-generated or manual)
        $this->crud->addField([
            'name' => 'invoice_number',
            'label' => 'Invoice Number',
            'type' => 'text',
            'default' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'wrapper' => ['class' => 'form-group col-md-4'],
            'hint' => 'Will be auto-generated if left blank'
        ]);
        // File upload with proper configuration
        $this->crud->addField([
            'name' => 'invoice_file',
            'label' => 'Invoice File (PDF)',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public',
            'wrapper' => ['class' => 'form-group col-md-6'],
            'hint' => 'Maximum file size: 5MB',
            'attributes' => [
                'accept' => '.pdf,.doc,.docx',
            ],
        ]);
        // Total amount in Euros (numeric field with € symbol)
        $this->crud->addField([
            'name' => 'total',
            'label' => 'Amount (€)',
            'type' => 'number',
            'prefix' => '€',
            'attributes' => [
                'step' => '0.01',
                'min' => '0',
            ],
            'wrapper' => ['class' => 'form-group col-md-4'],
        ]);

        CRUD::addField([
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'select_from_array',
            'options' => \App\Models\Selection::where('table', 'status')
                ->where('field', 'payment')
                ->orderBy('name')
                ->pluck('name', 'code')
                ->toArray(),
            'allows_null' => true,
            'wrapper' => ['class' => 'form-group col-md-2'],
        ]);

        // Invoice date (defaults to today)
        $this->crud->addField([
            'name' => 'invoice_date',
            'label' => 'Invoice Date',
            'type' => 'date',
            'default' => date('Y-m-d'),
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);
        // Due date (defaults to 30 days from today)
        $this->crud->addField([
            'name' => 'due_date',
            'label' => 'Due Date',
            'type' => 'date',
            'default' => date('Y-m-d', strtotime('+30 days')),
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name'  => 'created_by_name',
            'label' => ('Created By'),
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-3'],
            'attributes' => [
                'readonly' => 'readonly',
                'style' => 'background-color: #e5e5e5;',
            ],
        ]);

        // Created At
        CRUD::addField([
            'name'  => 'created_at',
            'label' => ('Created At'),
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-3'],
            'attributes' => [
                'readonly' => 'readonly',
                'style' => 'background-color: #e5e5e5;',
            ],

        ]);

        // Updated By
        CRUD::addField([
            'name' => 'updated_by_name',
            'label' => ('Updated By'),
            'type' => 'text',
            'wrapper' => ['class' => 'form-group col-md-3'],
            'attributes' => [
                'readonly' => 'readonly',
                'style' => 'background-color: #e5e5e5;',
            ],
        ]);

        // Updated At
        CRUD::addField([
            'name'  => 'updated_at',
            'label' => ('Updated At'),
            'type'  => 'text',
            'wrapper' => ['class' => 'form-group col-md-3'],
            'attributes' => [
                'readonly' => 'readonly',
                'style' => 'background-color:  #e5e5e5;',
            ],

        ]);



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

  public function store(InvoiceRequest $request)
{

    $response = $this->traitStore($request);

    // Get the saved invoice
    $invoice = $this->crud->entry;

    // Send notification email if invoice belongs to a user
    if ($invoice && $invoice->person && $invoice->person->user) {
        $user = $invoice->person->user;
        if ($user && $user->email) {
            Mail::to($user->email)->send(new InvoiceUploadedMail($invoice));
        }
    }

    return $response;
}


}
