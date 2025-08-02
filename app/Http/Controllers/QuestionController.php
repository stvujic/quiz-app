<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\UserQuestionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class QuestionController extends Controller
{
    public function indexByStatus($status)
    {
        $userId = Auth::id();

        if (!in_array($status, ['all', 'know', 'dont_know'])) {
            abort(404);
        }

        if ($status === 'all') {
            $questions = Question::with('category', 'userQuestionStatuses')->get();
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
            'text' => 'required|string|max:5000',
            'answer' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
        ]);

        Question::create($validated);

        return redirect()->route('questions.status', 'all')->with('success', 'Question added successfully.');
    }

    public function edit(Question $question)
    {
        $categories = Category::all();
        return view('questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:5000',
            'answer' => 'required|string|max:10000',
            'category_id' => 'required|exists:categories,id',
        ]);

        $question->update($validated);

        return redirect()->route('questions.status', 'all')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.status', 'all')->with('success', 'Question deleted successfully.');
    }

    public function toggleStatus(Question $question)
    {
        $userId = Auth::id();

        $status = UserQuestionStatus::where('user_id', $userId)
            ->where('question_id', $question->id)
            ->first();

        if (!$status) {
            // Ako ne postoji, dodaj kao 'next' (I Know)
            UserQuestionStatus::create([
                'user_id' => $userId,
                'question_id' => $question->id,
                'status' => 'next',
            ]);
        } else {
            // Inače obrni status
            $status->status = $status->status === 'next' ? 'hint' : 'next';
            $status->save();
        }

        return back()->with('success', 'Question status updated.');
    }

}
