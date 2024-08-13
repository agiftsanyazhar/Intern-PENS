<?php

namespace App\Http\Controllers;

use App\DataTables\OpportunityStateDataTable;
use App\Helpers\AuthHelper;
use App\Http\Requests\OpportunityStateRequest;
use App\Models\OpportunityState;
use Exception;
use Illuminate\Validation\ValidationException;

class OpportunityStateController extends Controller
{
    /**
     * Display a listing of the opportunity states.
     *
     * @param \App\DataTables\OpportunityStateDataTable $dataTable
     * @return \Illuminate\View\View
     */
    public function index(OpportunityStateDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('Opportunity State')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('opportunity-state.create') . '" class="btn btn-sm btn-primary" role="button">Add Opportunity</a>';

        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function create()
    {
        return view('opportunity-state.form');
    }

    public function store(OpportunityStateRequest $request)
    {
        try {
            $data = $request->only(['opportunity_status', 'note']);

            OpportunityState::create($data);

            return redirect()->route('opportunity-state.index')->withSuccess('Opportunity State Successfully Added');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data = OpportunityState::findOrFail($id);

        return view('opportunity-state.form', compact('data', 'id'));
    }

    public function update(OpportunityStateRequest $request, $id)
    {
        try {
            $opportunityState = OpportunityState::findOrFail($id);

            $data = $request->only(['opportunity_status', 'note']);

            $opportunityState->update($data);

            return redirect()->route('opportunity-state.index')->withSuccess('Opportunity State Successfully Updated');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $opportunityState = OpportunityState::findOrFail($id);

            if ($opportunityState) {
                $opportunityState->delete();
                $status = 'success';
                $message = __('global-message.delete_form', ['form' => __('Opportunity State')]);
            } else {
                $status = 'error';
                $message = __('global-message.delete_form_failed', ['form' => __('Opportunity State')]);
            }

            if (request()->ajax()) {
                return response()->json(['status' => $status, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
            }

            return redirect()->back()->with($status, $message);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
