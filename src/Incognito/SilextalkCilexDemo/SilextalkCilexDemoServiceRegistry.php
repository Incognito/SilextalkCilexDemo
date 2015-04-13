<?php

namespace Incognito\SilextalkCilexDemo;

use Incognito\SilextalkBase\Model\Mailer;
use Incognito\SilextalkCilexDemo\Command\ComposeCommand;
use Incognito\SilextalkBase\Model\EmailMessageFactory;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\YamlFileLoader;

class SilextalkCilexDemoServiceRegistry
{
  
    const DEFAULT_SENDER = "bar@example.com";

    // FIXME service namespaces are over-lapping. Should have prefixed with own ns.
    static function boot(\Pimple $app)
    {
        $app->register(new SwiftmailerServiceProvider());

        $app['swiftmailer.options'] = array(
            'host' => 'host',
            'port' => '25',
            'username' => 'username',
            'password' => 'password',
            'encryption' => null,
            'auth_mode' => null
        );

        $app['email_factory'] = $app->share(function () {
            return new EmailMessageFactory();
        });

        $app['mailer.command'] = $app->share(function () use ($app) {
            return new ComposeCommand();
        });

        $app->register(new ValidatorServiceProvider());

        $app['mailer.mailer'] = $app->share(function () use ($app) {
            return new Mailer($app['mailer'], self::DEFAULT_SENDER);
        });

        $app['validator.mapping.class_metadata_factory'] = new LazyLoadingMetadataFactory(
            new YamlFileLoader(__DIR__.'/Resources/config/validation.yml')
        );
    }
}
