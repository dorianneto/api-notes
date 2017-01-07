<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

/**
 * Base controller
 *
 * @version   v1.0.0
 * @link      http://hsa.dorianneto.com.br/
 * @author    Dorian Neto <doriansampaioneto@gmail.com>
 */
class Controller extends BaseController
{
    /**
     * Validates request data
     * @param  array  $data
     * @param  array  $rules
     * @return json|null
     */
    protected function validator(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        return null;
    }
}
