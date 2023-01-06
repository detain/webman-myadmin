<?php
/**
* This file is part of webman.
*
* Licensed under The MIT License
* For full copyright and license information, please see the MIT-LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @author    walkor<walkor@workerman.net>
* @copyright walkor<walkor@workerman.net>
* @link      http://www.workerman.net/
* @license   http://www.opensource.org/licenses/mit-license.php MIT License
*/

return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'driver'      => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset'     => 'utf8',
            'collation'   => 'utf8_unicode_ci',
            'prefix'      => '',
            'strict'      => true,
            'engine'      => null,
        ],
        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('MONGO_HOSTNAME', '127.0.0.1'),
            'database' => env('MONGO_DATABASE', null),
            'username' => env('MONGO_USERNAME', null),
            'password' => env('MONGO_PASSWORD', null),
            'port'     =>  27017,
            'options' => [
                // here you can pass more settings to the Mongo Driver Manager
                // see https://www.php.net/manual/en/mongodb-driver-manager.construct.php under "Uri Options" for a list of complete parameters that you can use

                'database' => 'admin', // required with Mongo 3+
            ],
        ],
    ]
];
