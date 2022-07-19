<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'photo_download', 'add_mini_calibration', 'mini_calibration_list_view', 'download_specification', 'mini/download_validation','interface/upload','/interface/download','/configuration/serv_datetitme','/generate_raport','/get_minis_by_connector','/login','/add_odl','/add_odl_view','/odl_report'

    ];
}
