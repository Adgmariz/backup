<?php
  namespace App\EventSubscriber;

    use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
    use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Symfony\Component\HttpKernel\KernelEvents;
    use Symfony\Component\HttpFoundation\Session\Session;

    class SessionFilter implements EventSubscriberInterface{
        
        private $session;

        private function getSession(){
            return $this->session;
        }
        private function setSession($session){
            $this->session = $session;
        }


        public function prepareSession(){
            $this->setSession(new Session());
            if($this->getSession() == NULL){
                $this->getSession()->start();
            }
        }

        private function checkSession(){
            $this->prepareSession();
            if(!$this->getSession()->get('islogged')){
                throw new AccessDeniedHttpException('Vocẽ não está logado.');  
            }

            //$session->get('islogged') ? $this->render('front/index.html.twig') : $this->redirect('/');
        }

        public function onKernelController(FilterControllerEvent $event){
            $controller = $event->getController();
            $action = $controller[1];
            $actionsToAvoidChecking = ["index", "logout"];
            if($controller[0] instanceof FrontController && array_key_exists($action, $actionsToAvoidChecking)  == false){
                $this->checkSession();
            }
            
            //throw new AccessDeniedHttpException('This action needs a valid token!');
        }
        
        public static function getSubscribedEvents()
        {
            return array(
                KernelEvents::CONTROLLER => 'onKernelController',
            );
        }
  }
