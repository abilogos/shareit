<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use \App\Rules\NotInMime;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Display a listing of the user owning files.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //setting and retriving page_size with session
        $pageSize = $request->page_size??session('page_size_file_index', 15);
        session(['page_size_file_index' => $pageSize]);

        //all files of authenticated user
        $files = File::where('user_id', Auth::id())->paginate($pageSize);
        return view('file.index', compact('files'));
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
        $fileLink = $fileModel->link;
        return view('file.stored', compact('fileLink'));
    }

    /**
     * Display the specified file details.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return view('file.show', compact('file'));
    }

    /**
     * Download a file and count downloaded time
     *
     * @param  File   $file
     * @return \Illuminate\Http\Response file downloading response
     */
    public function download(File $file)
    {
        $file->hitDownload();
        return $this->fileDownloadResponse($file->storage_path, $file->name);
    }

    /**
     * This method will clean response header for file downloading
     *
     * @return void
     */
    private function clean_response() : void
    {
        if (ob_get_length()) {
            ob_end_clean();
        }
    }

    /**
     * this method prepare a download response if file exists
     *
     * @param  string $storagePath the file_path in storage folder
     * @param  string $title       the file name to download
     * @return \Illuminate\Http\Response file downloading response
     */
    private function fileDownloadResponse($storagePath, $title)
    {
        $this->clean_response();

        if (!file_exists(storage_path($storagePath))) {
            return abort(404);
        } else {
            return response()->download(storage_path($storagePath), $title);
        }
    }

    /**
     * Remove the specified file from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();
        return back();
    }
}
