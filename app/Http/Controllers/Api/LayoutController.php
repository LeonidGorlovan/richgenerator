<?php

namespace App\Http\Controllers\Api;

use CfDigital\Delta\Core\Models\Setting;
use Illuminate\Routing\Controller;

class LayoutController extends Controller
{
    public function __invoke()
    {
        return [
            'settings' => Setting::query()->where('to_layout', 1)->pluck('value', 'key')
        ];
    }
}
