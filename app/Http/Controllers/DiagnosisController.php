<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
    {
        return view('diagnosis',[
            'title' => 'History Diagnosis',
            'diagnosis_data' => Diagnosis::with('hypothesis.images')->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function destroy($id)
    {
        Diagnosis::where('id',$id)->delete();
        return redirect()->route('diagnosis.index')->with('status','Data deleted succesfully!');
    }
}
