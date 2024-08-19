<?php

namespace App\Http\Controllers;

use App\DataTables\CustomersDataTable;
use App\Models\{
    Customer,
    User,
};
use App\Models\OpportunityState; // Assuming you need to fetch opportunity states for `opportunity_state_id`
use App\Helpers\AuthHelper;
use App\Http\Requests\CustomerRequest;
use Exception;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function index(CustomersDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('Customer')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('customers.create') . '" class="btn btn-sm btn-primary" role="button">Add Customer</a>';

        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function create()
    {
        $users = User::all()->pluck('name', 'id'); // Fetch users for `user_pic_id`
        $opportunityStates = OpportunityState::all()->pluck('opportunity_status', 'id'); // Fetch opportunity states for `opportunity_state_id`

        return view('customers.form', compact('users', 'opportunityStates'));
    }

    public function store(CustomerRequest $request)
    {
        try {
            $data = $request->only([
                'company_name',
                'company_address',
                'company_email',
                'company_phone',
                'company_pic_name',
                'company_pic_address',
                'company_pic_email',
                'company_pic_phone',
                'description'
            ]);

            Customer::create($data);

            return redirect()->route('customers.index')->withSuccess('Customer Successfully Added');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data = Customer::findOrFail($id);
        $users = User::all()->pluck('name', 'id'); // Fetch users for `user_pic_id`
        $opportunityStates = OpportunityState::all()->pluck('opportunity_status', 'id'); // Fetch opportunity states for `opportunity_state_id`

        return view('customers.form', compact('data', 'users', 'opportunityStates', 'id'));
    }

    public function update(CustomerRequest $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            $data = $request->only([
                'company_name',
                'company_address',
                'company_email',
                'company_phone',
                'company_pic_name',
                'company_pic_address',
                'company_pic_email',
                'company_pic_phone',
                'description'
            ]);

            $customer->update($data);

            return redirect()->route('customers.index')->withSuccess('Customer Successfully Updated');
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
            $customer = Customer::findOrFail($id);

            if ($customer) {
                $customer->delete();
                $status = 'success';
                $message = __('global-message.delete_form', ['form' => __('Customer')]);
            } else {
                $status = 'error';
                $message = __('global-message.delete_form_failed', ['form' => __('Customer')]);
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
