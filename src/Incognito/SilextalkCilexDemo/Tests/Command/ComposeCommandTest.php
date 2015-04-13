<?php

namespace Incognito\SilextalkCilexDemo\Test\Command;

use Cilex\Application;
use Incognito\SilextalkCilexDemo\Command\ComposeCommand;
use Incognito\SilextalkCilexDemo\SilextalkCilexDemoServiceRegistry;
use Symfony\Component\Console\Tester\CommandTester;

class ComposeCommandTest  extends \PHPUnit_Framework_TestCase
{
    protected $app;

    protected $mailerLogger;

    public function setUp()
    {
        $app = new Application('Fake app for testing');

        SilextalkCilexDemoServiceRegistry::boot($app);

        $app->command(new ComposeCommand());

        $this->app = $app;

        // Log swiftmailer messages
        $app['mailer.logger'] = $app->share(function() {
            return new \Swift_Plugins_MessageLogger();
        });

        $app['mailer'] = $app->share($app->extend('mailer', function($mailer, $app) {
            $mailer->registerPlugin($app['mailer.logger']);
            return $mailer;
        }));

        $app['swiftmailer.options'] = array();
        $this->mailerLogger = $app['mailer.logger'];

        return $app;
    }

    public function testCommandIsLoaded()
    {
        $command = $this->app['console']->find('mailer:compose');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'toAddress' => 'foo@example.com',
            'subject'   => 'Foo subject',
            'body'      => 'bar body',
        ]);

        $this->assertRegExp('/Mail sent!/', $commandTester->getDisplay());

        $mailCollector = $this->mailerLogger;

        // Check that an e-mail was sent
        $this->assertEquals(1, $mailCollector->countMessages());
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        // Asserting e-mail data
        $this->assertInstanceOf('Swift_Message', $message);

        $this->assertEquals('Foo subject', $message->getSubject());
        $this->assertEquals('foo@example.com', key($message->getTo()));
        $this->assertEquals('bar body', $message->getBody());
    }
}
