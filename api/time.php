<?php

use Carbon\Carbon;

$response = [];
$response['time'] = Carbon::now()->format('d-M h:m:s');

echo json_encode($response);
