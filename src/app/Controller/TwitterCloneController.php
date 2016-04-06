<?php
// app/src/Controller/TwitterCloneController.php
namespace App\Controller;

use App\Repository\TwitterCloneRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Twig_Environment;

/**
 * Controller that renders application index view 
 * and manages Tweet form submission.
 *
 * @author Robert C. McIntosh <rcmcintosh0214@gmail.com>
 */
final class TwitterCloneController
{
    /**
     * @var Twig_Environment
     */    
    private $view;
    
    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    /**
     * @var Symfony\Component\Validator\Validator\RecursiveValidator
     */
    private $validator;

    /**
     * TwitterCloneRepository encapsulates insertion and
     * retrieval of tweets from database.
     * 
     * @var App\Repository\TwitterCloneRepository
     */    
    private $repository;
    
    /**
     * Form for Tweet
     *
     * @var Symfony\Component\Form\Form
     */    
    private $form;
      
    /**
     * Array containing Symfony\Component\Validator\Constraints
     * objects; used for Tweet form input validation.
     *
     * @var array
     */
    private $formConstraints;
    
    /**
     * Class constructor
     *
     * @param Twig_Environment $view
     * @param Request $request
     * @param Session $session
     * @param RecursiveValidator $validator
     * @param App\Repository\TwitterCloneRepository $repository
     * @param Form $form
     * @param array $formConstraints
     */
    public function __construct(Twig_Environment $view,
        Request $request,
        Session $session,
        RecursiveValidator $validator,
        TwitterCloneRepository $repository,
        Form $form,
        array $formConstraints)
    {
        $this->view = $view;
        $this->request = $request;
        $this->session = $session;
        $this->validator = $validator;
        $this->repository = $repository;
        $this->form = $form;
        $this->formConstraints = $formConstraints;
    }
    
    /**
     * Renders index view which displays Tweet form and list
     * of previous Tweets ordered by most recent first.
     *
     * @return string
     */
    public function indexAction()
    {
        return $this->view->render('index.html.twig', array(    
            'tweets' => $this->repository->findAllByMostRecent(),
            'form' => $this->form->createView()
        ));
    }

    /**
     * Manages Tweet form submission.
     *
     * On form input validation failure, redirects to
     * index view and displays flash message detailing error
     * messages. On form input validation success,
     * adds Tweet to database, then redirects to index view.
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */    
    public function tweetAction()
    {        
        $this->form->handleRequest($this->request);
        
        if ($this->form->isValid()) {
            /** @vars $data array */
            $data = $this->form->getData();
            $tweet = strip_tags($data['tweet']);
            
            /** @vars $errors Symfony\Component\Validator\ConstraintViolationListInterface */
            $errors = $this->validator->validateValue($tweet, $this->formConstraints);
                  
            if (count($errors) > 0) {
                $this->session->getFlashBag()->add('error', (string) $errors);

                return new RedirectResponse('/');
            } 
    
            if (! $this->repository->addTweet($tweet)) {
                $this->session->getFlashBag()->add('error', 'An error occurred while trying to save your Tweet.');
            }
            
            return new RedirectResponse('/');
        }
    }
}
