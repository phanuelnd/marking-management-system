<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserUpdateController extends Controller
{
    public function changeInfo(Request $request)
    {
        $user = $request->user();
        $user_type = $user->type;
        $fields = $request->validate(
            [
                'name' => 'string',
                'email' => Rule::unique($user->type . 's', 'email')->ignore($user->id),
                'phone' => ['numeric', Rule::unique($user->type . 's', 'phone')->ignore($user->id)],
            ]
        );
        unset($user->type);
        $user->update($fields);
        $user->type = $user_type;

        return response($user);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'password' => 'required|confirmed'
            ],
        );

        $validator->after(function ($validator) use ($request, $user) {
            if ($request->password && !Hash::check($request->current_password, $user->password)) {
                $validator->errors()->add(
                    'current_password',
                    'Provided password is incorrect'
                );
            }
        });

        $validator->validate();

        unset($user->type);
        $user->update(['password' => bcrypt($request->password)]);

        return response(['message' => 'Password was reset!']);
    }
}
