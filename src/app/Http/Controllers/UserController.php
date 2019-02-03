<?php

namespace App\Http\Controllers;

use App\Mail\PasswordRemember;
use App\User;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    public function passwordRemember()
    {
        $this->validate($this->request, [
            'email'     => 'required|email'
        ]);

        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }

        $user->auditLog()->Create(['actionType' => 'request', 'action' => sprintf('%s requested password reset', $this->request->get('email'))]);
        $recoveryToken = uniqid();
        $user->update(['recoveryToken' => $recoveryToken]);
        Mail::to($user->email)->send(new PasswordRemember($recoveryToken));

        return response()->json($user, 201);
    }

    public function changePassword()
    {
        $this->validate($this->request, [
            'password' => 'required',
            'token'    => 'required',
        ]);

        $user = User::where('recoveryToken', $this->request->input('token'))->first();
        if (!$user) {
            return response()->json([
                'error' => 'Token was not found.'
            ], 400);
        }
        $user->update(['recoveryToken' => '', 'password' => base64_encode($this->request->input('password'))]);
        $user->auditLog()->Create(['actionType' => 'change', 'action' => 'User password is changed']);
        return response()->json($user, 200);
    }

}