<?php

namespace App\Http\Controllers\API;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @method sendResponse($array, string $string)
 */
class UserController extends AppBaseController
{
    public function search(Request $request)
    {
        $profiles = Profile::where(
            [
                ['first_name', 'LIKE', $request->get('name') . '%'],
                ['last_name', 'LIKE', $request->get('surname') . '%']
            ]
        )
            ->orderBy('id')
            ->limit(10)
            ->get();

        return $this->sendResponse($profiles, 'successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->sendResponse($user->toArray(), 'User retrieved successfully.');
    }
}
