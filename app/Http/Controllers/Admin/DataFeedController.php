<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataFeed;

class DataFeedController extends Controller
{
    /**
     * @param Request $request
     * @param mixed $type
     * @return mixed
     */
    public function getDataFeed(Request $request, $type)
    {
        $df = new DataFeed();

        return (object)[
            'labels' => $df->getDataFeed(
                $type,
                'label',
                $request->limit
            ),
            'data' => $df->getDataFeed(
                $type,
                'data',
                $request->limit
            ),
        ];
    }
}
