<?php

namespace App\Http\Controllers;

use App\Exports\ExampleExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Transaction;



class ExportController extends Controller
{
    //
    public function export(Request $request)
    {
        $filterType = $request->input('filterType');
        $filterAmount = $request->input('filterAmount');

        $query = Transaction::query();
        if ($filterType === 'greater') {
            $query->where('amount', '>', $filterAmount);
        } elseif ($filterType === 'smaller') {
            $query->where('amount', '<', $filterAmount);
        } elseif ($filterType === 'equal') {
            $query->where('amount', '=', $filterAmount);
        }

        // احصل على البيانات المصفاة
        $filteredData = $query->get();

        // قم بتصدير البيانات المصفاة إلى ملف Excel
        return Excel::download(new ExampleExport($filteredData), 'exported_data.xlsx');
    }
}
