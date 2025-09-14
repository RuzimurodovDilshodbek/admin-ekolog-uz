<!-- Post Item Start -->
<div
    class="post--item post-list post--title-larger">
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-4 col-xxs-12">
            <div class="post--img">
                    <a href="{{$post->detailUrl}}" class="thumb"><img
                            src="{{$post->detail_image?->card}}" alt=""></a>
                <a href="#" class="cat">{{ count($post->sections) > 0 ? $post->sections[0]->title : ''}}</a>
            </div>
        </div>

        <div class="col-md-8 col-sm-12 col-xs-8 col-xxs-12">
            <div class="post--info">


                <div class="title">
                    <h3 class="h4"><a href="{{$post->detailUrl}}" class="btn-link">{{$post->title}}</a>
                    </h3>
                </div>
            </div>

            <div class="post--content">
                <p>{{strip_tags($post->description)}}</p>
{{--                <p>{{strip_tags(trim(substr($post->content,0,200)))}}</p>--}}
            </div>

            <div class="post--action" style="display: flex; justify-content: space-between">
                <div>
                    <a href="{{$post->detailUrl}}">{{__("home.Давомини ўқиш...")}}</a>
                </div>
                <div class="text-muted">
                    <span style="margin-right: 10px"><i class="fa fm fa-eye"></i>{{ $post->view_count }} </span>
                    <a href="#"><i class="fa fm fa-calendar"></i>{{date("d.m.Y H:i",strtotime($post->publish_date))}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Post Item End -->
