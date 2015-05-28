#!/usr/bin/php -q
<?php
set_time_limit(0);

require("functions.php");
require("config.php");

while (true)
{
    $startTime = microtime(true);

    foreach ($sites as $site => $url)
    {
        $data = getRemoteData($url);

        list ($load) = explode(";", $data);
        saveLoad($load, $site);
    }
    $startEnd = microtime(true);

    sleep(60 - (int)($startEnd - $startTime));
}
