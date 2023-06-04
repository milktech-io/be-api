<?php

namespace App\Services;

use App\Models\Skill;
use App\Repositories\SkillRepository;

class SkillService
{
    public function query($data)
    {
        return (new SkillRepository)->query(Skill::class, $data, function ($query) {
            return $query;
        });
    }
}
