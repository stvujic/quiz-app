<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\UserQuestionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function indexByStatus($status)
    {
        $userId = Auth::id();

        if (!in_array($status, ['all', 'know', 'dont_know'])) {
            abort(404);
        }

        if ($status === 'all') {
            $questions = Question::with('category')->get();
        } else {
            $userStatuses = UserQuestionStatus::where('user_id', $userId)
                ->where('status', $status === 'know' ? 'next' : 'hint')
                ->pluck('question_id');

            $questions = Question::whereIn('id', $userStatuses)->with('category')->get();
        }

        return view('questions.index', compact('questions', 'status'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Question::create($validated);

        return redirect()->route('questions.status', 'all')->with('success', 'Question added successfully.');
    }
}
