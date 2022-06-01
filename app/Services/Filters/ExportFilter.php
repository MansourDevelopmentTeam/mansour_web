<?php


namespace App\Services\Filters;


use App\Http\Resources\ExportFileResource;
use App\Models\Export\Export;

class ExportFilter
{
    public function filter()
    {
        $query = Export::query();
        if (request()->has('date_to') && !empty(request()->get('date_to'))){
            $query->whereDate('created_at', '>=' ,request('date_to'));
        }
        if (request()->has('date_from') && !empty(request()->get('date_from'))){
            $query->whereDate('created_at', '<=' ,request('date_from'));
        }
        if (request()->has('date_from') && request()->has('date_to')
            && !empty(request()->get('date_from')) && !empty(request()->get('date_to'))){

            $query->whereDate('created_at', '<=' ,request('date_from'))
                ->whereDate('created_at', '>=' ,request('date_to'));
        }

        if (request()->has('type') && !empty(request()->get('type'))){
            $query->where('type', request('type'));
        }

        if (request()->has('state') && !empty(request()->get('state'))){
            $query->where('state', request('state'));
        }
        $filter = $query->paginate(10);
        if ($filter->count()){
            $results['items'] = ExportFileResource::collection($filter);
            $results['total'] = $filter->total();
            $results['pages'] = $filter->lastPage();
            return $results;
        }
        return null;
    }
}
