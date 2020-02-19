<?php

namespace App\Http\Controllers;

use App\Tool;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $data = Tool::latest()->get();
            return DataTables::of($data)
                -> addColumn('action', function($data) {
                    $button = '<button type="button" name="edit" class="edit btn btn-primary btn-sm" id="'.$data->id.'">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit"  class="delete btn btn-danger btn-sm" id="'.$data->id.'">Delete</button>';
                    return $button;
                })
                -> rawColumns(['action'])
                -> make(true);
        }
        return view('layout.main');
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
        $rules = [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'tempat_beli' => 'required',
        ];

        $error = Validator::make($request->all(), $rules);
        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = [
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'tempat_beli' => $request->tempat_beli
        ];
        Tool::create($form_data);
        return response()->json(['success' => 'Data Added Successfully!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function show(Tool $tool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Tool::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tool $tool)
    {
        // $rules = [
        //     'kode_barang' => 'required',
        //     'nama_barang' => 'required',
        //     'tempat_beli' => 'required'
        // ];
        // $error = Validator::make(request()->all(), $rules);

        // if ($error->fails())
        // {
        //     return response()->json(['errors' => $error->errors()->all()]);
        // }

        // $form_data = [
        //     'kode_barang' => $request->kode_barang,
        //     'nama_barang' => $request->nama_barang,
        //     'tempat_beli' => $request->tempat_beli,
        // ];

        // Tool::whereId($request->hidden_id)->update($form_data);
        // return response()->json(['success' => 'Data is Successfully Updated!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tool  $tool
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tool $tool)
    {
        //
    }
}
