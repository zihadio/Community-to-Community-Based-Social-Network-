<?php

namespace App\Http\Controllers;

use App\Friend;
use App\PersonalInformation;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Communities;
use App\Image;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Redirect;
use Response;

use Request as AjaxRequest;
use App\Community_Post;




class CommunityController extends Controller
{


    public function updateInfo(){

        $id = AjaxRequest::input('id');

        $post = Community_Post::findOrFail($id);

        return $post->infoStatus();
    }

    public function view($communityid){
        if (Auth::check()){

            /*return view('app.community')->with('active', 'community');*/

            $communityid = Communities::where('community_id', $communityid)->first();

            return view('app.community')
                ->with('community_id', $communityid)->with('active', 'community_id');
        }

        return view('welcome');
    }
    //Community page route
    public function communitySelect(){

        return view('app.communityselect');
    }




    public function getTags($body){

        preg_match_all('/#(\w+)/', $body, $matches);

        $tags = array();

        for ($i = 0; $i < count($matches[1]); $i++){

            $tag = $matches[1][$i];

            array_push($tags, $tag);
        }

        return $tags;

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function store(Request $request)
    {

        $rules = array(
            'body' => 'required|min:3|max:255',
            'image' => 'image'
        );

        $validator = Validator::make(Input::all(), $rules);

        // Validate the input and return correct response
        if ($validator->fails()){
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        $user = Auth::user()->id;
        $communityid = PersonalInformation::where('user_id', $user)->value('community_id');

        $post = Community_Post::create([
            'body' => $request->input('body'),
            'user_id' => $user,
            'community_id' => $communityid

        ]);

        $tags = $this->getTags($request->input('body'));

        foreach($tags as $tag){
            $post->tags()->create([
                'name' => $tag
            ]);
        }


        if ($request->hasFile('image')){
            $image = $request->file('image');
            if ($image->isValid()){
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move('img/community_posts/', $filename);
                $user = Auth::user()->id;
                $communityid = PersonalInformation::where('user_id', $user)->value('community_id');
                Image::create([
                    'filename' => $filename,
                    'community_id' => $post->community_id,
                    'imageable_type' => 'App\Community_Post',
                    'imageable_id' => $post->id,
                ]);


            }
        }




        return Response::json(array(
            'success' => true,
        )); // 400 being the HTTP code for an invalid request.

    }

    public function getComunityTimeline(){

        $posts = Community_Post::all();

        return view('app.community', ['posts' => $posts ]);
    }



    public function CommunityLikePost(){

        Like::create([
            'user_id'       => Auth::id(),
            'likeable_id'   => 1,
            'likeable_type' => 'App\Community_Post',
        ]);

        if (Request::ajax()){


            $postId = Request::input('id');
            $post = Post::findOrFail($postId);
            $this->handleLike('App\Community_Post', $postId);

            if ($like = Like::whereLikeableType('App\Community_Post')->whereLikeableId($postId)->whereUserId(Auth::id())->first()){
                // notification for the like
                /*if ($post->user_id !== Auth::user()->id){

                    if (!Notification::where('user_id', $post->user_id)->where('from', Auth::user()->id)->where('notification_type', 'App\Like')->where('seen', 0)->first()){
                        $like->notifications()->create([
                            'user_id' => $post->user_id,
                            'from' => Auth::user()->id
                        ]);
                    }

                }*/

                return 1;
            } else {
/*                Notification::where('user_id', $post->user_id)->where('from', Auth::user()->id)->where('notification_type', 'App\Like')->delete();*/

                return 0;
            }
        }
    }

    public function handleLike($type, $id){

        $existing_like = Like::whereLikeableType($type)->whereLikeableId($id)->whereUserId(Auth::id())->first();

        if (is_null($existing_like)) {
            Like::create([
                'user_id'       => Auth::id(),
                'likeable_id'   => $id,
                'likeable_type' => $type,
            ]);
        } else {
            Like::whereLikeableType($type)->whereLikeableId($id)->whereUserId(Auth::id())->delete();
        }

    }




    public function destroy($id)
    {

        $post = Community_Post::findOrFail($id);

        if ($post->user_id == Auth::user()->id){
            // DELETE POST AND STUFF
            /*$post->likes()->delete();
            $post->comments()->delete();
            $post->tags()->delete();*/
            $post->delete();
        }

        return redirect()->back();

    }

}
