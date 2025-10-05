<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Controllers\Admin\Operations\EmailOperation;
use App\Models\Person;
use App\Models\User;
use App\Http\Controllers\Admin\ISO3166;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use EmailOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');

        $this->crud->setHeading('
        <style>
            .sds-heading {
                font-size: 2.3vw; /* Use viewport width for scaling */
                font-weight: bold;
                color: rgb(135, 206, 235);
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

             // For non-admin users, restrict the data they can see and update to their own
        if (!auth()->user()->isAdmin()) {
            $this->crud->addClause('where', 'id', '=', auth()->user()->id);
            $this->crud->denyAccess(['create', 'delete']);
        }
    }

    protected function setupListOperation()
    {
        // Non-admins only see their own profile
        if (!backpack_user()->isAdmin()) {
            $this->crud->addClause('where', 'id', backpack_user()->id);
        }

        // $this->crud->addButtonFromView('line', 'email', 'email', 'beginning');
        if (auth()->check() && auth()->user()->isAdmin()) {
            $this->crud->addButtonFromView('line', 'email', 'email', 'beginning');
        }

        CRUD::disableResponsiveTable();
        CRUD::enablePersistentTable();

        CRUD::addColumn([
            'name' => 'email',
            'label' => 'Email',
            'type' => 'text',
        ]);

        // Add Person columns to the list view
        // CRUD::addColumn([
        //     'name' => 'person.first_name',
        //     'label' => 'First Name',
        //     'type' => 'text',
        // ]);

        CRUD::addColumn([
            'name' => 'person.last_name',
            'label' => 'Last Name',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'person.phone',
            'label' => 'Phone',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'person.payment_plan',
            'label' => 'Payment Plan',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'person.valid_till',
            'label' => 'Valid Till',
            'type' => 'date',
            'format' => 'DD-MM-YYYY',
        ]);

        CRUD::addColumn([
            'name' => 'active',
            'label' => 'Active',
            'type' => 'select_from_array',
            'options' => [1 => 'Yes', 0 => 'No'],
        ]);

        $this->crud->removeButton('preview');
        $this->crud->removeButton('revisions');
        $this->crud->removeButton('show');


    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        $regions = config('regions');

        CRUD::field('email')
            ->label('Email')
            ->tab('General')
            ->wrapper(['class' => 'form-group col-md-12'])
            ->attributes(['readonly' => 'readonly']);

         $entry = $this->crud->getCurrentEntry(); // get current record being edited

        $htmlPreview = '<small>No profile picture uploaded.</small>';
        if ($entry && $entry->person && $entry->person->profile_picture) {
            $htmlPreview = '<img src="' . asset('storage/' . $entry->person->profile_picture) . '"
        width="100" style="border-radius:8px">';
        }

        CRUD::addField([
            'name'  => 'current_profile_picture',
            'label' => 'Current Profile Picture',
            'type'  => 'custom_html',
            'value' => $htmlPreview,   // now it's a string, not a closure
            'tab'   => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name'  => 'person.profile_picture',
            'label' => 'Profile Picture',
            'type'  => 'upload',
            'upload' => true,
            'disk'  => 'public',
            'tab'   => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        // Personal Information Fields
        CRUD::addField([
            'name'  => 'person.first_name',
            'label' => 'First Name',
            'type'  => 'text',
            'tab'   => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name'  => 'person.last_name',
            'label' => 'Last Name',
            'type'  => 'text',
            'tab'   => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name' => 'person.gender',
            'label' => 'Gender',
            'type' => 'select_from_array',
            'tab'  => 'General',
            'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'],
            'allows_null' => false,
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name'  => 'person.preferred_contact_method',
            'label' => 'Preferred Contact Method',
            'type'  => 'select_from_array',
            'options' => [
                'email' => 'Email',
                'phone' => 'Phone/WhatsApp',
            ],
            'default' => 'email',
            'tab'   => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name' => 'person.phone',
            'label' => 'Phone',
            'type' => 'text',
            'tab'  => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        // Address Fields
        CRUD::addField([
            'name' => 'person.street',
            'label' => 'Street',
            'type' => 'text',
            'tab'  => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-3'],
        ]);

        CRUD::addField([
            'name' => 'person.number',
            'label' => 'Number',
            'type' => 'text',
            'tab'  => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-3'],
        ]);

        CRUD::addField([
            'name' => 'person.city',
            'label' => 'City',
            'type' => 'text',
            'tab'  => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-3'],
        ]);

        CRUD::addField([
            'name' => 'person.zip',
            'label' => 'Zip Code',
            'type' => 'text',
            'tab'  => 'General',
            'wrapperAttributes' => ['class' => 'form-group col-md-3'],
        ]);

        CRUD::field('person.country')
            ->label('Country of Residence')
            ->tab('General')
            ->type('custom_country_select')
            ->options(collect([
                'AT' => 'Austria',
                'CH' => 'Switzerland',
                'FR' => 'France',
                'separator' => '──────────',
            ])->merge(
                collect((new \League\ISO3166\ISO3166())->all())
                    ->pluck('name', 'alpha2')
                    ->sort()
            )->toArray())
            ->default('AT')
            ->wrapper(['class' => 'form-group col-md-3'])
            ->attributes(['data-separator-key' => 'separator']);

        CRUD::addField([
            'name'  => 'person.region',
            'label' => 'Region',
            'type'  => 'select_from_array',
            'tab'   => 'General',
            'options' => \App\Models\Region::orderBy('name')->pluck('name', 'id')->toArray(),
            'allows_null' => true,
            'wrapper' => ['class' => 'form-group col-md-3'],
        ]);

        CRUD::addField([
            'name'  => 'kanton_toggle_script',
            'type'  => 'custom_html',
            'tab'   => 'General',
            'value' => view('kanton_toggle_script')->render(),
        ]);


        // University Information Fields
        CRUD::addField([
            'name' => 'person.university_name',
            'label' => 'University Name',
            'type' => 'text',
            'tab'  => 'University Info',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name' => 'person.university_address',
            'label' => 'University Address',
            'type' => 'text',
            'tab'  => 'University Info',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name' => 'person.start_year',
            'label' => 'Start Year',
            'type' => 'number',
            'tab'  => 'University Info',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        CRUD::addField([
            'name' => 'person.finish_year',
            'label' => 'Finish Year',
            'type' => 'number',
            'tab'  => 'University Info',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
        ]);

        // Student ID Photo Uploads
        CRUD::addField([
            'name'  => 'person.student_id_picture_front',
            'label' => 'Student ID Picture Front',
            'type'  => 'view',
            'view'  => 'crud::fields.custom_upload',
            'tab'   => 'University Info',
            'upload' => true,
            'disk'  => 'public',
            'clear' => true,
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            'value' => function ($entry) {
                return $entry->person->student_id_picture_front ?? null;
            }
        ]);

        CRUD::addField([
            'name'  => 'person.student_id_picture_back',
            'label' => 'Student ID Picture Back',
            'type'  => 'view',
            'view'  => 'crud::fields.custom_upload',
            'tab'   => 'University Info',
            'upload' => true,
            'disk'  => 'public',
            'clear' => true,
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            'value' => function ($entry) {
                return $entry->person->student_id_picture_back ?? null;
            }
        ]);

        CRUD::addField([
            'name' => 'active',
            'label' => 'Account Active?',
            'type' => 'select_from_array',
            'options' => [1 => 'Yes', 0 => 'No'],
            'allows_null' => false,
            'default' => 1,
            'tab' => 'Payment Plan',
            'wrapperAttributes' => ['class' => 'form-group col-md-6'],

            // Make read-only for non-admins
            'attributes' => backpack_user()->isAdmin()
                ? []
                : ['readonly' => 'readonly', 'disabled' => 'disabled'],
        ]);

              CRUD::addField([
            'name'  => 'person.payment_plan',
            'label' => 'Payment Plan',
            'type'  => 'select_from_array',
            'tab' => 'Payment Plan',
            'options' => \App\Models\Selection::where('table', 'payment')
                ->where('field', 'payment')
                ->orderBy('order')
                ->pluck('name', 'code')
                ->toArray(),
            'allows_null' => true,
            'wrapper' => ['class' => 'form-group col-md-3'],
        ]);

        CRUD::addField([
            'name'  => 'person.valid_till',
            'label' => 'Valid Till',
            'type'  => 'select_from_array',
           'tab' => 'Payment Plan',
             'wrapperAttributes' => ['class' => 'form-group col-md-3'],
            'options' => collect([
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ])->mapWithKeys(function ($month) {
                $year = now()->year;
                $dateObj = \Carbon\Carbon::createFromFormat('F Y', "$month $year")->endOfMonth();
                $date    = $dateObj->toDateString();
                $label   = $dateObj->format('d-F-Y');
                return [$date => $label];
            })->toArray(),

            // Make field readonly/disabled for non-admins
            'attributes' => backpack_user()->isAdmin()
                ? []
                : ['readonly' => 'readonly', 'disabled' => 'disabled'],
        ]);



        // Pass regions to the view
        $this->data['regions'] = config('regions');
        view()->share('regions', $regions);

        // Set the custom create view
        $this->crud->setCreateView('vendor.backpack.crud.create');
    }

    protected function setupUpdateOperation()
    {
        // Non-admins only see their own profile
        if (!backpack_user()->isAdmin()) {
            $this->crud->addClause('where', 'id', backpack_user()->id);
        }
        $this->setupCreateOperation();
    }

    public function store()
    {
        $response = $this->traitStore();
        $user = $this->crud->getCurrentEntry();

        $this->handlePersonData($user);

        return $response;
    }

    protected function handlePersonData($user)
    {
        $personData = request()->input('person', []);

        // Handle file uploads
        foreach (['student_id_picture_front', 'student_id_picture_back', 'profile_picture'] as $field) {
            $inputField = "person.{$field}";
            $clearField = "clear_person.{$field}";

            if (request()->has($clearField)) {
                // Clear the existing file
                if ($user->person && $user->person->{$field}) {
                    Storage::disk('public')->delete($user->person->{$field});
                    $personData[$field] = null;
                }
            } elseif (request()->hasFile($inputField)) {
                // Debug: Log the file details
                $file = request()->file($inputField);
                Log::info("File uploaded: ", ['name' => $file->getClientOriginalName(), 'path' => $file->getPathname()]);

                // Upload new file
                $originalName = $file->getClientOriginalName();
                $directory = ($field === 'profile_picture') ? 'profile_pictures' : 'student_ids';
                $path = $file->storeAs($directory, $originalName, 'public');

                // Debug: Log the stored path
                Log::info("Stored path: {$path}");

                if ($path) {
                    $personData[$field] = $path;
                } else {
                    Log::error("Failed to store file for field: {$field}");
                }

                // Delete old file if it exists
                if ($user->person && $user->person->{$field}) {
                    Storage::disk('public')->delete($user->person->{$field});
                }
            }
        }

        // Update or create person
        if ($user->person) {
            $user->person->update($personData);
        } else {
            $person = new Person($personData);
            $user->person()->save($person);
        }
    }
}
