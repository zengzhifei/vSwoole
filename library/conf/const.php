<?php
// +----------------------------------------------------------------------+
// | VSwoole FrameWork                                                    |
// +----------------------------------------------------------------------+
// | Not Decline To Shoulder a Responsibility                             |
// +----------------------------------------------------------------------+
// | zengzhifei@outlook.com                                               |                  
// +----------------------------------------------------------------------+

//框架应用根目录
defined('VSWOOLE_APP_PATH') or define('VSWOOLE_APP_PATH', VSWOOLE_ROOT . 'application/');
//框架应用服务端目录
defined('VSWOOLE_APP_SERVER_PATH') or define('VSWOOLE_APP_SERVER_PATH', VSWOOLE_APP_PATH . 'server/');
//框架应用客户端目录
defined('VSWOOLE_APP_CLIENT_PATH') or define('VSWOOLE_APP_CLIENT_PATH', VSWOOLE_APP_PATH . 'client/');

//框架配置根目录
defined('VSWOOLE_CONFIG_PATH') or define('VSWOOLE_CONFIG_PATH', VSWOOLE_ROOT . 'configs/');

//框架数据根目录
defined('VSWOOLE_DATA_PATH') or define('VSWOOLE_DATA_PATH', VSWOOLE_ROOT . 'data/');
//框架数据服务进程目录
defined('VSWOOLE_DATA_PID_PATH') or define('VSWOOLE_DATA_PID_PATH', VSWOOLE_DATA_PATH . 'pid/');
//框架文件缓存目录
defined('VSWOOLE_DATA_CACHE_PATH') or define('VSWOOLE_DATA_CACHE_PATH', VSWOOLE_DATA_PATH . 'cache/');

//框架核心根目录
defined('VSWOOLE_LIB_PATH') or define('VSWOOLE_LIB_PATH', VSWOOLE_ROOT . 'library/');
//框架核心配置目录
defined('VSWOOLE_LIB_CONF_PATH') or define('VSWOOLE_LIB_CONF_PATH', VSWOOLE_LIB_PATH . 'conf/');
//框架核心工具目录
defined('VSWOOLE_LIB_COMMON_PATH') or define('VSWOOLE_LIB_COMMON_PATH', VSWOOLE_LIB_PATH . 'common/');
//框架核心客户端目录
defined('VSWOOLE_LIB_CLIENT_PATH') or define('VSWOOLE_LIB_CLIENT_PATH', VSWOOLE_LIB_PATH . 'client/');
//框架核心服务端目录
defined('VSWOOLE_LIB_SERVER_PATH') or define('VSWOOLE_LIB_SERVER_PATH', VSWOOLE_LIB_PATH . 'server/');

//框架日志根目录
defined('VSWOOLE_LOG_PATH') or define('VSWOOLE_LOG_PATH', VSWOOLE_ROOT . 'log/');
//框架日志客户端目录
defined('VSWOOLE_LOG_CLIENT_PATH') or define('VSWOOLE_LOG_CLIENT_PATH', VSWOOLE_LOG_PATH . 'client/');
//框架日志服务端目录
defined('VSWOOLE_LOG_SERVER_PATH') or define('VSWOOLE_LOG_SERVER_PATH', VSWOOLE_LOG_PATH . 'server/');

//框架公共根目录
defined('VSWOOLE_PUBLIC_PATH') or define('VSWOOLE_PUBLIC_PATH', VSWOOLE_ROOT . 'public/');
//框架静态文件目录
defined('VSWOOLE_PUBLIC_STATIC_PATH') or define('VSWOOLE_PUBLIC_STATIC_PATH', VSWOOLE_PUBLIC_PATH . 'static/');

//服务器
defined('VSWOOLE_SERVER') or define('VSWOOLE_SERVER', 1);
//客户端
defined('VSWOOLE_CLIENT') or define('VSWOOLE_CLIENT', 2);
//Http服务
defined('VSWOOLE_HTTP_SERVER') or define('VSWOOLE_HTTP_SERVER', 'Swoole_Http_Server');
//UDP服务
defined('VSWOOLE_UDP_SERVER') or define('VSWOOLE_UDP_SERVER', 'Swoole_Udp_Server');
//WebSocket服务
defined('VSWOOLE_WEB_SOCKET_SERVER') or define('VSWOOLE_WEB_SOCKET_SERVER', 'Swoole_WebSocket_Server');
//Timer服务
defined('VSWOOLE_TIMER_SERVER') or define('VSWOOLE_TIMER_SERVER', 'Swoole_Timer_Server');

//根命名空间
defined('VSWOOLE_NAMESPACE') or define('VSWOOLE_NAMESPACE', 'vSwoole');
//服务端命名空间
defined('VSWOOLE_APP_SERVER_NAMESPACE') or define('VSWOOLE_APP_SERVER_NAMESPACE', 'vSwoole\application\server');
//客户端命名空间
defined('VSWOOLE_APP_CLIENT_NAMESPACE') or define('VSWOOLE_APP_CLIENT_NAMESPACE', 'vSwoole\application\client');

//类文件扩展名
defined('VSWOOLE_CLASS_EXT') or define('VSWOOLE_CLASS_EXT', '.php');
//配置文件扩展名
defined('VSWOOLE_CONFIG_EXT') or define('VSWOOLE_CONFIG_EXT', '.php');
//进程号文件扩展名
defined('VSWOOLE_PID_EXT') or define('VSWOOLE_PID_EXT', '.pid');
//缓存文件扩展名
defined('VSWOOLE_CACHE_FILE_EXT') or define('VSWOOLE_CACHE_FILE_EXT', '.php');
//日志文件扩展名
defined('VSWOOLE_LOG_EXT') or define('VSWOOLE_LOG_EXT', '.log');

//运行模式
defined('VSWOOLE_IS_CLI') or define('VSWOOLE_IS_CLI', php_sapi_name() === 'cli' ? true : false);
//路由
defined('VSWOOLE_VAR_URL') or define('VSWOOLE_VAR_URL', 's');

