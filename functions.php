<?php

class mysql
{
    private static $instance;

    private function __construct()
    {
        
    }

    public static function getInstance()
    {
        if (!self::$instance)
            self::init();

        return self::$instance;
    }

    private static function init()
    {
        self::$instance = new mysqli("localhost", "root", "1234qazxcv", "load");
    }

    public static function getAssocData($res)
    {
        while ($row = $res->fetch_assoc())
        {
            $out[] = $row;
        }
        return $out;
    }

}

function getRemoteData($url)
{
    $data = @file_get_contents($url);
    if ($data === false)
        $data = "-1" . ";" . time() . ";" . date("Y-m-d H:i:s", time());
    return $data;
}

function saveLoad($load, $site)
{
    $mysqli = mysql::getInstance();
    $q = "INSERT INTO `load`.`log` (`load` ,`site`) VALUES ('$load', '$site');";
    $result = $mysqli->query($q);
}

function getData($site, $limit = 4320)
{
    $mysqli = mysql::getInstance();

    $q = "SELECT * FROM log WHERE site = '$site' ORDER BY id DESC LIMIT $limit;";
    $result = $mysqli->query($q);
    $out = array();

    $out = mysql::getAssocData($result);

    return $out;
}

function prepDiagData($data)
{
    $out = array();
    foreach ($data as $val)
    {
        $out['date'][] = $val['time'];
        $out['load'][] = $val['load'];
        $out['site'][] = $val['site'];
    }

    return $out;
}

function htmlHeader()
{
    return "<!DOCTYPE html><html><head><title></title></head><body>";
}

function htmlFooter()
{
    return "</body></html>";
}

function htmlCSS()
{

    return "
	<style>
	.tbl  table, td, th {
		border: 1px solid black;
		padding: 0px 5px;
		color: black;
		font-weight: bold;
		font-size: 10px;
		font-family: arial;
	}

	.tbl th{
		background-color: #ccc;
	}
	.tbl{
		margin-left: 50px!important;
		margin-right: 50px!important;
	}
	</style>
	";
}

function showStats($data, $site = 'unknown')
{
    $max = max($data['load']);

    $bar = "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||";

    $out = htmlHeader();
    $out .= htmlCSS();

    $out .= "<table class ='tbl'>";
    $out .= "<tr><th colspan=3>$site ( max:$max )</th></tr>";
    $out .= "<tr><th>date</th><th>%</th><th>load</th></tr>";
    foreach ($data['load'] as $k => $val)
    {
        $out .= "<tr>";
        @$pr = $data['load'][$k] / $max * 100;
        $out .= "<td>" . $data['date'][$k] . "</td>";
        $out .= "<td>" . substr($bar, 0, $pr + 1) . "</td>";
        $out .= "<td>" . $data['load'][$k] . "</td>";
        $out .= "</tr>";
    }
    $out .= "</table>";
    $out .= htmlFooter();
    
    return $out;
}

function getSites()
{
    $sql = mysql::getInstance();
    $q = "SELECT DISTINCT site FROM log;";
    $res = $sql->query($q);
    $out = mysql::getAssocData($res);
    return $out;
}

function getLastData()
{
    $sites = getSites();

    $sql = mysql::getInstance();

    foreach ($sites as $val)
    {
        $q = "select * from log where site = '{$val['site']}' order by time desc limit 1";
        $res = $sql->query($q);
        $out[] = mysql::getAssocData($res);
    }

    return $out;
}

function showLastData($data)
{
    $out = htmlHeader();
    $out .= htmlCSS();

    $out .= "<table class ='tbl'>";
    $out .= "<tr><th>date</th><th>site</th><th>load</th><th>link</th></tr>";
    foreach ($data as $k => $val)
    {
        $val = $val[0];
        $out .= "<tr>";
        $out .= "<td>" . $val['time'] . "</td>";
        $out .= "<td>" . $val['site'] . " </td>";
        $out .= "<td>" . $val['load'] . "</td>";
        $out .= "<td><a href ='?site={$val['site']}' target ='_blank'>show</a></td>";
        $out .= "</tr>";
    }
    $out .= "</table>";
    $out .= htmlFooter();
    
    return $out;
}
