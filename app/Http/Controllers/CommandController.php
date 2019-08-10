<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use VK\Client\VKApiClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class CommandController extends Controller
{

    protected $vk;

    protected $object;
    protected $secret;
    protected $group_id;

    protected $message;
    protected $id;
    protected $peer_id;
    protected $payload;
    protected $attachments;


    public function __construct(int $group_id, ?string $secret, array $object)
    {
        $this->object = $object;
        $this->secret = $secret;
        $this->group_id = $group_id;
        $this->vk = new VKApiClient();
        $this->convertFromObject();
    }

    private function convertFromObject()
    {
        $this->message = (isset($this->object['text'])) ? $this->object['text'] : "";
        $this->id = (isset($this->object['from_id'])) ? $this->object['from_id'] : "";
        $this->peer_id = (isset($this->object['peer_id'])) ? $this->object['peer_id'] : "";
        $this->payload = (isset($this->object['payload'])) ? json_decode($this->object['payload'], true) : "";
        $this->attachments = (isset($this->object['attachments'])) ? $this->object['attachments'] : "";
    }

    public function execute()
    {
        switch ($this->message) {
//            case "🏡 Личный кабинет":
//                echo $this->send($this->id, 'Test');
//                break;
        }

        if (!empty($this->payload)) {
            foreach ($this->payload as $key => $value) {
                switch ($key) {
                    case "button":
                        $this->button($value);
                        break;
                }
            }
        }
    }

    private function button(string $command)
    {
        $user = DB::table('users')->where('user_id', $this->id)->first();

        switch ($command) {
            case "goToCabinet":
                $keyboard = [
                    'one_time' => false,
                    'buttons' => [
                        [
                            [
                                'action' => [
                                    'type' => 'text',
                                    'payload' => '{"button": "getUrlCabinet"}',
                                    'label' => 'Получить ссылку',
                                ],
                                'color' => 'positive',
                            ],
                            [
                                'action' => [
                                    'type' => 'text',
                                    'payload' => '{"button": "mainMenu"}',
                                    'label' => 'Главное меню',
                                ],
                                'color' => 'default',
                            ],
                        ],
                    ],
                ];
                $this->send($this->id,
                    "Добро пожаловать в личный кабинет!\n" .
                    "Имя: " . $user->first_name . "\n" .
                    "Фамилия: " . $user->last_name . "\n" .
                    "Ззвезды: " . $user->stars . "\n",
                    [
                        'keyboard' => json_encode($keyboard)
                    ]
                );
                break;
            case "getUrlCabinet":
                $url = $this->vk->utils()->getShortLink(self::API_TOKEN, [
                    'url' => env('BOT_WEBHOOK') . '/user/' . $user->access_id,
                ]);
                $this->send($this->id, "Ваш личный кабинет: \n". $url['short_url']);
                break;

            case "mainMenu":
                $this->send($this->id, "Вы перешли в главное меню.", [
                    'keyboard' => json_encode($this->mainMenuKeyboard)
                ]);
                break;
        }
    }
}
