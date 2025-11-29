<?php

namespace App\Controllers;

use App\Models\SystemSettingModel;

class SystemSetting extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SystemSettingModel();
    }

    // Toggle maintenance on/off (GET link is fine here)
    public function toggleMaintenance()
    {
        $setting = $this->model->first();
        if (!$setting) {
            // If table empty, create one row
            $id = $this->model->insert(['maintenance_mode' => 1]);
            $newStatus = 1;
        } else {
            $newStatus = ($setting['maintenance_mode'] == 1) ? 0 : 1;
            $this->model->update($setting['id'], ['maintenance_mode' => $newStatus]);
        }

        $msg = $newStatus ? 'Maintenance mode enabled' : 'Maintenance mode disabled';
        return redirect()->back()->with('main_success', $msg);
    }

    // Render maintenance page
    public function maintenance()
    {
        return view('maintenance_view');
    }
}
