<?php

namespace App\Http\Controllers\Web;


use App\Models\ItemStatus;
use App\Http\Resources\Web\ItemStatusesResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemStatusController extends Controller
{
    public function index(Request $request)
    {
        $itemstatuss = new ItemStatus();
        if (!empty($request->q)) {
            $itemstatuss = $itemstatuss->where('label', 'like', "%{$request->q}%")->orWhere('text', 'like', "%{$request->q}%")->orWhere('description', 'like', "%{$request->q}%");
        }
        return Inertia::render('ItemStatus/Index', [
            'itemstatuss' => ItemStatusesResource::collection($itemstatuss->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    public function create()
    {
        return Inertia::render('ItemStatus/Form');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'label' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }

        $ItemStatus = ItemStatus::create([
            'text' => $request->text,
            'label' => $request->label,
            'description' => $request->description,
        ]);
        if ($ItemStatus) {
            return redirect()->route('item-status.index')->with('flash', ['success' => true, 'message' => CreateMessage('Notification Type')]);
        }
        return redirect()->route('item-status.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    public function edit($id)
    {
        return Inertia::render('ItemStatus/Form', [
            'item_status' => new ItemStatusesResource(ItemStatus::find($id))
        ]);
    }

    public function update(Request $request, ItemStatus $itemStatus, $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required',
            'text' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        $ItemStatus = ItemStatus::find($id);
        if ($ItemStatus) {
            $ItemStatus = ItemStatus::where(['id' => $id])->update([
                'label' => $request->label,
                'text' => $request->text,
                'description' => $request->description,
            ]);

            return redirect()->route('item-status.index')->with('flash', ['success' => true, 'message' => CreateMessage('Notification Type')]);
        }
        return redirect()->route('item-status.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    public function destroy($id)
    {
        $ItemStatus = ItemStatus::find($id);
        if ($ItemStatus->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('Notification Type')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
