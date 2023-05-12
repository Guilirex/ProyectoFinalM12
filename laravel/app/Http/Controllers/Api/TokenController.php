<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\File;
use App\Models\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function user(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();

        return response()->json([
            "success" => true,
            "user" => $request->user(),
            // "roles"   => $user->getRoleNames(),
        ]);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Get user
            $user = User::where([
                ["email", "=", $credentials["email"]]
            ])->firstOrFail();
            // Revoke all old tokens
            $user->tokens()->delete();
            // Generate new token
            $token = $user->createToken("authToken")->plainTextToken;
            // Token response
            return response()->json([
                "success" => true,
                "authToken" => $token,
                "tokenType" => "Bearer"
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
    protected function register(Request $request)
    {
        Log::debug($request);
        $validacion = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'second_surname' => ['nullable', 'string', 'max:255'],
            'imageUri' => ['nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        Log::debug($request->input('imageUri'));

        $imageUri = $request->file('imageUri');
    

        // Desar fitxer al disc i inserir dades a BD
        $file = new File();
        $ok = $file->diskSave($imageUri);
        if ($ok) {
            $user = User::create([
                'name' => $validacion['name'],
                // 'lastname'=> $validacion['lastname'],
                // 'second_surname'=> $validacion['second_surname'],
                'file_id' => $file->id,
                'email' => $validacion['email'],
                'password' => Hash::make($validacion['password']),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading file'
            ], 421);
        }


        $token = $user->createToken("authToken")->plainTextToken;

        return response()->json([
            "success" => true,
            "authToken" => $token,
            "tokenType" => "Bearer"
        ], 200);

    }
    public function logout(Request $request)
    {
        Log::debug($request);
        // Revoke token used to authenticate current request...
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "success" => true,
            "message" => "Current token revoked",
        ]);
    }
    public function getUserAvatar($userId)
    {
        // Recuperar el usuario con la file_id
        $user = User::with('file')->findOrFail($userId);
    
        // Comprobar si el usuario tiene una imagen asignada
        if (!$user->file) {
            return response()->json(['error' => 'User does not have an avatar'], 404);
        }
    
        // Construir la URL de la imagen
        $imagePath = $user->file->file_path;
        $imageUrl = url('storage/' . $imagePath);
    
        return response()->json(['image_url' => $imageUrl]);
    }
    



}