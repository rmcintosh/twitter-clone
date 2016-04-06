<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

/**
 * Load application Controller and Repository classes
 */
include __DIR__ . '/../src/app/Controller/TwitterCloneController.php';
include __DIR__ . '/../src/app/Repository/TwitterCloneRepository.php';

$app = new Silex\Application();

/**
 * Application configuration settings
 */
include __DIR__ . '/../src/settings.php';

/**
 * Silex service providers
 */
include __DIR__ . '/../src/service_providers.php';

/**
 * Application services
 */
include __DIR__ . '/../src/services.php';

/**
 * Application Routes
 */
include __DIR__ . '/../src/routes.php';

/**
 * Run!
 */
$app->run();
