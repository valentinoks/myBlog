@extends('layouts.app')
<style type="text/css">
    .avatar{
        border-radius: 100%;
        max-width: 100px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">                    
                    You Are Logged In!

                    @if (count($posts) > 0)
                        @foreach  ($posts->all() as $post)
                            <hr/>
                            <p>Posted by: {{ $post->name }}</p>
                            <h4>{{$post->post_title}}</h4>
                            <img src="{{ $post->post_image }}" alt="">
                             <p>{{ substr($post->post_body, 0, 150) }}</p>

                             <ul class="nav nav-pills">
                                <li role="presentation">
                                    <a href='{{ url("/view/{$post->id}") }}'>
                                        <span>VIEW</span>
                                    </a>
                                </li>
                                
                                <hr/>
                                
                           
                            
                                @if(Auth::id() == 1)
                                <li role="presentation">
                                    <a href='{{ url("/edit/{$post->id}") }}'>
                                        <span>EDIT</span>
                                    </a>
                                </li>
                                <hr/>
                                <li role="presentation">
                                    <a href='{{ url("/delete/{$post->id}") }}'>
                                        <span>DELETE</span>
                                    </a>
                                </li>
                                <hr/>
                                @endif
                            </ul>
                             
                        @endforeach
                    @else
                        <p>No Post Available! </p>
                    @endif

                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
