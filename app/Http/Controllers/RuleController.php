<?php

namespace App\Http\Controllers;

use App\Models\Hypothesis;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Validation\Rule as ValidationRule; // Import Rule untuk validasi exists

class RuleController extends Controller
{
    /**
     * Menampilkan halaman aturan.
     * Aman karena menggunakan Eloquent dan dilindungi middleware admin.
     */
    public function index()
    {
        return view('rule', [
            'title' => 'Rule',
            'hypothesis_data' => Hypothesis::orderBy('id', 'desc')->get(),
            // Eager load relasi untuk optimasi query
            'rule_data' => Rule::with(['evidence', 'hypothesis'])->get(),
        ]);
    }

    /**
     * Memperbarui aturan (bobot).
     * Telah ditambahkan validasi untuk memastikan integritas data dan stabilitas.
     */
    public function update(Request $request) // Parameter $id tidak digunakan, bisa dihapus
    {
        // PERBAIKAN: Tambahkan blok validasi yang kuat
        $validator = Validator::make($request->all(), [
            // Pastikan 'rule_id' dan 'weight' adalah array dan memiliki jumlah elemen yang sama
            'rule_id' => 'required|array',
            'weight' => 'required|array|size:' . count($request->rule_id ?? []),
            
            // Validasi setiap elemen di dalam array
            'rule_id.*' => 'required|integer|exists:rules,id', // Pastikan setiap ID aturan ada di tabel 'rules'
            'weight.*' => 'required|numeric|between:0,1' // Pastikan setiap bobot adalah angka antara 0 dan 1
        ]);

        if ($validator->fails()) {
            return redirect()->route('rule.index')
                ->withErrors($validator)
                ->withInput();
        }
        
        $hypothesisName = '';
        foreach ($request->rule_id as $key => $value) {
            // Kita sudah memvalidasi bahwa ID ada, jadi kita bisa menggunakan find()
            $save = Rule::find($value); 
            $save->weight = $request->weight[$key];
            $save->save();
            
            // Simpan nama hipotesis untuk pesan status
            if(empty($hypothesisName)) {
                $hypothesisName = $save->hypothesis->name;
            }
        }

        return redirect()->route('rule.index')->with('status', 'Rule of ' . $hypothesisName . ' has been changed!');
    }
}