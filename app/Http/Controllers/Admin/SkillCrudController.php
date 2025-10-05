<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SkillRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

class SkillCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Skill::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/skill');
        CRUD::setEntityNameStrings('skill', 'skills');

        $this->crud->setHeading('
        <style>
            .sds-heading {
                font-size: 2.3vw;
                font-weight: bold;
                color: rgb(135, 206, 235);
                text-align: center;
                padding: 1%;
                margin: 0;
            }

            @media (max-width: 1024px) {
                .sds-heading {
                    font-size: 2vw;
                    padding: 4%;
                }
            }

            @media (max-width: 768px) {
                .sds-heading {
                    font-size: 2vw;
                    padding: 6%;
                }
            }
        </style>
        <h1 class="sds-heading">SKILL PRO FINDER</h1>
    ');
    }

    protected function setupListOperation()
    {
        // For non-admins, only show their own skills
        if (!backpack_user()->isAdmin()) {
            $this->crud->addClause('where', 'user_id', backpack_user()->id);
        }

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

        if (backpack_user()->isAdmin()) {
            CRUD::column('user.email')
                ->type('text')
                ->label('User Email');
        }

        CRUD::column('skill_name')->type('text');
        CRUD::column('years_of_experience')->type('number');
        CRUD::column('price')->type('number');
        CRUD::column('skill_level')->type('text');
        CRUD::column('certification')->type('text');

        $this->crud->removeButton('preview');
        $this->crud->removeButton('update');
        $this->crud->removeButton('revisions');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('show');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SkillRequest::class);

        CRUD::addField([
            'name' => 'skill_name',
            'label' => 'Skill Name',
            'type' => 'select_from_array',
            'options' => \App\Models\Selection::where('table', 'Skills')
                ->where('field', 'Un-skill')
                ->orderBy('name')
                ->pluck('name', 'code')
                ->toArray(),
            'wrapper' => ['class' => 'form-group col-md-4'],
        ]);

        CRUD::field('years_of_experience')
            ->type('number')
            ->label('Years of Experience')
            ->default(0)
            ->wrapper(['class' => 'form-group col-md-4']);

        CRUD::addField([
            'name' => 'price',
            'label' => 'Select Price Option',
            'type' => 'select_from_array',
            'options' => \App\Models\Selection::where('table', 'price')
                ->where('field', 'price')
                ->orderBy('name')
                ->pluck('name', 'code')
                ->toArray(),
            'allows_null' => true,
            'wrapper' => ['class' => 'form-group col-md-4'],
        ]);

        CRUD::field('description')
            ->type('textarea')
            ->label('Description')
            ->wrapper(['class' => 'form-group col-md-12']);

        CRUD::field('skill_level')
            ->type('select_from_array')
            ->label('Skill Level')
            ->options([
                'Beginner' => 'Beginner',
                'Intermediate' => 'Intermediate',
                'Expert' => 'Expert',
            ])
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('certification')
            ->type('select_from_array')
            ->label('Certification')
            ->options([
                'Yes' => 'Yes',
                'No' => 'No',
            ])
            ->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('sample_pictures')
            ->type('upload_multiple')
            ->label('Sample Pictures')
            ->upload(true)
            ->disk('public')
            ->path('skills/pictures')
            ->multiple(true)
            ->accept('image/jpeg,image/png,image/gif,image/webp')
            ->mimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
            ->withFiles([
                'disk' => 'public',
                'path' => 'skills/pictures',
            ])
            ->wrapper(['class' => 'form-group col-md-12']);

        // Handle user_id field differently for admins vs non-admins
        if (!backpack_user()->isAdmin()) {
            CRUD::field('user_id')
                ->type('hidden')
                ->value(backpack_user()->id);
        } else {
            CRUD::addField([
                'name' => 'user_id',
                'label' => 'User',
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => 'App\Models\User',
            ]);
        }
    }

    protected function setupUpdateOperation()
    {
        if (!backpack_user()->isAdmin()) {
            $this->crud->addClause('where', 'user_id', backpack_user()->id);
        }

        $this->setupCreateOperation();

        // For admins, show the user as a select field
        if (backpack_user()->isAdmin()) {
            $this->crud->removeField('user_id');
            $this->crud->addField([
                'name' => 'user_id',
                'label' => 'User',
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => 'App\Models\User',
            ]);
        }
    }

    protected function setupShowOperation()
    {
        if (!backpack_user()->isAdmin()) {
            $this->crud->addClause('where', 'user_id', backpack_user()->id);
        }
        $this->setupListOperation();

        CRUD::column('description')->type('textarea');
        CRUD::column('sample_pictures')->type('view')
            ->label('Sample Pictures')
            ->view('crud::columns.multiple_images')
            ->disk('public')
            ->prefix('storage/');
        // CRUD::column('sample_videos')->type('view')
        //     ->label('Sample Videos')
        //     ->view('crud::columns.multiple_videos')
        //     ->disk('public')
        //     ->prefix('storage/');
    }

    public function store(Request $request)
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $request = $this->crud->getRequest();

        // Process sample_pictures
        if ($request->hasFile('sample_pictures')) {
            $pictures = [];
            foreach ($request->file('sample_pictures') as $file) {
                $path = $file->store('skills/pictures', 'public');
                $pictures[] = $path;
            }
            $request->merge(['sample_pictures' => json_encode($pictures)]);
        }

        // Process sample_videos
        if ($request->hasFile('sample_videos')) {
            $videos = [];
            foreach ($request->file('sample_videos') as $file) {
                $path = $file->store('skills/videos', 'public');
                $videos[] = $path;
            }
            $request->merge(['sample_videos' => json_encode($videos)]);
        }

        // For non-admins, ensure user_id is set to their own ID
        if (!backpack_user()->isAdmin()) {
            $request->merge(['user_id' => backpack_user()->id]);
        }

        $request->merge([
            'created_by' => backpack_user()->id,
            'updated_by' => backpack_user()->id,
        ]);

        return $this->traitStore();
    }

    public function update(Request $request)
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $skill = $this->crud->getCurrentEntry();
        $request = $this->crud->getRequest();

        // Process sample_pictures
        if ($request->hasFile('sample_pictures')) {
            $pictures = [];
            foreach ($request->file('sample_pictures') as $file) {
                $path = $file->store('skills/pictures', 'public');
                $pictures[] = $path;
            }
            $request->merge(['sample_pictures' => json_encode($pictures)]);
        }

        // Process sample_videos
        if ($request->hasFile('sample_videos')) {
            $videos = [];
            foreach ($request->file('sample_videos') as $file) {
                $path = $file->store('skills/videos', 'public');
                $videos[] = $path;
            }
            $request->merge(['sample_videos' => json_encode($videos)]);
        }

        // Handle file clearing
        if ($request->input('clear_sample_pictures')) {
            foreach ($request->input('clear_sample_pictures', []) as $file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
            }
            $request->merge(['sample_pictures' => json_encode([])]);
        }

        if ($request->input('clear_sample_videos')) {
            foreach ($request->input('clear_sample_videos', []) as $file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
            }
            $request->merge(['sample_videos' => json_encode([])]);
        }

        // For non-admins, ensure they can't change the user_id
        if (!backpack_user()->isAdmin()) {
            $request->merge(['user_id' => backpack_user()->id]);
        }

        $request->merge(['updated_by' => backpack_user()->id]);

        return $this->traitUpdate();
    }
}
