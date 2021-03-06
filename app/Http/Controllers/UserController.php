<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->model = User::class;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => ['required', 'unique:users,username'],
            'password' => ['required', 'min:6']
        ]);

        try {
            $data = $this->model::create($request->all());
            if (is_null($data)) {
                return response()->json([], 500);
            }

            return response()->json([], 201);
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    public function update(int $id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => ['required', Rule::unique('users')->ignore($id)],
            'password' => ['required', 'min:6']
        ]);

        try {
            $resource = $this->model::find($id);
            if (is_null($resource)) {
                return response()->json('Resource not found', 404);
            }
            $resource->fill($request->all());
            $resource->save();
            return response()->json([], 200);
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }
}
