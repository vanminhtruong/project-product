<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    // Xem thông tin hồ sơ người dùng
    public function profile(Request $request)
    {
        $user = $request->user()->load(['carts', 'orders']);
        return response()->json($user, 200);
    }

    // Cập nhật thông tin hồ sơ
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            
            // Validate dữ liệu
            $request->validate([
                'full_name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            // Cập nhật thông tin
            $user->update([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return response()->json([
                'message' => 'Cập nhật thông tin thành công',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Cập nhật thông tin thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
