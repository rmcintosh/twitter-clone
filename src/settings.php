<?php
$app['config'] = array(
    'db' => array(
        'db_host' => 'localhost',
        'db_name' => 'twitter_clone',
        'db_user' => 'root',
        'db_pass' => ''
    ),
    'firewall' => array(
        'security.firewalls' => array(
            'admin' => array(
                'pattern' => '^/*',
                'http' => true,
                'users' => array(
                    // password is foo
                    'user' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
                ),
            )
        )
    ),
    'monolog' => array(
        'monolog.logfile' => __DIR__ . '/../log/app.log'    
    ),
    'twig' => array(
        'twig.path' => __DIR__ . '/templates/',
    )
);

    
    
