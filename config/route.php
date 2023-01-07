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

use Webman\Route;

Route::get('/ping', function($request) {
    return response('Server is up and running', 200);
});
Route::options('/ping', function($request) {
    return response('Server is up and running', 200);
});
Route::get('/invoices', [app\controller\InvoicesController::class, 'index']);
Route::get('/invoices/{id:\d+}', [app\controller\InvoicesController::class, 'get']);
Route::get('/domains', [app\controller\DomainsController::class, 'index']);
//Route::get('/domains/{id:\d+}', [app\controller\DomainsController::class, 'get']);
Route::get('/vps', [app\controller\VpsController::class, 'index']);
//Route::get('/vps/{id:\d+}', [app\controller\VpsController::class, 'get']);
Route::get('/backups', [app\controller\BackupsController::class, 'index']);
//Route::get('/backups/{id:\d+}', [app\controller\BackupsController::class, 'get']);
Route::get('/mail', [app\controller\MailController::class, 'index']);
//Route::get('/mail/{id:\d+}', [app\controller\MailController::class, 'get']);
Route::get('/licenses', [app\controller\LicensesController::class, 'index']);
//Route::get('/licenses/{id:\d+}', [app\controller\LicensesController::class, 'get']);
Route::get('/ssl', [app\controller\SslController::class, 'index']);
//Route::get('/ssl/{id:\d+}', [app\controller\SslController::class, 'get']);
Route::get('/webhosting', [app\controller\WebhostingController::class, 'index']);
//Route::get('/webhosting/{id:\d+}', [app\controller\WebhostingController::class, 'get']);
Route::get('/quickservers', [app\controller\QuickserversController::class, 'index']);
//Route::get('/quickservers/{id:\d+}', [app\controller\QuickserversController::class, 'get']);
Route::get('/servers', [app\controller\ServersController::class, 'index']);
//Route::get('/servers/{id:\d+}', [app\controller\ServersController::class, 'get']);
/*Route::group('/mail', function() {
    Route::any('', [app\controller\Mail::class, 'index']);
    Route::any('/send', [app\controller\Mail::class, 'send']);
    Route::any('/advsend', [app\controller\Mail::class, 'advsend']);
    Route::any('/log', [app\controller\Mail::class, 'log']);

})->middleware([
    app\middleware\AuthCheck::class
]);*/
// Set cross domain for all OPTIONS requests
/*Route::options('[{path:.+}]', function (){
    return response('');
});*/
Route::disableDefaultRoute();


