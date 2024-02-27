<?php

namespace App\Search;

use Illuminate\Contracts\Database\Eloquent\Builder;

class Search
{
    public function __construct(
        protected Builder $query,
    ) {}

    public function params()
    {
        return [];
    }

    public function rules($query, $params)
    {
        return [];
    }

    public function query()
    {
        return $this->query;
    }
}
