<?php

namespace App\Http\Controllers;

use App\BankAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return BankAccount::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return BankAccount
     */
    public function store(Request $request)
    {
        $request->validate(BankAccount::$validationRules);

        return BankAccount::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankAccount  $bankAccount
     * @return BankAccount
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate(BankAccount::$validationRules);

        $bankAccount->name = $request->get('name');
        $bankAccount->real = $request->get('real') ? 1 : 0;
        $bankAccount->saveOrFail();
        return $bankAccount;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return JsonResponse
     */
    public function destroy(BankAccount $bankAccount)
    {
        if ($bankAccount) {
            $bankAccount->delete();
        }
        return JsonResponse::create(['status' => 'success']);
    }
}
