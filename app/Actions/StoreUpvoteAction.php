<?php
namespace App\Actions;

use App\Models\Feedback;
use App\Models\Vote;
use App\Services\ExchangeRates\Api;
use App\Services\ExchangeRates\Models\BufferRate;
use App\Services\ExchangeRates\Models\ExchangeRate;

use Illuminate\Support\Facades\Config;
use PhpParser\Node\Expr\Cast\Double;

class StoreUpvoteAction
{


    public function excecute($id)
    {
        // Check if the user has already voted on this feedback
        $vote = Vote::where('user_id', auth()->id())
            ->where('feedback_id', $id)
            ->first();

        if ($vote) {
            // Update the existing vote
            $vote->update(['vote' => 1]);
        } else {
            // Create a new vote
            Vote::create([
                'user_id' => auth()->id(),
                'feedback_id' => $id,
                'vote' => 1,
            ]);
        }
        // Update the vote count in the feedback table
        $feedback = Feedback::find($id);
        $feedback->votes = $feedback->votes + 1;
        return $feedback->save();
    }


}
