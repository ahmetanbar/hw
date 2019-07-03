<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ProfilesController extends Controller
{
    public function index($user){
        $user = User::findOrFail($user);
        return view('profiles/index',[
            'user' => $user,
        ]);
    }

    public function edit(\App\User $user){
        $this->authorize('update',$user->profile);
        return view('profiles.edit',compact('user'));
    }

    public function update(User $user){
        $this->authorize('update',$user->profile);
        $data = request()->validate([
            'title' => 'required',
            'describtion' => 'required',
            'url' => 'nullable',
            'image' => '',
            'error' => 'nullable'
        ]);  

        if(request('error') and request('image') and request('description')){  //if new users try to share any post or comment they redirected profile/edit page.
            return redirect("/p/create");                                      //if the users complete profile part and click the save button they automatically redirected create page.
        }

        if(request('image')){
            $imagePath = request('image')->store('profile','public');
            $imageArray = ['image' => $imagePath];
        }

        // dd(array_merge(
        //     $data,
        //     ['image' => $imagePath]
        // ));

        auth()->user()->profile->update(array_merge(
            $data,
            // ['image' => $imagePath ?? null]
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
        }


}
