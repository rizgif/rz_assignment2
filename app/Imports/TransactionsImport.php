<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;

class TransactionsImport implements ToModel
{
    public function model(array $row)
    {
        // Check if the amount is available in the CSV row
        if (isset($row[2])) {
            return new Transaction([
                'date' => $row[0],
                'name' => $row[1],
                'amount' => $row[2],

            ]);
        } else {
            // If amount is not available, insert a default value (e.g., 0)
            return new Transaction([
                'date' => $row[0],
                'name' => $row[1],
                'amount' => 0, // Insert default value

            ]);
        }
    }
}
