<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use \App\Rules\NotInMime;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validating requested file.
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',
                new NotInMime(['exe', 'php', 'bmp'])
                ]
            ]);
        //httpRequest file
        $requestFile = $request->file("file");

        //generating file row in database
        $fileModel = Auth::user()->files()->save(
            new File([
                'name' => $requestFile->getClientOriginalName()
            ])
        );

        //move file in storage/app/shares folder
        $address = $requestFile->storeAs("shares", $fileModel->id);
        $fileLink = route('file.show', ['file'=>$fileModel]);
        return view('file.stored', compact('fileLink'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
