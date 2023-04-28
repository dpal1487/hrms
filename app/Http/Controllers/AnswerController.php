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

        if (
            $Answer = Answer::create([
                'question_id' => $request->question,
                'answer' => $request->answer,
                'order_by' => $request->order_by,
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'Answer created successfully']);

            return redirect('/answer');
        }
    }

    public function edit($id)
    {
        $questions = Question::get();

        $answer = Answer::find($id);

        return Inertia::render('Answer/Form', [
            'answer' => new AnswerResources($answer),
            'questions' => $questions,
        ]);
    }

    public function update(Request $request, Answer $answer, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required',
        ]);

        $answer = Answer::find($id);

        if (
            $answer = Answer::where(['id' => $answer->id])->update([
                'question_id' => $request->question,
                'answer' => $request->answer,
                'order_by' => $request->order_by,
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'Answer created successfully']);
            return response()->json([
                'success' => true,
                'message' => 'Employee Address Updated successfully',
                'redirect' => '/address',
            ]);

            // return redirect('/answer');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong !',
                'redirect' => '/address',
            ]);
        }
    }

    public function destroy($id)
    {
        // dd($id);

        $answer = Answer::find($id);
        if ($answer->delete()) {
            return response()->json(['success' => true, 'message' => 'Answer has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
