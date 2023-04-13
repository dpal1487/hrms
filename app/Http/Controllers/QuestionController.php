<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResources;

use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = Question::get();
        // $question = new Question();

        // if (!empty($request->q)) {
        //     $question = $questions
        //         ->whereHas('industry', function ($q) use ($request) {
        //             $q->where('name', 'like', "%$request->q%");
        //         })
        //         ->orWhere('question_key', 'like', "%$request->q%")
        //         ->orWhere('text', 'like', "%$request->q%")
        //         ->orWhere('language', 'like', "%$request->q%")
        //         ->orWhere('type', 'like', "%$request->q%");
        // }

        // return QuestionResources::collection($question);
        return Inertia::render('Question/Index', [
            'questions' => QuestionResources::collection($question),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Question/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_joining' => 'required',
            'number' => 'required|numeric',
            'qualification' => 'required',
            'emergency_number' => 'required|integer',
            'pan_number' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}/',
            'father_name' => 'required',
            'formalities' => 'required|integer',
            'salary' => 'required',
            'offer_acceptance' => 'required|integer',
            'probation_period' => 'required',
            'date_of_confirmation' => 'required',
            'department_id' => 'required',
        ]);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        if (
            $question = question::create([
                'code' => 'ABC123',
                'date_of_joining' => $request->date_of_joining,
                'number' => $request->number,
                'qualification' => $request->qualification,
                'emergency_number' => $request->emergency_number,
                'pan_number' => $request->pan_number,
                'father_name' => $request->father_name,
                'formalities' => $request->formalities,
                'salary' => $request->salary,
                'offer_acceptance' => $request->offer_acceptance,
                'probation_period' => $request->probation_period,
                'date_of_confirmation' => $request->date_of_confirmation,
                'notice_period' => $request->notice_period,
                'last_working_day' => $request->last_working_day,
                'full_final' => $request->full_final,
                'department_id' => $request->department_id,
                'user_id' => $user->id,
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'question created successfully']);

            return redirect('/question');
        }
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
    public function edit(Question $question)
    {
        $question = question::find($id);

        // $question = new questionResources($question);

        return Inertia::render('question/Form', [
            'question' => new questionResources($question),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_joining' => 'required',
            'number' => 'required|numeric',
            'qualification' => 'required',
            'emergency_number' => 'required|integer',
            'pan_number' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}/',
            'father_name' => 'required',
            'formalities' => 'required|integer',
            'salary' => 'required',
            'offer_acceptance' => 'required|integer',
            'probation_period' => 'required',
            'date_of_confirmation' => 'required',
            'department_id' => 'required',
        ]);

        $question = question::find($id);

        $question = new questionResources($question);

        $user = User::where(['id' => $question->user->id])->get();

        $user = User::where(['id' => $question->user->id])->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        if (
            $question = question::where(['id' => $question->id])->update([
                'code' => 'ABC123',
                'date_of_joining' => $request->date_of_joining,
                'number' => $request->number,
                'qualification' => $request->qualification,
                'emergency_number' => $request->emergency_number,
                'pan_number' => $request->pan_number,
                'father_name' => $request->father_name,
                'formalities' => $request->formalities,
                'salary' => $request->salary,
                'offer_acceptance' => $request->offer_acceptance,
                'probation_period' => $request->probation_period,
                'date_of_confirmation' => $request->date_of_confirmation,
                'department_id' => $request->department_id,
                'user_id' => $question->user->id,
            ])
        ) {
            // return response()->json(['success'=>true,'message'=>'question Updated successfully']);

            return redirect('/question');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question = Question::find($id);
        if ($question->delete()) {
            return response()->json(['success' => true, 'message' => 'Question has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
