<?php

namespace App\Http\Controllers;

use App\Communities;
use App\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Response;

use Image;
use App\User;
use Auth;
use DB;


class ProfileController extends Controller
{
	public function view($id){

		$user = User::findOrFail($id);

		return view('app.profile')->with('user', $user);
	}

	public function edit($id){

		$user = User::findOrFail($id);

		if (!$user->id == Auth::user()->id){
			return redirect()->back();
		}

		return view('app.profile.edit')->with('user', $user);

	}

	public function changeCover(Request $request){
		
		$rules = array(
            'image' => 'required|image'
        );

        $validator = Validator::make(Input::all(), $rules);

        // Validate the input and return correct response
        if ($validator->fails()){
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if ($request->hasFile('image')){

        	$image = $request->file('image');
			$filename = time() . '.' . $image->getClientOriginalExtension();
			$image->move(Auth::user()->getCoverPath(), $filename);

			$img = Image::make(asset(Auth::user()->getCoverPath() . $filename));
			$img->fit(1300,400);
			$img->save(Auth::user()->getCoverPath() . $filename);

			Auth::user()->update([
				'cover' => $filename
			]);
        }

        return Response::json(array(
        	'success' => true
        ));

	}

	public function changeProfile(Request $request){
		$rules = array(
            'image' => 'required|image'
        );

        $validator = Validator::make(Input::all(), $rules);

        // Validate the input and return correct response
        if ($validator->fails()){
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        if ($request->hasFile('image')){

        	$image = $request->file('image');
			$filename = time() . '.' . $image->getClientOriginalExtension();
			$image->move(Auth::user()->getAvatarPath(), $filename);

			$img = Image::make(asset(Auth::user()->getAvatarPath() . $filename));
			$img->fit(500,500);
			$img->save(Auth::user()->getAvatarPath() . $filename);

			Auth::user()->update([
				'avatar' => $filename
			]);
        }

        return Response::json(array(
        	'success' => true
        ));
	}

	public function personalInfoSave(){

	    $data = Communities::all()->toArray();
        return view('app.personal_information', compact('data'));
    }

    public function personalInfoSavePost(Request $request){

        /*return $request->all();*/

        $user = Auth::id();


        $this->validate($request,[
           'country' => 'required',
           'city' => 'required',
           'phoneno' => 'required',
            'profession' => 'required'
        ]);

        $personalInformation = new PersonalInformation();
        $personalInformation->user_id = $user;
        $personalInformation->country = $request->country;
        $personalInformation->city = $request->city;
        $personalInformation->phone = $request->phoneno;
        $personalInformation->profession = $request->profession;
        $personalInformation->save();


        $communityid = Communities::where('name', $request->profession)->value('community_id');
        $personalInformation->community_id = $communityid;
        $personalInformation->save();


        return redirect(route('index'));

    }
}
