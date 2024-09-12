<?php

namespace App\Http\Controllers;

use App\DataTables\{
    NotificationDataTable,
};
use App\Helpers\AuthHelper;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    public function index(NotificationDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('Notification')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '';

        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
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

            $notification->is_read = 1;
            $notification->save();

            return redirect()->to(route('opportunity-state.show', $notification->opportunity_state_id));
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
