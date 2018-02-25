<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Finance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;

class ChartController extends Controller
{

    const REAL_X_DOLLAR = 2.80;

    /**
     * Revenue X Expenses Comparison Chart
     * @return JsonResponse
     */
    public function revExp()
    {

        $months = $this->getMonths();

        $labels = [];
        $rev = [];
        $exp = [];

        foreach($months as $month) {
            $labels[] = $month['label'];
            $rev[] = $this->getMonthRevenue($month);
            $exp[] = $this->getMonthExpenses($month);
        }

        return JsonResponse::create([
            'labels' => $labels,
            'rev' => $rev,
            'exp' => $exp,
        ]);
    }

    /**
     * Expenses per Category Chart
     * @return JsonResponse
     */
    public function expCategory()
    {
        $expenses = $this->getExpensesPerCategory();

        return JsonResponse::create($expenses);
    }


    /**
     * Revenue per Category Chart
     * @return JsonResponse
     */
    public function revCategory()
    {
        $revenue = $this->getRevenuePerCategory();

        return JsonResponse::create($revenue);
    }


    /**
     * Patrimony Chart
     * @return JsonResponse
     */
    public function patrimony()
    {

        $months = $this->getMonths();

        $labels = [];
        $values = [];

        foreach($months as $month) {
            $labels[] = $month['label'];
            $values[] = $this->getMonthPatrimony($month);
        }

        return JsonResponse::create([
            'labels' => $labels,
            'values' => $values,
        ]);

    }


    protected function getMonths()
    {
        $olderDateFromDatabase = Finance::orderBy('date')->limit(1)->first()->date;
        $olderDateFromDatabase->day = 1;

        $lastMonth = Carbon::now();
        $lastMonth->day = 1;

        $twelveMonthsBefore = Carbon::now();
        $twelveMonthsBefore->subMonths(12);
        $twelveMonthsBefore->day = 1;


        $month = ($olderDateFromDatabase < $twelveMonthsBefore ? $twelveMonthsBefore : $olderDateFromDatabase);

        $months = [];

        $test = [];

        while ($month <= $lastMonth) {

            $test[] = 'one';

            $startDate = new Carbon($month);

            $endDate = new Carbon($month);
            $endDate->modify('last day of this month');
            $endDate->hour   = 23;
            $endDate->minute = 59;
            $endDate->second = 59;

            $months[] = [
                'label' => $month->format('M/y'),
                'startDate' => $startDate,
                'endDate' => $endDate,
            ];

            $month->month = $month->month + 1;
            $month->day = 1;
            $month->hour = 0;
            $month->minute = 0;
            $month->second = 0;

        }

        return $months;

    }

    protected function getMonthRevenue($month)
    {

        $total = DB::select('
            SELECT SUM(amount / IF(b.real = 1, ' . self::REAL_X_DOLLAR . ', 1)) amount 
            FROM finances f
            JOIN categories c ON f.category_id = c.id
            JOIN bank_accounts b ON f.bank_account_id = b.id
            WHERE c.level1 = 1 
              AND f.dc = "C"
              AND f.date >= ?
              AND f.date <= ?
              AND f.deleted_at IS NULL
       ', [
            $month['startDate'],
            $month['endDate']
        ]);

        return $total[0]->amount ? round($total[0]->amount) : 0;

    }

    protected function getMonthExpenses($month)
    {

        $total = DB::select('
            SELECT SUM(amount / IF(b.real = 1, ' . self::REAL_X_DOLLAR . ', 1)) amount 
            FROM finances f
            JOIN categories c ON f.category_id = c.id
            JOIN bank_accounts b ON f.bank_account_id = b.id
            WHERE c.level1 IN (2,4,5) 
              AND f.dc = "D"
              AND f.date >= ?
              AND f.date <= ?
              AND f.deleted_at IS NULL
       ', [
            $month['startDate'],
            $month['endDate']
        ]);

        return $total[0]->amount ? round($total[0]->amount) : 0;

    }

    /**
     * Get the expenses per category from last month
     */
    protected function getExpensesPerCategory()
    {

        $startDate = new Carbon();
        //$startDate->subMonth();
        $startDate->day = 1;
        $startDate->hour = $startDate->minute = $startDate->second = 0;

        $endDate = new Carbon();
        //$endDate->subMonth();
        $endDate->modify('last day of this month');
        $endDate->hour = 23;
        $endDate->minute = $endDate->second = 59;

        $finances = DB::select('
            SELECT c.name, SUM(amount / IF(b.real = 1, ' . self::REAL_X_DOLLAR . ', 1)) amount
            FROM finances f
            JOIN categories c ON f.category_id = c.id
            JOIN bank_accounts b ON f.bank_account_id = b.id
            WHERE f.date >= ?
              AND f.date <= ?
              AND f.deleted_at IS NULL 
              AND c.level1 IN (2,4,5)
              AND f.dc = "D"
            GROUP BY c.name
        ', [
            $startDate,
            $endDate
        ]);

        $labels = [];
        $values = [];
        foreach($finances as $finance) {
            $labels[] = $finance->name;
            $values[] = round($finance->amount);
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    /**
     * Get the revenue per category from last month
     */
    protected function getRevenuePerCategory()
    {

        $startDate = new Carbon();
        //$startDate->subMonth();
        $startDate->day = 1;
        $startDate->hour = $startDate->minute = $startDate->second = 0;

        $endDate = new Carbon();
        //$endDate->subMonth();
        $endDate->modify('last day of this month');
        $endDate->hour = 23;
        $endDate->minute = $endDate->second = 59;

        $finances = DB::select('
            SELECT c.name, SUM(amount / IF(b.real = 1, ' . self::REAL_X_DOLLAR . ', 1)) amount
            FROM finances f
            JOIN categories c ON f.category_id = c.id
            JOIN bank_accounts b ON f.bank_account_id = b.id
            WHERE f.date >= ?
              AND f.date <= ?
              AND f.deleted_at IS NULL 
              AND c.level1 IN (1)
              AND f.dc = "C"
            GROUP BY c.name
        ', [
            $startDate,
            $endDate
        ]);

        $labels = [];
        $values = [];
        foreach($finances as $finance) {
            $labels[] = $finance->name;
            $values[] = round($finance->amount);
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }


    /**
     * Get the total patrimony per month
     * @param array $month
     * @return float $amount
     */
    protected function getMonthPatrimony($month)
    {
        $accounts = BankAccount::all();
        $totalBalance = 0;

        foreach($accounts as $account) {
            $lastBalance = DB::select('
                SELECT (balance / IF(b.real = 1, ' . self::REAL_X_DOLLAR . ', 1)) balance 
                FROM balances bal
                JOIN bank_accounts b ON bal.bank_account_id = b.id
                WHERE bal.bank_account_ID = ' . $account->id . '
                  AND bal.date <= ?
                ORDER BY date DESC 
                LIMIT 1 
           ', [
                $month['endDate']
            ]);

            if (isset($lastBalance[0]->balance)) {
                $totalBalance += $lastBalance[0] ? round($lastBalance[0]->balance) : 0;
            }

        }

        return $totalBalance;

    }


}
