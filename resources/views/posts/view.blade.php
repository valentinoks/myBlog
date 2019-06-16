@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        
            <div class="card">
                <div class="card-header">View Post</div>
                <div class="card-body">                    

                    @if (count($posts) > 0)
                        @foreach  ($posts->all() as $post)
                            <h4>{{$post->post_title}}</h4>
                            <img src="{{ $post->post_image }}" alt="">
                             <p>{{ ($post->post_body) }}</p>

                             <cite style="float:left;">Posted on: {{date('M j, Y H:i', strtotime($post->
                             updated_at))}}</cite>

                             <ul class="nav nav-pills">
                                <li role="presentation">
                                    <a href='{{ url("/like/{$post->id}") }}'>
                                        <span>COMMENT</span>
                                    </a>
                                </li>
                             </ul>
                        @endforeach
                    @else
                        <p>No Post Available! </p>
                    @endif

                    <form method="POST" action='{{ url("/comment/{$post->id}") }}'>
                        {{csrf_field()}}
                            <div class="form-group">
                                <textarea id="comment" rows="6" class="form-control" 
                                name="comment" required autofocus></textarea>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg btn-block">
                            POST COMMENT</button>
                            </div>
                    </form>

                    <h3>Comments</h3>
                        @if(count($comments) > 0)
                            @foreach($comments->all() as $comment)
                                <p>{{ $comment->comment }}</p>
                                <p>Posted by: {{ $comment->name }}</p>
                                <hr/>
                            @endforeach
                        @else
                        @endif
                </div>
                <div class="card-body">                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
