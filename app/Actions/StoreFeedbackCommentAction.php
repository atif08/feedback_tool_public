<?php

namespace App\Actions;

use App\Events\NewCommentEvent;
use App\Models\Feedback;
use App\Notifications\NewCommentNotification;
use App\Services\ExchangeRates\Api;
use App\Services\ExchangeRates\Models\BufferRate;
use App\Services\ExchangeRates\Models\ExchangeRate;
use Illuminate\Http\Request;

class StoreFeedbackCommentAction
{
    public function __construct(private readonly NotifyMentionedUserAction $notifyMentionedUserAction)
    {
    }


    public function excecute(Feedback $feedback, Request $request)
    {
        $content = $request->input('content');
        $mentions = $request->input('mentions');

        $feedback->comment($content);

        $this->notifyMentionedUserAction->excecute($content,$mentions);

        $feedback->user->notify(new NewCommentNotification());

        broadcast(new NewCommentEvent($feedback->user))->toOthers();

        return $feedback;
    }
}
