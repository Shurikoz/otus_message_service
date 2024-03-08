<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;

class MessengerController extends AppBaseController
{
    public function getMessageV1()
    {
        Log::info('Запрошено сообщение, api version 1');

        return json_encode('Test message, api version 1');
    }

    public function getMessageV2()
    {
        Log::info('Запрошено сообщение, api version 2');

        return json_encode('Test message, api version 2');
    }
}
