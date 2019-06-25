<?php

function githubApi($method, $urlPath, $body = null) {
  $output = [];
  $retval = '';
	$command = 'curl'
      . ' -s'
			. ($body ? ' -d ' . escapeshellarg($body) : '')
      . ' -X '
			. $method
      . ' "'
			. 'https://api.github.com/repos/'
			. $urlPath
      . '"'
      . ' -H "Authorization: token ' . $_ENV['GITHUB_TOKEN'] . '"';
			echo $command;
  exec(
      $command,
      $output,
      $retval
  );
  return json_decode(implode('', $output), true);
}

if ($_ENV['TRAVIS_PULL_REQUEST'] != "false") {
		$commitsInPullRequest = githubApi(
			'GET',
			$_ENV['TRAVIS_PULL_REQUEST_SLUG']
			. '/pulls/'
			. ((int)$_ENV['TRAVIS_PULL_REQUEST'])
			. '/commits'
		);
    foreach ($commitsInPullRequest as $commit) {
    	$message = $commit['commit']['message'];
			$matches = [];
			preg_match('/([A-Za-z0-9]{2,4}-[0-9]+) /', $message, $matches);
			$ticketLinks = [];
			if (!empty($matches[1])) {
				$ticketId = $matches[1];
				$ticketLink = 'https://fielmann.atlassian.net/browse/' . $ticketId;
				$ticketLinks[] = $ticketLink;
			}
    }
		githubApi(
			'POST',
			$_ENV['TRAVIS_PULL_REQUEST_SLUG']
			. '/issues/'
			. ((int)$_ENV['TRAVIS_PULL_REQUEST'])
			. '/comments',
			json_encode([
				'body' => "Tickets:\n\n" . implode("\n", $ticketLinks)
			])
		);
}