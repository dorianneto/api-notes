<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User as Model;
use Validator;

class User extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(Request $request)
    {
        $data      = $request->all();
        $validator = Validator::make($data, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data['password'] = Hash::make($data['password']);

        $this->model->insert($data);

        return response()->json(['message' => 'User stored!']);
    }
}
