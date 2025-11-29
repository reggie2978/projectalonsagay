<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\SystemSettingModel;

class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = service('uri');
        $path = strtolower(trim($uri->getPath(), '/'));

        // Allow these routes even during maintenance
        $allowed = [
            'maintenance',                        // maintenance page itself
            'main/login',                         // admin login
            'auth/login',                         // in case using different route
            'systemsetting/togglemaintenance',    // allow admin toggle only
        ];

        // Allow admin pages also (Main/*)
        if (strpos($path, 'main') === 0) {
            return; // Admin panel always accessible
        }

        // Check maintenance mode
        $model = new SystemSettingModel();
        $setting = $model->first();

        if ($setting && intval($setting['maintenance_mode']) === 1) {

            // if NOT allowed, redirect to maintenance page
            if (!in_array($path, $allowed, true)) {
                return redirect()->to('/maintenance');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}
