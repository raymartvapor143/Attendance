<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Attendance;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function attendance()
    {
        return view('attendance.bac');
    }


 public function store(Request $request)
    {
        // ✅ Validate
        $validator = Validator::make($request->all(), [
            'fullName'          => 'required|string|max:255',
            'position'          => 'required|string|max:255',
            'type_attendee'     => 'required|string|max:255',
            'phone_number'      => 'required|string|max:20',
            'attendance_date'   => 'required|date',
            'attendance_time'   => 'required|string',
            'photo'             => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // ✅ Handle base64 photo
        $photo = $request->photo;

        if (!str_starts_with($photo, 'data:image')) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid image format'
            ], 400);
        }

        $image = preg_replace('/^data:image\/\w+;base64,/', '', $photo);
        $image = str_replace(' ', '+', $image);
        $imageName = 'attendance_' . Str::uuid() . '.jpg';

        Storage::disk('public')->put('attendance/' . $imageName, base64_decode($image));

        // ✅ Save to DB
        Attendance::create([
            'full_name'        => $request->fullName,
            'position'         => $request->position,
            'type_attendee'    => $request->type_attendee,
            'phone_number'     => $request->phone_number,
            'attendance_date'  => $request->attendance_date,
            'attendance_time'  => $request->attendance_time,
            'photo_path'       => 'attendance/' . $imageName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance saved successfully'
        ]);
    }


}
