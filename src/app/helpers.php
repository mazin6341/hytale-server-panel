<?php

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

function paginateCollection(Collection $collection, $perPage = 15, $page = null, $options = []) {
    // Determine the current page
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

    // Slice the collection to get the items for the current page
    $currentPageItems = $collection->forPage($page, $perPage);

    // Create the paginator
    return new LengthAwarePaginator(
        $currentPageItems->values(),                    // Only the items for this page
        $collection->count(),                           // Total count of items
        $perPage,                                       // Items per page
        $page,                                          // Current page
        [
            'path' => Paginator::resolveCurrentPath(),  // Ensures links use the current URL
            'query' => request()->query(),              // Maintains search filters in links
        ] + $options
    );
}