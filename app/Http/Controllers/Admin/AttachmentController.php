<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file'=>'required|mimes:pdf,jpg,png|max:4096'
        ]);

        $path = $request->file('file')->store('attachments','public');

        Attachment::create([
            'attachable_id' => $request->attachable_id,
            'attachable_type' => $request->attachable_type,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $request->file('file')->extension(),
            'uploaded_by' => auth()->id()
        ]);

        return back()->with('success','Attachment saved.');
    }
}
