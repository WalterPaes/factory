<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends BaseController
{
    public function __construct()
    {
        $this->model = Maintenance::class;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start' => ['required', 'date'],
            'end' => ['required', 'date'],
            'equipment_id' => 'exists:equipment,id',
            'user_id' => 'exists:user,id',
            'description' => 'required'
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
            'start' => ['required', 'date'],
            'end' => ['required', 'date'],
            'equipment_id' => 'exists:equipment,id',
            'user_id' => 'exists:user,id',
            'description' => 'required'
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
