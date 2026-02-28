<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentProfileController extends Controller
{
    /**
     * GET /api/student/profile
     * View authenticated student's profile.
     */
    public function show(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'student') {
            return response()->json(['message' => 'Access denied. Students only.'], 403);
        }

        $user = $request->user()->load(['college', 'department', 'course']);

        return response()->json([
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'phone'         => $user->phone,
            'roll_number'   => $user->roll_number,
            'year'          => $user->year,
            'is_approved'   => $user->is_approved,
            'status'        => $user->status,
            'profile_photo' => $user->profile_photo,
            'college'       => $user->college?->name,
            'department'    => $user->department?->name,
            'course'        => $user->course?->name,
            'created_at'    => $user->created_at,
        ]);
    }

    /**
     * PUT /api/student/profile
     * Update authenticated student's profile details.
     */
    public function update(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'student') {
            return response()->json(['message' => 'Access denied. Students only.'], 403);
        }

        $user = $request->user();

        $validated = $request->validate([
            'name'          => ['sometimes', 'string', 'max:255'],
            'phone'         => ['sometimes', 'string', 'max:20'],
            'year'          => ['sometimes', 'integer', 'min:1', 'max:6'],
            'profile_photo' => ['sometimes', 'string', 'max:500'],
        ]);

        // Students cannot change their college, department, course, or roll_number
        // Those are locked after registration (admin can change them)
        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user'    => $user->fresh()->load(['college', 'department', 'course']),
        ]);
    }

    /**
     * PUT /api/student/profile/password
     * Change authenticated student's password.
     */
    public function changePassword(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'student') {
            return response()->json(['message' => 'Access denied. Students only.'], 403);
        }

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Revoke all other tokens after password change (security)
        $user->tokens()->where('id', '!=', $request->user()->currentAccessToken()->id)->delete();

        return response()->json(['message' => 'Password changed successfully.']);
    }

    /**
     * DELETE /api/student/profile
     * Delete the authenticated student's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'student') {
            return response()->json(['message' => 'Access denied. Students only.'], 403);
        }

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password confirmation failed.',
            ], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'Account deleted successfully.']);
    }
}
