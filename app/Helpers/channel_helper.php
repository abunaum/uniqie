<?php
function channel()
{   
    $channel = new \App\Models\Channel();
    $getchannel = $channel->findAll();
    return $getchannel;
}