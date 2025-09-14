@foreach($posts as $post)
    <li>
        <!-- Post Item Start -->
        <div class="post--item post--layout-3">
            <div class="post--img">
                    <a href="{{$post->detailUrl}}" class="thumb"><img
                            src="{{$post->detail_image?->card}}" alt=""></a>

                <div class="post--info">
                    <ul class="nav meta">
                        <li><a href="#"><i class="fa fm fa-calendar"></i>{{$post->date}}</a></li>
                    </ul>

                    <div class="title">
                        <h3 class="h4"><a href="{{$post->detailUrl}}" class="btn-link">{{$post->title}}</a></h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Post Item End -->
    </li>
@endforeach
