<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Feedback extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasComments;

    protected $guarded = [];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    /*
     * This string will be used in notifications on what a new comment
     * was made.
    */
    public function commentableName(): string
    {
        return '';
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {
        return '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }
    public function upVote(): BelongsTo
    {
        return $this->belongsTo(Vote::class,'id','feedback_id')->where('vote',1);
    }
    public function downVote(): BelongsTo
    {
        return $this->belongsTo(Vote::class,'id','feedback_id')->where('vote',-1);
    }
}
