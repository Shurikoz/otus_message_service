<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends AppBaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'            => ['required', 'email'],
            'password'         => ['required'],
            'confirm_password' => ['required', 'same:password'],
            'first_name'       => ['string', 'max:50'],
            'last_name'        => ['string', 'max:50'],
            'birthday'         => ['date'],
            'sex'              => ['boolean'],
            'interests'        => ['string', 'max:200'],
            'city'             => ['string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken(config('app.name'))->accessToken;
        $success['email'] = $user->email;

        return $this->sendResponse($success, 'User register successfully.');
    }
}
