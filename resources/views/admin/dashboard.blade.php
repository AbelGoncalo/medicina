
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Painel administrativo">
        <meta name="author" content="António Albino José Miguel">
        <link rel="shortcut icon" href="" type="image/x-icon">
        <title>@yield('titulo')</title>

        <!-- FontAwesome/Pacote de icones -->
        <link href="css/all.min.css" rel="stylesheet" type="text/css">
        <link href="/admin/css/all.min.css" rel="stylesheet" type="text/css">

        <link href="/css/fontawesome.min.css" rel="stylesheet" type="text/css">
        <link href="/admin/css/fontawesome.min.css" rel="stylesheet" type="text/css">

        <!-- Bootstrap Core CSS -->
        <link href="admin/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="/admin/css/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="/admin/css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/admin/css/startmin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="/admin/css/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="font-awesome/css/all.min.css">
        <link rel="stylesheet" href="admin/dataTables/dataTables.responsive.css">
        {{-- Sweetalert  --}}
        <link rel="stylesheet" href="/admin/css/sweetalert2.min.css">
       {{-- Customizar admin dashboard --}}
       <link rel="stylesheet" href="admin/css/custom_admin.css">
    </head>
    <body>

        

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
             

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li>
                       <img src="/img/logo_a.svg" alt="" width="150" height="40">
                    </li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown navbar-inverse">
                        <a  href="/notificacao_admin">
                            Notificações
                            <span class="badge bg-secondary">
                                {{Auth::user()->unreadNotifications->count()}}
                            </span>
                        </a>
                      
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw fa-lg">
                                </i>{{Auth::user()->nome}}<b class="caret"></b>

                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="/"><i class="fa fa-home fa-fw"></i>Página Inícial</a>
                            <li><a href="/perfil"><i class="fa fa-user fa-fw"></i> Actualizar Perfil</a>
                            <li class="divider"></li>
                            <li><a href="/sair"><i class="fa fa-sign-out fa-fw"></i>Sair</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Menu lateral -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            
                              
                                <!-- links do menu -->
                            
                            <li>
                                <p class="h2 text-center">Menú</p>
                            </li>
                            <li>
                                <a href="/admin.dashboard" class="h4"><i class="fa fa-home fa-lg " aria-hidden="true"></i><span> Página Inícial</span></a>
                           
                              </li>
                            <li>
                                <a href="/utente.listar" class="h4"><i class=" fa fa-user fa-lg "></i><span> Utentes</span></a>
                           
                              </li>
                            <li>
                                <a href="/medico.listar" class="h4"><i class="fa fa-user-md fa-lg " aria-hidden="true"></i><span> Médicos</span></a>
                            </li>
                          <li>
                            <a href="/especialidade.listar" class="h4"><i class="fa fa-book fa-lg " aria-hidden="true"></i><span> Especialidades</span></a>
                        </li>
                        <li>
                            <a href="/exame.listar" class="h4"> <i class="fa fa-medkit fa-lg " aria-hidden="true"></i><span> Exames</span></a>
                        </li>
                          <li>
                            <a href="/consulta.listar" class="h4"><i class="fa fa-handshake fa-lg " aria-hidden="true"></i><span> Consultas</span></a>
                        </li>

                        
                        </ul>
                    </div>
          
            </nav>

            <main id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12 header_admin_dashboard my-5">
                        <h3 >Administrador : {{Auth::user()->nome}} </h3>
                   
                    </div> 
              
                </div>
                <hr>
               @yield('conteudo')
              </main>
            <!-- /#page-wrapper -->

        {{-- </div> --}}
        <!-- /#wrapper -->
       
        <!-- jQuery -->
        <script src="/admin/js/jquery.min.js"></script>
        <script src="/admin/js/jquery.js"></script>
        <script src="/js/ jquery-1.10.2.js"></script>
           {{-- grafico com chart.js --}}
       <script src="/js/chart.min.js"></script>
       <script src="/admin/js/morris.min.js"></script>
     
       {{-- <script src="/admin/css/dataTables/dataTables.min.js"></script> --}} 
        <!-- Bootstrap Core JavaScript -->
        <script src="/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="/admin/js/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="/admin/js/raphael.min.js"></script>
        {{-- Jquery Mask --}}
        <script src="{{asset('js/jquery.mask.min.js')}}"></script>
        

        <!-- Custom Theme JavaScript -->
        <script src="/admin/js/startmin.js"></script>
        <script src="/admin/js/dataTables/dataTables.min.js"></script>

        @include('sweetalert::alert')
        
        {{-- Script Para editar Especialidade --}}
        <script src="/js/jquery-3.6.0.min.js"></script>
        <script src="/js/scriptEditarRegistro.js"></script>
        <script src="/js/script_rcu.js"></script>
        <script src="/admin/js/relatorio.js"></script>
        {{-- Script requisição Ajax --}}

        <script src="/admin/js/scriptCadastro.js"></script>
        <script src="/admin/js/scriptListar.js"></script>
        {{-- sweetalert messagem de retorno --}}
        <script src="/admin/js/sweetalert2.all.min.js"></script>

        {{-- Fim do script para editar Especialidade --}}


        {{-- Mostrar mensagens de alerta --}}
        {{-- Mesagens de sucesso--}}
        @if (Session::has('success'))
            <script>
                Swal.fire({
               
                    position: 'center',
                    icon: 'success',
                    title: "{!!Session::get('success')!!}",
                    showConfirmButton: true,
                   
            })
            </script>
        @endif
        {{-- Fim das mensagens de sucesso --}}

          {{-- Mesagens de erro--}}
          @if (Session::has('error'))
          <script>
              Swal.fire({
             
                  position: 'center',
                  icon: 'error',
                  title: "{!!Session::get('error')!!}",
                  showConfirmButton: true,
              
          })
          </script>
      @endif
      {{-- Fim das mensagens de erro --}}
 
          {{-- Mesagens de Aviso--}}
          @if (Session::has('warning'))
          <script>
              Swal.fire({
             
                  position: 'center',
                  icon: 'warning',
                  title: "{!!Session::get('warning')!!}",
                  showConfirmButton: true,
                
          })
          </script>
      @endif
      {{-- Fim das mensagens de aviso --}}

      {{-- Alert deletar registros --}}
      <script>
            function excluirRegistro(btn,rota){
            $(btn).click(function(){
            let idExame =  $(this).attr('data-id');
                
            Swal.fire({
                title: 'Deseja realmente excluir o registro ?',
                text: "Não pode reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Excluir'

                }).then((result) => {
                if (result.isConfirmed) {
                    window.location = rota;
                    Swal.fire({
                    title:'Registro excluido com sucesso.',
                    icon:'success',
                
                    })
                }
                })
            })
            }




          
     </script>

      {{-- fim do alerta deletar registros --}}
       
      <script>   


      
        $(document).ready(function(){
           /*Pesquisar medico*/
       
             $("#buscar").keyup(function(){
             let valor  = $(this).val().toLowerCase();

            $('.table-medico tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
            })
          }) 
          /*fim*/

           /*Pesquisar utente*/
       
           $("#buscar").keyup(function(){
             let valor  = $(this).val().toLowerCase();

            $('.table-utente tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
            })
          }) 
          /*fim*/

           /*Pesquisar especialidade*/
       
           $("#buscar").keyup(function(){
             let valor  = $(this).val().toLowerCase();

            $('.table-especialidade tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
            })
          }) 
          /*fim*/

           /*Pesquisar consulta*/
       
           $("#buscar").keyup(function(){
             let valor  = $(this).val().toLowerCase();

            $('.table-consultas tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
            })
          }) 
          /*fim*/

           /*Pesquisar exame*/
       
           $("#buscar").keyup(function(){
             let valor  = $(this).val().toLowerCase();

            $('.tabela-exame  tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
            })
          }) 
          /*fim*/
           })
          
   
        
      </script>
 

 <script>
    const ctx = document.getElementById('myChart');
  var _ydata = JSON.parse('{!! json_encode($months ?? '')  !!}');
  var _xdata = JSON.parse('{!! json_encode($monthCount ?? '')  !!}');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: _ydata,
            datasets: [{
                label: 'Consultas Marcadas',
                data: _xdata,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(153, 110, 255, 0.2)',
                    'rgba(153, 109, 255, 0.2)',
                    'rgba(153, 108, 255, 0.2)',
                    'rgba(153, 103, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
     

 
 
    </body>
</html>


