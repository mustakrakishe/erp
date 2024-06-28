<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Customize the pagination information for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array $paginated
     * @param  array $default
     * @return array
     */
    public function paginationInformation($request, $paginated, $default)
    {
        return [
            'meta' => [
                'total'        => $paginated['total'],
                'from'         => $paginated['from'],
                'to'           => $paginated['to'],

                'per_page'     => $paginated['per_page'],

                'current_page' => $paginated['current_page'],
                'last_page'    => $paginated['last_page'],
            ],
        ];
    }
}
