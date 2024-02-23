<?php

namespace App\Traits;

use ReflectionClass;

trait ModelTrait
{
    public function classOrFallback($class, $fallback, $args = [])
    {
        $class = sprintf($class, class_basename(get_called_class()));
        $class = class_exists($class) ? $class : $fallback;
        return (new ReflectionClass($class))->newInstanceArgs($args);
    }

    public function scopeSearch($query)
    {
        $search = $this->classOrFallback('App\Search\%sSearch', 'App\Search\Search', [ $query ]);
        // return (new Search($query));
        return ['scopeSearch'];
    }

    public function scopeSearchPaginate($query)
    {
        //
    }
}
