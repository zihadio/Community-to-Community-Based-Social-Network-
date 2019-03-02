{{--{{ $community_id->name }}--}}
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
                {!! Form::open(['id' => 'PostForm', 'method' => 'POST', 'action' => 'CommunityController@store', 'files' => 'true']) !!}
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

                @if (Auth::user()->getCommunityTimeline()->count())
                    <div class="posts">
                        @foreach (Auth::user()->getCommunityTimeline() as $post)
                            @include('layouts.community_posts')
                        @endforeach
                    </div>
                @endif

            </div> <!-- news feed -->

            <div class="col-md-3 sidebar">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <font size="3">Community Name</font>

                    </div>
                    <div class="panel-body" style="font-size: 14px;">
                        <font size="6">{!!  $community_id->name  !!}</font>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {



            $(".smoothScroll").click(function(event){
                //prevent the default action for the click event
                event.preventDefault();

                //get the full url - like mysitecom/index.htm#home
                var full_url = this.href;

                //split the url by # and get the anchor target name - home in mysitecom/index.htm#home
                var parts = full_url.split("#");
                var trgt = parts[1];

                //get the top offset of the target anchor
                var target_offset = $("#"+trgt).offset();
                var target_top = target_offset.top;

                //goto that anchor by setting the body scroll top to anchor top
                $('html, body').animate({scrollTop:target_top}, 425);
            });

            $("#PostForm").on('submit', function(e){
                e.preventDefault();

                $form = $(this);

                var formData = new FormData($form[0]);

                var request = new XMLHttpRequest();

                request.upload.addEventListener('progress', function(e){

                    var percent = e.loaded/e.total * 100;
                    $('#PostProgressBar').parent().show();
                    $('#PostProgressBar').css('width', percent+'%').attr('aria-valuenow', percent);

                });

                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        var data = JSON.parse(request.responseText);
                        if (data.success){
                            location.reload();
                        } else {
                            var errorText = "";

                            if (data.errors.body){
                                errorText = data.errors.body + '<br>';
                            }
                            if (data.errors.image){
                                errorText += data.errors.image;
                            }

                            $("#PostErrors").show();
                            $("#PostErrors").html(errorText);
                        }
                    }
                }

                request.open('POST', "{{ route('community_posts.store') }}");
                request.send(formData);
                $("#PostForm")[0].reset();

            });






            $("#q").keypress(function (e) {
                if (e.which == 13) {
                    submitSearch();
                    return false;
                }
            });





            $("#PostImageUploadBtn").click(function () {
                $("#image").trigger('click');
            });

        });
    </script>


@append

