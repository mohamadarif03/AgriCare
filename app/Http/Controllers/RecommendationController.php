<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Models\RecommendationChecklist;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    protected RecommendationService $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index(Request $request)
    {
        $userId = auth()->id();
        $lahans = Lahan::where('user_id', $userId)->where('is_aktif', true)->orderByDesc('created_at')->get();

        $selectedLahanId = $request->query('lahan');
        $selectedLahan = null;

        if ($selectedLahanId) {
            $selectedLahan = $lahans->firstWhere('id', $selectedLahanId);
        }

        if (!$selectedLahan && $lahans->isNotEmpty()) {
            $selectedLahan = $lahans->first();
        }

        $recommendation = null;
        if ($selectedLahan) {
            // Check if valid cache exists
            $recommendation = \App\Models\Recommendation::where('lahan_id', $selectedLahan->id)
                ->where('user_id', $userId)
                ->where('is_archived', false)
                ->where('generated_at', '>=', now()->subHours(24))
                ->with('checklists')
                ->first();
        }

        return view('pages.ai_reccomendation', compact('lahans', 'selectedLahan', 'recommendation'));
    }

    public function getData(Request $request)
    {
        $lahanId = $request->query('lahan_id');
        if (!$lahanId) {
            return response()->json(['success' => false, 'message' => 'Lahan ID required'], 400);
        }

        try {
            $recommendation = $this->recommendationService->getRecommendation(auth()->id(), $lahanId);
            return response()->json(['success' => true, 'data' => $recommendation]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function refreshRecommendation(Request $request)
    {
        $lahanId = $request->input('lahan_id');
        if (!$lahanId) {
            return response()->json(['success' => false, 'message' => 'Lahan ID required'], 400);
        }

        try {
            $recommendation = $this->recommendationService->getRecommendation(auth()->id(), $lahanId, true);
            return response()->json(['success' => true, 'data' => $recommendation]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function toggleChecklist(Request $request)
    {
        $checklistId = $request->input('checklist_id');
        $isChecked = $request->input('is_checked');

        $checklist = RecommendationChecklist::whereHas('recommendation', function ($q) {
            $q->where('user_id', auth()->id());
        })->find($checklistId);

        if (!$checklist) {
            return response()->json(['success' => false, 'message' => 'Checklist not found'], 404);
        }

        $checklist->is_checked = filter_var($isChecked, FILTER_VALIDATE_BOOLEAN);
        $checklist->checked_at = $checklist->is_checked ? now() : null;
        $checklist->save();

        return response()->json(['success' => true]);
    }
}
