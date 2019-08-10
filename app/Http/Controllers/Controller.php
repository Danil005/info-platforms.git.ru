<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiMessagesCantFwdException;
use VK\Exceptions\Api\VKApiMessagesChatBotFeatureException;
use VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException;
use VK\Exceptions\Api\VKApiMessagesContactNotFoundException;
use VK\Exceptions\Api\VKApiMessagesDenySendException;
use VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException;
use VK\Exceptions\Api\VKApiMessagesPrivacyException;
use VK\Exceptions\Api\VKApiMessagesTooLongForwardsException;
use VK\Exceptions\Api\VKApiMessagesTooLongMessageException;
use VK\Exceptions\Api\VKApiMessagesTooManyPostsException;
use VK\Exceptions\Api\VKApiMessagesUserBlockedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected const API_TOKEN = "2f9e3f92aff9937f2c2814c0820e336dd9e322fadc8d48646d67ef4f74f8b856ca0267959b60c35e0f9fd";

    protected $mainMenuKeyboard = [
        'one_time' => false,
        'buttons' => [
            [
                [
                    'action' => [
                        'type' => 'text',
                        'payload' => '{"button": "goToCabinet"}',
                        'label' => '🏡 Личный кабинет',
                    ],
                    'color' => 'default',
                ],
            ],
        ],
    ];

    protected function send(int $id, string $message, array $params = [])
    {
        $vk = new VKApiClient();
        $data = array_merge($params, [
            'user_id' => $id,
            'message' => $message,
            'random_id' => rand(0, 10000000000)
        ]);
        $vk->messages()->send(self::API_TOKEN, $data);
    }
}
