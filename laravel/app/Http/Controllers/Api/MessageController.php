<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use App\Models\File;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();
        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'route_id' => 'required|exists:routes,id',
            // 'date' => 'required|date_format:Y-m-d H:i:s',
            'text' => 'nullable|string|max:255',
            'imageUri' => 'nullable',
            'img_author_message' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
        ]);
        $date = Carbon::now()->format('Y-m-d H:i:s');

        if ($request->file('imageUri')) {
            $imageUri = $request->file('imageUri');
            $file = new File();
            $ok = $file->diskSave($imageUri);
            if ($ok) {
                $messageData = [
                    'user_id' => $validatedData['user_id'],
                    'route_id' => $validatedData['route_id'],
                    'date' => $date,
                    'file_id' => $file->id,
                    'img_author_message' => $validatedData['img_author_message'],
                    'author_name' => $validatedData['author_name']
                ];
                if ($validatedData['text']) {
                    $messageData['text'] = $validatedData['text'];
                }
                $message = Message::create($messageData);            
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error uploading file'
                ], 421);
            }
        } else {
            if ($request->input('text')) {
            $message = Message::create([
                'user_id' => $validatedData['user_id'],
                'route_id' => $validatedData['route_id'],
                'date' => $date,
                'text' => $validatedData['text'],
                'img_author_message' => $validatedData['img_author_message'],
                'author_name' => $validatedData['author_name']
            ]);
        }   else{
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating message'
                ], 421);
            }
        }
        return response()->json([
            'success' => true,
            'data' => $message,
            'message' => 'Message created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $message
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_user' => 'sometimes|required|exists:users,id',
            'id_route' => 'sometimes|required|exists:routes,id',
            'date' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'text' => 'sometimes|required|string|max:255',
            'attached_file' => 'nullable|file'
        ]);

        $message = Message::findOrFail($id);

        $message->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $message,
            'message' => 'Message updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully.'
        ]);
    }
}