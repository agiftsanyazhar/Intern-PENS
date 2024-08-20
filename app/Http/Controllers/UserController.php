<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title', ['form' => trans('User')]);
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('users.create') . '" class="btn btn-sm btn-primary" role="button">Add User</a>';

        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all()->pluck('title', 'id'); // Assuming 'name' is the correct column

        return view('users.form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->only(['name', 'email', 'password', 'phone', 'role_id', 'note']);

            $data['name'] = $data['name'] ?? stristr($data['email'], "@", true) . rand(100, 1000);
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            $user->assignRole($data['role_id']);

            return redirect()->route('users.index')->withSuccess('User Successfully Added');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::findOrFail($id); // Find the user
        $roles = Role::all()->pluck('title', 'id'); // Fetch roles for the form

        return view('users.form', compact('data', 'roles', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id); // Find the user

            // Check permissions if in demo mode
            if (env('IS_DEMO') && $user->hasRole('Admin')) {
                return redirect()->back()->with('error', 'Permission denied');
            }

            $data = $request->only(['name', 'email', 'password', 'phone', 'role_id', 'note']);

            $data['name'] = $data['name'] ?? stristr($data['email'], "@", true) . rand(100, 1000);
            $data['password'] = $request->password ? bcrypt($request->password) : $user->password;

            $user->update($data);

            $user->syncRoles($data['role_id']);

            return redirect()->route('users.index')->withSuccess('User Successfully Updated');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return redirect()->back()->withInput()->withErrors($errors);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user) {
                $user->delete();
                $status = 'success';
                $message = __('global-message.delete_form', ['form' => __('users.title')]);
            } else {
                $status = 'error';
                $message = __('global-message.delete_form_failed', ['form' => __('users.title')]);
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
