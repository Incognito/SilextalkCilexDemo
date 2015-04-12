<?php

namespace Incognito\SilextalkCilexDemo\Test\Command;

use Incognito\SilextalkCilexDemo\Command\ComposeCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ComposeCommandTest  extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $application = new Application();
        $application->add(new ComposeCommand());

        $this->app = $application;
    }

    public function testCommandIsLoaded()
    {
        $command = $this->app->find('mailer:compose');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'toAddress' => 'foo@example.com',
            'subject'   => 'Foo subject',
            'body'      => 'bar body',
        ]);

        $this->assertRegExp('/Nothing here yet/', $commandTester->getDisplay());
    }
}
