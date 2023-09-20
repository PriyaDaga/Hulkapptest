<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Mail\RegisterMail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function users(){
        $authuser = Auth::user();
        $userrole = $authuser['role'];
        if($authuser['role'] == 'admin'){
            $users = User::all();
        }else{
            $users = $authuser;
        }
        return view('users.index',compact('users','userrole'));
    }

    public function edituser($id){
        $user = User::find($id);
        return view('users.edit',compact('user'));
    }

    public function updateuser(Request $request,$id){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'DOB' => ['required'],
            'address' => ['required'],
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->DOB = $request->input('DOB');
        $user->address = $request->input('address');
        $user->save();
        return redirect()->route('profile.users');
    }

    public function deleteuser($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('profile.users');
    }

    public function verifyuser($id){
        $user = User::find($id);
        $chk = $user['verified'];
        if($chk == 0){
            $user->verified = 1;
        }else{
            $user->verified = 0;
        }
        $user->save();
        $mailData = [
            'title' => 'Mail from Hulkapp',
            'body' => 'Your account has been verified.'
        ];
         
        \Mail::to($user['email'])->send(new RegisterMail($mailData));
        return redirect()->route('profile.users');
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
