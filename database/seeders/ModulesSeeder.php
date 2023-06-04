<?php

namespace Database\Seeders;

use App\Models\Module;
use DB;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private function getNextOrder()
    {
        $module = Module::all()->map(function ($m) {
            $m->order = intval($m->order);

            return $m;
        })->sortByDesc('order')->first() ?? false;

        return $module ? $module->order + 1 : 1;
    }

    public function run()
    {
        DB::table('modules')->delete();

        Module::create([
            'title' => 'Inicio',
            'route' => '/inicio',
            'permissions' => json_encode(['administracion', 'soporte']),
            'icon' => 'columns',
            'order' => '1',
        ]);

        Module::create([
            'title' => 'Usuarios',
            'route' => '/Usuarios',
            'permissions' => json_encode(['administracion', 'soporte']),
            'icon' => 'id-card',
            'order' => $this->getNextOrder(),
        ]);

 
        Module::create([
            'title' => 'Ventas',
            'route' => '/ventas',
            'permissions' => json_encode(['administracion', 'soporte']),
            'icon' => 'credit-card',
            'order' => $this->getNextOrder(),
        ]);

        Module::create([
            'title' => 'Productos',
            'route' => '/productos',
            'permissions' => json_encode(['administracion']),
            'icon' => 'store',
            'order' => $this->getNextOrder(),
        ]);

        Module::create([
            'title' => 'Traducciones   ',
            'route' => '/traducciones',
            'permissions' => json_encode(['administracion', 'soporte']),
            'icon' => 'language',
            'order' => $this->getNextOrder(),
        ]);
        
        Module::create([
            'title' => 'Roles',
            'route' => '/roles',
            'icon' => 'user-tie',
            'order' => $this->getNextOrder(),
            'permissions' => json_encode(['administracion', 'soporte']),
        ]);

        Module::create([
            'title' => 'Comunidad',
            'route' => '/comunidad',
            'icon' => 'globe',
            'order' => $this->getNextOrder(),
            'permissions' => json_encode(['administracion', 'soporte']),
        ]);
    }
}
