<?php

namespace App\Http\Controllers;

use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    public function index()
    {
        $popups = Popup::paginate(10);
        return view('admin.popups.index', compact('popups'));
    }

    public function create()
    {
        return view('admin.popups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Validate that the uploaded file is an image
            'expiry_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
    
        $filename = null; // Initialize filename variable
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension(); // Get the original file extension
            $filename = time() . '.' . $ext; // Create a unique filename using the current timestamp
            $file->move(public_path('assets/uploads/popups'), $filename); // Move the file to the specified directory
        }
    
        // Create a new popup with the uploaded image filename
        Popup::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $filename, // Store the filename in the database
            'expiry_date' => $request->expiry_date,
            'is_active' => $request->is_active ?? false,
        ]);
    
        return redirect()->route('popups.index')->with('success', 'Popup created successfully.');
    }

    public function edit($id)
    {
        $popup = Popup::findOrFail($id);
        return view('admin.popups.edit', compact('popup'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'expiry_date' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);
    
        $popup = Popup::findOrFail($id);
        $imagePath = $popup->image;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Define the path to the old image
            $oldImagePath = public_path('assets/uploads/popups/' . $imagePath);
            
            // Delete old image if it exists
            if ($imagePath && file_exists($oldImagePath)) {
                unlink($oldImagePath); // Use unlink to delete the file
            }
    
            // Process the new image upload
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension(); // Get the original file extension
            $filename = time() . '.' . $ext; // Create a unique filename using the current timestamp
            $file->move(public_path('assets/uploads/popups'), $filename); // Move the file to the specified directory
            
            // Update the image path for the popup
            $imagePath = $filename;
        }
    
        // Update the popup with the new data
        $popup->update($request->only(['title', 'content', 'is_active', 'expiry_date']) + ['image' => $imagePath]);
    
        return redirect()->route('popups.index')->with('status', 'Popup updated successfully!');
    }

    public function destroy($id)
    {
        $popup = Popup::findOrFail($id);
        if ($popup->image) {
            Storage::disk('public')->delete($popup->image);
        }
        $popup->delete();

        return redirect()->route('popups.index')->with('status', 'Popup deleted successfully!');
    }
}