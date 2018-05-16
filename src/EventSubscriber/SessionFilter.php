<?php
  namespace App\EventSubscriber;

    use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
    use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Symfony\Component\HttpKernel\KernelEvents;
    use Symfony\Component\HttpFoundation\Session\Session;
    use App\Controller\FrontController;

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
            //var_dump($this->getSession()->all());exit;
            if(!$this->getSession()->get('islogged')){
                throw new AccessDeniedHttpException('Você não está logado, retorne para a página principal.');
                
            }

            //$session->get('islogged') ? $this->render('front/index.html.twig') : $this->redirect('/');
        }

        private function logout(){
            $this->prepareSession();
            $this->getSession()->clear();
            //$this->getSession()->invalidate();
            $this->prepareSession();
            //var_dump($this->getSession()->all());exit;
        }

        public function onKernelController(FilterControllerEvent $event){
            $controller = $event->getController();
            $action = $controller[1];
            $actionsToAvoidChecking = ["index", "/", "login"];
            //var_dump($action,in_array($action, $actionsToAvoidChecking));exit;
            //$condition1 = $controller[0] instanceof FrontController;
           //var_dump($action);exit;
           if($controller[0] instanceof FrontController && $action == "logout"){
            $this->logout();
           }
            else if($controller[0] instanceof FrontController && in_array($action, $actionsToAvoidChecking)  == false){
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
