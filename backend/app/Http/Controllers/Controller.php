<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiError;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $model;

    public function index(Request $request)
    {
        if (!$this->model) throw new ApiError('No model');
        return $this->model->search($request);
    }

    public function store(Request $request)
    {
        if (!$this->model) throw new ApiError('No model');
        return ['store', $this->model->getTable(), $request->all()];
    }

    public function show(Request $request, $id)
    {
        if (!$this->model) throw new ApiError('No model');
        return ['show', $this->model->getTable(), $request->all(), $id];
    }

    public function update(Request $request, $id)
    {
        if (!$this->model) throw new ApiError('No model');
        return ['update', $this->model->getTable(), $request->all(), $id];
    }

    public function destroy(Request $request, $id)
    {
        if (!$this->model) throw new ApiError('No model');
        return ['destroy', $this->model->getTable(), $id];
    }
}
