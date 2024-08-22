<?php

namespace App\Http\Controllers;

use App\DataTables\{
    OpportunityStateDataTable,
    OpportunityStateDetailDataTable
};
use App\Helpers\AuthHelper;
use App\Http\Requests\OpportunityStateRequest;
use App\Models\{
    Customer,
    OpportunityState,
};
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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
        $headerAction = '<a href="' . route('opportunity-state.create') . '" class="btn btn-sm btn-primary" role="button">Add Opportunity State</a>';

        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function create()
    {
        $customers = Customer::all()->pluck('company_name', 'id');
        
        // Ensure $customerPics is an array
        $customerPics = Customer::all()->mapWithKeys(function ($customer) {
            return [$customer->id => $customer->company_pic_name];
        })->toArray(); // Ensure conversion to array
     
        return view('opportunity-state.form', compact('customers', 'customerPics'));
    }
    
    

    public function store(OpportunityStateRequest $request)
    {
        try {
            $data = $request->only([
                'customer_id',
                'opportunity_status_id',
                'opportunity_value',
                'title',
                'description',
                'created_by',
                'created_at',
                'updated_by'
            ]);

            $data['created_by'] = AuthHelper::authSession()->id;
            $data['created_at'] = Carbon::now();

            OpportunityState::create($data);

            return redirect()->route('opportunity-state.index')->withSuccess('Opportunity State Successfully Added');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(OpportunityStateDetailDataTable $dataTable, $id)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('Opportunity State Detail')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $opportunityState = OpportunityState::find($id);

        $masterDetail = $opportunityState;
        $backAction = '<a href="' . route('opportunity-state.index') . '" class="btn btn-sm btn-primary" role="button">Back</a>';

        $headerAction = '<a href="' . route('opportunity-state-detail.create', $id) . '" class="btn btn-sm btn-primary" role="button">Add Opportunity State Detail</a>';

        return $dataTable->with('id', $id)->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction', 'backAction', 'masterDetail', 'id'));
    }

    public function edit($id)
    {
        $data = OpportunityState::findOrFail($id);
        $customers = Customer::all()->pluck('company_name', 'id');

        return view('opportunity-state.form', compact('data', 'customers', 'id'));
    }

    public function update(OpportunityStateRequest $request, $id)
    {
        try {
            $opportunityState = OpportunityState::findOrFail($id);

            $data = $request->only([
                'customer_id',
                'opportunity_status_id',
                'opportunity_value',
                'title',
                'description',
                'updated_by'
            ]);

            $data['updated_by'] = AuthHelper::authSession()->id;

            $opportunityState->update($data);

            return redirect()->route('opportunity-state.index')->withSuccess('Opportunity State Successfully Updated');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $opportunityState = OpportunityState::findOrFail($id);

            $data = $request->only([
                'deleted_by'
            ]);

            if ($opportunityState) {
                $data['deleted_by'] = AuthHelper::authSession()->id;
                $opportunityState->update($data);

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
