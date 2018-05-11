<?php
// +----------------------------------------------------------------------+
// | VSwoole FrameWork                                                    |
// +----------------------------------------------------------------------+
// | Not Decline To Shoulder a Responsibility                             |
// +----------------------------------------------------------------------+
// | zengzhifei@outlook.com                                               |                  
// +----------------------------------------------------------------------+

namespace vSwoole\application\server;


use vSwoole\application\server\logic\HttpLogic;
use vSwoole\library\common\Command;
use vSwoole\library\common\Config;
use vSwoole\library\common\Inotify;
use vSwoole\library\common\Process;
use vSwoole\library\server\HttpServer;

class Http extends HttpServer
{
    /**
     * 启动服务器
     * @param array $connectOptions
     * @param array $configOptions
     * @throws \ReflectionException
     */
    public function __construct(array $connectOptions = [], array $configOptions = [])
    {
        parent::__construct($connectOptions, $configOptions);
    }

    /**
     * 管理进程启动回调函数
     * @param \swoole_server $server
     */
    public function onManagerStart(\swoole_server $server)
    {
        parent::onManagerStart($server); // TODO: Change the autogenerated stub

        //DEBUG模式下，监听文件变化自动重启
        if (Config::loadConfig('config')->get('is_debug')) {
            Process::getInstance()->add(function () use ($server) {
                Inotify::getInstance()->watch([VSWOOLE_CONFIG_PATH, VSWOOLE_APP_SERVER_PATH . 'logic/HttpLogic.php'], function () use ($server) {
                    Command::getInstance($server)->reload();
                });
            });
        }
    }

    /**
     * 工作进程启动回调函数
     * @param \swoole_server $server
     * @param int $worker_id
     */
    public function onWorkerStart(\swoole_server $server, int $worker_id)
    {
        parent::onWorkerStart($server, $worker_id); // TODO: Change the autogenerated stub

        //引入Http服务器逻辑类
        $this->logic = new HttpLogic($server);
    }

    /**
     * 接收Http客户端请求回调函数
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     */
    public function onRequest(\swoole_http_request $request, \swoole_http_response $response)
    {
        parent::onRequest($request, $response); // TODO: Change the autogenerated stub

        $this->logic->execute($request, $response);
    }

    /**
     * 异步任务执行回调函数
     * @param \swoole_server $server
     * @param int $task_id
     * @param int $src_worker_id
     * @param $data
     */
    public function onTask(\swoole_server $server, int $task_id, int $src_worker_id, $data)
    {
        parent::onTask($server, $task_id, $src_worker_id, $data); // TODO: Change the autogenerated stub
    }

    /**
     * 异步任务执行完成回调函数
     * @param \swoole_server $server
     * @param int $task_id
     * @param $data
     */
    public function onFinish(\swoole_server $server, int $task_id, $data)
    {
        parent::onFinish($server, $task_id, $data); // TODO: Change the autogenerated stub
    }

}