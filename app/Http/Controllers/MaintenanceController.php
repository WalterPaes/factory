<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class MaintenanceController extends BaseController
{
    public function __construct()
    {
        $this->model = Maintenance::class;
    }

    public function index(Request $request)
    {
        try {
            return Maintenance::with(['user', 'equipment'])
                ->paginate($request->per_page);
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $data = Maintenance::where('id', $id)
                ->with(['user', 'equipment'])
                ->first();
            if (is_null($data)) {
                return response()
                    ->json([], 404);
            }
            return $data;
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
            'equipment_id' => ['required', 'exists:equipments,id'],
            'description' => 'required'
        ]);

        try {
            $requestData = $request->all();
            $requestData['user_id'] = Auth::user()->id;

            $data = $this->model::create($requestData);
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
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
            'equipment_id' => ['required', 'exists:equipments,id'],
            'description' => 'required'
        ]);

        try {
            $resource = $this->model::find($id);
            if (is_null($resource)) {
                return response()->json('Resource not found', 404);
            }

            $requestData = $request->all();
            $requestData['user_id'] = Auth::user()->id;

            $resource->fill($requestData);
            $resource->save();

            return response()->json([], 200);
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    public function searchByUser(int $id)
    {
        try {
            $users = User::query()
                ->where('user_id', $id)
                ->paginate();
            return $users;
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    public function searchByEquipment(int $id)
    {
        try {
            $equipments = Maintenance::query()
                ->where('equipment_id', $id)
                ->paginate();
            return $equipments;
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }
}
