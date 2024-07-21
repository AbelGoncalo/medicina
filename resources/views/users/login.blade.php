@extends('layouts.main')
@section('title','Acessar Sistema')
@section('content')
<section class="mt-4 container form_login">
    <form method="POST" action="{{$action}}" class=" col-md-5" >
       
      @csrf
      <h3 class="text text-dark text-center">Acessar Sistema</h3>
      <hr class="text-primary">
             
              @if(session('msg'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="text-center">{{session('msg')}}</p>
              </div>
              @endif
            <div>
                <label for="usuario">E-mail:</label>
                <input id="usuario" placeholder="exemplo@gmail.com" type="email" class="form-control"   name="email" >
                @error('usuario')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
   
            <div>
                <label for="password">Senha:</label>
                <input  id="password" placeholder="********" type="password" class="form-control mb-2"   name="password"  >
                @error('password')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
           
            <div >
                <button type="submit" class="btn" id="btn-logar">
                    Entrar
                </button>
            </div>
            <p class="mt-2 text text-center">Esqueceu sua password? <a href="#" data-toggle="modal" data-target="#redefinirtModal" class="link-item text text-center">Redefinir Password</a></p>
            <p class="mt-2 text text-center">Não possui uma conta? <a href="cadastrar.utente" class="link-item text text-center">Cadastra-se</a></p>


    </form>
</section>

<!-- Modal redefinir senha -->
  <div class="modal fade" id="redefinirtModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Redefinir Senha</h4>
        </div>
        
         <form action="/redifinir" method="post">
          @csrf
          <div class="col-md-12">
            
              <input type="email" placeholder="Informe seu email" name="email" id="email" class="form-control">
          </div>
          <div class="col-md-6 " >
            <button style="margin-left:46rem" type="submit" class="btn btn-primary">Redefinir</button>
          </div>
        </form>
         <div class="modal-footer"></div>
        </div>

    
      </div>
    </div>
  </div>
    <!-- Fim do Modal redefinir senha   -->
    
    
    
    
    
  @endsection