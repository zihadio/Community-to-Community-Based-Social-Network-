@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row timeline">
            <div class="col-md-3">
                <div class="col-md-12 profile followUser">
                    <div class="profile-img text-center">
                        <a href="{{ route('profile.view', ['id' => Auth::user()->id]) }}">
                            <img src="{{ Auth::user()->getAvatarImagePath() }}" height="100px" class="img-circle">
                        </a>
                        <p>{{ Auth::user()->getFullName() }}</p>
                    </div>
                    @include('layouts.menu_links')
                </div>
            </div> <!-- profile -->
            <div class="col-md-6 feed">
                {!! Form::open(['id' => 'PostForm', 'method' => 'POST', 'action' => 'PostsController@store', 'files' => 'true']) !!}
                {!! Form::textarea('body', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => "What's on your mind?", 'rows' => '2']) !!}

                <div class="textareaOptions">
                    <li id="PostImageUploadBtn" class="pointer"><i class="fa fa-lg fa-camera-retro" aria-hidden="true"></i></li>
                    <input type="file" id="image" name="image" style="display:none" />
                    {{ Form::button('<i class="fa fa-location-arrow" aria-hidden="true"></i> Post', array('class'=>'btn btn-signature pull-right', 'type'=>'submit')) }}
                </div>
                <div class="progress" style="display: none">
                    <div id="PostProgressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <span class="help-block" id="PostErrors" style="display: none;">
				</span>
                {!! Form::close() !!}

                @if (Auth::user()->getTimeline()->count())
                    <div class="posts">
                        @foreach (Auth::user()->getTimeline() as $post)
                            @include('layouts.posts')
                        @endforeach
                    </div>
                @endif
            </div> <!-- news feed -->










            </div>
        </div>
    </div>

@stop