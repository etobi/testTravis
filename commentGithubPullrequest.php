<?php

if ($_ENV['TRAVIS_PULL_REQUEST'] != "false") {
    $output = [];
    $retval = '';
		$command = 'curl'
        . ' -s'
        . ' -X GET'

        . ' "'
        . 'https://api.github.com/repos/'
				. $_ENV['TRAVIS_PULL_REQUEST_SLUG']
				. '/pulls/'
        . ((int)$_ENV['TRAVIS_PULL_REQUEST'])
        . '/commits'
        . '"'
        . ' -H "Authorization: token e45e67f37360af3f256892c91f64ab88067bdfac"';
				echo $command;
    exec(
        $command,
        $output,
        $retval
    );
    $commitsInPullRequest = json_decode(implode('', $output), true);
    foreach ($commitsInPullRequest as $commit) {
    	$message = $commit['commit']['message'];
			$matches = [];
			preg_match('/[A-Za-z0-9]{2,4}-[0-9]+ /', $message, $matches);
			var_dump($matches);
    }
}