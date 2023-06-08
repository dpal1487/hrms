<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'faq_cat_title' => 'required',
            'status' => 'required',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors(['message' => $validate->errors()->first()]);
        }
        $faqCategory  = FaqCategory::create([
            'title' => $request->faq_cat_title,
            'status' => $request->status
        ]);

        if ($faqCategory) {
            foreach ($request->items as $value) {
                $faq = Faq::create([
                    'category_id' => $faqCategory->id,
                    'title' => $value['faq_title'],
                    'artical' => $value['faq_artical'],
                ]);
            }
        }
        if ($faq) {
            return redirect("/support/faq")->with('flash', ['message' => 'FAQ Successfully created.']);
        }
        return redirect()->back()->withErrors(['message' => "Opps something went wrong"]);
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
