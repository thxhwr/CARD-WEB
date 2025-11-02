<?php
    $files = [
        '/home/thxdeal/mysql_certs/ca.pem',
        '/home/thxdeal/mysql_certs/client-cert.pem',
        '/home/thxdeal/mysql_certs/client-key.pem'
      ];
      foreach ($files as $f) {
          echo "<h3>$f</h3>";
          echo "exists: " . (file_exists($f) ? 'yes' : 'no') . "<br>";
          echo "is_readable: " . (is_readable($f) ? 'yes' : 'no') . "<br>";
          if (is_readable($f)) {
              echo "first 200 chars:<pre>" . htmlspecialchars(substr(file_get_contents($f),0,200)) . "</pre>";
          }
      }
?>