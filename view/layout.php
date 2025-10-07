<?php

/** @var string|null $title */
/** @var string|null $content */
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'My app' ?></title>
  <link rel="stylesheet" href="/assets/css/app.css">
  <script type="importmap">
    {
      "imports": {
        "utils/": "/assets/js/utils/"
      }
    }  
  </script>
</head>
<body>
  <div class="page">
    <a href="javascript:history.back()">back</a>
  </div>
  <?= $content ?>
  <script type="module" src="/assets/js/app.js"></script>
</body>
</html>
