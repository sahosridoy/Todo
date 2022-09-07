<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkResource;
use App\Models\Work;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;


class WorkController extends Controller
{

    use ApiResponse;


    public function index()
    {


        $data_query = Work::all();
        return WorkResource::collection($data_query)->additional($this->ResponseInfo());
    }



    public function store(Request $request)
    {

        $data = $request->all();
        try {
            Work::create($data);
            return $this->ResponseSuccess([], 'Your data created sucessfuly');
        } catch (\Exception $e) {
            return $this->ResponseError([],$e->getMessage());
        }
    }

    public function changeStatus($id, $status)
    {
        Work::findOrFail($id)->update([
            'status' => 2,
        ]);

        try {
            Work::findOrFail($id)->update([
                'status' => $status,
            ]);
            return $this->ResponseSuccess([], 'Your data status change sucessfuly');
        } catch (\Exception $e) {
            return $this->ResponseError([],$e->getMessage());
        }

        // $data = $request->all();
        // try {
        //     Work::create($data);
        //     return $this->ResponseSuccess([], 'Your data created sucessfuly');
        // } catch (\Exception $e) {
        //     return $this->ResponseError([],$e->getMessage());
        // }
    }





}
