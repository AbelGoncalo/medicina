<div id="wrapper">
	
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		
        <div class="container navigation">
		
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand " href="/">
                    <img src="/img/logo.svg" alt="logtipo do site" width="50" height="50" />
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div  class=" collapse navbar-collapse navbar-right navbar-main-collapse">
			  <ul class="nav navbar-nav ">
				<li class="active"><a href="/">Página inicial</a></li>
				<li><a href="..#service">Serviços</a></li>
				<li><a href="..#doctor">Médicos</a></li>
				<li><a href="..#facilities">Especialidades</a></li>
                <li><a href="/fale.conosco">Contacta-nos</a></li>
                @if(Auth::user())
                {{-- Area das notificações --}}
                @if( Auth::user()->Nivel === 0)
                <li><a href="/notificacao_utente">
                    Notificações
                    <span class="badge bg-secondary">
                        {{Auth::user()->unreadnotifications->count()}}
                    </span>
                </a></li>
                @elseif ( Auth::user()->Nivel === 1)
                <li><a href="/notificacao_medico">
                    Notificações
                    <span class="badge bg-secondary">
                        {{Auth::user()->unreadnotifications->count()}}
                    </span>
                </a></li>
                @endif
                
                {{-- Fim das notificações --}}

                {{-- Ação do usuário --}}
				<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        @if (isset(Auth::user()->imagem))
                        <img src="{{asset('/storage/usuario'.Auth::user()->id_usuario.'/'.Auth::user()->imagem)}}" alt="foto-de-perfil"  id="foto_perfil" class="img-xs rounded-circle">  {{Auth::user()->nome}} <b class="caret"></b>
                        @else
                        <img src="{{'/img/sem-foto.png'}}" alt="foto-de-perfil"  id="foto_perfil" class="img-xs rounded-circle">  {{Auth::user()->nome}} <b class="caret"></b>

                        @endif
                    </a>
                    {{-- Verificar e apresentar informações dos usuarios 
                        de acordo o seu nivel de acesso --}}
                    @if(Auth::user()->Nivel === 0)
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/perfil"><i class="fa fa-user fa-fw"></i> Actualizar Perfil</a>
                        <li><a href="/selecionar"><i class="fa fa-edit fa-fw"></i> Marcar Consulta</a>
                        <li>
      
                            <a href="/mostrar/{{Auth::user()->id_usuario}}" ><i class="fa fa-table fa-fw"></i>
                                Registro Clínico
                            </a>
                      
                        <li><a href="/sair"><i class="fa fa-sign-out fa-fw"></i>Sair</a>
                        </li>
                    </ul>

                    @else
                    @if (Auth::user()->Nivel === 1)
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/perfil"><i class="fa fa-user fa-fw"></i> Actualizar Perfil</a>
                        <li><a href="/dashboard.medico"> <i class="fas fa-heartbeat fa-fw"></i> Consultas Marcadas</a>
                        <li><a href="/sair"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                    </ul>
                    @else
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/perfil"><i class="fa fa-user fa-fw"></i> Actualizar Perfil</a>
                        <li><a href="/admin.dashboard"><i class="fa fa-table fa-fw"></i> Painel Administrativo</a>
                        <li><a href="/sair"><i class="fa fa-sign-out fa-fw"></i>Sair</a>
                        </li>
                    </ul>
                    @endif
                    @endif
                </li>
                {{-- Fim da ação do usuário --}}
                @else
                <li><a href="/logar">Entrar</a></li>
                <li><a href="/cadastrar.utente">Cadastrar-se</a></li>
                @endif

			  </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
 
</div>	