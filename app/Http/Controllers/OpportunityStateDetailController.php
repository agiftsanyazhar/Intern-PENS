<?php

namespace App\Http\Controllers;

use App\DataTables\OpportunityStateDetailDataTable;
use App\Helpers\AuthHelper;
use App\Http\Requests\OpportunityStateDetailRequest;
use App\Models\{
    OpportunityState,
    OpportunityStateDetail,
};
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;

class OpportunityStateDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OpportunityStateDetailDataTable $dataTable, $id)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('Opportunity State Detail')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('opportunity-state-detail.create', $id) . '" class="btn btn-sm btn-primary" role="button">Add Opportunity State Detail</a>';

        $opportunityState = OpportunityState::findOrFail($id);

        return $dataTable->with('id', $id)->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction', 'opportunityState', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $opportunityStateId = $id;

        return view('opportunity-state.opportunity-state-detail.form', compact('opportunityStateId'));
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

            return redirect()->route('opportunity-state-detail.index', $data['opportunity_state_id'])->withSuccess('Opportunity State Detail Successfully Added');
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
    public function edit($id)
    {
        $data = OpportunityStateDetail::findOrFail($id);

        return view('opportunity-state.opportunity-state-detail.form', compact('data', 'id'));
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

            return redirect()->route('opportunity-state.index')->withSuccess('Opportunity State Detail Successfully Updated');
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
    public function destroy(OpportunityStateDetailRequest $opportunityDetail)
    {
        //
    }
}
