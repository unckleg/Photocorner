<div class="comments-block">
    <div class="col-md-8">
        <h3 class="block-heading">{{ t('Comments') }}</h3>
        {{ Form::open() }}
        <div class="form-group">
            {{ Form::textarea('comment','',['class'=>"form-control",'rows'=>2,'placeholder'=>t('Comment')]) }}
        </div>
        <div class="form-group">
            {{ Form::submit(t('Comment'),['class'=>'btn btn-info']) }}
        </div>
        {{ Form::close() }}

        @foreach($comments as $comment)
            <div class="media" id="comment-{{ $comment->id }}">
                <a class="pull-left" href="{{ route('user', ['user' => $comment->user->username]) }}">
                    <img class="media-object" src="{{ getAvatar($comment->user,75,75) }}" alt="{{{ $comment->user->fullname }}}" style="width: 64px; height: 64px;">
                </a>

                <div class="media-body">
                    <h4 class="media-heading"><a href="{{ route('user', ['user' => $comment->user->username]) }}">{{{ ucfirst($comment->user->fullname) }}}</a> <span class="pull-right">
                                @if(Auth::check() == true AND ($comment->user_id == Auth::user()->id || $image->user->id == Auth::user()->id))
                                <button data-content="{{ $comment->id }}" type="button" class="close delete-comment" aria-hidden="true">&times;</button>
                            @endif

                            <i class="comment-time fa fa-clock-o"></i> <abbr class="timeago comment-time" title="{{ $comment->created_at->toISO8601String() }}">{{ $comment->created_at->toISO8601String() }}</abbr> </span></h4>
                    <p>{{ Smilies::parse(e($comment->comment)) }}</p>

                    @if(Auth::check())
                        <a class="replybutton" id="box-{{ $comment->id }}">{{ t('Reply') }}</a>

                        <div class="commentReplyBox" id="openbox-{{ $comment->id }}">
                            <input type="hidden" name="pid" value="19">
                            {{ Form::textarea('comment','',['id'=>'textboxcontent'.$comment->id,'class'=>"form-control",'rows'=>2,'placeholder'=>t('Comment')]) }}
                            </br>
                            <button class="btn btn-info replyMainButton" id="{{ $comment->id }}">{{ t('Reply') }}</button>
                            <a class="closebutton" id="box-{{ $comment->id }}">{{ t('Cancel') }}</a>
                        </div>
                        <span class="reply-add-{{ $comment->id }}"></span>
                    @endif
                    @foreach($comment->reply as $reply)
                        <hr/>
                        <div class="media" id="reply-{{ $reply->id }}">
                            <a class="pull-left" href="{{ route('user', ['user' => $reply->user->username]) }}">
                                <img class="media-object" src="{{ getAvatar($reply->user,64,64) }}" alt="{{{ $reply->user->fullname }}}" style="width: 64px; height: 64px;">
                            </a>

                            <div class="media-body">
                                <h4 class="media-heading"><a href="{{ route('user', ['user' => $reply->user->username]) }}">{{{ ucfirst($reply->user->fullname) }}}</a> <span class="pull-right">
                                        @if(Auth::check() === true AND ($reply->user_id == Auth::user()->id || $image->id == Auth::user()->id || $reply->comment->user->id == Auth::user()->id))
                                            <span class="right"><button data-content="{{ $reply->id }}" type="button" class="close delete-reply" aria-hidden="true">&times;</button></span>
                                        @endif
                                        <i class="comment-time fa fa-clock-o"></i> <abbr class="timeago comment-time" title="{{ $reply->created_at->toISO8601String() }}">{{ $reply->created_at->toISO8601String() }}</abbr> </span></h4>
                                <p>{{ Smilies::parse(e($reply->reply)) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr/>
            </div>
        @endforeach

        <div class="row">
            {{ $comments->links() }}
        </div>
    </div>

    <!--.col-md-8-->
</div>