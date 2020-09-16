<?php

// Any helper general function here

function checkOwnership($user_id)
{
    if(Auth::user()->id != $user_id)
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