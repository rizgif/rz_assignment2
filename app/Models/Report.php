<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    public function test($selectedYear)
    {
        // Sample test data for transactions and buckets
        $testData = [
            ['category' => 'Food', 'amount' => 50],
            ['category' => 'Transportation', 'amount' => 30],
            ['category' => 'Utilities', 'amount' => 80],
        ];

        // Transform the test data into objects with "category" and "total_spending" properties
        $formattedData = collect($testData)->map(function ($item) {
            return (object) [
                'category' => $item['category'],
                'total_spending' => $item['amount'],
            ];
        });

        return $formattedData;
    }

    public function getCategorySpending($selectedYear)
    {
      $categorySpending = DB::table('transactions as t')
          ->join('buckets as b', 't.name', 'like', DB::raw("concat('%', b.description, '%')"))
          ->select('b.category', DB::raw('SUM(t.amount) AS total_expense'))
          ->whereRaw("substr(t.date, -4) = '$selectedYear'")
          ->groupBy('b.category')
          ->get();
  
      return $categorySpending;
    }
}
