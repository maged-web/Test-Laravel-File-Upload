<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function store(Request $request)
    {
        $filename = $request->file('photo')->store('houses');

        House::create([
            'name' => $request->name,
            'photo' => $filename,
        ]);

        return 'Success';
    }

    public function update(Request $request, House $house)
    {
        $filename = $request->file('photo')->store('houses');

        // TASK: Delete the old file from the storage
        if($house->photo)
        {
            Storage::delete($house->photo);
        }

        $house->update([
            'name' => $request->name,
            'photo' => $filename,
        ]);

        return 'Success';
    }

    public function download(House $house)
    {
        // TASK: Return the $house->photo file from "storage/app/houses" folder
        // for download in browser
        $filePath = storage_path("app/houses/{$house->photo}");
        if(file_exists($filePath))
        {
            return Storage::download($filePath);
        }
        else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}