<?php

namespace App\Http\Controllers;

use App\Actions\StoreDownVoteAction;
use App\Actions\StoreFeedbackCommentAction;
use App\Actions\StoreUpvoteAction;
use App\Http\Queries\FeedbackIndexQuery;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function index()
    {
        $query = new FeedbackIndexQuery();

        return inertia('Dashboard', [
            'feedback' => $query->withCount(['upVote', 'downVote'])->paginate(),
        ]);
    }

    public function create()
    {

        return inertia('Feedback/CreateFeedback');
    }

    public function store(Request $request)
    {
        $feedback = Feedback::create($this->validateRule() + ['user_id' => auth()->user()->id]);

        if ($request->image) {
            $feedback
                ->addMedia($request->image)
                ->toMediaCollection();
        }
        return redirect('/feedback')->with('message','feedback stored successfully');

    }

    public function show($id)
    {

        $feedback = Feedback::with(['comments.commentator', 'media'])->withCount(['upVote', 'downVote'])->findOrFail($id);
//        dd($feedback->media[0]->original_url);
        return inertia('Feedback/Item', ['feedback' => $feedback, 'users' => User::selectRaw('id,name as display')->get()]);
    }

    public function upvote($id, StoreUpvoteAction $storeUpvoteAction)
    {
        $storeUpvoteAction->excecute($id);
        return redirect()->back();
    }

    public function downvote($id, StoreDownVoteAction $storeDownVoteAction)
    {
        $storeDownVoteAction->excecute($id);
        return redirect()->back();
    }

    public function comment(Feedback $feedback, Request $request, StoreFeedbackCommentAction $commentAction)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);
        $commentAction->excecute($feedback, $request);
        return redirect()->back();
    }


    protected function validateRule(?Feedback $feedback = null)
    {
        $feedback ??= new Feedback();

        return request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:bug,feature,improvement,other',
        ]);
    }
}
