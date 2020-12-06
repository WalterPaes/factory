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
            return Equipment::with('components')
                ->paginate($request->per_page);
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }

    public function actives()
    {
        try {
            return Equipment::actives();
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
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
            $resource = $this->model::edit($id, $request->all());
            if (is_null($resource)) {
                return response()->json('Resource not found', 404);
            }

            return response()->json([], 200);
        } catch (Throwable $t) {
            return response()->json([
                "message" => $t->getMessage()
            ], 500);
        }
    }
}
