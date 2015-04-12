<?php

namespace Incognito\SilextalkCilexDemo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
      // TODO: Everything.
        /* Duplicate of code that we had in Silex, just for reference sake."
          $emailMessage = $app['email_factory']::createFromRequest($request);

          $validationErrors = $app['validator']->validate($emailMessage);

          if ($validationErrors->count() > 0) {
              return new Response("Nope. That's not valid.", 400);
          }

          $app['mailer.mailer']->send($emailMessage);

          return $app->redirect($app['url_generator']->generate('mailer_compose'));
        */

      // TODO load email factory
      // TODO validate command input
      // TODO Send email
      // TODO Show success/failure
       $output->writeln("Nothing here yet");
    }
}
