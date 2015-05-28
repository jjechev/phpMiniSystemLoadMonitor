<?php

require("functions.php");
require("config.php");

$site = isset($_GET["site"]) ?  $_GET["site"]   : null;
$site = isset($sites[$site]) ?  $site           : null;

if ($site)
{
    $data = getData($site);
    $data = prepDiagData($data);
    echo showStats($data, $site);
}
else
{
    $data = getLastData();
    echo showLastData($data);
}


if (isset($_GET['refresh']))
{
    $r = $_GET['refresh'] ? $_GET['refresh'] : 60;
    echo "<meta http-equiv='refresh' content='$r'>";
}
