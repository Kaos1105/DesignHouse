<?php

namespace App\Repositories\Contracts;

use App\Models\Design;

interface IDesign extends IBase
{
    public function applyTags(Design $design, array $data);

    public function addComment(Design $design, array $data);

    public function like(Design $design);

    public function isLikedByUser(Design $design);
}
