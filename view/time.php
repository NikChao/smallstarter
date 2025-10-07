<?php

use Carbon\Carbon;

$currentDateTime = Carbon::now()->format('d-M h:m:s');

?>

<script type="module" src="/assets/js/pages/time.js"></script>
<div class="page">
<h1>It's <span id="time"><?= $currentDateTime ?></span></h1>
</div>
