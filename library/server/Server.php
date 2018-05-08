<?php
// +----------------------------------------------------------------------+
// | VSwoole FrameWork                                                    |
// +----------------------------------------------------------------------+
// | Not Decline To Shoulder a Responsibility                             |
// +----------------------------------------------------------------------+
// | zengzhifei@outlook.com                                               |
// +----------------------------------------------------------------------+

namespace vSwoole\library\server;


use vSwoole\library\common\Log;
use vSwoole\library\common\Utils;

abstract class Server
{
    //服务对象
    protected $swoole;
    //服务逻辑对象
    protected $logic;
    //服务连接配置
    protected $connectOptions = [
        //服务类型
        'serverType'     => '',
        //监听IP
        'host'           => '0.0.0.0',
        //监听客户端端口
        'port'           => '',
        //服务进程运行模式
        'mode'           => SWOOLE_PROCESS,
        //服务Sock类型
        'sockType'       => SWOOLE_SOCK_TCP,
        //监听管理端IP
        'adminHost'      => '',
        //监听管理端端口
        'adminPort'      => '',
        //监听管理Sock类型
        'adminSockType'  => '',
        //监听其他客户端IP+端口
        'others'         => [],
        //监听其他客户端Sock类型
        'othersSockType' => '',
    ];
    //服务运行配置
    protected $configOptions = [
        //守护进程化
        'daemonize'                => true,
        //日志
        'log_file'                 => 'vSwoole.log',
        //工作进程数
        'worker_num'               => 4,
        //工作线程数
        'reactor_num'              => 2,
        //TASK进程数
        'task_worker_num'          => 4,
        //心跳检测最大时间间隔
        'heartbeat_check_interval' => 60,
        //连接最大闲置时间
        'heartbeat_idle_time'      => 600,
        //启用CPU亲和性设置
        'open_cpu_affinity'        => true,
        //debug模式
        'debug_mode'               => false,
    ];
    //服务回调事件列表
    protected $callbackEventList = [
        'Start',
        'Shutdown',
        'ManagerStart',
        'ManagerStop',
        'WorkerStart',
        'WorkerStop',
        'WorkerExit',
        'WorkerError',
        'Connect',
        'Receive',
        'Packet',
        'Close',
        'BufferFull',
        'BufferEmpty',
        'Task',
        'Finish',
        'PipeMessage'
    ];

    /**
     * 启动服务器
     * @param array $connectOptions
     * @param array $configOptions
     */
    public function __construct(array $connectOptions = [], array $configOptions = [])
    {
        //配置相关参数
        $this->connectOptions = array_merge($this->connectOptions, $connectOptions);
        $this->configOptions = array_merge($this->configOptions, $configOptions);

        // 实例化服务
        if (!empty($this->connectOptions)) {
            switch ($this->connectOptions['serverType']) {
                case VSWOOLE_WEB_SOCKET_SERVER:
                    $this->swoole = new \swoole_websocket_server($this->connectOptions['host'], $this->connectOptions['port'], $this->connectOptions['mode'], $this->connectOptions['sockType']);
                    array_push($this->callbackEventList, 'HandShake', 'Open', 'Message');
                    break;
                case VSWOOLE_HTTP_SERVER:
                    $this->swoole = new \swoole_http_server($this->connectOptions['host'], $this->connectOptions['port']);
                    array_push($this->callbackEventList, 'Request');
                    unset($this->callbackEventList[array_search('Connect', $this->callbackEventList)]);
                    unset($this->callbackEventList[array_search('Receive', $this->callbackEventList)]);
                    break;
                default:
                    $this->swoole = new \swoole_server($this->connectOptions['host'], $this->connectOptions['port'], $this->connectOptions['mode'], $this->connectOptions['sockType']);
                    break;
            }
        }

        // 设置服务参数
        if (!empty($this->configOptions)) {
            $cpu_cores = swoole_cpu_num();
            if ($cpu_cores) {
                if ($this->configOptions['worker_num'] < 1 || $this->configOptions['worker_num'] > (4 * $cpu_cores)) {
                    $this->configOptions['worker_num'] = 4 * $cpu_cores;
                }
                if ($this->configOptions['reactor_num'] < 1 || $this->configOptions['reactor_num'] > (2 * $cpu_cores)) {
                    $this->configOptions['reactor_num'] = 2 * $cpu_cores;
                }
                if ($this->configOptions['task_worker_num'] < 1 || $this->configOptions['task_worker_num'] > (4 * $cpu_cores)) {
                    $this->configOptions['task_worker_num'] = 4 * $cpu_cores;
                }
            }
            $this->swoole->set($this->configOptions);
        }

        // 设置服务回调事件
        if (!empty($this->callbackEventList)) {
            foreach ($this->callbackEventList as $event) {
                if (method_exists($this, 'on' . $event)) {
                    $this->swoole->on($event, [$this, 'on' . $event]);
                }
            }
        }

        //监听管理端IP+端口
        if ($this->connectOptions['adminHost'] && $this->connectOptions['adminPort']) {
            $this->swoole->addListener($this->connectOptions['adminHost'], $this->connectOptions['adminPort'], $this->connectOptions['adminSockType'] ? $this->connectOptions['adminSockType'] : $this->connectOptions['sockType']);
        }

        //监听其他客户端IP+端口
        if (is_array($this->connectOptions['others'])) {
            foreach ($this->connectOptions['others'] as $ip => $port) {
                $this->swoole->addListener($ip, $port, $this->connectOptions['othersSockType'] ? $this->connectOptions['othersSockType'] : $this->connectOptions['sockType']);
            }
        }

        //开启服务
        return $this->swoole->start();
    }

    /**
     * 展示服务启动信息
     */
    protected function startShowServerInfo()
    {
        $setting = $this->swoole->setting;
        $str = '';
        $str .= '+-----------------------------------------------------------------------------------------------------+' . PHP_EOL;
        $str .= '|' . $this->connectOptions['serverType'] . ' start ok. ' . date('Y-m-d H:i:s') . PHP_EOL;
        $str .= '+-----------------------------------------------------------------------------------------------------+' . PHP_EOL;
        $str .= '|' . 'IP: ' . Utils::getServerIp() . PHP_EOL;
        foreach ($setting as $option => $config) {
            $str .= '|' . $option . ': ' . (is_bool($config) ? ($config ? 'true' : 'false') : $config) . PHP_EOL;
        }
        $str .= '+-----------------------------------------------------------------------------------------------------+';
        Log::write($str, $setting['log_file']);
        if (!$setting['daemonize']) echo $str;
    }

    /**
     * 魔术方法
     * @param $method
     * @param $args
     */
    public function __call($method, $args)
    {
        call_user_func_array([$this->swoole, $method], $args);
    }
}