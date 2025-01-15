<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->get();
        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'type' => 'required|in:aprovado,cancelado',
        ]);

        $notification = Notification::create(array_merge($validated, [
            'user_id' => Auth::id(),
        ]));

        return response()->json($notification, 201);
    }
}