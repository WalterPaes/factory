<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Client\Request;

class EquipmentController extends BaseController
{
    public function __construct()
    {
        $this->model = Equipment::class;
    }

    function store(Request $request)
    {

    }

    function update(int $id, Request $request)
    {
        // TODO: Implement update() method.
    }
}
