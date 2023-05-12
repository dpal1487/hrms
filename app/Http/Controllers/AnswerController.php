<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Http\Resources\AnswerResources;
use Inertia\Inertia;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $answers = new Answer();
        if (!empty($request->q)) {
            $answers = $answers
                ->whereHas('question', function ($q) use ($request) {
                    $q->where('question_key', 'like', "%$request->q%");
                })
                ->orWhere('answer', 'like', "%$request->q%");
        }
        return Inertia::render('Answer/Index', [
            'answers' => AnswerResources::collection($answers->paginate(10)),
        ]);
    }

    public function create()
    {
        $questions = Question::get();
        return Inertia::render('Answer/Form', ['questions' => $questions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required',
        ]);


        $answer = Answer::create([
            'question_id' => $request->question,
            'answer' => $request->answer,
            'order_by' => $request->order_by,
        ]);

        if ($answer) {
            return redirect()
                ->route('answer.index')
                ->with('message', 'Answer craeted Successfully');
        }
        return redirect()
            ->route('answer.index')
            ->with('message', 'Answer not created');
    }

    public function edit(Answer $answer)
    {
        $questions = Question::get();

        return Inertia::render('Answer/Form', [
            'answer' => new AnswerResources($answer),
            'questions' => $questions,
        ]);
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required',
        ]);

        $answer = Answer::where(['id' => $answer->id])->update([
            'question_id' => $request->question,
            'answer' => $request->answer,
            'order_by' => $request->order_by,
        ]);
        if ($answer > 0) {
            return redirect()
                ->route('answer.index')
                ->with('message', 'Answer updated Successfully');
        }
        return redirect()
            ->route('answer.index')
            ->with('message', 'Answer not updated');
    }

    public function destroy(Answer $answer)
    {

        if ($answer->delete()) {
            return response()->json(['success' => true, 'message' => 'Answer has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
