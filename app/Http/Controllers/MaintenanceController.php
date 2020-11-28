<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'description' => 'required'
        ]);

        $requestData = $request->all();
        $requestData['user_id'] = Auth::user()->id;

        $data = $this->model::create($requestData);
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
            'description' => 'required'
        ]);

        $resource = $this->model::find($id);
        if (is_null($resource)) {
            return response()->json('Resource not found', 404);
        }

        $requestData = $request->all();
        $requestData['user_id'] = Auth::user()->id;

        $resource->fill($requestData);
        $resource->save();

        return response()->json([], 200);
    }
}
