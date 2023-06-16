<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = new Subscription();
        if (!empty($request->q)) {
            $transactions = $transactions
                ->where('name', 'like', "%$request->q")
                ->orWhere('stripe_id', 'like', "%$request->q%")
                ->orWhere('stripe_price', 'like', "%$request->q%")
                ->orWhere('quantity', 'like', "%$request->q%");
        }
        if (!empty($request->status) || $request->status != '') {
            $transactions = $transactions->where('stripe_status', '=', $request->status);
        }
        return Inertia::render('Transaction/Index', [
            'transactions' => TransactionResource::collection($transactions->paginate(10)),
        ]);
    }
}
