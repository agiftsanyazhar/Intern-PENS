<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all'); // Default filter is 'all'

        $query = Notification::where('receiver_id', AuthHelper::authSession()->id);

        if ($filter === 'read') {
            $query->where('is_read', true);
        } elseif ($filter === 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('notification.partials.list', compact('notifications'))->render()
            ]);
        }

        return view('notification.index', compact('notifications', 'filter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($opportunityStateId, $receiverId, $senderId)
    {
        try {
            $notification = new Notification();
            $notification->opportunity_state_id = $opportunityStateId;
            $notification->receiver_id = $receiverId;
            $notification->sender_id = $senderId;
            $notification->save();
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function markAsRead($id)
    {
        try {
            $notification = Notification::findOrFail($id);

            $notification->read_at = now();
            $notification->save();

            return redirect()->to(route('opportunity-state.show', $notification->opportunity_state_id));
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
