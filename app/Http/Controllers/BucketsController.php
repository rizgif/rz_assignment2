<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class BucketsController extends Controller
{
  /**
   * Parse and insert CSV data into the buckets table.
   */
  public function parseAndInsertCSV($csvFile)
  {
    // Keyword-category mapping
    $keywordsAndCategories = [
      'ST JAMES RESTAURAT' => 'Entertainment',
      'RED CROSS' => 'Donations',
      'GATEWAY' => 'Communication',
      'SAFEWAY' => 'Groceries',
      'Subway' => 'Entertainment',
      'PUR & SIMPLE RESTAUR' => 'Entertainment',
      'REAL CDN SUPERS' => 'Groceries',
      'ICBC' => 'Car Insurance',
      'FORTISBC' => 'Gas Heating',
      'BMO' => 'Other',
      'WALMART' => 'Groceries',
      'COSTCO' => 'Groceries',
      'MCDONALDS' => 'Entertainment',
      'WHITE SPOT RESTAURAN' => 'Entertainment',
      'SHAW CABLE' => 'Utilities',
      'CANADIAN TIRE' => 'Other',
      'World Vision' => 'Donations',
      '7-ELEVEN' => 'Other',
      'TIM HORTONS' => 'Entertainment',
      'ROGERS MOBILE' => 'Communication',
      'O.D.P. FEE' => 'Other',
      'MONTHLY ACCOUNT FEE' => 'Other'
      // Add more keywords and corresponding categories as needed
    ];

    // Open the CSV file
    if (($handle = fopen($csvFile, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Extract description from CSV data
        $description = $data[1];
        // Map description to category using the keyword-category mapping
        $category = $this->getCategoryForDescription($description, $keywordsAndCategories);
        // Insert into the buckets table
        Bucket::create([
          'category' => $category,
          'description' => $description
        ]);
      }
      fclose($handle);
    }
  }

  /**
   * Determine category for a description based on keywords.
   */
  private function getCategoryForDescription($description, $keywordsAndCategories)
  {
    foreach ($keywordsAndCategories as $keyword => $category) {
      if (stripos($description, $keyword) !== false) {
        return $category;
      }
    }
    // If no category found, return 'Other' or handle it as needed
    return 'Other';
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // $buckets = Bucket::all();
    // return view('buckets-data', compact('buckets'));
    // If bucket is empty, insert sample bucket data
    if (Bucket::count() === 0) {
      // $this->parseAndInsertCSV(storage_path('app/csv/2023 02.csv'));
    }
    $buckets = Bucket::all();
    return view('buckets-data', compact('buckets'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    request()->validate([
      'category' => 'required',
      'description' => 'required',
    ]);

    return Bucket::create([
      'category' => request('category'),
      'description' => request('description'),
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Bucket $bucket)
  {
    return $bucket;
  }

  public function edit($id)
  {
    $bucket = Bucket::findOrFail($id);
    return view('buckets-edit', compact('bucket'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'category' => 'required',
      'description' => 'required',
    ]);

    $bucket = Bucket::findOrFail($id);
    $bucket->category = $request->category;
    $bucket->description = $request->description;
    $bucket->save();

    return redirect()->route('buckets-data')->with('success', 'Bucket updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Bucket $bucket)
  {
    try {
      $deletedBucketName = $bucket->category; // Assuming 'name' is the attribute representing the name of the bucket
      $isSuccess = $bucket->delete();

      if ($isSuccess) {
        Session::flash('success', 'Bucket "' . $deletedBucketName . '" (ID: ' . $bucket->id . ') deleted successfully.');
      } else {
        Session::flash('error', 'Failed to delete bucket "' . $deletedBucketName . '" (ID: ' . $bucket->id . ').');
      }

      return redirect()->back();
    } catch (\Exception $e) {
      Session::flash('error', 'Failed to delete bucket: ' . $e->getMessage());
      return redirect()->back();
    }
  }
}
