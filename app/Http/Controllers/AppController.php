<?php

namespace App\Http\Controllers;

use App\Exports\DiagnosisExport;
use App\Models\Diagnosis;
use App\Models\Evidence;
use App\Models\Hypothesis;
use App\Models\Rule;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AppController extends Controller 
{
    public function dashboard()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'cnt_user' => User::count(),
            'cnt_evidence' => Evidence::count(),
            'cnt_hypothesis' => Hypothesis::count(),
            'cnt_case' => Diagnosis::count(),
            // 'diagnosis_data' => Diagnosis::orderBy('created_at', 'desc')->get(),
            // Filter diagnoses by the currently logged-in user
            'diagnosis_data' => Diagnosis::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get(),
            'hypothesis_data' => Hypothesis::orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function index()
    {
        return view('index', [
            'title' => 'Index',
            'app_title' => Setting::where('component', 'title')->first(),
            'app_desc' => Setting::where('component', 'description')->first(),
        ]);
    }

    public function expert_result(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'evidence_id' => 'required|array|min:0'
        ]);

        $selectedEvidences = $request->input('evidence_id');
        // $weights = $request->input('evidence_id'); // Get the weights input by user

        $hypotheses = Rule::distinct('hypothesis_id')->pluck('hypothesis_id')->toArray();
        // $hypotheses = Hypothesis::all();

        $results = [];
        $maxWeight = null;
        $bestHypothesis = null;
        
        foreach ($hypotheses as $hypothesis) {
            $totalWeight = 0;
            foreach ($selectedEvidences as $evidenceId) {
                $rule = Rule::where('evidence_id', $evidenceId)
                            ->where('hypothesis_id', $hypothesis)
                            ->first();
                if ($rule) {
                    $totalWeight += $rule->weight;
                }
            }
            $results[$hypothesis] = $totalWeight;
            

            // calculate the contribution of each evidence
            foreach ($selectedEvidences as $evidenceId) {
                $rule = Rule::where('evidence_id', $evidenceId)
                            ->where('hypothesis_id', $hypothesis)
                            ->first();
                if ($rule && $totalWeight > 0) {
                    $contribution = $rule->weight / $totalWeight;

                    $probability_H = $rule->weight * $contribution;
                    $probabilityHypothesis[$hypothesis][$evidenceId] = $probability_H;
                } else {
                    $probabilityHypothesis[$hypothesis][$evidenceId] = 0;
                }
            }

            $totalProbabilities = [];
            foreach ($probabilityHypothesis as $hypothesis => $probability_H) {
                $totalProbabilities[$hypothesis] = array_sum($probability_H);
            }

            foreach ($selectedEvidences as $evidenceId) {
                $rule = Rule::where('evidence_id', $evidenceId)
                            ->where('hypothesis_id', $hypothesis)
                            ->first();
                if ($rule && isset($totalProbabilities[$hypothesis]) && $totalProbabilities[$hypothesis] > 0) {
                    $bayesValue = ($probability_H[$evidenceId] * $rule->weight) / $totalProbabilities[$hypothesis];
                    $bayesValues[$hypothesis][$evidenceId] = $bayesValue;
                } else {
                    $bayesValues[$hypothesis][$evidenceId] = 0;
                }
            }

            $totalBayes = [];
            foreach ($bayesValues as $hypothesis => $bayesvalue) {
                $totalBayes[$hypothesis] = array_sum($bayesvalue) * 100;
            }

            // Check if the current hypothesis has the maximum weight
            if (is_null($maxWeight) || $totalWeight > $maxWeight) {
                $maxWeight = $totalWeight;
                $bestHypothesis = $hypothesis;
            }

            // Mendapatkan nilai terbesar
            $maxTotalBayes = max($totalBayes);

            // Menemukan hipotesis dengan nilai terbesar
            $bestBayes = array_search($maxTotalBayes, $totalBayes);
        }

                // Urutkan nilai $totalBayes dari yang terbesar ke yang terkecil
        arsort($totalBayes);

        $certaintyDescriptions = []; // Array untuk menyimpan deskripsi kepastian

        foreach ($totalBayes as $hypothesisId => $bayesValue) {
            // Simpan deskripsi kepastian berdasarkan totalBayes masing-masing hypothesis
            $certaintyDescriptions[$hypothesisId] = $this->getCertaintyDescription($bayesValue);
        }

        // Mengambil data Hypothesis dengan ID $bestBayes
        $bestHypothesisData = Hypothesis::find($bestBayes);

        // Ambil data Hypothesis berdasarkan ID yang ada di $totalBayes
        $hypothesesData = Hypothesis::whereIn('id', array_keys($totalBayes))->get()->keyBy('id');

        // Ambil data evidence yang dipilih
        $selectedEvidencesData = Evidence::whereIn('id', $selectedEvidences)->get();

        // Determine certainty description based on maxTotalBayes value
        $certainty = $this->getCertaintyDescription($maxTotalBayes);


            // dd($bestHypothesisData);
            // Calculate total contributions for each hypothesis
            
            
            // foreach ($probabilityHypothesis as $probabilitiesH) {
            //     if ($probability_H > 0) {
            //         $totalProbabilities += $probabilitiesH;
            //         $totalProbabilities[$hypotheses] = $totalProbabilities;
            //     }else {
            //         $totalProbabilities[$hypotheses] = 0;
            //     }
                
            // }

            // foreach ($probabilityHypothesis as $probabilitiesH) {
            //      $totalProbabilities = $probabilitiesH;
            //      if ($probabilitiesH) {
            //         $totalProbabilities += $probabilitiesH;
            //      }
            // }

            // // the contribution of each evidence
            // foreach ($selectedEvidences as $evidenceId) {
            //     $rule = Rule::where('evidence_id', $evidenceId)
            //                 ->where('hypothesis_id', $hypothesis)
            //                 ->first();
            //     if ($rule && $totalWeight > 0) {
            //         // Periksa apakah $selectedEvidences[$evidenceId] ada
            //         if (isset($selectedEvidences[$evidenceId])) {
            //             $contribution = ($rule->weight / $totalWeight) * $selectedEvidences[$evidenceId];
            //             $evidenceContributions[$hypothesis][$evidenceId] = $contribution;
            //         } else {
            //             $evidenceContributions[$hypothesis][$evidenceId] = 0;
            //         }
            //     } else {
            //         $evidenceContributions[$hypothesis][$evidenceId] = 0;
            //     }
            // }

       

        // Cari nilai terbesar dan hypothesis-nya
        // $maxHypothesis = array_keys($results, max($results))[0];
        // $maxValue = $results[$maxHypothesis];

        // $maxHypothesis = array_keys($results, max($results))[0];
        // $maxWeight = $results[$maxHypothesis];

        // $hypotheses = Hypothesis::all();

        // $results = [];

        // foreach ($hypotheses as $hypothesis) {
        //     $totalWeight = 0;
        //     foreach ($selectedEvidences as $evidenceId) {
        //         $evidence = Evidence::find($evidenceId);

        //         if ($evidence->hypothesis_id == $hypothesis->id) {
        //             $totalWeight += $evidence->weight;
        //         }
        //     }
        //     $results[$hypothesis->name] = $totalWeight;
        //     dd($totalWeight);

        // }

        Diagnosis::create([
            'hypothesis_id' => $bestHypothesisData->id, // Menggunakan ID dari hypothesis terbaik
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'value' => $maxTotalBayes, // Menyimpan nilai Total Bayes tertinggi
            'user_id' => Auth::id() // Simpan ID pengguna yang sedang login

        ]);

        return view('expert_result', compact(
            'results', 
            'bestHypothesis', 
            'maxWeight', 
            // 'evidenceContributions', 
            'probabilityHypothesis', 
            'selectedEvidences', 
            'totalProbabilities',
            'bayesValues',
            'totalBayes',
            'maxTotalBayes' ,
            'bestBayes',
            'bestHypothesisData',// Mengirim data nama dan gambar ke view
            'hypothesesData',
            'selectedEvidencesData',
            'certainty',
            'certaintyDescriptions'

        ));
    }

    private function getCertaintyDescription($value)
        {
            if ($value >= 90 && $value <= 100) {
                return 'Pasti';
            } elseif ($value >= 70 && $value < 90) {
                return 'Hampir pasti';
            } elseif ($value >= 50 && $value < 70) {
                return 'Kemungkinan besar';
            } elseif ($value >= 20 && $value < 50) {
                return 'Kemungkinan Kecil';
            } else {
                return 'Tidak ada';
            }
        }
    //     return view('expert_result', [
    //         'title' => 'Expert Result',
    //         // 'data' => $data_result,
    //         // 'data_name' => $request->name,
    //         // 'data_description' => $request->description,
    //         // 'data_evidence' => $data_evidence_data,
    //         // 'data_diagnosis' => $data_name,
    //         'data_expert_value' => $totalWeight,
    // ]);

        // {
            
            // // Langkah 1: Menerima input evidence dari pengguna
            // $selectedEvidence = $request->input('evidence_id');
    
            // // Langkah 2: Menghitung total bobot evidence
            // $totalWeight = 0;
            // foreach ($selectedEvidence as $evidenceId) {
            //     $evidence = Evidence::find($evidenceId);
            //     $rule = Rule::where('evidence_id', $evidenceId)->first();
            //     if ($rule) {
            //         $totalWeight += $rule->weight;
            //     }
            // }

            // $totalWeight = 0; 
            // foreach ($selectedEvidence as $evidenceId) { 
            //     $evidence = Evidence::find($evidenceId); 
            //     $ruleId = $evidence->id;
            //     $rule = Rule::find($ruleId);
            //     $weight = $rule->weight;
            //     $totalWeight += $weight;
            // } 

            // Langkah 3: Menghitung probabilitas hipotesis
            // $hypothesesProbability = [];
            // $hypotheses = Hypothesis::all();
            // foreach ($hypotheses as $hypothesis) {
            //     $hypothesisProbability = [];
            //     foreach ($selectedEvidence as $evidenceId) {
            //         $evidence = Evidence::find($evidenceId);
            //         $rule = Rule::where('evidence_id', $evidenceId)->first();
            //         $hypothesisProbability[] = $rule->weight / $totalWeight;
            //     }
            //     $hypothesesProbability[$hypothesis->id] = $hypothesisProbability;
            // } 

            // // Langkah 4: Menghitung probabilitas evidence
            // $evidenceProbability = [];
            // foreach ($hypothesesProbability as $hypothesisId => $probabilities) {
            //     $evidenceProbability[$hypothesisId] = array_product($probabilities);
            // }

            // // Langkah 5: Menghitung nilai Bayes
            // $bayesValues = [];
            // foreach ($hypothesesProbability as $hypothesisId => $probabilities) {
            //     $bayesValue = 1;
            //     foreach ($probabilities as $key => $probability) {
            //         $evidence = Evidence::find($selectedEvidence[$key]);
            //         $bayesValue *= $probability * $evidence->weight;
            //     }
            //     $bayesValues[$hypothesisId] = $bayesValue / $evidenceProbability[$hypothesisId];
            // }
    
            // // Langkah 6: Menghitung total nilai Bayes
            // $totalBayes = 0;
            // foreach ($bayesValues as $bayesValue) {
            //     $totalBayes += $bayesValue;
            // }
    
            // // Langkah 7: Menghitung persentase total nilai Bayes
            // $percentage = ($totalBayes / count($bayesValues)) * 100;
    
            // Return response
            // return view('expert_result', [
            //         'title' => 'Expert Result',
            //         // 'data' => $data_result,
            //         // 'data_name' => $request->name,
            //         // 'data_description' => $request->description,
            //         // 'data_evidence' => $data_evidence_data,
            //         // 'data_diagnosis' => $data_name,
            //         'data_expert_value' => $totalWeight,
            // ]);
        

        // $data = array();
        // $tot_hypo_weight = 0;
        // foreach (Hypothesis::orderBy('created_at', 'desc')->get() as $item_hypothesis) {
        //     $tot_evi_weight = $item_hypothesis->weight;
        //     $evidence_data = array();
        //     foreach ($request->evidence_id as $item_ev_id) {
        //         $get_evi_weight = Rule::where('hypothesis_id', $item_hypothesis->id)->where('evidence_id', $item_ev_id)->first();
        //         $tot_evi_weight = $tot_evi_weight * $get_evi_weight->weight;
        //         $evidence_data[] = [
        //             'code' => $get_evi_weight->evidence->code, 
        //             'name' => $get_evi_weight->evidence->name,
        //             'weight' => $get_evi_weight->weight
        //         ];
        //     }
        //     $tot_hypo_weight = $tot_hypo_weight + $tot_evi_weight;
        //     $data[] = [
        //         'id' => $item_hypothesis->id,
        //         'name' => $item_hypothesis->name,
        //         'weight' => $item_hypothesis->weight,
        //         'evidence_data' => $evidence_data,
        //         'tot_evi_weight' => $tot_evi_weight,
        //     ];
        // }
        // $tot_hypo_weight;
        // $data_result = array();
        // foreach ($data as $data_item) {
        //     $data_result[] = [
        //         'id' => $data_item['id'],
        //         'name' => $data_item['name'],
        //         'weight' => $data_item['weight'],
        //         'evidence_data' => $data_item['evidence_data'],
        //         'tot_evi_weight' => $data_item['tot_evi_weight'],
        //         'tot_hypo_weight' => $tot_hypo_weight,
        //         'diagnosis_result' => ($data_item['tot_evi_weight'] / $tot_hypo_weight)
        //     ];
        // }

        // $diagnosis_result = 0;
        // foreach ($data_result as $index => $record) {
        //     if ($record['diagnosis_result'] > $diagnosis_result) {
        //         $data_id =$record['id'];
        //         $data_name =$record['name'];
        //         $data_weight =$record['weight'];
        //         $data_evidence_data =$record['evidence_data'];
        //         $data_tot_evi_weight =$record['tot_evi_weight'];
        //         $data_tot_hypo_weight = $record['tot_hypo_weight'];
        //         $diagnosis_result =$record['diagnosis_result'];
        //     }
        // }

        // $data_result;
        // $columns = array_column($data_result, 'diagnosis_result');
        // array_multisort($columns, SORT_DESC, $data_result);
        
        // Diagnosis::create([
        //     'hypothesis_id' => $data_id,
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'value' => $diagnosis_result,
        // ]);

        // return view('expert_result', [
        //     'title' => 'Expert Result',
        //     'data' => $data_result,
        //     'data_name' => $request->name,
        //     'data_description' => $request->description,
        //     'data_evidence' => $data_evidence_data,
        //     'data_diagnosis' => $data_name,
        //     'data_expert_value' => $diagnosis_result,
        // ]);
    // }

    public function expert_system()
    {
        return view('expert_system', [
            'title' => 'Expert System',
            'evidence' => Evidence::all(),
        ]);
    }

    public function diagnosis()
    {
        return view('diagnosis',[
            'title' => 'History Diagnosis',
            'diagnosis_data' => Diagnosis::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function setting()
    {
        return view('setting.application', [
            'title' => 'Setting',
            'app_title' => Setting::where('component', 'title')->first(),
            'app_description' => Setting::where('component', 'description')->first(),
            'app_evidence' => Setting::where('component', 'evidence')->first(),
            'app_hypothesis' => Setting::where('component', 'hypothesis')->first(),
        ]);
    }

    public function setting_update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'evidence' => 'required',
            'hypothesis' => 'required',
        ]);

        Setting::where('component', 'title')->update(['value' => $request->title]);
        Setting::where('component', 'description')->update(['value' => $request->description]);
        Setting::where('component', 'evidence')->update(['value' => $request->evidence]);
        Setting::where('component', 'hypothesis')->update(['value' => $request->hypothesis]);

        return redirect()->route('setting.index')->with('status','Data created succesfully!');
    }
}
