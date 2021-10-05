<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee');
    }

    public function allData()
    {
       $employees = Employee::orderBy('id','desc')->get();
       return response()->json($employees);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'designation' => 'required|string',
            'address' => 'required|string',
        ]);

        $data = Employee::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'address' => $request->address,
        ]);

        return response()->json($data);
    }

    public function edit($id)
    {
        $data = Employee::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'designation' => 'required|string',
            'address' => 'required|string',
        ]);

        $data = Employee::findOrFail($id);
        $data->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'address' => $request->address,
        ]);

        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Employee::findOrFail($id);
        $data->delete();

        return response()->json($data);
    }
}
