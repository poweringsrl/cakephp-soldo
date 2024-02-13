<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Cache\Cache;
use Cake\Core\Plugin;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}

if (!defined('TMP')) {
    define('TMP', ROOT . DS . 'tmp' . DS);
}

if (!defined('CACHE')) {
    define('CACHE', TMP . 'cache' . DS);
}

if (!defined('SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY')) {
    define('SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY', 'soldo_access_token');
}

Plugin::load('Muffin/Webservice', ['bootstrap' => true]);

if (Cache::getConfig(SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY)) {
    Cache::drop(SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY);
}

Cache::setConfig(SOLDO_ACCESS_TOKEN_CACHE_CONFIG_KEY, [
    'className' => 'File',
    'duration' => '+7200 seconds',
    'path' => CACHE,
]);
