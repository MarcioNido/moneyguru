<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Finance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filters = json_decode($request->get('filter'));

        $startDate = new \DateTime($filters->start_date);
        $endDate = new \DateTime($filters->end_date);

        $finances = Finance::with(['category', 'bankAccount'])
            ->where('bank_account_id', $filters->bank_account_id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->orderBy('date')
            ->paginate(10);

        return $finances;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Finance
     */
    public function store(Request $request)
    {
        $request->validate(Finance::$validationRules);

        DB::beginTransaction();

        Balance::updateBalance($request->all());
        $finance = Finance::create($request->all());

        DB::commit();

        return Finance::with(['category', 'bankAccount'])->find($finance->id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Finance  $finance
     * @return Finance
     */
    public function update(Request $request, Finance $finance)
    {

        $request->validate(Finance::$validationRules);


        DB::beginTransaction();

        Balance::reverseBalance($finance);

        $finance->fill($request->all());

        $finance->save();

        Balance::updateBalance($finance);

        DB::commit();

        return Finance::with(['category', 'bankAccount'])->find($finance->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Finance  $finance
     * @return JsonResponse
     */
    public function destroy(Finance $finance)
    {
        if ($finance) {

            DB::beginTransaction();

            Balance::reverseBalance($finance);

            $finance->delete();

            DB::commit();
        }

        return JsonResponse::create(['status' => 'success']);
    }
}
