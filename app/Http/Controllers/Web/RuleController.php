<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\Web\RuleResource;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rules = new Rule();
        if (!empty($request->q)) {
            $rules = $rules->where('rule', 'like', "%{$request->q}%")->orWhere('value', 'like', "%{$request->q}%")->orWhere('message', 'like', "%{$request->q}%");
        }
        return Inertia::render('Rules/Index', [
            'rules' => RuleResource::collection($rules->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Rules/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rule' => 'required',
            'value' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        $rule = Rule::create([
            'rule' => $request->rule,
            'value' => $request->value,
            'message' => $request->message,
        ]);
        if ($rule) {
            return redirect()->route('rules.index')->with('flash', ['success' => true, 'message' => CreateMessage('Rule')]);
        }
        return redirect()->route('rules.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Rules/Form', [
            'rule' => new RuleResource(Rule::find($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'rule' => 'required',
            'value' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }

        $rule = Rule::find($id);

        if ($rule) {
            $rule = Rule::where(['id' => $id])->update([
                'rule' => $request->rule,
                'value' => $request->value,
                'message' => $request->message,
            ]);
            return redirect()->route('rules.index')->with('flash', ['success' => true, 'message' => UpdateMessage('Rule')]);
        }
        return redirect()->back()->withErrors(['success' => false, 'message' => "sdasd" . ErrorMessage()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rule = Rule::find($id);
        if ($rule->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('Rule')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
