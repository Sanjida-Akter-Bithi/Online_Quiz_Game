<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Models\Category;

class QuizController extends Controller
{
    // Show paginated, filterable list of quizzes
    public function index(Request $request)
    {
        $query = Quiz::with('category');
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $quizzes = $query->paginate(10)->appends($request->except('page'));
        $categories = Category::all();
        return view('quizzes.index', compact('quizzes', 'categories'));
    }

    // Show the create quiz form
    public function create()
    {
        return view('quizzes.create');
    }

    // Store a newly created quiz with category and questions/options
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_name' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
            'questions' => 'required|array|size:5',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|size:4',
            'questions.*.options.*.option_text' => 'required|string',
            'questions.*.correct_option' => 'required|integer|between:0,4',
        ]);

        $category = Category::firstOrCreate(['name' => $request->category_name]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $category->id,
            'difficulty' => $request->difficulty,
        ]);

        foreach ($request->questions as $i => $qData) {
            $question = $quiz->questions()->create([
                'question_text' => $qData['question_text'],
            ]);
            foreach ($qData['options'] as $j => $optData) {
                $is_correct = ((string)$qData['correct_option'] === (string)$j);
                $question->options()->create([
                    'option_text' => $optData['option_text'],
                    'is_correct' => $is_correct,
                ]);
            }
        }

        return redirect()->route('quizzes.index')->with('success', 'Quiz and questions created successfully!');
    }

    // === THIS IS THE IMPORTANT METHOD for showing quiz details ===
    public function show(Quiz $quiz)
    {
        // Loads the quiz with *all* of its questions and each question's options and category
        $quiz->load('questions.options', 'category');
        return view('quizzes.show', compact('quiz'));
    }

    // Show the form for editing a quiz (with questions & options loaded)
    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.options', 'category');
        return view('quizzes.edit', compact('quiz'));
    }

    // Update quiz and all related questions/options
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_name' => 'required|string|max:255',
            'difficulty' => 'required|in:easy,medium,hard',
            // Could add more validation for editing questions/options if needed
        ]);

        $category = Category::firstOrCreate(['name' => $request->category_name]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $category->id,
            'difficulty' => $request->difficulty,
        ]);

        // --- Update questions and options ---
        if ($request->has('questions')) {
            foreach($request->questions as $qid => $qData) {
                $question = $quiz->questions()->find($qid);
                if ($question) {
                    $question->update([
                        'question_text' => $qData['question_text'],
                    ]);
                    // Update all options for this question (force save)
                    if (isset($qData['options'])) {
                        foreach ($qData['options'] as $oid => $opData) {
                            $option = $question->options()->find($oid);
                            if ($option) {
                                $option->option_text = $opData['option_text'];
                                $option->is_correct =
                                    (isset($qData['correct_option']) && (string)$qData['correct_option'] === (string)$oid)
                                    ? 1 : 0;
                                $option->save();
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('quizzes.edit', $quiz)->with('success', 'Quiz updated successfully.');
    }

    // Delete a quiz and all its questions/options
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
