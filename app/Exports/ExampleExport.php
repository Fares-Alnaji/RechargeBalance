<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExampleExport implements FromCollection
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        return $this->data;
    }
}
