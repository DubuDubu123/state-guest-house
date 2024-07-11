<?php

namespace App\Base\Filters\Admin;

use App\Base\Libraries\QueryFilter\FilterContract;

/**
 * Test filter to demonstrate the custom filter usage.
 * Delete later.
 */
class RequestCancellationFilter implements FilterContract
{
    /**
     * The available filters.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'is_paid','cancel_method',
        ];
    }

    /**
    * Default column to sort.
    *
    * @return string
    */
    public function defaultSort()
    {
        return '-created_at';
    }

   

   

    public function is_paid($builder, $value = 0)
    {
        $builder->where('is_paid', $value);
    }

    public function cancel_method($builder, $value = 0)
    {
        // dd($value);
        $builder->where('cancel_method', $value);
    }

   
}
