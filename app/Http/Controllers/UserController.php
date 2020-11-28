<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            'username' => 'required',
            'password' => ['required', 'min:6']
        ]);

        $data = $this->model::create($request->all());
        if (is_null($data)) {
            return response()->json([], 500);
        }

        return response()->json([], 201);
    }

    public function update(int $id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'password' => ['required', 'min:6']
        ]);

        $resource = $this->model::find($id);
        if (is_null($resource)) {
            return response()->json('Resource not found', 404);
        }

        $resource->fill($request->all());
        $resource->save();

        return response()->json([], 200);
    }
}
