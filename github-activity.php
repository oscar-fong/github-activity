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
foreach ($userActivity as $activity) {
  $type = $activity['type'];
  $repo = $activity['repo']['name'];
  switch ($type) {
    case 'PushEvent':
      if (isset($summary[$type][$repo])) {
        $summary[$type][$repo]++;
      } else {
        $summary[$type][$repo] = 1;
      }
      break;
    case 'CreateEvent':
    case 'DeleteEvent':
      $summary[$type][$repo] = $activity['payload']['ref_type'];
      break;
    case 'DiscussionEvent':
      $summary[$type][$repo] = $activity['payload']['discussion']['title'];
      break;
    case 'IssuesEvent':
      $summary[$type][$repo] = ['action' => $activity['payload']['action'], 'issue' => $activity['payload']['issue']['title']];
      break;
  }
}
foreach ($summary as $type => $activity) {
  foreach ($activity as $repo => $content) {
    switch ($type) {
      case 'PushEvent':
        echo '- Pushed ', $content, ' commits to ', $repo, PHP_EOL;
        break;
      case 'CreateEvent':
        echo '- Created ', $content, ' ', $repo, PHP_EOL;
        break;
      case 'DeleteEvent':
        echo '- Deleted ', $content, ' ', $repo, PHP_EOL;
        break;
      case 'DiscussionEvent':
        echo "- Created discussion in $repo: \"$content\"", PHP_EOL;
        break;
      case 'IssuesEvent':
        $action = $content['action'];
        $action[0] = strtoupper($action[0]);
        $issue = $content['issue'];
        echo "- $action issue in $repo: \"$issue\"", PHP_EOL;
        break;
    }
  }
}
