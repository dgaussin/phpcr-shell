<?php

namespace PHPCR\Shell\Console\Command\Phpcr;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class VersionCheckoutCommand extends Command
{
    protected function configure()
    {
        $this->setName('version:checkout');
        $this->setDescription('Checkout a node version and enable changes to be made');
        $this->addArgument('path', InputArgument::REQUIRED, 'Absolute path to node');
        $this->setHelp(<<<HERE
Sets the versionable node at <info>path</info> to checked-out status by setting
its jcr:isCheckedOut property to true. Under full versioning it also sets
the jcr:predecessors property to be a reference to the current base
version (the same value as held in <comment>jcr:baseVersion</comment>).

This method puts the node into the checked-out state, making it and its
connected non-versionable subgraph no longer read-only (see <info>version:checkin</info> for
an explanation of the term "connected non-versionable subgraph". Under
simple versioning this will simply be the whole subgraph).

If successful, these changes are persisted immediately, there is no need
to call save.

If this node is already checked-out, this method has no effect.
HERE
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $session = $this->getHelper('phpcr')->getSession();
        $nodeHelper = $this->getHelper('node');
        $absPath = $input->getArgument('path');
        $workspace = $session->getWorkspace();

        $node = $session->getNodeByPathOrIdentifier($absPath);
        $nodeHelper->assertNodeIsVersionable($node);

        $versionManager = $workspace->getVersionManager();
        $version = $versionManager->checkout($absPath);
    }
}
