<?php

namespace App\Http\Controllers\Web;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BrandModel;
use Illuminate\Support\Str;


class BrandModelController extends Controller
{
    public function statusUdate(Request $request)
    {
        if (BrandModel::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Brand Model', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }

        $brandmodel = BrandModel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'brand_id' => $request->brand_id,
        ]);
        if ($brandmodel) {
            return redirect()->route('brand.show', $request->brand_id)->with('flash', ['success' => true, 'message' => CreateMessage('Brand Model')]);
        }
        return redirect()->route('brand.show')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
                400,
            );
        }

        $brandmodel = BrandModel::where(['id' => $request->id])->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'brand_id' => $request->brand_id,
        ]);
        if ($brandmodel) {
            return redirect()->route('brand.show', $request->brand_id)->with('flash', ['success' => true, 'message' => UpdateMessage('Brand Model')]);
        }
        return redirect()->route('brand.show')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brandmodel = BrandModel::find($id);

        if ($brandmodel->delete()) {
            return response()->json(['success' => true, 'message' => 'Brand Model has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
