<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class StudentsController extends Controller
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
            $data = Student::latest()->get();
            return DataTables::of($data)
                    -> addColumn('action', function($data){
                        $button = '<button type="button" class="edit btn btn-primary btn-sm" name="edit" id="'.$data->id.'">Edit</button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" class="delete btn btn-danger btn-sm" id="'.$data->id.'">Delete</button>';
                        return $button;
                    })
                    -> rawColumns(['action'])
                    -> make(true);
        }
        return view('sample');
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
            'first_name'    => 'required',
            'last_name'     => 'required',
            'address'       => 'required'
        ];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'address'     => $request->address
        ];
        Student::create($form_data);
        return response()->json(['success' => 'Data Added Successflly!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax()) {
            $data = Student::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $rules = [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'address'           => 'required'
        ];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = [
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'address'           => $request->address
        ];
        Student::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is Successfully Updated!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Student::findOrFail($id);
        $data->delete();
    }
}
