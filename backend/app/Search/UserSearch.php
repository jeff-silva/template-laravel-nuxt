<?php

namespace App\Search;

use Illuminate\Contracts\Database\Eloquent\Builder;

class UserSearch
{
    public function params()
    {
        return [
            'group_id' => null,
        ];
    }

    public function rules($query, $params)
    {
        if ($params->group_id) {
            //
        }

        return $query;
    }
}
