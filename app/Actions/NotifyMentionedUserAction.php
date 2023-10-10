<?php
namespace App\Actions;

use App\Events\UserMentionEvent;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Vote;
use App\Notifications\UserMentionNotification;
use App\Services\ExchangeRates\Api;
use App\Services\ExchangeRates\Models\BufferRate;
use App\Services\ExchangeRates\Models\ExchangeRate;

class NotifyMentionedUserAction
{

    public function excecute(string $content,array|null $mentions): void
    {
//        preg_match_all('/<a[^>]*\sdata-id="([^"]*)"[^>]*>/', $content, $matches);
//
//        $mentionedUsers = $matches[1];
//
//        foreach ($mentionedUsers as $id) {
//            $user = User::find($id);
//            if ($user) {
//                $user->notify(new UserMentionNotification());
//                broadcast(new UserMentionEvent($user))->toOthers();
//            }
//        }
        if(is_array($mentions) && count($mentions) > 0){
            foreach ($mentions as $user) {
                $user = User::find($user['id']);
                if ($user) {
                    $user->notify(new UserMentionNotification());
                    broadcast(new UserMentionEvent($user))->toOthers();
                }
            }
        }


    }


}
