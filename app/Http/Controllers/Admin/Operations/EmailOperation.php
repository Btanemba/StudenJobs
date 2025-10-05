<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Prologue\Alerts\Facades\Alert;

trait EmailOperation
{
    protected function setupEmailRoutes($segment, $routeName, $controller)
    {
        // Show the form
        Route::get($segment.'/{id}/email', [
            'as'        => $routeName.'.email',
            'uses'      => $controller.'@email',
            'operation' => 'email',
        ]);

        // Handle the form submission
        Route::post($segment.'/{id}/email', [
            'as'        => $routeName.'.sendEmail',
            'uses'      => $controller.'@sendEmail',
            'operation' => 'email',
        ]);
    }

    protected function setupEmailDefaults()
    {
        $this->crud->allowAccess('email');

        $this->crud->operation('email', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });
    }

    public function email($id)
    {
        $this->crud->hasAccessOrFail('email');

        $user = $this->crud->getEntry($id);

        return view('vendor.backpack.crud.operations.email', [
            'crud'  => $this->crud,
            'entry' => $user,
        ]);
    }

    public function sendEmail($id)
    {
        $this->crud->hasAccessOrFail('email');

        $user = $this->crud->getEntry($id);

        request()->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::raw(request('message'), function ($mail) use ($user) {
            $mail->to($user->email)
                 ->subject(request('subject'));
        });

        Alert::success("Email sent to {$user->email}")->flash();

        return redirect($this->crud->route);
    }
}
