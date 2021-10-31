<?php

namespace App\Repositories\Contracts;

interface IChat extends IBase
{
    public function createParticipants(string $chatId, array $data);

    public function getUserChats(string $userId);
}
