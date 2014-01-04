<?php
use Jackalope\Session;
use Jackalope\Transport\DoctrineDBAL\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created at 03/01/14 22:46
 */

class MigrateLengthAttributes extends Command
{
    /** @var  Session */
    private $session;

    public function configure()
    {
        $this->setName('jackalope:dbal:migrate-length-attributes');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setSession();

        /** @var \Symfony\Component\Console\Helper\DialogHelper $dialog */
        $dialog = $this->getHelper('dialog');

        $output->writeln('<info>This command iterates through all properties in your workspace and resaves them so Jackalope saves them with the phpcr:length attribute.');

        if (!$dialog->askConfirmation($output, 'Are you sure you want to migrate your data? Please make sure you have a backup of your database before proceeding! (y/n) [n]: ', false)) {
            $output->writeln('<error>Cancelled migration</error>');
            return 1;
        }

        $this->processNode($this->session->getRootNode());
    }

    protected function setSession()
    {
        $this->session = $this->getHelper('session')->getSession();
    }

    protected function processNode(\Jackalope\Node $node)
    {
        /** @var Client $transport */
        $transport = $this->session->getObjectManager()->getTransport();
        $transport->updateProperties($node);
        foreach ($node as $childNode) {
            $this->processNode($childNode);
        }
    }
} 