@extends('layouts.main')
@section('title','Notificações')
@section('content')
<section class="container mt-10 notificacoes " >
    <h4>Notificações</h4>
    @if(Auth::user()->unreadNotifications->count() > 0)
        @foreach (Auth::user()->unreadNotifications as $notification)
        <div class="alert alert-info alert-dismissible" role="alert">
          <span>Caro Utente,</span> <strong>{{Auth::user()->nome}}! </strong>
          <p class="mensagen">{{$notification->data['mensagen']}}</p>
          <p><strong>Recebida a {{$notification->created_at->diffForHumans()}}</strong></p>
        <p>
            <a href="/notificacao.lida/{{$notification->id }}" class="btn btn-primary"><strong>Marcar como lida</strong> </a>
            <a href="remover/{{$notification->id}}" title="remover" class="btn btn-danger" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>

        </p>
        </div>
        @endforeach
        {{-- @else
        <div id="empty" class=" alert alert-info">
            <p class="text-center" >Nenhuma notificação disponível</p>
        </div> --}}
    @endif
  
    @foreach (Auth::user()->readNotifications as $notification)
    <div class="alert alert-success alert-dismissible" role="alert">
      <span>Caro Utente,</span> <strong>{{Auth::user()->nome}}! </strong>
      <p class="mensagen">{{$notification->data['mensagen']}}</p>
      <p>
          <strong>Visualizada a {{$notification->read_at->diffForHumans()}}</strong>
          <a href="remover/{{$notification->id}}" title="remover" class="btn btn-danger" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>

        </p>
    </div>
    @endforeach
@if (Auth::user()->unreadNotifications->count() > 0)
<div class="marcarcomolidada">
    <a href="/notificacaes.lidas" class="btn mb-5 marcartodos" id="signup"> Marcar todas como lidas</a>
</div>
  

@endif
@if (Auth::user()->Notifications->count() ===0)
<div  class=" alert alert-info" >
    <p class="text-center" >Nenhuma notificação disponível</p>
</div>
@endif
</section>

<style>
    .notificacoes{
        margin-top: 10rem;
        margin-bottom: 15rem
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

    #empty{
        margin-top: -80vh;
    }
    .notificacoes {
        margin-top: 20vh;
    }
</style>

 
@endsection