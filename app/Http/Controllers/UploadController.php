<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransactionsImport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Imports\BucketsImport; // Import BucketsImport


class UploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload-form');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_files.*' => 'required|file|mimes:csv,txt|max:2048', // Ensure it's a CSV file and not larger than 2MB
        ]);

        if ($request->hasFile('csv_files')) {
            $successFiles = [];
            $errorFiles = [];

            foreach ($request->file('csv_files') as $file) {
                // Generate a unique file name with a random string appended
                $fileName = time() . '_' . Str::random(8) . '_' . $file->getClientOriginalName();
                
                // Store the file in the storage/uploads directory with the generated file name
                $file->storeAs('uploads', $fileName); 
                
                // Process the uploaded CSV file using Laravel Excel
                try {
                    Excel::import(new TransactionsImport(), $file);
                    Excel::import(new BucketsImport(), $file); // Import BucketsImport
                    $successFiles[] = $file->getClientOriginalName();
                } catch (\Exception $e) {
                    $errorFiles[] = $file->getClientOriginalName();
                }

                // Rename the file with ".imported" extension
                $newFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.imported.' . pathinfo($fileName, PATHINFO_EXTENSION);
                Storage::move("uploads/{$fileName}", "uploads/{$newFileName}");
            }

            // Prepare success and error messages
            $successMessage = count($successFiles) > 0 ? 'Files uploaded and data processed successfully: ' . implode(', ', $successFiles) : '';
            $errorMessage = count($errorFiles) > 0 ? 'Error uploading files: ' . implode(', ', $errorFiles) : '';

            // Combine messages with line breaks if both are present
            $message = $successMessage . ($successMessage && $errorMessage ? '<br>' : '') . $errorMessage;

            return redirect()->route('dashboard')->with('message', $message);
        }

        return redirect()->back()->with('error', 'No files uploaded.');
    }
}
