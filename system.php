<?php

date_default_timezone_set('Europe/Sofia');

if (!isset($_GET['showmestat']))
    die("...");

if (isset($_GET['top']))
{
    $out = `/usr/bin/top -bn1`;
    print "<pre>" . $out . "</pre>";
}
elseif (isset($_GET['df']))
{
    $out = `/bin/df`;
    print "<pre>" . $out . "</pre>";
}
elseif (isset($_GET['help']))
{
    $out = 'top <br>' .
            'df <br>' .
            'load <br>';
    print $out;
}
elseif (isset($_GET['load']))
{
    $load = sys_getloadavg();
    $time = time();
    print $load[0] . ";" . $time . ";" . date("Y-m-d H:i:s", $time);
}

if (isset($_GET['refresh']))
{
    $r = $_GET['refresh'] ? $_GET['refresh'] : 60;
    print "<meta http-equiv='refresh' content='$r'>";
}
