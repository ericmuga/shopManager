<?php

namespace App\Traits;

use App\Services\SearchQueryService;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Http\Request;

namespace App\Traits;


trait Searchable
{
    /**
     * Apply search query to the model.
     *
     * @param Builder $queryBuilder
     * @param Request $request
     * @param array   $searchColumns
     * @param array   $strictColumns
     * @param array   $relatedModels
     * @param int     $rows
     * @param array   $withSum
     *
     * @return mixed
     */
    public function applySearchQuery(
        Builder $queryBuilder,
        Request $request,
        array $searchColumns,
        array $strictColumns = [],
        array $relatedModels = [],
        int $rows = 10,
        array $withSum = []
    ) {
        $rows = $request->rows ?: $rows;
        $searchParameter = $request->has('search') ? $request->search : '';

        $searchService = new SearchQueryService(
            $queryBuilder,
            $searchParameter,
            $searchColumns,
            $strictColumns,
            $relatedModels
        );

        $query = $searchService->search();

        if (!empty($withSum)) {
            $query->withSum($withSum);
        }

        return $query->paginate($rows);
    }
}
