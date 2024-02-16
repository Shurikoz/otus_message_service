<?php

namespace App\Http\Controllers\API;

use App\Models\Profile;
use App\Models\User;

/**
 * @method sendResponse($array, string $string)
 */
class UserController extends AppBaseController
{
    public function search()
    {
//        $name = 'ана';
        $name = 'Дми';
        $surname = 'Аб';

        $profiles = Profile::where(
            [
                ['first_name', 'LIKE', $name . '%'],
                ['last_name', 'LIKE', $surname . '%']
            ]
        )->orderBy('id')->get();

        return $this->sendResponse(count($profiles), 'successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->sendResponse($user->toArray(), 'User retrieved successfully.');
    }
}
