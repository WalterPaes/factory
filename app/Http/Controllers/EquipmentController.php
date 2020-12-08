<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Throwable;

class EquipmentController extends BaseController
{
    public function __construct()
    {
        $this->model = Equipment::class;
    }

    public function index(Request $request)
    {
        try {
            if ($request->input('actives')) {
                return Equipment::actives();
            }
            return Equipment::with('components')
                ->paginate($request->per_page);
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $data = Equipment::find($id);
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
            'name' => 'required',
        ]);

        try {
            $equipment = $this->model::create($request->all());
            if (is_null($equipment)) {
                return response()->json([], 500);
            }

            return response()->json([], 201);
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }

    public function update(int $id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => ['required', 'boolean']
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
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }

    public function components(int $id)
    {
        try {
            $data = Equipment::where('id', $id)
                ->with('components')
                ->get();
            if (is_null($data)) {
                return response()
                    ->json([], 404);
            }
            return $data;
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }

    public function storeEquipmentComponent(int $id, Request $request)
    {
        $this->validate($request, [
            'component_id' => 'required',
        ]);

        try {
            $data = Equipment::saveComponent($id, $request->component_id);
            if (is_null($data)) {
                return response()
                    ->json([], 404);
            }
            return $data;
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }

    public function destroyEquipmentComponent(int $equipment_id, int $component_id)
    {
        try {
            Equipment::removeComponent($equipment_id, $component_id);
            return response()->json([], 204);
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }
}
