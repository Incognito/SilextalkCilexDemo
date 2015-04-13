<?php

namespace Incognito\SilextalkCilexDemo\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Cilex\Command\Command;

class ComposeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mailer:compose')
            ->setDescription('Compose an email to send.')
            ->addArgument('toAddress', InputArgument::REQUIRED, 'Email address for the recipient')
            ->addArgument('subject', InputArgument::REQUIRED, 'Subject line')
            ->addArgument('body', InputArgument::REQUIRED, 'Email body message');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailMessageFactory = $this->getService('email_factory');
        $emailMessage = $emailMessageFactory::createEmail(
            $input->getArgument('toAddress'),
            $input->getArgument('subject'),
            $input->getArgument('body')
        );

        $validationErrors = $this->getService('validator')->validate($emailMessage);

        if ($validationErrors->count() > 0) {
            $output->writeln("Nope. That's not valid.");

            return 1; // Exit faulure
        }

        $this->getService('mailer.mailer')->send($emailMessage);

        $output->writeln("Mail sent!");

        return 0; // Exit success
    }
}
