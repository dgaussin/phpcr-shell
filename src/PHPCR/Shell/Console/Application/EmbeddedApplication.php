<?php

namespace PHPCR\Shell\Console\Application;

use PHPCR\Shell\Event\ApplicationInitEvent;
use PHPCR\Shell\Event\PhpcrShellEvents;

class EmbeddedApplication extends ShellApplication
{
    /**
     * Do not provide shell features
     */
    const MODE_COMMAND = 'command';

    /**
     * Provide shell features
     */
    const MODE_SHELL = 'shell';

    protected $mode;

    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN', $mode = self::MODE_COMMAND)
    {
        parent::__construct(SessionApplication::APP_NAME, SessionApplication::APP_VERSION);

        $this->registerHelpers();
        $this->registerEventListeners();
        $this->mode = $mode;
    }

    public function init()
    {
        if (true === $this->initialized) {
            return;
        }

        $this->registerPhpcrCommands();

        if ($this->mode == self::MODE_SHELL) {
            $this->registerShellCommands();
        }

        $event = new ApplicationInitEvent($this);
        $this->dispatcher->dispatch(PhpcrShellEvents::APPLICATION_INIT, $event);

        $this->initialized = true;
    }

    protected function getDefaultCommand()
    {
        return 'list';
    }
}
