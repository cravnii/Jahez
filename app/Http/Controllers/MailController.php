<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMailRequest;
use App\Http\Requests\UpdateMailRequest;
use App\Http\Resources\Mails\MailResource;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index()
{
    $mails = Mail::paginate(10);
    return response()->json([
        'data' => [
            'mails' => MailResource::collection($mails),
        ]
    ]);
}

public function store(StoreMailRequest $request)
{
    $validatedData = $request->validated();
    Mail::create($validatedData);

    return response()->json([
        'message' => 'Mail was sent successfully'
    ]);
}

public function show(Mail $mail)
{
    if (!$mail) {
        return response()->json([
            'message' => 'Mail not found'
        ], 404);
    }

    return response()->json([
        'mail' => new MailResource($mail),
    ]);
}

public function update(UpdateMailRequest $request, Mail $mail)
{
    $validatedData = $request->validated();

    $mail->update($validatedData);

    return response()->json([
        'message' => 'Mail was updated successfully'
    ]);
}

public function destroy(Mail $mail)
{
    $mail->delete();
    return response()->json([
        'message' => 'Mail deleted successfully'
    ]);
}

}
