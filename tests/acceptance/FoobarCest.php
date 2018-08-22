<?php
namespace Etobi\Tests;

class FoobarCest
{
    public function _before(\AcceptanceTester $I)
    {
    }

    public function _after(\AcceptanceTester $I)
    {
    }

    /**
     * @param \AcceptanceTester $I
     *
     * @env stage-standard
     * @env foobar
     */
    public function standardTest(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->seeInSource('Example Domain');
    }


    /**
     * @param \AcceptanceTester $I
     *
     * @env stage-interact
     */
    public function interactTest(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('a');

        $I->seeInSource('IANA-managed Reserved Domains');
    }
}
