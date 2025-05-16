<?php

namespace App\Http\Controllers;

use App\Models\Hypothesis;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        return view('rule',[
            'title' => 'Rule',
            'hypothesis_data' => Hypothesis::orderBy('id','desc')->get(),
            'rule_data' => Rule::all(),
        ]); 
    }

    public function update(Request $request, $id)
    {
        
        foreach ($request->rule_id as $key => $value) {
            $save = Rule::where('id', $value)->first();
            $save->weight = $request->weight[$key];
            $save->save();
        }

        return redirect()->route('rule.index')->with('status','Rule of '.$save->hypothesis->name.' has been changed!');
    }
}
