<?php
function channel()
{
    $channel = new \App\Models\Channel();
    $getchannel = $channel->findAll();
    return $getchannel;
}

function channelactive()
{
    $channel = new \App\Models\Channel();
    $getchannel = $channel->where('status', 'aktif')->findAll();
    return $getchannel;
}
