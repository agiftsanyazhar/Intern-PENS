<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\OpportunityStateDetailRequest;
use App\Models\{
    OpportunityState,
    OpportunityStateDetail,
};
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OpportunityStateDetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($opportunityStateId)
    {
        $opportunityState = OpportunityState::find($opportunityStateId);

        return view('opportunity-state.opportunity-state-detail.form', compact('opportunityState', 'opportunityStateId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OpportunityStateDetailRequest $request)
    {
        try {
            $data = $request->only([
                'opportunity_state_id',
                'opportunity_status_id',
                'description',
                'created_by',
                'created_at',
                'updated_by'
            ]);

            $data['created_by'] = AuthHelper::authSession()->id;
            $data['created_at'] = Carbon::now();

            OpportunityStateDetail::create($data);

            return redirect()->route('opportunity-state.show', $data['opportunity_state_id'])->withSuccess('Opportunity State Detail Successfully Added');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($opportunityStateId, $opportunityStateDetailId)
    {
        $data = OpportunityStateDetail::findOrFail($opportunityStateDetailId);
        $opportunityState = OpportunityState::find($opportunityStateId);

        return view('opportunity-state.opportunity-state-detail.form', compact('data', 'opportunityStateId', 'opportunityState', 'opportunityStateDetailId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OpportunityStateDetailRequest $request, $id)
    {
        try {
            $opportunityStateDetail = OpportunityStateDetail::findOrFail($id);

            $data = $request->only([
                'opportunity_state_id',
                'opportunity_status_id',
                'description',
                'created_by',
                'created_at',
                'updated_by'
            ]);

            $data['updated_by'] = AuthHelper::authSession()->id;

            $opportunityStateDetail->update($data);

            return redirect()->route('opportunity-state.show', $data['opportunity_state_id'])->withSuccess('Opportunity State Detail Successfully Updated');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $opportunityStateDetail = OpportunityStateDetail::findOrFail($id);

            $data = $request->only([
                'deleted_by'
            ]);

            if ($opportunityStateDetail) {
                $data['deleted_by'] = AuthHelper::authSession()->id;
                $opportunityStateDetail->update($data);

                $opportunityStateDetail->delete();
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
