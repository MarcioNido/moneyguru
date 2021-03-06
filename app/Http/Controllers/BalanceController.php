<?php

namespace App\Http\Controllers;

use App\Balance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
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

        $date = new \DateTime($filters->date);

        $balance = Balance::where('bank_account_id', $filters->bank_account_id)
            ->where('date', '<=', $date)
            ->orderBy('date', 'desc')
            ->limit(1)
            ->get();

        return count($balance) > 0 ? $balance : JsonResponse::create(['status' => 'no balance'], 404);
    }


    public function reCalc(Request $request)
    {
        $bank_account_id = $request->get('bank_account_id');

        DB::delete('DELETE FROM balances WHERE bank_account_id = ?', [
            $bank_account_id
        ]);

        $finances = DB::select('SELECT * FROM finances WHERE bank_account_id = ? AND deleted_at IS NULL ORDER BY date', [
            $bank_account_id
        ]);


        if ($finances) {

            $date = null;
            $balance = 0;

            foreach($finances as $finance) {

                if ($date && $date !== $finance->date) {
                    DB::insert('INSERT INTO balances (bank_account_id, date, balance) VALUES (?,?,?)', [
                        $bank_account_id,
                        $date,
                        $balance
                    ]);
                }

                $date = $finance->date;

                $balance += $finance->dc == 'C' ? $finance->amount : $finance->amount * -1;

            }

            DB::insert('INSERT INTO balances (bank_account_id, date, balance) VALUES (?,?,?)', [
                $bank_account_id,
                $date,
                $balance
            ]);


        }

        return JsonResponse::create(['status' => 'success']);

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function show(Balance $balance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function edit(Balance $balance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Balance $balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Balance $balance)
    {
        //
    }
}
