<?php

use Db\Persistence;
use App\Helpers\AppLogger;

$response = [];
$response['value'] = rand();

$persistence = new Persistence();
$persistence->execute("insert into fun_items (value) values (?)", [$response['value']]);
AppLogger::logger()->info("Saved random number [${response['value']}] to database.");

echo json_encode($response);
