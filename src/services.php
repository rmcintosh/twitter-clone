<?php
/**
 * Form for Tweet
 *
 * @return Symfony\Component\Form\Form
 */
$app['twitter_clone.form'] = $app->share(function($app) {
    return $app['form.factory']->createBuilder('form')
        ->add('tweet')
        ->getForm();
});

/**
 * Constraints for Tweet form input:
 * Require that Tweet input be not blank
 * Require that Tweet input have a min length
 * of 1 character and max length of 140 characters.
 *
 * @return array
 */
$app['twitter_clone.form_constraints'] = $app->share(function() {
    return array(
        new Symfony\Component\Validator\Constraints\NotBlank(),
        new Symfony\Component\Validator\Constraints\Length(array(
            'min' => 1,
            'max' => 140
        ))
    );  
});

/**
 * TwitterCloneRepository encapsulates insertion of tweets into and
 * retrieval of tweets from the database.
 * 
 * Constructor description
 *
 * <code>
 * $config = array(
 *     'db_host' => 'DB_HOST',  // host
 *     'db_name' => 'DB_NAME',  // name of database
 *     'db_user' => 'username', // db user name
 *     'db_pass' => 'userpass'  // password for db user
 * );
 * </code>
 *
 * @param array $config
 * @param Monolog\Logger $logger
 *
 * @return App\Repository\TwitterCloneRepository
*/

$app['twitter_clone.repository'] = $app->share(function($app) {
    return new App\Repository\TwitterCloneRepository($app['config']['db'], $app['monolog']);
});

/**
 * TwitterCloneController renders application index view 
 * and manages Tweet form submission.
 * 
 * Constructor description
 *
 * @param Twig_Environment $view
 * @param Symfony\Component\HttpFoundation\Request $request
 * @param Symfony\Component\HttpFoundation\Session\Session $session
 * @param Symfony\Component\Validator\Validator\RecursiveValidator $validator
 * @param App\Repository\TwitterCloneRepository $repository
 * @param Symfony\Component\Form\Form $form
 * @param array $formConstraints
 *
 * @return App\Controller\TwitterCloneController
*/
$app['twitter_clone.controller'] = $app->share(function($app) {
    return new App\Controller\TwitterCloneController(
        $app['twig'],
        $app['request'],
        $app['session'],
        $app['validator'],
        $app['twitter_clone.repository'],
        $app['twitter_clone.form'],
        $app['twitter_clone.form_constraints']
    );
});

