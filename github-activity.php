<?php
$username = $argv[1];
$url = "https://api.github.com/users/$username/events";
$opts = [
  'http' => [
    'method' => 'GET',
    'header' => 'User-Agent:MyApp\r\nAccept: application/vnd.github+json\r\nX-GitHub-Api-Version: 2022-11-28',
  ]
];
$context = stream_context_create($opts);
$result = file_get_contents($url, false, $context);
$userActivity = json_decode($result, true);
$activitySummary = [];
foreach ($userActivity as $activity) {
  $type = $activity['type'];
  $repoName = $activity['repo']['name'];
  if (isset($activitySummary[$type][$repoName])) {
    $activitySummary[$type][$repoName]++;
  } else {
    $activitySummary[$type][$repoName] = 1;
  }
}

foreach ($activitySummary as $key => $activity) {
  echo $key;
  print_r($activity);
}
