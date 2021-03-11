#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application; // Symfony Console 组件

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1)); // 定义项目根目录

require BASE_PATH . '/vendor/autoload.php'; // 通过composer完成类自动加载

$application = new Application();

$application->add(new \Xxm\Command\FirstCommand()); // 注册命令

$application->run();
