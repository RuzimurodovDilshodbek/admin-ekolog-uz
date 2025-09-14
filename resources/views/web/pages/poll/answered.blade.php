@if($poll->type == "checkbox")
    <ul class="nav" data-ajax-content="inner">
        <li class="title">
            <h3 class="h4">{{$poll->title}}</h3>
        </li>

        <li class="options">
            <form action="#" class="poll-form">

                <input type="hidden" name="poll_id" value="{{$poll->id}}">
                @foreach($poll->variants as $variant)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   @if($poll->isVoted()) disabled @endif
                                   @if($variant->isChecked()) checked
                                   @endif name="selectedVariant[]"
                                   value="{{$variant->id}}">
                            <span>{{$variant->title}}</span>
                        </label>
                        @if($poll->isVoted())
                            <p>{{$variant->votedCount()}}%<span
                                    style="width: {{$variant->votedCount()}}%;"></span></p>
                        @endif
                    </div>
                @endforeach

                <button type="button"
                        class="@if($poll->isVoted()) disabled @endif btn btn-primary @if(!$poll->isVoted()) send-button @endif">{{__("Ovoz berish")}}</button>
            </form>
        </li>
    </ul>

@else
    <ul class="nav" data-ajax-content="inner">
        <li class="title">
            <h3 class="h4">{{$poll->title}}</h3>
        </li>

        <li class="options">
            <form action="#" class="poll-form">
                <input type="hidden" name="poll_id" value="{{$poll->id}}">
                @foreach($poll->variants as $variant)
                    <div class="radio">
                        <label>
                            <input type="radio" @if($poll->isVoted()) disabled @endif @if($variant->isChecked()) checked @endif name="selectedVariant"
                                   value="{{$variant->id}}">
                            <span>{{$variant->title}}</span>
                        </label>

                        @if($poll->isVoted())
                            <p>{{$variant->votedCount()}}%<span
                                    style="width: {{$variant->votedCount()}}%;"></span></p>
                        @endif

                    </div>
                @endforeach
                <button type="button"
                        class="@if($poll->isVoted()) disabled @endif btn btn-primary @if(!$poll->isVoted()) send-button @endif">{{__("home.Овоз бериш")}}</button>
            </form>
        </li>
    </ul>
@endif
