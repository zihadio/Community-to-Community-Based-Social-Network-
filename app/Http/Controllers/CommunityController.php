<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Communities;


class CommunityController extends Controller
{
    public function view($communityid){
        if (Auth::check()){

            /*return view('app.community')->with('active', 'community');*/

            $communityid = Communities::where('community_id', $communityid)->first();

            return view('app.community')
                ->with('community_id', $communityid)->with('active', 'community_id');
        }

        return view('welcome');
    }
}
