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
                ->where('status', $status)
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
            UserQuestionStatus::create([
                'user_id' => $userId,
                'question_id' => $question->id,
                'status' => 'know',
            ]);
        } else {
            $status->status = $status->status === 'know' ? 'dont_know' : 'know';
            $status->save();
        }

        return back()->with('success', 'Question status updated.');
    }

    // ---------- TEST MODE ----------

    public function showTestCategories()
    {
        $categories = Category::all();
        return view('test.select_category', compact('categories'));
    }

    public function startTest(Request $request)
    {
        $userId = Auth::id();
        $categoryId = $request->input('category_id');

        session()->forget('viewed_question_ids'); // reset prikazanih pitanja

        $query = Question::with('category')
            ->where(function ($q) use ($userId) {
                $q->whereDoesntHave('userQuestionStatuses', function ($sub) use ($userId) {
                    $sub->where('user_id', $userId);
                })
                    ->orWhereHas('userQuestionStatuses', function ($sub) use ($userId) {
                        $sub->where('user_id', $userId)
                            ->where('status', 'dont_know');
                    });
            });

        if ($categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        $question = $query->first();

        if (!$question) {
            return redirect()->route('dashboard')->with('info', 'No more questions in this category.');
        }

        return view('test.question', compact('question', 'categoryId'));
    }

    public function submitTestAnswer(Request $request)
    {
        $userId = Auth::id();
        $questionId = $request->input('question_id');
        $categoryId = $request->input('category_id');
        $action = $request->input('action');

        // Ako je kliknuo know ili dont_know – upiši status
        if (in_array($action, ['know', 'dont_know'])) {
            UserQuestionStatus::updateOrCreate(
                ['user_id' => $userId, 'question_id' => $questionId],
                ['status' => $action]
            );
        }

        // Zabeleži da je pitanje prikazano
        $viewed = session()->get('viewed_question_ids', []);
        if (!in_array($questionId, $viewed)) {
            $viewed[] = $questionId;
            session()->put('viewed_question_ids', $viewed);
        }

        // Pronađi sledeće pitanje
        $viewed = session()->get('viewed_question_ids', []);

        $query = Question::with('category')
            ->whereNotIn('id', $viewed)
            ->where(function ($q) use ($userId) {
                $q->whereDoesntHave('userQuestionStatuses', function ($sub) use ($userId) {
                    $sub->where('user_id', $userId);
                })
                    ->orWhereHas('userQuestionStatuses', function ($sub) use ($userId) {
                        $sub->where('user_id', $userId)
                            ->where('status', 'dont_know');
                    });
            });

        if ($categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        $nextQuestion = $query->first();

        if (!$nextQuestion) {
            session()->forget('viewed_question_ids');
            return redirect()->route('dashboard')->with('info', 'Test completed for this category.');
        }

        return view('test.question', [
            'question' => $nextQuestion,
            'categoryId' => $categoryId,
        ]);
    }

    public function showCurrentTestQuestion(Request $request)
    {
        $questionId = $request->input('question_id');
        $categoryId = $request->input('category_id');
        $question = Question::with('category')->findOrFail($questionId);

        return view('test.question', [
            'question' => $question,
            'categoryId' => $categoryId,
            'showHint' => true,
        ]);
    }

    public function showHint(Request $request)
    {
        $questionId = $request->input('question_id');
        $categoryId = $request->input('category_id');

        $question = Question::with('category')->findOrFail($questionId);

        return view('test.question', [
            'question' => $question,
            'categoryId' => $categoryId,
            'showHint' => true,
        ]);
    }
}
