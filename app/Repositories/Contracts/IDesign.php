<?php

namespace App\Repositories\Contracts;

use App\Models\Design;

interface IDesign extends IBase
{
    public function applyTags(Design $design, array $data);

    public function allLive();
}
