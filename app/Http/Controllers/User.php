<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\User as Model;
use Carbon\Carbon;

/**
 * User's controller
 *
 * @version   v1.0.0
 * @link      http://hsa.dorianneto.com.br/
 * @author    Dorian Neto <doriansampaioneto@gmail.com>
 */
class User extends Controller
{
    /**
     * The model class
     * @var \App\User
     */
    protected $model;

    /**
     * The class constructor
     * @param \App\User $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Stores a user
     * @param  Request $request
     * @return json
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'email', 'password');

        $validator = $this->validator($data, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if (!is_null($validator)) {
            return $validator;
        }

        try {
            $data['password']   = Hash::make($data['password']);
            $data['created_at'] = Carbon::now();

            $this->model->insert($data);

            return response()->json(['message' => 'user_stored']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
