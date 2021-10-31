<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat\Message;
use App\Repositories\Contracts\IMessage;

class MessageRepository extends BaseRepository implements IMessage
{
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }
}