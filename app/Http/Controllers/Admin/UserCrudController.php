<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\DB;


/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.


        // Add Person columns to the list view
        CRUD::addColumn([
            'name' => 'person.first_name',
            'label' => 'First Name',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'person.last_name',
            'label' => 'Last Name',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'person.gender',
            'label' => 'Gender',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'person.phone',
            'label' => 'Phone',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'person.student_id_picture_front',
            'label' => 'Student ID Picture Front',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $path = $entry->person->student_id_picture_front;
                if ($path) {
                    $url = asset('storage/' . $path);
                    return '<a href="' . $url . '" download><img src="' . $url . '" height="50px" /> Download</a>';
                }
                return 'No image uploaded';
            },
        ]);
        CRUD::addColumn([
            'name' => 'person.student_id_picture_back',
            'label' => 'Student ID Picture Back',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $path = $entry->person->student_id_picture_back;
                if ($path) {
                    $url = asset('storage/' . $path);
                    return '<a href="' . $url . '" download><img src="' . $url . '" height="50px" /> Download</a>';
                }
                return 'No image uploaded';
            },
        ]);

        $this->crud->removeButton( 'preview' );
        $this->crud->removeButton( 'show' );
         
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
        CRUD::setValidation(UserRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.

        $regions = config('regions');

        CRUD::field('email')
        ->label('Email')
        ->wrapper(['class' => 'form-group col-md-12'])
        ->attributes(['readonly' => 'readonly']);

        CRUD::addField([
            'name'  => 'person.first_name',
            'label' => 'First Name',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        CRUD::addField([
            'name'  => 'person.last_name',
            'label' => 'Last Name',
            'type'  => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        CRUD::addField([
            'name' => 'person.gender',
            'label' => 'Gender',
            'type' => 'select_from_array',
            'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'],
            'allows_null' => false,
            'wrapperAttributes' => [
        'class' => 'form-group col-md-6'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.phone',
            'label' => 'Phone',
            'type' => 'text',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-6'
    ],
        ]);

        // Add fields for address and university details
        CRUD::addField([
            'name' => 'person.street',
            'label' => 'Street',
            'type' => 'text',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-3'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.number',
            'label' => 'Number',
            'type' => 'text',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-3'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.city',
            'label' => 'City',
            'type' => 'text',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-3'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.zip',
            'label' => 'Zip Code',
            'type' => 'text',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-3'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.country',
            'label' => 'Country',
            'type' => 'select_from_array',
            'options' => ['Austria' => 'Austria'],
            'allows_null' => false,
            'attributes' => ['id' => 'person-country'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        CRUD::addField([
            'name' => 'person.region',
            'label' => 'Region',
            'type' => 'select_from_array',
            'options' => config('regions.Austria', []),
            'allows_null' => false,
            'attributes' => ['id' => 'person-region'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);



        CRUD::addField([
            'name' => 'person.university_name',
            'label' => 'University Name',
            'type' => 'text',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-6'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.university_address',
            'label' => 'University Address',
            'type' => 'text',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-6'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.start_year',
            'label' => 'Start Year',
            'type' => 'number',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-6'
    ],
        ]);

        CRUD::addField([
            'name' => 'person.finish_year',
            'label' => 'Finish Year',
            'type' => 'number',
            'wrapperAttributes' => [
        'class' => 'form-group col-md-6'
    ],
        ]);

        // Add file upload for student ID pictures
        CRUD::addField([
            'name' => 'person.student_id_picture_front',
            'label' => 'Student ID Picture Front',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public', // Specify the disk for storing the
            'prefix' => 'uploads/',
        ]);

        CRUD::addField([
            'name' => 'person.student_id_picture_back',
            'label' => 'Student ID Picture Back',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public', // Specify the disk for storing the files
            'prefix' => 'uploads/',
        ]);

        // Pass regions to the view
        $this->data['regions'] = config('regions');


        // Share $regions with the Blade view
        view()->share('regions', $regions);

        // Set the custom create view
        $this->crud->setCreateView('vendor.backpack.crud.create');


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


    public function store()
{
    // Call the default Backpack store to create the user
    $response = $this->traitStore();
    $user = $this->crud->getCurrentEntry();

    $personData = request()->input('person', []);

    // Handle file uploads
    if (request()->hasFile('person.student_id_picture_front')) {
        $file = request()->file('person.student_id_picture_front');
        $personData['student_id_picture_front'] = $file->store('uploads', 'public');
    }

    if (request()->hasFile('person.student_id_picture_back')) {
        $file = request()->file('person.student_id_picture_back');
        $personData['student_id_picture_back'] = $file->store('uploads', 'public');
    }

    // Save the person
    $person = new Person($personData);
    $user->person()->save($person);

    return $response;
}



}
