<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherProfileController extends Controller
{
    /**
     * GET /api/teacher/profile
     * View authenticated teacher's profile.
     */
    public function show(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'teacher') {
            return response()->json(['message' => 'Access denied. Teachers only.'], 403);
        }

        $user = $request->user()->load('department.college');

        return response()->json([
            'id'          => $user->id,
            'name'        => $user->name,
            'email'       => $user->email,
            'phone'       => $user->phone,
            'employee_id' => $user->employee_id,
            'status'      => $user->status,
            'profile_photo' => $user->profile_photo,
            'department'  => $user->department ? [
                'id'      => $user->department->id,
                'name'    => $user->department->name,
                'college' => $user->department->college?->name,
            ] : null,
            'created_at'  => $user->created_at,
        ]);
    }

    /**
     * PUT /api/teacher/profile
     * Update authenticated teacher's profile details.
     */
    public function update(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'teacher') {
            return response()->json(['message' => 'Access denied. Teachers only.'], 403);
        }

        $user = $request->user();

        $validated = $request->validate([
            'name'          => ['sometimes', 'string', 'max:255'],
            'phone'         => ['sometimes', 'string', 'max:20'],
            'department_id' => ['sometimes', 'integer', 'exists:departments,id'],
            'employee_id'   => ['sometimes', 'string', 'max:50', 'unique:users,employee_id,' . $user->id],
            'profile_photo' => ['sometimes', 'string', 'max:500'],  // URL or path
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user'    => $user->fresh()->load('department'),
        ]);
    }

    /**
     * PUT /api/teacher/profile/password
     * Change authenticated teacher's password.
     */
    public function changePassword(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'teacher') {
            return response()->json(['message' => 'Access denied. Teachers only.'], 403);
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
     * DELETE /api/teacher/profile
     * Delete the authenticated teacher's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        if ($request->user()->role !== 'teacher') {
            return response()->json(['message' => 'Access denied. Teachers only.'], 403);
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

        // Revoke all tokens before deleting
        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'Account deleted successfully.']);
    }
}
