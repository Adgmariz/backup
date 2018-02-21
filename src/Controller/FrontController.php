<?php
  namespace App\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\Controller;
  use Symfony\Component\Routing\Annotation\Route;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\Extension\Core\Type\PasswordType;
  use Symfony\Component\HttpFoundation\Session\Session;
  
  use App\Entity\LogTarefa;
  use App\Entity\Tarefa;
  use App\Entity\Agendamento;
  use App\Entity\Usuario;

  class FrontController extends Controller{

      private function prepareForm(){
        return $this->createFormBuilder(null, array(
            'action' => '/login',
            'method' => 'POST',
        ))
        ->add('usuario', TextType::class, array('attr' => [
                    'placeholder' => 'usuario'
        ]))
        ->add('senha', PasswordType::class, array('attr' => [
                    'placeholder' => 'senha'
        ]))->getForm();
      }

      /**
        * @Route("/")
        */
      public function index(){
        //TODO: if/else login para verificar sessão
        $form = $this->prepareForm();
        return $this->render('front/login.html.twig', [
            'form' => $form->createView()
        ]);
      }

      /**
        * @Route("/dashboard")
        */
      public function dashboard(){
        $session = new Session();
        $session->start();
        return $session->get('islogged') ? $this->render('front/index.html.twig') : $this->redirect('/');
      }

      /**
        * @Route("/login")
        */
      public function login(Request $request){
        $form = $this->prepareForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $usuario = $data['usuario'];
            $senha = md5($data['senha']);
            $result = $this->getDoctrine()
             ->getRepository(Usuario::class)
             ->checkUsuario($usuario, $senha);
            $session = new Session();
            $session->start();
            $session->set('islogged', true);
             return $this->redirect($result ? 'dashboard' : '/');
             
        }
        else{
          return $this->redirect('/');
        }
      }
      /**
        * @Route("/logout")
        */
      public function logout(){
        $session = new Session();
        $session->start();
        $session->invalidate();
        return $this->redirect('/');
      }

      /**
       * @Route("/testedb")
       */
      public function testedb(){
        $result = $this->getDoctrine()->getRepository(Agendamento::class)->findAll();
        $tostring = '';
        foreach($result as $res){
          var_dump($result, $res->getTarefa());exit;
          $tostring.=$res->getTarefa();
        }

        return new Response($tostring);
        //var_dump($result);exit;
        //->getRepository(LogTarefa::class)
      }
  }
