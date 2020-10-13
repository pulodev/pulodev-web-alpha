<?php

// Any helper general function here

function checkOwnership($user_id)
{
    //if not owner AND not admin
    if(Auth::user()->id != $user_id && !Auth::user()->isAdmin())
        abort(403);

    return;
}

function cutText($text, $max)
{
    return (strlen($text) > $max) ? substr($text, 0, $max) . '...' : $text;
}

function storageSrc($asset)
{
    return 'https://skspace.sgp1.cdn.digitaloceanspaces.com/webAssets/'.$asset;
}

function generateSlug($title, $object)
{
    $slug = Str::slug($title, '-');
    if($object::where('slug', $slug)->first() != null)
        $slug .= '-' . time();

    return $slug;
}

function getAvatar($user)
{
    return ($user->avatar_url == '')
        ? "https://ui-avatars.com/api/?background=0D8ABC&color=fff&rounded=true&size=100&name=" . $user->username
        : 'https://kodingclub.s3.ap-southeast-1.amazonaws.com/avatar/' . $user->avatar_url;
}

function isValidUrl($url)
{
    $neededKeys = ['scheme', 'host', 'path'];
    $parsedUrl = parse_url($url);

    $validKeys = array_filter($neededKeys, function($key) use ($parsedUrl){
        return array_key_exists($key, $parsedUrl);
    });

    return sizeof($neededKeys) === sizeof($validKeys);
}

function cleanUrl($url) 
{
    //remove question mark like utm_soruce etc...
    $parsedURL = parse_url($url);

    //For Youtube Only
    if(Str::contains($parsedURL['host'], 'youtube.com')){
        //exclude &feature and &t
        $url = preg_replace( '/&?feature=.+?(&|$)$/', '', $url );
        $url = preg_replace( '/&?t=.+?(&|$)$/', '', $url );

    }else if(Str::contains($parsedURL['host'], 'youtu.be')){
        
        $param  = str_replace("/","",$parsedURL['path']);
        $url    = "https://youtube.com/watch?v=" . $param;

    }else{
        $url = strtok($url, '?');
    }

    return $url;
}