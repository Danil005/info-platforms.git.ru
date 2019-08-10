<?php

namespace App;


use App\Http\Controllers\CommandController;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;

class ServerHandler extends VKCallbackApiServerHandler
{
    const SECRET = '1123151sfafasf1234';
    const GROUP_ID = 170419631;
    const CONFIRMATION_TOKEN = '262d47ed';

    function confirmation(int $group_id, ?string $secret) {
        if ($secret === static::SECRET && $group_id === static::GROUP_ID) {
            echo static::CONFIRMATION_TOKEN;
        }
    }

    public function messageNew(int $group_id, ?string $secret, array $object) {
        $command = new CommandController($group_id, $secret, $object);

        $command->execute();
        echo 'ok';
    }
}
