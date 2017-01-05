<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note as Model;
use JWTAuth;
use Validator;

class Note extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get(Request $request)
    {
        $all = $this->model->where('user_id', JWTAuth::user()->id)->get();

        return response()->json($all);
    }

    public function find(Request $request, $id)
    {
        $all = $this->model->where('user_id', JWTAuth::user()->id)->find($id);

        return response()->json($all);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => JWTAuth::user()->id]);

        $data      = $request->all();
        $validator = Validator::make($data, [
            'text' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $stored = $this->model->insert($data);

        return response()->json(['message' => 'Note stored!']);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['user_id' => JWTAuth::user()->id]);

        $data      = $request->all();
        $validator = Validator::make($data, [
            'text' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $updated = $this->model
            ->where('id', $id)
            ->where('user_id', JWTAuth::user()->id)
            ->update($data);

        if ($updated == 0) {
            return response()->json(['message' => 'ID not found.'], 400);
        }

        return response()->json(['message' => 'Note updated!']);
    }

    public function destroy(Request $request, $id)
    {
        $deleted = $this->model
            ->where('id', $id)
            ->where('user_id', JWTAuth::user()->id)
            ->delete();

        if ($deleted == 0) {
            return response()->json(['message' => 'ID not found.'], 400);
        }

        return response()->json(['message' => 'Note deleted!']);
    }
}
