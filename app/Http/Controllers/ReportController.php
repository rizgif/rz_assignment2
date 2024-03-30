<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Transaction;


class ReportController extends Controller
{
  //
  public function index()
  {
    // Get distinct years from transactions
    $dates = Transaction::select('date')->distinct()->pluck('date');

    $years = $dates->map(function ($date) {
      return explode('/', $date)[2]; // Extract the year from the date
    })->unique(); // Get unique years

    return view('reports', compact('years'));
  }

  // public function show(Request $request)
  // {
  //     $year = $request->input('year');

  //     // Get category-wise spending for the selected year
  //     $report = new Report();
  //     $categorySpending = $report->getCategorySpending($year);

  //     return view('reports.show', compact('year', 'categorySpending'));
  // }

  public function generate(Request $request)
  {
    $year = $request->input('year');

    // Get category-wise spending for the selected year
    $report = new Report();
    $categorySpending = $report->getCategorySpending($year);

    // Prepare data for CanvasJS
    $chartData = [];
    foreach ($categorySpending as $category) {
        $chartData[] = [
            "label" => $category->category,
            "y" => $category->total_expense
        ];
    }


    return view('reports.show', compact('year', 'categorySpending', 'chartData'));
  }
}
