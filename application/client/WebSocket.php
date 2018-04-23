<?php
// +----------------------------------------------------------------------+
// | VSwoole FrameWork                                                    |
// +----------------------------------------------------------------------+
// | Not Decline To Shoulder a Responsibility                             |
// +----------------------------------------------------------------------+
// | zengzhifei@outlook.com                                               |                  
// +----------------------------------------------------------------------+

namespace application\client;


use library\client\WebSocketClient;

class WebSocket extends WebSocketClient
{
    public function __construct(array $connectOptions = [], array $configOptions = [])
    {
        parent::__construct($connectOptions, $configOptions);
    }

    public function send()
    {
        var_dump(2222);
    }


}