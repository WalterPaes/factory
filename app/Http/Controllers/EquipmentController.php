<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends BaseController
{
    public function __construct()
    {
        $this->model = Equipment::class;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
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
