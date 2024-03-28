<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransactionsImport;

class UploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload-form');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048', // Ensure it's a CSV file and not larger than 2MB
        ]);

        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName); // Store the file in the storage/uploads directory
            
            // Process the uploaded CSV file using Laravel Excel
            Excel::import(new TransactionsImport(), $file);

            return redirect()->route('dashboard')->with('success', 'File uploaded and data processed successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }
}
