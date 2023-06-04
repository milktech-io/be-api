<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository
{

    public function getAllModules()
    {
        $modules = Module::orderBy('modules.order', 'DESC')->get();

        return ok('', $modules);
    }


}
