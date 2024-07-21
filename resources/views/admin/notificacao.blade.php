@extends('admin.dashboard')
@section('titulo','Painel Administrativo')
@section('conteudo')
<section class="container mt-10 notificacoes  " >
    <h4>Notificações</h4>
    @if(Auth::user()->unreadNotifications->count() > 0)
        @foreach (Auth::user()->unreadNotifications as $notification)
        <div class="alert alert-info alert-dismissible width" role="alert">
          <span>Caro Administrador,</span> <strong>{{Auth::user()->nome}}! </strong>
          <p class="mensagen">{{$notification->data['mensagen']}}, <strong><a href="/consulta.listar">ver detalhes</a></strong> </p>
          <p><strong>Recebida a {{$notification->created_at->diffForHumans()}}</strong></p>
        <p>
            <a href="/notificacao.lida/{{$notification->id }}" class="btn btn-primary"><strong>Marcar como lida</strong> </a>
            <a href="remover/{{$notification->id}}" title="remover" class="btn btn-danger" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>

        </p>
        </div>
        @endforeach
        @else

        <div id="empty" class=" alert alert-info">
            <p class="text-center" >Nenhuma notificação disponível</p>
        </div>
    
    @endif
  
    @foreach (Auth::user()->readNotifications as $notification)
    <div class="alert alert-success alert-dismissible" role="alert">
      <span>Caro Administrador,</span> <strong>{{Auth::user()->nome}}! </strong>
      <p class="mensagen">{{$notification->data['mensagen']}}</p>
      <p>
          <strong>Visualizada a {{$notification->read_at->diffForHumans()}}</strong>
          <a href="remover/{{$notification->id}}" title="remover" class="btn btn-danger" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>

        </p>
    </div>
    @endforeach

    <div class="marcarcomolidada">
           <a href="/notificacaes.lidas" class="btn btn-primary mb-5 marcartodos" id="signup"> Marcar todas como lidas</a>
    </div>
</section>

<style>
    .notificacoes{
        margin-top: 3rem;
        margin-bottom: 15rem
      
    }
    .notificacoes > div{

        width:104rem;
    }
    
    .lida{
        padding: 2px;
        text-transform:capitalize;
        text-decoration: underline
       
    }
    .mensagen{
        text-align: justify;
    }
    .marcarcomolidada{
        
        margin-bottom: 1rem
    }
</style>

 
@endsection