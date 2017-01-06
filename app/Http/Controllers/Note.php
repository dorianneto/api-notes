<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use App\Note as Model;
use JWTAuth;

class Note extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get(Request $request)
    {
        $all = $this->model
            ->where('user_id', JWTAuth::user()->id)
            ->get();

        return response()->json($all);
    }

    public function find(Request $request, $id)
    {
        $the_one = $this->model
            ->where('user_id', JWTAuth::user()->id)
            ->find($id);

        return response()->json($the_one);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => JWTAuth::user()->id]);
        $data = $request->only('text', 'user_id');

        $validator = $this->validator($data, [
            'text' => 'required|max:255'
        ]);

        if (!is_null($validator)) {
            return $validator;
        }

        try {
            $data['created_at'] = Carbon::now();

            $this->model->insert($data);

            return response()->json(['message' => 'note_stored']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->merge(['user_id' => JWTAuth::user()->id]);
        $data = $request->only('text', 'user_id');

        $validator = $this->validator($data, [
            'text' => 'required|max:255'
        ]);

        if (!is_null($validator)) {
            return $validator;
        }

        try {
            $updated = $this->model
                ->where('id', $id)
                ->where('user_id', JWTAuth::user()->id)
                ->update($data);

            if ($updated == 0) {
                return response()->json(['message' => 'id_not_found'], 400);
            }

            return response()->json(['message' => 'note_updated']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $deleted = $this->model
                ->where('id', $id)
                ->where('user_id', JWTAuth::user()->id)
                ->delete();

            if ($deleted == 0) {
                return response()->json(['message' => 'id_not_found'], 400);
            }

            return response()->json(['message' => 'note_deleted']);
        } catch (QueryException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
