<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $returnUrl;
    public $fileRepo;

    /**
     * @param $request
     * @param $fillables
     * @return array
     */
    public function prepare($request, $fillables): array
    {
        $data = array();
        foreach ($fillables as $fillable) {
            if ($request->has($fillable)) {
                $data[$fillable] = $request->get($fillable);
            } else {
                if (Str::of($fillable)->startsWith("is_")) {
                    $data[$fillable] = 0;
                }
            }
        }

        if (count($request->allFiles()) > 0) {
            foreach ($request->allFiles() as $key => $value) {
                $uploadedFile = $request->file($key);
                $data[$key] = $uploadedFile->hashName();
                $uploadedFile->storeAs($this->fileRepo, $data[$key]);
            }
        }

        return $data;
    }

    public function prepare2($request, $type): array
    {
        $instance = new $type;
        $instance->
        $data = array();
        foreach ($model->getFillable() as $fillable) {
            if ($request->has($fillable)) {
                $data[$fillable] = $request->get($fillable);
            } else {
                if (Str::of($fillable)->startsWith("is_")) {
                    $data[$fillable] = 0;
                }
            }
        }

        if (count($request->allFiles()) > 0) {
            foreach ($request->allFiles() as $key => $value) {
                $uploadedFile = $request->file($key);
                $data[$key] = $uploadedFile->hashName();
                $uploadedFile->storeAs($this->fileRepo, $data[$key]);
            }
        }

        return $data;
    }
}
