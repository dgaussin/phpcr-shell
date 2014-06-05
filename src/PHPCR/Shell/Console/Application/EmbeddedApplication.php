<?php

namespace PHPCR\Shell\Console\Application;

class EmbeddedApplication extends ShellApplication
{
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct(SessionApplication::APP_NAME, SessionApplication::APP_VERSION);

        $this->registerHelpers();
        $this->registerEventListeners();
    }

    public function init()
    {
        if (true === $this->initialized) {
            return;
        }

        $this->registerPhpcrCommands();
        $this->initialized = true;
    }

    protected function getDefaultCommand()
    {
        return 'list';
    }
}
