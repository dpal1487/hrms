<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\AnswerResources;
use Illuminate\Support\Facades\Validator;

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
            'answers' => AnswerResources::collection($answers->paginate(10)->appends($request->all())),
        ]);
    }

    public function create()
    {
        $questions = Question::get();
        return Inertia::render('Answer/Form', ['questions' => $questions]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }

        $answer = Answer::create([
            'question_id' => $request->question,
            'answer' => $request->answer,
            'order_by' => $request->order_by,
        ]);
        if ($answer) {
            return response()->json(['success' => true, 'message' => 'Answer created successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Answer not created']);
        }
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
        $validator = Validator::make($request->all(), [

            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }

        $answer = Answer::where(['id' => $answer->id])->update([
            'question_id' => $request->question,
            'answer' => $request->answer,
            'order_by' => $request->order_by,
        ]);
        if ($answer) {
            return response()->json(['success' => true, 'message' => 'Answer updated successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Answer not updated']);
        }
    }

    public function destroy(Answer $answer)
    {

        if ($answer->delete()) {
            return response()->json(['success' => true, 'message' => 'Answer has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $answer = Answer::whereIn('id', $request->ids)->delete();

        if ($answer) {
            return response()->json(['success' => true, 'message' => 'Answer has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
