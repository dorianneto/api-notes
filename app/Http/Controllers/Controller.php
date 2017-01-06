<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

class Controller extends BaseController
{
    protected function validator(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        return null;
    }
}
