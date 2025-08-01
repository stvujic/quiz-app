<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Category;
use App\Models\UserQuestionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ukupno pitanja
        $totalQuestions = Question::count();
        $knownQuestions = UserQuestionStatus::where('user_id', $userId)
            ->where('status', 'next')
            ->count();

        // Procenat ukupno
        $overallPercentage = $totalQuestions > 0
            ? round(($knownQuestions / $totalQuestions) * 100)
            : 0;

        // Dinamičko čitanje svih kategorija iz baze
        $categories = Category::pluck('name')->toArray();
        $categoryProgress = [];

        foreach ($categories as $categoryName) {
            $categoryQuestions = Question::whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            })->get();

            $total = $categoryQuestions->count();

            $known = $categoryQuestions->filter(function ($question) use ($userId) {
                return $question->userStatuses->where('user_id', $userId)
                    ->where('status', 'next')
                    ->isNotEmpty();
            })->count();

            $percentage = $total > 0 ? round(($known / $total) * 100) : 0;

            $categoryProgress[$categoryName] = [
                'known' => $known,
                'total' => $total,
                'percentage' => $percentage,
            ];
        }

        return view('dashboard', compact(
            'totalQuestions',
            'knownQuestions',
            'overallPercentage',
            'categoryProgress'
        ));
    }
}
