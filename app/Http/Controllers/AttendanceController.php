<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Attendee;

class AttendanceController extends Controller
{
    public function attendance()
    {
        return view('attendance.bac');
    }


public function store(Request $request)
{
    try {
        // Validate incoming request
        $request->validate([
            'fullName' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'type_attendee' => 'required|string|max:255',
            'phone_number' => 'required|string|max:50',
            'purpose' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'photo' => 'required|string', // base64 image
            'attendance_date' => 'required|date',
            'attendance_time' => 'required|string',
        ]);

        // Ensure photo is valid base64
        $photoData = $request->input('photo');
        if (!preg_match('/^data:image\/(\w+);base64,/', $photoData)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid photo format'
            ], 422);
        }

        // Decode the base64 image
        $decoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photoData));
        if ($decoded === false) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to decode photo'
            ], 422);
        }

        // Save to Laravel public storage
        $fileName = Str::random(12) . '.jpg';
        $photoPath = "photos/{$fileName}";
        Storage::disk('public')->put($photoPath, $decoded);

        // Generate public URL
        $photoUrl = asset("storage/{$photoPath}");

        // Save attendee record
        $attendee = Attendee::create([
            'fullName' => $request->fullName,
            'position' => $request->position,
            'type_attendee' => $request->type_attendee,
            'phone_number' => $request->phone_number,
            'purpose' => $request->purpose,
            'company' => $request->company,
            'address' => $request->address,
            'photo' => $photoUrl,
            'attendance_date' => $request->attendance_date,
            'attendance_time' => $request->attendance_time,
        ]);

        return response()->json([
            'success' => true,
            'attendee' => $attendee
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Laravel validation errors
        return response()->json([
            'success' => false,
            'error' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        // Catch any other exception
        return response()->json([
            'success' => false,
            'error' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}


}
