<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $current_user = Auth::user();
        if (!$current_user || $current_user->cannot("create", $current_user)) {
            return response()->json(["error" => "Unauthorized"], 401);
        }

        $validation = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json(["error" => $validation->errors()], 400);
        }

        try {
            $user = new User($request->all());
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(["error"=> $e->getMessage()],500);
        }
    }
}
