<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Configuration extends \Codeception\Module
{
    /**
     * get configuration
     */
    public function getConfiguration()
    {
        $config = $this->_getConfig();

        foreach (func_get_args() as $arg) {
            if (isset($config[$arg])) {
                $config = $config[$arg];
            } else {
                return;
            }
        }
        return $config;
    }
}
