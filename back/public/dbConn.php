<?php
    $env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/agency/.env');
    $serverUrl = $env['SERVER_URL'];
    $serverId = $env['SERVER_ID'];
    $serverPwd = $env['SERVER_PWD'];
    $dbName = $env['DB_NAME'];

try {
    $mysqli = new mysqli($serverUrl, $serverId, $serverPwd, $dbName);
} catch(mysqliException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>