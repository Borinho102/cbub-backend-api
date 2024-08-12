<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $type)
    {
        $filename = storage_path(sprintf('app/%s.txt', str()->replace('-', '_', $type)));
        $file = fopen($filename, 'r');
        $content = fread($file, filesize($filename));

        return response($content);
    }
}
