<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\User;
use App\Models\File;

use Carbon\Carbon;
use Dompdf\Dompdf;

use PDF;
use ZipArchive;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;










if (!Auth::check()) {
    return redirect()->route('login');
}


class SuratController extends Controller
{

    public function __construct()
    {
    $this->middleware('auth');
    }



    public function index(Request $request)
{
    $user = Auth::user();
    $suratTypes = Surat::select('tipe_surat', DB::raw('count(*) as count'))->groupBy('tipe_surat')->get();
    $suratStatus = Surat::select('status', DB::raw('count(*) as count'))->groupBy('status')->get();
    
    $surat = Surat::query();

    // Jika query pencarian tidak kosong, filter berdasarkan keyword pencarian
    if ($request->has('search')) {
        $keyword = $request->query('search');
        $surat->where('nama', 'like', "%$keyword%")
            ->orWhere('tipe_surat', 'like', "%$keyword%")
            ->orWhere('nik', 'like', "%$keyword%")
            ->orWhere('status', 'like', "%$keyword%");
    }
    
    // mendapatkan semua data surat setelah dilakukan filter pencarian
    $surat = $surat->get();
    
    // Perbarui status jika tanggal pengambilan terlewat
    foreach ($surat as $item) {
        $tanggalPengambilan = Carbon::parse($item->tanggal_pengambilan);
        $today = Carbon::now();
        $nextDay = $tanggalPengambilan->copy()->addDay(); // Add 1 day to the $tanggalPengambilan
        
        if ($item->status !== 'Selesai' && $today->isSameDay($nextDay)) {
            $item->status = 'Terlambat';
            $item->save();
        }
    }

    return view('surat.index', compact('surat', 'suratTypes', 'suratStatus'));
}

public function updateStatusInput(Request $request, $id)
{
    $surat = Surat::findOrFail($id);
    
    if ($surat->status === 'Selesai') {
        return redirect()->back()->with('error', 'Status cannot be changed.');
    }
    
    $surat->status = 'Dokumen Lengkap';
    $surat->inputted_by = Auth::user()->name;
    $surat->save();

    // Redirect back or to a different page after updating the status
    return redirect()->back()->with('status', 'Status updated successfully!');
}

public function updateStatus(Request $request, Surat $surat)
{
    if ($surat->status === 'Selesai') {
        return redirect()->back()->with('error', 'Status cannot be changed.');
    }
    
    $surat->status = 'Selesai';
    $surat->verified_by = Auth::user()->name;
    $surat->save();

    return redirect()->back()->with('success', 'Status surat berhasil diubah menjadi Selesai.');
}





   
    public function create()
    {
        return view('surat.create');
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'tipe_surat' => 'required',
            'file_path.*' => 'nullable|file|max:10240', // 10MB
        ]);
    
        $surat = new Surat();
        $surat->nik = $request->nik;
        $surat->nama = $request->nama;
        $surat->tipe_surat = $request->tipe_surat;
        $surat->tanggal = now();
        $surat->tanggal_pengambilan = now()->addDays(3);
        $surat->status = 'Dalam Proses';
        $surat->keterangan = $request->keterangan;
        $surat->penulis_id = Auth::id(); // Set penulis_id from the currently logged-in user
        $surat->save();
    
        if ($request->hasFile('file_path')) {
            $filePaths = [];
            foreach ($request->file('file_path') as $file) {
                $folderName = $request->nik; // Folder name will be the same as 'nik'
                $filePath = $file->store('public/files/' . $folderName);
                $filePaths[] = $filePath;
            }
            $surat->file_path = $filePaths;
            $surat->save();
        }
    

        $request->session()->flash('success', 'Surat berhasil ditambahkan');
        


        return redirect()->route('surat.show', ['id' => $surat->id]);

       
    }
    

    

        






    public function edit($id)
    {
        $surat = Surat::find($id);
        return view('surat.edit', ['surat' => $surat]);
    }

    public function inputDocument($id)
    {
        $surat = Surat::find($id);
        return view('surat.input-document', ['surat' => $surat]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tipe_surat' => 'required',
            'file_path' => 'file|max:10240', // 10MB
        ]);

        $surat = Surat::find($id);
        $surat->nama = $request->nama;
        $surat->tipe_surat = $request->tipe_surat;
        $surat->status = $request->status;
        $surat->keterangan = $request->keterangan;

        if ($request->hasFile('file_path')) {
            Storage::delete('public/files/' . $surat->file_path);
            $file_path = $request->file('file_path')->store('public/files');
            $surat->file_path = $file_path;
        }

        $surat->save();

        return redirect()->route('surat.index');
    }

    
    
   

        

        

        
    


        


    public function destroy($id)
    {
        $surat = Surat::find($id);
        Storage::delete('public/files/' . $surat->file_path);
        $surat->delete();

        return redirect()->route('surat.index');
    }
    
    public function show($id)
    {
        $surat = Surat::findOrFail($id);
        $successMessage = session('success');

        return view('surat.show', compact('surat', 'successMessage'));
        

        
    }
//public function download($id)
//{
//    $surat = Surat::findOrFail($id);

//    return response()->download(storage_path('app/' . $surat->file_path), $surat->nama . '.pdf');
//}


public function download($id)

{
    $surat = Surat::findOrFail($id);

    return response()->download(storage_path('app/' . $surat->file_path), $surat->nama);
}







public function downloadFiles($nik)
{
    $folderName = $nik;
    $zipFileName = $folderName . '.zip';
    $zipPath = storage_path('app/public/files/' . $zipFileName);

    $files = glob(storage_path('app/public/files/' . $folderName . '/*'));

    // Create a new ZIP archive
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        foreach ($files as $file) {
            // Add each file to the ZIP archive
            $fileName = pathinfo($file, PATHINFO_BASENAME);
            $zip->addFile($file, $fileName);
        }

        $zip->close();

        // Set the appropriate headers for downloading the ZIP file
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    // Return an error response if the ZIP archive creation failed
    return response()->json(['error' => 'Failed to create ZIP archive'], 500);
}





}
