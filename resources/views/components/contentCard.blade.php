<content-card 
    username="{{$link->user->username}}"
    fullname="{{$link->user->fullname}}"
    avatar_url="{{getAvatar($link->user)}}"
    owner="{{$link->owner}}"
    published_diff="{{$link->published_diff}}"
    url="{{$link->url}}"
    title="{{$link->title}}"
    body="{{$link->body}}"
    thumbnail="{{$link->thumbnail}}"
    media="{{$link->media}}"
></content-card>