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

        $hypotheses = Rule::distinct('hypothesis_id')->pluck('hypothesis_id')->toArray();

        $results = [];
        $maxWeight = null;
        $bestHypothesis = null;
        
        // Initialize arrays to prevent errors if they are not populated
        $probabilityHypothesis = [];
        $bayesValues = [];
        $totalBayes = [];

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
            foreach ($probabilityHypothesis as $hypo_id => $probability_H) {
                $totalProbabilities[$hypo_id] = array_sum($probability_H);
            }

            foreach ($selectedEvidences as $evidenceId) {
                 $rule = Rule::where('evidence_id', $evidenceId)
                             ->where('hypothesis_id', $hypothesis)
                             ->first();
                if ($rule && isset($probabilityHypothesis[$hypothesis][$evidenceId]) && isset($totalProbabilities[$hypothesis]) && $totalProbabilities[$hypothesis] > 0) {
                    $bayesValue = ($probabilityHypothesis[$hypothesis][$evidenceId] * $rule->weight) / $totalProbabilities[$hypothesis];
                    $bayesValues[$hypothesis][$evidenceId] = $bayesValue;
                } else {
                    $bayesValues[$hypothesis][$evidenceId] = 0;
                }
            }
            
            if (isset($bayesValues[$hypothesis])) {
                $totalBayes[$hypothesis] = array_sum($bayesValues[$hypothesis]) * 100;
            } else {
                 $totalBayes[$hypothesis] = 0;
            }


            // Check if the current hypothesis has the maximum weight
            if (is_null($maxWeight) || $totalWeight > $maxWeight) {
                $maxWeight = $totalWeight;
                $bestHypothesis = $hypothesis;
            }
        }

        // Find the best hypothesis based on the highest totalBayes score
        $bestBayes = null;
        $maxTotalBayes = 0;
        if (!empty($totalBayes)) {
            $maxTotalBayes = max($totalBayes);
            $bestBayes = array_search($maxTotalBayes, $totalBayes);
        }

        arsort($totalBayes);

        $certaintyDescriptions = [];
        foreach ($totalBayes as $hypothesisId => $bayesValue) {
            $certaintyDescriptions[$hypothesisId] = $this->getCertaintyDescription($bayesValue);
        }

        $bestHypothesisData = Hypothesis::find($bestBayes);
        $hypothesesData = Hypothesis::whereIn('id', array_keys($totalBayes))->get()->keyBy('id');
        $selectedEvidencesData = Evidence::whereIn('id', $selectedEvidences)->get();
        $certainty = $this->getCertaintyDescription($maxTotalBayes);

        if ($bestHypothesisData) {
            Diagnosis::create([
                'hypothesis_id' => $bestHypothesisData->id,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'value' => $maxTotalBayes,
                'user_id' => Auth::id()
            ]);
        }

        return view('expert_result', compact(
            'results', 
            'bestHypothesis', 
            'maxWeight', 
            'probabilityHypothesis', 
            'selectedEvidences', 
            'totalProbabilities',
            'bayesValues',
            'totalBayes',
            'maxTotalBayes',
            'bestBayes',
            'bestHypothesisData',
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