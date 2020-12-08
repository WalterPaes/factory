<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;

abstract class BaseController extends Controller
{
    protected $model;

    public function index(Request $request)
    {
        try {
            return $this->model::paginate($request->per_page);
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $data = $this->model::find($id);
            if (is_null($data)) {
                return response()
                    ->json([], 404);
            }
            return $data;
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $total = $this->model::destroy($id);
            if ($total < 1) {
                return response()->json('Resource not found', 404);
            }
            return response()->json([], 204);
        } catch (Throwable $t) {
            return response()->json([], 500);
        }
    }

    abstract function store(Request $request);

    abstract function update(int $id, Request $request);
}

