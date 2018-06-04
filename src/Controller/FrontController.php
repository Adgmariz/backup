<?php
  namespace App\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\Controller;
  use Symfony\Component\Routing\Annotation\Route;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\Extension\Core\Type\PasswordType;
  use Symfony\Component\HttpFoundation\Session\Session;
  use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\HiddenType;

  use App\Entity\LogTarefa;
  use App\Entity\Tarefa;
  use App\Entity\Agendamento;
  use App\Entity\Usuario;

  class FrontController extends Controller{

      private function prepareFormLogin(){
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
        $form = $this->prepareFormLogin();
        return $this->render('front/login.html.twig', [
            'form' => $form->createView()
        ]);
      }

      /**
        * @Route("/dashboard")
        */
      public function dashboard(){
        // $session = new Session();
        // return $session->get('islogged') ?
        return $this->render('front/index.html.twig');
      }

      /**
        * @Route("/login")
        */
      public function login(Request $request){
        $form = $this->prepareFormLogin();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $usuario = $data['usuario'];
            $senha = md5($data['senha']);
            $result = $this->getDoctrine()
             ->getRepository(Usuario::class)
             ->checkUsuario($usuario, $senha);
            $session = new Session();
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
        return $this->redirect('/');
      }

      /**
       * @Route("/testedb")
       */
      public function testedb(){
        $result = $this->getDoctrine()->getRepository(Agendamento::class)->findAll();
        $tostring = '';
        foreach($result as $res){
          //var_dump($res->getTarefa());exit;
          $tostring.=$res->getTarefa();
        }

        return new Response($tostring);
        //var_dump($result);exit;
        //->getRepository(LogTarefa::class)
      }

      private function prepararAgendamento($agendamento){
        $usuarioToSet = $this->getDoctrine()->getRepository(Usuario::class)->findById($agendamento->getUsuario());
        $agendamento->setUsuario($usuarioToSet[0]);//$usuarioToSet[0] é uma instância de Usuario
        $tarefaToSet = $this->getDoctrine()->getRepository(Tarefa::class)->findById($agendamento->getTarefa());
        $agendamento->setTarefa($tarefaToSet[0]);
        return $agendamento;
      }


      /**
       * @Route("/listaragendamentos")
       */
      public function listaragendamentos(){
        $agendamentos = $this->getDoctrine()->getRepository(Agendamento::class)->findAll();
        foreach($agendamentos as $agendamento){
          $agendamento = $this->prepararAgendamento($agendamento);
        }
        return $this->render('front/listaragendamentos.html.twig', ['agendamentos'=>$agendamentos]);
      }

      /**
       * @Route("/editaragendamentos/{id}")
       */
      public function editaragendamento(Agendamento $agendamento = null){
        try{
          if($agendamento != null){
            $agendamento = $this->prepararAgendamento($agendamento);
            $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
            $tarefas = $this->getDoctrine()->getRepository(Tarefa::class)->findAll();
            $form = $this->prepareFormEditar($agendamento);
            //TODO: criar uma página de edição. tag <SELECT>(html) para 'Usuario' e 'Tarefa'(de acordo com o id)
            //TODO:(alterar a tarefa que o agendamento está vinculado. Campos de edição(texto) para descrição, frequencia,
            return $this->render('front/editaragendamentos.html.twig', ['agendamento'=>$agendamento,
                                                                        'usuarios'   =>$usuarios,
                                                                        'tarefas'    =>$tarefas,
                                                                        'form'       =>$form->createView()]);
          }
          else{
            throw new \Exception("Objeto 'Agendamento' não encontrado" );
          }

        }
        catch(Exception $ex){
          return $ex->getTraceAsString();
        }
      }

      /**
       * @Route("/processaeditagend")
       */
      public function processaEditarAgendamento(){
        $form = $_POST['form'];
        $agendamento_id = $form['agendamento'];
        $usuario_id = $form['usuario'];
        $tarefa_id = $form['tarefa'];
        
        //Transforma o $usuario_id e $tarefa_id em int
        $usuario_id = intval($usuario_id);
        $tarefa_id = intval($tarefa_id);

        //Na linha abaixo, $agendamento é um array, no qual a posição 0 corresponde a um objeto do tipo Agendamento.
        $agendamento = $this->getDoctrine()->getRepository(Agendamento::class)->findById($agendamento_id);
        //Na linha abaixo, $agendamento é transformado em um objeto do tipo Agendamento.
        $agendamento = $agendamento[0];

        $usuario = $this->getDoctrine()->getRepository(Usuario::class)->findById($usuario_id);
        $usuario = $usuario[0];
        $tarefa = $this->getDoctrine()->getRepository(Tarefa::class)->findById($tarefa_id);
        $tarefa = $tarefa[0];
        
        $agendamento->setUsuario($usuario);
        $agendamento->setTarefa($tarefa);
        
        
        //-carregar agendamento do banco (->getDoctrine->findById)
        //-chamar ->setUsuario, com o id recebido nos parametros
        //-chamar ->setTarefa, com o id recebido nos parametros
        //-enviar para o banco ->getDoctrine->getRepository->save($agendamento)
        
        ///só consegui achar persist e flush
      }

        //$this->getDoctrine()->getRepository(Agendamento::class)->update()
      private function prepareFormEditar(Agendamento $agendamento){
        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        $tarefas = $this->getDoctrine()->getRepository(Tarefa::class)->findAll();
        $formBuilder = $this->createFormBuilder(null, array(
            'action' => '/processaeditagend',
            'method' => 'POST',
        ));
        $formBuilder->add('agendamento', HiddenType::class, array('attr' => [
          'value' => $agendamento->getId()
        ]));
        $formBuilder->add('usuario', ChoiceType::class, [
          'choices' => [
              $usuarios
          ],
          'choice_label' => function($usuario, $key, $index) {
              return strtoupper($usuario->getNome());
          },
          'choice_value' => function (Usuario $usuario = null) {
            return $usuario ? $usuario->getId() : 'x'; 
          },
          'data' => $agendamento->getUsuario()
          ]
        );
        $formBuilder->add('tarefa', ChoiceType::class, [
          'choices' => [
              $tarefas
          ],
          'choice_label' => function($tarefa, $key, $index) {
              return strtoupper($tarefa->getDescricao());
          },
          'choice_value' => function (Tarefa $tarefa = null) {
            return $tarefa ? $tarefa->getId() : 'x'; 
          },
          'data' => $agendamento->getTarefa()
        ]);
          $formBuilder->add('Confirmar', SubmitType::class, array('attr' => [
            'class' => 'btn btn-info btn-block login'
        ]));
        return $formBuilder->getForm();
      }

  }
