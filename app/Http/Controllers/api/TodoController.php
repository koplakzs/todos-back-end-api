<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Todolist::all();

        return response()->json([
            "data" => $all
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'task' => 'required',
            ]

        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 401);
        } else {
            $post = Todolist::create([
                'task' => $request->input('task'),
                'status' => "Pending"
            ]);

            if ($post) {
                return response()->json([
                    'status' => true,
                    'message' => "Data Berhasil di Simpan",
                    'data' => $post
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Data Gagal di Simpan",
                    'data' => $post
                ], 401);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = Todolist::find($id);

        if ($show) {
            return response()->json([
                "status" => true,
                'data' => $show
            ], 200);
        }
        return response()->json([
            'status' => false,
            'data' => "Data Tidak Ditemukan"
        ], 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $updates = Todolist::find($id);

        $validator = Validator::make(
            $request->all(),
            [
                'task' => 'required',
                'status' => 'required'
            ]

        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 401);
        } else {
            $post = $updates->update([
                'task' => $request->input('task'),
                'status' => $request->input('status')
            ]);

            if ($post) {
                return response()->json([
                    'status' => true,
                    'message' => "Data Berhasil di Update",
                    'data' => $post
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Data Gagal di Update",
                    'data' => $post
                ], 401);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Todolist::find($id)->delete();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => "Data Berhasil Dihapus"
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data Gagal Dihapus'
        ], 401);
    }
}
