<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class CoreController extends Controller
{
    protected $model;
    protected $resource;
    protected $user;

    public function __construct(
        protected Request $request
    ) {
        $modelname = Str::apa(Pluralizer::singular($request->route("model") ?? ""));
        $model = '\\App\\Models\\' . $modelname;

        $this->model = new $model;

        if (class_exists('\\App\\Http\\Resources\\' . $modelname . 'Resource')) {
            $this->resource = '\\App\\Http\\Resources\\' . $modelname . 'Resource';
        } else {
            $this->resource = '\\Illuminate\\Http\\Resources\\Json\\JsonResource';
        }

        $this->user = auth()->user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if ($this->user->cannot('viewAny', $this->model)) {
            return response()->json(["error" => "Unauthorized"], 403);
        }

        $data = $this->model->all();
        return new $this->resource($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        if ($this->user->cannot('create', $this->model)) {
            return response()->json(["error" => "Unauthorized"], 403);
        }

        if (isset($this->model->validation_rules)) {
            $validation = Validator::make($request->all(), $this->model->validation_rules);
            if ($validation->fails()) {
                return response()->json(["error" => $validation->errors()], 400);
            }
        }
        
        $data = $this->model->create($request->all());
        return response()->json(new $this->resource($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $modelName, int $id)
    {
        if ($this->user->cannot('view', $this->model)) {
            return response()->json(["error" => "Unauthorized"], 403);
        }

        $data = $this->model->findOrFail($id);
        return response()->json(new $this->resource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $modelName, int $id)
    {
        if ($this->user->cannot('update', $this->model)) {
            return response()->json(["error" => "Unauthorized"], 403);
        }

        if (isset($this->model->validation_rules)) {
            $update_rules = [];
            foreach ($request->all() as $key => $value) {
                if (isset($this->model->validation_rules[$key])) {
                    $update_rules[$key] = $this->model->validation_rules[$key];
                }
            }

            $validation = Validator::make($request->all(), $update_rules);
            if ($validation->fails()) {
                return response()->json(["error" => $validation->errors()], 400);
            }
        }

        $data = $this->model->find($id);
        if (!$data) {
            return response()->json(["error" => "Resource not found -> ".$id], 404);
        }

        $data->update($request->all());
        return response()->json(new $this->resource($data));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $modelName, int $id)
    {
        //
    }
}
