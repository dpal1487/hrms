<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Industry;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResources;

use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = new Question();

        if (!empty($request->q)) {
            $questions = $questions
                ->whereHas('industry', function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->q%");
                })
                ->orWhere('question_key', 'like', "%$request->q%")
                ->orWhere('text', 'like', "%$request->q%")
                ->orWhere('language', 'like', "%$request->q%");
        }

        // return QuestionResources::collection($questions->paginate(10));
        return Inertia::render('Question/Index', [
            'questions' => QuestionResources::collection($questions->paginate(10)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industries = Industry::get();
        // return $industries;
        return Inertia::render('Question/Form', ['industries' => $industries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'question_key' => 'required',
            'text' => 'required',
            'type' => 'required',
            'industry' => 'required',
            'language' => 'required',
        ]);

        if (
            $question = question::create([
                'question_key' => $request->question_key,
                'text' => $request->text,
                'type' => $request->type,
                'industry_id' => $request->industry,
                'language' => $request->language,
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'question created successfully']);

            return redirect('/question')->with('message', 'Question created successfully');
        }
        return redirect('/question')->with('message', 'Question not created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, $id)
    {
        $industries = Industry::get();

        $question = question::find($id);

        // $question = new questionResources($question);

        return Inertia::render('Question/Form', [
            'question' => new questionResources($question),
            'industries' => $industries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, $id)
    {
        $request->validate([
            'question_key' => 'required',
            'text' => 'required',
            'type' => 'required',
            'industry' => 'required',
            'language' => 'required',
        ]);

        $question = question::find($id);

        if (
            $question = question::where(['id' => $question->id])->update([
                'question_key' => $request->question_key,
                'text' => $request->text,
                'type' => $request->type,
                'industry_id' => $request->industry,
                'language' => $request->language,
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'question created successfully']);

            return redirect('/question')->with('message', 'Question updated successfully');
        }
        return redirect('/question')->with('message', 'Question not updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);

        $question = Question::find($id);
        if ($question->delete()) {
            return response()->json(['success' => true, 'message' => 'Question has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
