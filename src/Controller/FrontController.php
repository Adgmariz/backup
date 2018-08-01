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
  use Symfony\Component\Form\Extension\Core\Type\IntegerType;
  use Symfony\Component\Form\Extension\Core\Type\FileType;

  use App\Entity\LogTarefa;
  use App\Entity\Tarefa;
  use App\Entity\Agendamento;
  use App\Entity\Usuario;

  class FrontController extends Controller{

      private function prepareFormLogin(){
        return $this->createFormBuilder(null, array(
            'action'  => '/login',
            'method'  => 'POST'
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
            $tarefas = $this->getDoctrine()->getRepository(Tarefa::class)->fetchAllAtivos();
            $form = $this->prepareFormEditar($agendamento);
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
        $usuario_id = (int)$form['usuario'];
        $tarefa_id = (int)$form['tarefa'];
        //Repositories
        $agendamentoRepository = $this->getDoctrine()->getRepository(Agendamento::class);
        $usuarioRepository = $this->getDoctrine()->getRepository(Usuario::class);
        $tarefaRepository = $this->getDoctrine()->getRepository(Tarefa::class);
        //Validações
        $resultAgendamento = $agendamentoRepository->findById($agendamento_id)[0];
        if($resultAgendamento != NULL){
          $resultUsuario = $usuarioRepository->findById($usuario_id)[0];
          $resultTarefa = $tarefaRepository->findById($tarefa_id)[0];
          if($resultUsuario != NULL && $resultTarefa != NULL){
              $resultAgendamento->setUsuario($resultUsuario->getId());
              $resultAgendamento->setTarefa($resultTarefa->getId());

              // var_dump($resultAgendamento);exit;
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($resultAgendamento);
              $entityManager->flush($resultAgendamento);
              return $this->listaragendamentos();
          }
        }
      }

        //$this->getDoctrine()->getRepository(Agendamento::class)->update()
      private function prepareFormEditar(Agendamento $agendamento){
        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        $tarefas = $this->getDoctrine()->getRepository(Tarefa::class)->fetchAllAtivos();
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

        $formBuilder->add('frequencia', IntegerType::class, array('data'=>$agendamento->getFrequencia()));

          $formBuilder->add('Confirmar', SubmitType::class, array('attr' => [
            'class' => 'btn btn-info btn-block login'
        ]));
        return $formBuilder->getForm();
      }

      /**
       * @Route("/excluiragendamento/{id}")
       */
      public function excluirAgendamento(Agendamento $agendamento = null){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($agendamento);
        $entityManager->flush();
        return $this->redirect('/listaragendamentos');
      }

      private function prepareForm($action, Agendamento $agendamento = NULL){
        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        $tarefas = $this->getDoctrine()->getRepository(Tarefa::class)->fetchAllAtivos();
        $defaultDataTarefa = NULL;
        $defaultDataUsuario = NULL;

        $formBuilder = $this->createFormBuilder(null, array(
            'action' => $action,
            'method' => 'POST',
        ));
        if($agendamento != NULL){
          $formBuilder->add('agendamento', HiddenType::class, array('attr' => [
            'value' => $agendamento->getId()
          ]));
          $defaultDataTarefa = $agendamento->getTarefa();
          $defaultDataUsuario = $agendamento->getUsuario();
        }
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
          'data' => $defaultDataUsuario
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
          'data' => $defaultDataTarefa
        ]);
          $formBuilder->add('Confirmar', SubmitType::class, array('attr' => [
            'class' => 'btn btn-info btn-block login'
        ]));
        return $formBuilder->getForm();
      }

      /**
       * @Route("/criaragendamento")
       */
      public function criarAgendamento(){
        $form = $this->prepareForm("/processacriaragend");
        return $this->render("front/criaragendamento.html.twig",['form' => $form->createView()]);
      }

      /**
       * @Route("/processacriaragend")
       */
      public function processaCriarAgendamento(){
        $form = $_POST['form'];
        $agendamento = new Agendamento();
        $agendamento->setUsuario($form['usuario']);
        $agendamento->setTarefa($form['tarefa']);
        $agendamento->setFrequencia(1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($agendamento);
        $entityManager->flush($agendamento);
        
        return $this->redirect('/listaragendamentos');
      }

      private function prepararTarefa($tarefa){
        $usuarioToSet = $this->getDoctrine()->getRepository(Usuario::class)->findById($tarefa->getUsuario());
        $tarefa->setUsuario($usuarioToSet[0]);//$usuarioToSet[0] é uma instância de Usuario
        return $tarefa;
      }

      /**
       * @Route("/listartarefas")
       */
      public function listartarefas(){
        $tarefas = $this->getDoctrine()->getRepository(Tarefa::class)->fetchAllAtivos();
        foreach($tarefas as $tarefa){
          $tarefa = $this->prepararTarefa($tarefa);
        }
        return $this->render('front/listartarefas.html.twig', ['tarefas'=>$tarefas]);
      }

      private function prepareFormTarefa(){
        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        $formBuilder = $this->createFormBuilder(null, array(
          'action' => "/processacriartarefa",
          'method' => 'POST',
      ));
      $formBuilder->add('usuario', ChoiceType::class, [
        'choices' => [
            $usuarios
        ],
        'choice_label' => function($usuario, $key, $index) {
            return strtoupper($usuario->getNome());
        },
        'choice_value' => function (Usuario $usuario = null) {
          return $usuario ? $usuario->getId() : 'x'; 
        }
        ]);
        $formBuilder->add('descricao', TextType::class);
        $formBuilder->add('caminho', TextType::class);
        // $formBuilder->add('caminho', FileType::class);
        $formBuilder->add('Confirmar', SubmitType::class, array('attr' => [
          'class' => 'btn btn-info btn-block login'
      ]));
        return $formBuilder->getForm();
      }

      /**
       * @Route("/criartarefa")
       */
      public function criarTarefa(){
        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        $form = $this->prepareFormTarefa();
        return $this->render("front/criartarefa.html.twig",[ 'usuarios'   =>$usuarios,
                                                             'form'       =>$form->createView()]);
      }

      /**
       * @Route("/processacriartarefa")
       */
      public function processaCriarTarefa(){
        $form = $_POST['form'];
        // var_dump($form);exit;
        // var_dump($_FILES);exit;
        $tarefa = new Tarefa();
        
        $usuarioToSet = $form['usuario'];
        $usuarioToSet = $this->getDoctrine()->getRepository(Usuario::class)->findById($usuarioToSet);
        $usuario = $usuarioToSet[0];
        $usuarioId = $usuario->getId();

        $tarefa->setUsuario($usuarioId);
        $tarefa->setDescricao($form['descricao']);
        $tarefa->setAtivo(1);
        $tarefa->setCaminho($form['caminho']);
        $dataCriacao = date('d-m-Y H:i');
        $tarefa->setDataCriacao($dataCriacao);
        $dataAlteracao = date('d-m-Y H:i');
        $tarefa->setDataAlteracao($dataAlteracao);
        $caminhoExists = file_exists($tarefa->getCaminho());

        if($caminhoExists){
          $tarefaExists = $this->getDoctrine()
          ->getRepository(Tarefa::class)
          ->findByCaminho($tarefa->getCaminho());
          //Se $tarefaExists for um array vazio, é porque não existe tarefa com o caminho informado.
          $tarefaExists = count($tarefaExists);
          if($tarefaExists == 0){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tarefa);
            $entityManager->flush($tarefa);
            return $this->listartarefas();
          }
          else{
            return $this->render('front/tarefaexistente.html.twig');
          }
        }
        else{
          return $this->render('front/caminhoinvalido.html.twig');
        }
        // var_dump($var);exit;
        // var_dump(exec('cp /home/alexis/Downloads/Redacao_Enem.tif /home/backup/', $output, $result), $output, $result);exit;
        //se $result for diferente de 0, é pq falhou.
        
        }

        /**
       * @Route("/executartarefa/{id}")
       */
        public function executarTarefa(Tarefa $tarefa = null){
          if($tarefa != null){
            $caminho = $tarefa->getCaminho();
            $arrayBarras = explode('/', $tarefa->getCaminho());
            $pos = count($arrayBarras) - 1;
            $isFile = strpos($arrayBarras[$pos], '.');
            $comando = "cp -f";
            $args = " ";
            if($isFile == false){
              //passar cp -R path/pasta /home/backup
              $args = " -R ";
            }
            exec($comando.$args.$caminho." /home/backup", $output, $result);
            // var_dump($comando.$args.$caminho." /home/backup");exit;
            return $this->listartarefas();
          }
          else{
            throw new \Exception("Objeto 'Tarefa' não encontrado");
          }
        }

        private function prepareFormEditarTarefa(Tarefa $tarefa){
          $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        $formBuilder = $this->createFormBuilder(null, array(
          'action' => "/processaeditatarefa",
          'method' => 'POST',
        ));
        $formBuilder->add('usuario', ChoiceType::class, [
        'choices' => [
            $usuarios
        ],
        'choice_label' => function($usuario, $key, $index) {
            return strtoupper($usuario->getNome());
        },
        'choice_value' => function (Usuario $usuario = null) {
          // var_dump($usuario);exit;
          return $usuario ? $usuario->getId() : 'x'; 
        },
        'data' => $tarefa->getUsuario()
        ]);
        $formBuilder->add('descricao', TextType::class, [
          'data' => $tarefa->getDescricao()
        ]);
        $formBuilder->add('caminho', TextType::class, [
          'data' => $tarefa->getCaminho()
        ]);
        $formBuilder->add('tarefa', HiddenType::class, array('attr' => [
          'value' => $tarefa->getId()
        ]));
        $formBuilder->add('Confirmar', SubmitType::class, array('attr' => [
          'class' => 'btn btn-info btn-block login'
      ]));
        return $formBuilder->getForm();
        }

      /**
       * @Route("/editartarefas/{id}")
       */
      public function editartarefas(Tarefa $tarefa = null){
        if($tarefa != null){
          $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
          $tarefa = $this->prepararTarefa($tarefa);
          $form = $this->prepareFormEditarTarefa($tarefa);
          return $this->render("front/editartarefa.html.twig",['usuarios'   =>$usuarios,
                                                              'form'       =>$form->createView()]);
        }
        else{
          throw new \Exception("Objeto 'Tarefa' não encontrado" );
        }
      }

      /**
       * @Route("/processaeditatarefa")
       */
      public function processaEditaTarefa(){
        $form = $_POST['form'];
        $usuario_id = (int)$form['usuario'];
        $descricao = $form['descricao'];
        $caminho = $form['caminho'];
        $tarefa = $form['tarefa'];
        //Repositories
        $usuarioRepository = $this->getDoctrine()->getRepository(Usuario::class);
        $tarefaRepository = $this->getDoctrine()->getRepository(Tarefa::class);
        //Validações
        $resultTarefa = $tarefaRepository->findById($tarefa)[0];

        if($resultTarefa != NULL){
          $resultUsuario = $usuarioRepository->findById($usuario_id)[0];
          if($resultUsuario != NULL){
              $resultTarefa->setUsuario($resultUsuario->getId());
              $resultTarefa->setDescricao($descricao);
              $resultTarefa->setCaminho($caminho);
              // var_dump($resultAgendamento);exit;
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($resultTarefa);
              $entityManager->flush($resultTarefa);
              return $this->listartarefas();
         }
        }
      }

      /**
       * @Route("/excluirtarefa/{id}")
       */
      public function excluirTarefa(Tarefa $tarefa = null){
        $tarefa->setAtivo(0);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tarefa);
        $entityManager->flush();
        return $this->redirect('/listartarefas');
      }


  }