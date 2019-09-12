@extends('layouts.blog-post')



@section('content')



    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->photo ? $post->photo->file : null}}" alt="">

    <hr>

    <!-- Post Content -->

    <p>{!!$post->body!!}</p>

    <hr>


    @if(Session::has('comment_message'))

            {{session('comment_message')}}


       @endif

    <!-- Blog Comments -->


@if(Auth::check())

    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>


        {!! Form::open(['method'=>'POST', 'action'=> 'PostCommentsController@store']) !!}


              <input type="hidden" name="post_id" value="{{$post->id}}">


             <div class="form-group">
                 {!! Form::label('body', 'Body:') !!}
                 {!! Form::textarea('body', null, ['class'=>'form-control','rows'=>3])!!}
             </div>

             <div class="form-group">
                 {!! Form::submit('Submit comment', ['class'=>'btn btn-primary']) !!}
             </div>
        {!! Form::close() !!}


    </div>


@endif

    <hr>

    <!-- Posted Comments -->



@if(count($comments) > 0)


        @foreach($comments as $comment)

    <!-- Comment -->
    <div class="media">
        <a class="pull-left" href="#">
            <img height="64" class="media-object" src="{{Auth::user()->gravatar}}" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{{$comment->author}}
                <small>{{$comment->created_at->diffForHumans()}}</small>
            </h4>
            <p>{{$comment->body}}</p>



            @if(count($comment->replies) > 0)


                  @foreach($comment->replies as $reply)


                        @if($reply->is_active == 1)



                        <!-- Nested Comment -->
                        <div id="nested-comment" class=" media">
                            <a class="pull-left" href="#">
                                <img height="64" class="media-object" src="{{$reply->photo}}" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"{{$reply->author}}
                                    <small>{{$reply->created_at->diffForHumans()}}</small>
                                </h4>
                                <p>{{$reply->body}}</p>
                            </div>


                            <div class="comment-reply-container">


                                <button class="toggle-reply btn btn-primary pull-right">Reply</button>


                                <div class="comment-reply col-sm-6">


                                        {!! Form::open(['method'=>'POST', 'action'=> 'CommentRepliesController@createReply']) !!}
                                             <div class="form-group">

                                                 <input type="hidden" name="comment_id" value="{{$comment->id}}">

                                                 {!! Form::label('body', 'Body:') !!}
                                                 {!! Form::textarea('body', null, ['class'=>'form-control','rows'=>1])!!}
                                             </div>

                                             <div class="form-group">
                                                 {!! Form::submit('submit', ['class'=>'btn btn-primary']) !!}
                                             </div>
                                        {!! Form::close() !!}


                                </div>

                          </div>
            <!-- End Nested Comment -->


                    </div>

                             @else


                                 <h1 class="text-center">No Replies</h1>




                            @endif

                     @endforeach

            @endif






        </div>
    </div>

     @endforeach

@endif



@stop


@section('scripts')

    <script>

        $(".comment-reply-container .toggle-reply").click(function(){


            $(this).next().slideToggle("slow");




        });




    </script>



    {{--If you want to turn on disqus then use the code below and change the src of the script to reflect your disqus account name--}}



    {{--<div id="disqus_thread"></div>--}}
    {{--<script>--}}

        {{--/**--}}
         {{--*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.--}}
         {{--*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/--}}
        {{--/*--}}
         {{--var disqus_config = function () {--}}
         {{--this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable--}}
         {{--this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable--}}
         {{--};--}}
         {{--*/--}}
        {{--(function() { // DON'T EDIT BELOW THIS LINE--}}
            {{--var d = document, s = d.createElement('script');--}}
            {{--s.src = '//codehacking.disqus.com/embed.js';--}}
            {{--s.setAttribute('data-timestamp', +new Date());--}}
            {{--(d.head || d.body).appendChild(s);--}}
        {{--})();--}}
    {{--</script>--}}
    {{--<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>--}}

    {{--<script id="dsq-count-scr" src="//codehacking.disqus.com/count.js" async></script>--}}








@stop

