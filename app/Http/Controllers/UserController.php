<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nosOfPagination = 6; // rows per page
        if ($request["email"]) { // if index has search parameter
            // paginated select * from Users where accountnumber like %request% command
            $User = User::where("email","like","%". $request["email"] ."%")->cursorPaginate($nosOfPagination);
        } else // if index has no search parameter
            // paginated select * from Users command
            $User = User::cursorPaginate($nosOfPagination);
        return Inertia::render('viewjs/user/index', [
            'pagination' => $User,
        ]);
    }

    /**
     * Show the form for searching resource.
     */
    public function search()
    {
        return Inertia::render('viewjs/user/search');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        return Inertia::render(
            'viewjs/user/show',
            [
                'user' => $User,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $User)
    {
        return Inertia::render(
            'viewjs/user/edit',
            ['user' => $User]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $User)
    {
        $User->update($request->all());

        $messagemain  = 'Nothing was saved.';
        $messagedescription = '::: '. ' xxxxxxxxx ' .' >>>';
        if ($User) {
            $messagemain  =  'Existing user data with ID: '. $User->email .' @ '. $User->name .', password is successfully reset.';
            $messagedescription = '::: '. $User->updated_at .' >>>';
        };

        return redirect()->route(
            'user.index',
            [
                'user' => $User,
                'messagemain'        => $messagemain,
                'messagedescription' => $messagedescription
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User)
    {
        $messagemain  = 'Nothing was deleted.';
        $messagedescription = '::: '. ' xxxxxxxxx ' .' >>>';
        if ($User) {
            $messagemain  =  'Existing row data with ID: '. $User->email .' @ '. $User->name .' was forever deleted.';
            $messagedescription = 'Last Modified : '. $User->updated_at .' >>>';
        };
        $User->deleteOrFail();
        return redirect()->route(
            'user.index',[
                'messagemain'        => $messagemain,
                'messagedescription' => $messagedescription
            ]
        );
    }
}

