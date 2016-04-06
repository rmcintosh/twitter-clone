<?php
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), $app['config']['twig']);
$app->register(new Silex\Provider\MonologServiceProvider(), $app['config']['monolog']);
$app->register(new Silex\Provider\SecurityServiceProvider(), $app['config']['firewall']);
