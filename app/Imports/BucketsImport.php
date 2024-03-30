<?php

namespace App\Imports;

use App\Models\Bucket;
use Maatwebsite\Excel\Concerns\ToModel;

class BucketsImport implements ToModel
{
  private $keywordsAndCategories = [
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
  ];

  public function model(array $row)
  {
    // Check if the description is available in the CSV row
    if (isset($row[1])) {
      $description = $row[1];
      // Map description to category using the keyword-category mapping
      $category = $this->getCategoryForDescription($description);
      return new Bucket([
        'description' => $description,
        'category' => $category,
      ]);
    }
    return null; // Skip the row if description is not available
  }

  private function getCategoryForDescription($description)
  {
    foreach ($this->keywordsAndCategories as $keyword => $category) {
      if (stripos($description, $keyword) !== false) {
        return $category;
      }
    }
    // If no category found, return 'Other' or handle it as needed
    return 'Other';
  }
}
