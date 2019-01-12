<?php
/**
 * Inline Games - Telegram Bot (@inlinegamesbot)
 *
 * (c) 2016-2019 Jack'lul <jacklulcat@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use jacklul\inlinegamesbot\BotCore;

/**
 * Handle webhook request only when it's a POST request
 */
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . ' /../vendor/autoload.php';

    try {
        $app = new BotCore();
        $app->run(true);
    } catch (\Throwable $e) {
        // Prevent Telegram from retrying
    }
} else {
    if ($_SERVER['REQUEST_URI'] === '/cron' && isset($_SERVER['HTTP_X_APPENGINE_CRON'])) {
        $_SERVER['argv'][1] = 'cron';

        require_once __DIR__ . ' /../vendor/autoload.php';

        /** @noinspection PhpUnhandledExceptionInspection */
        $app = new BotCore();
        /** @noinspection PhpUnhandledExceptionInspection */
        $app->run();
        exit;
    }

    header("Location: https://github.com/jacklul/inlinegamesbot");    // Redirect non-POST requests to Github repository
}
