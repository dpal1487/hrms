<?php

namespace App\Http\Middleware;

use App\Http\Resources\AddressResource;
use App\Models\CompanyAddress;
use App\Models\CompanyEmail;
use App\Models\CompanyUser;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{

    protected $rootView = 'app';
    protected $company = [];
    protected $email = [];
    protected $address = [];
    protected $status = [
        [
            'name' => 'All',
            'value' => '',
        ],
        [
            'name' => 'Active',
            'value' => '1',
        ],
        [
            'name' => 'Inactive',
            'value' => '0',
        ],
    ];


    public function version(Request $request)
    {
        return parent::version($request);
    }


    public function share(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $this->company = CompanyUser::where(['user_id' => $user->id])->first();
            $this->address = CompanyAddress::where('company_id', $this->company['company']['id'])->first();
            $this->email = CompanyEmail::where('company_id', $this->company['company']['id'])->where('is_primary', 1)->first();
            return array_merge(parent::share($request), [
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy())->toArray(), [
                        'status' => $this->status,
                        'company' => $this->company['company'],
                        'email' => $this->email,
                        'address' => !empty($this->address['address']) ? $this->address['address'] : [],

                        'flash' => [
                            'message' => fn () => $request->session()->get('message'),
                        ],
                    ]);
                },
            ]);
        }
        if ($user != "null") {
            return array_merge(parent::share($request), [
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy())->toArray(), [
                        'status' => $this->status,
                        'flash' => [
                            'message' => fn () => $request->session()->get('message'),
                        ],
                    ]);
                },
            ]);
        }
    }
}
