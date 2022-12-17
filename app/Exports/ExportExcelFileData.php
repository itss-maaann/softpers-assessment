<?php

namespace App\Exports;

use App\Models\FileColumn;
use App\Models\ExcelFileData;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomQuerySize;

class ExportExcelFileData implements FromCollection, WithHeadings, WithChunkReading, ShouldQueue
{
    use Exportable;
    protected $file;
    public function __construct($file)
    {
        $this->file = $file;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $export_file = DB::table('excel_file_data')
        ->leftJoin('file_columns', 'excel_file_data.column_id', '=', 'file_columns.id')
        ->leftJoin('files', 'file_columns.file_id', '=', 'files.id')
        ->where('file_columns.file_id', $this->file->id)
        ->select('file_columns.column_name','excel_file_data.*')
        ->get('column_id')
        ->groupBy('column_name')
        ->toArray();
        $temp_arr = [];
        foreach($export_file as $column){
            array_push($temp_arr,array_column($column, 'value'));
        }
        foreach($temp_arr as $key => $arr){
            for($i = 0; $i<count($arr); $i++){
            $sortData[$i] = array_column($temp_arr, $i);
            }
        }
        $collection = collect($sortData);
        return $collection;
    }
    public function headings(): array
    {
        $headings = FileColumn::where('file_id', $this->file->id)->pluck('column_name')->toArray();
        return [$headings];
    }
    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
