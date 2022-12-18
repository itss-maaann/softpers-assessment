<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileColumn;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Exports\ExportExcelFileData;
use App\Imports\ImportExcelFileData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\HeadingRowImport;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.index', ['files' => File::all()]);
    }

    public function importView()
    {
        return view('pages.importFile');
    }

    public function import(ExcelRequest $request)
    {
        $file = File::create([
            'name' => request()->file('file')->getClientOriginalName(),
        ]);
        $headings = (new HeadingRowImport)->toArray($request->file)[0][0];
        $filteredHeadings = array_filter($headings, 'is_string');
        foreach ($filteredHeadings as $heading) {
            FileColumn::create([
                'file_id' => $file->id,
                'column_name' => ucfirst(str_replace('_', ' ', $heading)),
            ]);
        }
        Excel::import(new ImportExcelFileData, $request->file);
        Cache::pull('columns');
        return redirect()->back()->with('success', 'Import has been started...!!');
    }

    public function viewFile(File $file){
        $data['file_name'] = $file->name;
        $data['headings'] = $file->columns->toArray();
        $data['cells'] = $file->excelFiles()->orderBy('id', 'asc')->orderBy('column_id', 'asc')->get()->toArray();
        return view('pages.view-file', $data);
    }

    public function exportFile(File $file)
    {
        return Excel::download(new ExportExcelFileData($file), $file->name);
    }
}
