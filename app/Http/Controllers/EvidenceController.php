<?php

namespace App\Http\Controllers;

use App\Models\Evidence;
use App\Models\Hypothesis;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('evidence.index',[
            'title' => 'Evidence - '.Setting::where('component', 'evidence')->first()->value,
            'evidence_data' => Evidence::orderBy('id','desc')->get()
        ]);
    }

    public function autoCode(){
        $lates_evidence = Evidence::orderby('id', 'desc')->first();
        $code = $lates_evidence->code;
        $order = (int) substr($code, 2, 3);
        $order++;
        $letter = "G";
        $code = $letter . sprintf("%03s", $order);
        return $code;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('evidence.create',[
            'title' => 'Evidence',
            'get_auto_code' => $this->autoCode()
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Evidence::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        foreach (Hypothesis::all() as $value) {
            Rule::create([
                'evidence_id' => Evidence::where('code', $request->code)->first()->id,
                'hypothesis_id' => $value->id,
                'weight' => 0.1
            ]); 
        }

        return redirect()->route('evidence.index')->with('status','Data created succesfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evidence $evidence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('evidence.edit',[
            'title' => 'Evidence',
            'get_evidence' => Evidence::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            // 'image' => 'required',
            // 'description' => 'required'
        ]);

        Evidence::where('id', $id)->update([
            'name' => $request->name,
            
        ]);
            
        return redirect()->route('evidence.index')->with('status','Data updated succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Rule::where('evidence_id',$id)->delete();
        Evidence::where('id',$id)->delete();
        return redirect()->route('evidence.index')->with('status','Data deleted succesfully!');
    }
}
