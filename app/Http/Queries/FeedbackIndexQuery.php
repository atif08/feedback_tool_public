<?php

namespace App\Http\Queries;

use App\Models\Feedback;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FeedbackIndexQuery extends QueryBuilder
{
    public function __construct()
    {
        $query = Feedback::query()
            ->select('id', 'title', 'description','category','user_id','votes')->with(['user']);

        parent::__construct($query);

        $this->allowedFilters(
            AllowedFilter::partial('title'),
            AllowedFilter::partial('description'),
            AllowedFilter::exact('category'),
        )->allowedSorts('title','id','description','votes','category' );
    }
}
