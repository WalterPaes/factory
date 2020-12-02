<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $model;

    public function index(Request $request)
    {
        return $this->model::paginate($request->per_page);
    }

    public function show(int $id)
    {
        $data = $this->model::find($id);
        if (is_null($data)) {
            return response()
                ->json([], 404);
        }
        return $data;
    }

    public function destroy(int $id)
    {
        $total = $this->model::destroy($id);
        if ($total < 1) {
            return response()->json('Resource not found', 404);
        }
        return response()->json([], 204);
    }

    abstract function store(Request $request);

    abstract function update(int $id, Request $request);
}

