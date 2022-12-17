<?php

namespace App\Http\Controllers;

use App\Exports\ExportExcelFileData;
use App\Http\Requests\ExcelRequest;
use App\Imports\ImportExcelFileData;
use App\Models\File;
use App\Models\FileColumn;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
        return redirect()->back()->with('success', 'Import has been started...!!');
    }

    public function exportFile(File $file)
    {
        return Excel::download(new ExportExcelFileData($file), $file->name);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
