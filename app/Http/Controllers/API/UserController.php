<?php

namespace App\Http\Controllers\API;

use App\Models\User;

/**
 * @method sendResponse($toArray, string $string)
 */
class UserController extends AppBaseController
{
    public function show($id)
    {
        $product = User::findOrFail($id);

        return $this->sendResponse($product->toArray(), 'User retrieved successfully.');
    }
}
