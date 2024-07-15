<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        print_r($validated);
    }

    public function login(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($credentials->fails()) {
            return response()->json($credentials->errors(), 401);
        }

        /* $user = User::where('email', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        } */

        if(!Auth::attempt(['email' => $request->username, 'password' => $request->password])){
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $user = Auth::user();        
        $token = $user->createToken('user.rights');
        return response()->json(['token' => $token->plainTextToken, 'user' => $user], 200);


    }

    public function logout(Request $request)
    {

    }
}
