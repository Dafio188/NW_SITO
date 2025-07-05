<?php
$files = [
  'index.php',
  'manifest.json',
  'assets/css/main.css',
  'assets/js/main.js',
  'assets/js/main.8215e5b6.js',
  'assets/images/logo/logo.png',
  'pages/home.php',
  'includes/config.php',
  'includes/database.php',
  'data/schema.sql',
];
echo "<h2>Diagnostica file AstroGuida</h2><ul>";
foreach($files as $f) {
  $path = __DIR__ . '/' . $f;
  if(file_exists($path)) {
    $perm = substr(sprintf('%o', fileperms($path)), -4);
    echo "<li style='color:green'>OK: $f (permessi $perm)</li>";
  } else {
    echo "<li style='color:red'>ERRORE: $f NON TROVATO</li>";
  }
}
echo "</ul>";
?> 