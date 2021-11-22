<?php
function user()
{
    $id = session()->get('id');
    if ($id != '') {
        $user = new \App\Models\User();
        $getuser = $user->asObject()->where('id', $id)->first();
        return $getuser;
    } else {
        return 'belum login';
    }
}
function Gdata()
{
    $data = [
        'ClientId' => '935030474584-ppg52lsgm2b3vmloph8okrbbdmu278b6.apps.googleusercontent.com',
        'ClientSecret' => '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'
    ];
    $obj = (object) $data;
    return $obj;
}
