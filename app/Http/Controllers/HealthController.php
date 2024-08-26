<?php

namespace App\Http\Controllers;

use App\Models\Health;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Http\Requests\HealthRequest;
use Exception;
use Illuminate\Validation\ValidationException;
use App\DataTables\HealthDataTable;


class HealthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HealthDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('Health')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('health.create') . '" class="btn btn-sm btn-primary" role="button">Add Health</a>';

        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('health.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HealthRequest $request)
    {
        try {
            $data = $request->only([
                'status_health',
                'day_parameter_value',
            ]);

            Health::create($data);

            return redirect()->route('health.index')->withSuccess('Health Successfully Added');
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
        $data = Health::findOrFail($id);

        return view('health.form', compact('data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HealthRequest $request, $id)
    {
        try {
            $health = Health::findOrFail($id);
            $data = $request->only([
                'status_health',
                'day_parameter_value',
            ]);

            $health->update($data);

            return redirect()->route('health.index')->withSuccess('Health Successfully Updated');
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
    public function destroy($id)
    {
        try {
            $health = Health::findOrFail($id);

            if ($health) {
                $health->delete();
                $status = 'success';
                $message = __('global-message.delete_form', ['form' => __('Health')]);
            } else {
                $status = 'error';
                $message = __('global-message.delete_form_failed', ['form' => __('Health')]);
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
