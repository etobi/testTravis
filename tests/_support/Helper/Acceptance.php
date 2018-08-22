<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{

    /**
     * @param bool $followRedirects
     */
    public function followRedirects($followRedirects)
    {
        $this->getModule('PhpBrowser')
            ->client
            ->followRedirects($followRedirects);
    }

    /**
     * @param string $url
     */
    public function seeLocationHeader($url)
    {
        $response = $this->getModule('PhpBrowser')->client->getInternalResponse();
        $locationHeader = $response->getHeaders()['Location'][0];
        $parsedUrl = parse_url($locationHeader);
        $this->assertEquals(
            $url,
            $parsedUrl['path'] . (
            isset($parsedUrl['query'])
                ? '?' . $parsedUrl['query']
                : ''
            )
        );
    }
}
