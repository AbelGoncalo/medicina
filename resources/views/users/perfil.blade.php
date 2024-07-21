@extends('layouts.main')
@section('title','Registro Clínico')
@section('content')
<section class="perfil-usuario container" >
  <div class="image col-md-6 container">
    @if (isset(Auth::user()->imagem))
    <img src="{{asset('/storage/usuario'.Auth::user()->id_usuario.'/'.Auth::user()->imagem )}}" alt="" class="file">
    <button class="btn" id="signup" data-toggle="modal" data-target="#modal_inserir_image">Editar foto</button>
    @else
        <img src="{{'img/sem-foto.png'}}" alt="" class="file">
        <button class="btn" id="signup" data-toggle="modal" data-target="#modal_inserir_image">Editar foto</button>
    @endif
  </div>
  {{-- Mostrar essa parte da view caso o usuario logado seja um utente --}}
  <div class="form_actualizar_perfil col-md-12 container">
    @if (Auth::user()->Nivel === 0  )
        <form action="{{$action_utente}}" method="post" id="form_actualizar_dados" >
          @csrf
          @method('PUT')
          <h3>Informações de Perfil</h3>
          <p>Actualiza seu perfil</p>
          {{-- Construcao do campo nome , data nascimento e bi  --}}
          <div class="field">
            
            <div class="col-md-12">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" name="nome_utente" id="nome" placeholder="Utilizador" value="{{$usuario->nome ?? ''}}">
            @error('nome')
              <small class="text-danger">{{$message}}</small>
            @enderror
            </div>
            {{-- -------------------------------------- --}}
            <div class="col-md-12">
              <label for="nascimento" class="form-label">Data Nascimento</label>
              <input type="date" class="form-control" name="nascimento" id="nascimento" value="{{$usuario->nascimento ?? ''}}">
              @error('nascimento')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
            {{-- -------------------------------------- --}}
            <div class="col-md-12">
              <label for="bi" class="form-label">BI nº</label>
              <input type="text" class="form-control" maxlength="15" name="bi" id="bi" placeholder="Número do BI" value="{{$usuario->bi ?? ''}}">
              @error('bi')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
        {{-- ------------------------------------------ --}}

        {{-- Construcao do campo sexo seguradora e numero de seguro  --}}
        <div class="field">
         
          {{-- -------------------------------------- --}}
          <div class="col-md-12">
            <label for="sexo" class="form-label">Genero</label>
            <select name="sexo" id="sexo" class="form-control">
              <option  selected  >{{$usuario->sexo ?? ''}}</option>
            </select>
              @error('sexo')
                <small class="text-danger">{{$message}}</small>
              @enderror
          </div>
          <div class="col-md-12">
            <label for="seguro" class="form-label">Seguradora</label>
            <input type="text" class="form-control" name="seguro" id="seguro" placeholder="Seguradora" style="margin-top:-1px" value="{{$usuario->seguro ?? ''}}">
            @error('seguro')
              <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
          {{-- -------------------------------------- --}}
          <div class="col-md-12">
            <label for="seguro_numero" class="form-label">Seguro nº</label>
            <input type="number" class="form-control" name="seguro_numero" id="data_nascimento" style="margin-top:-1px" value="{{$usuario->seguro_numero ?? ''}}">
            @error('seguro_numero')
            <small class="text-danger">{{$message}}</small>
          @enderror
          </div>
        </div>

      {{-- ------------------------------------------ --}}
 

      {{-- Construcao do campo morada, localidade caodigo postal  --}}
      <div class="field">
        <div class="col-md-12">
          <label for="morada" class="form-label">Morada</label>
          <input type="text" class="form-control" name="morada" id="morada" placeholder="Morada" value="{{$usuario->endereco->morada ?? ''}}">
          @error('morada')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        {{-- -------------------------------------- --}}
        <div class="col-md-12">
          <label for="localidade" class="form-label">Localidade</label>
          <input type="text" class="form-control" name="localidade" id="localidade" placeholder="Localidade" value="{{$usuario->endereco->localidade ?? ''}}">
          @error('localidade')
              <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="col-md-12">
          <label for="codigo_postal" class="form-label">Código Postal</label>
          <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="Código Postal" value="{{$usuario->endereco->codigo_postal ?? ''}}">
          @error('codigo_postal')
              <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>
    {{-- ------------------------------------------ --}}
    {{-- Construcao do campo email, telefone password --}}
     <div class="field">
      <div class="col-md-4">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email_utente" class="form-control"  id="email" placeholder="E-mail" value="{{Auth::user()->email ?? ''}}">
        @error('email')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div> 
      {{-- -------------------------------------- --}}
      <div class="col-md-4">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="tel" class="form-control" maxlength="12" name="telefone" id="telefone" placeholder="Telefone" value="{{$usuario->contacto->telefone ?? ''}}" onkeypress="$(this).mask('999-999-999')">
        @error('telefone')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn" id="signup" style="margin-top: 4.1rem; width:100%">Salvar</button>
      </div>
    </div>
 
  </form> 



  {{-- Mostrar essa parte da view caso o usuario logado seja um   Medico  --}}
  @elseif(Auth::user()->Nivel === 1)

    <form action="{{$action_medico}}" method="post" id="form_actualizar_dados">
      @csrf
      @method('PUT')
      <h3>Informações de Perfil</h3>
      <p>Actualiza seu perfil</p>
      
      {{-- Construcao do campo nome , data nascimento e bi  --}}
      <div class="field">
        <div class="col-md-12">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" name="nome_medico" id="nome" placeholder="Utilizador" value="{{$usuario->nome ?? ''}}">
        @error('nome')
          <small class="text-danger">{{$message}}</small>
        @enderror
        </div>
        {{-- -------------------------------------- --}}
        <div class="col-md-12">
          <label for="nascimento" class="form-label">Data Nascimento</label>
          <input type="date" class="form-control" name="nascimento" id="nascimento" value="{{$usuario->nascimento ?? ''}}">
          @error('nascimento')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        {{-- -------------------------------------- --}}
        <div class="col-md-12">
          <label for="bi" class="form-label">BI nº</label>
          <input type="text" class="form-control" maxlength="15" name="bi" id="bi" placeholder="Número do BI" value="{{$usuario->bi ?? ''}}">
          @error('bi')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>
    {{-- ------------------------------------------ --}
  {{-- Construcao do campo morada, localidade caodigo postal  --}}
  <div class="field">
    <div class="col-md-12">
      <label for="morada" class="form-label">Morada</label>
      <input type="text" class="form-control" name="morada" id="morada" placeholder="Morada" value="{{$usuario->endereco->morada ?? ''}}">
      @error('morada')
        <small class="text-danger">{{$message}}</small>
      @enderror
    </div>
    {{-- -------------------------------------- --}}
    <div class="col-md-12">
      <label for="localidade" class="form-label">Localidade</label>
      <input type="text" class="form-control" name="localidade" id="localidade" placeholder="Localidade" value="{{$usuario->endereco->localidade ?? ''}}">
      @error('localidade')
          <small class="text-danger">{{$message}}</small>
      @enderror
    </div>
    <div class="col-md-12">
      <label for="codigo_postal" class="form-label">Código Postal</label>
      <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="Código Postal" value="{{$usuario->endereco->codigo_postal ?? ''}}">
      @error('codigo_postal')
          <small class="text-danger">{{$message}}</small>
      @enderror
    </div>
  </div>
  {{-- ------------------------------------------ --}}
  {{-- Construcao do campo email, telefone password --}}
  <div class="field ">
  <div class="col-md-4" >
    <label for="email" class="form-label">E-mail</label>
    <input type="email" class="form-control" name="email_medico"  id="email" placeholder="E-mail" value="{{Auth::User()->email ?? ''}}">
    @error('email')
      <small class="text-danger">{{$message}}</small>
    @enderror
  </div>
  {{-- -------------------------------------- --}}
  <div class="col-md-4">
    <label for="telefone" class="form-label">Telefone</label>
    <input type="tel" class="form-control" maxlength="12" onkeypress="$(this).mask('999-999-999')" class="form-control" name="telefone" id="telefone" onkeypress="$(this).mask('999-999-999')" name="telefone" id="telefone" placeholder="Telefone" value="{{$usuario->contacto->telefone ?? ''}}">
    @error('telefone')
      <small class="text-danger">{{$message}}</small>
    @enderror
  </div>
  <div class="col-md-4">
    <button type="submit" class="btn" id="signup" style="margin-top: 4.1rem; width:100%">Salvar</button>
  </div>
  </div>


    
  </form> 



  @else
  {{-- form admin perfil --}}
  <form action="{{$action_admin}}" method="post" id="form_actualizar_dados">
    @csrf
    @method('PUT')
    <h3>Informações de Perfil</h3>
    <p>Actualiza seu perfil</p>
    
    {{-- Construcao do campo nome , data nascimento e bi  --}}
    <div class="field">
      <div class="col-md-12">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome" id="nome" placeholder="Utilizador" value="{{$usuario->nome}}">
      @error('nome')
        <small class="text-danger">{{$message}}</small>
      @enderror
      </div>
  
{{-- ------------------------------------------ --}}
{{-- Construcao do campo email, telefone password --}}
<div class="col-md-12">
  <label for="email" class="form-label">E-mail</label>
  <input type="email" class="form-control" name="email_admin" id="email" placeholder="E-mail" value="{{Auth::User()->email ?? ''}}">
  @error('email_admin')
    <small class="text-danger">{{$message}}</small>
  @enderror
</div>
<div class="col-md-12">
  <button type="submit" class="btn" id="signup" style="margin-top: 4.1rem; width:100%">Salvar</button>
</div>
</div>


   
</form> 
  @endif
  {{-- --------------------------------------------------- --}}
  <form action="{{$senha}}" method="post" class="form_alterar_password">
    @csrf
    @method('PUT')
    <h3>Actualizar Senha</h3>
    <p>Cria uma palavra passe segura</p>
    <div class="col-md-6">
      <label for="actual_password" class="form-label">Senha actual</label>
      <input type="password" class="form-control" name="actual_password" id="password" placeholder="********">
      @error('actual_password')
        <small class="text-danger">{{$message}}</small>
      @enderror
    </div>
    <div class="col-md-6">
      <label for="nova_password" class="form-label">Nova senha </label>
      <input type="password" class="form-control" name="nova_password" id="nova_password" placeholder="Nova Senha ">
      @error('nova_password')
        <small class="text-danger">{{$message}}</small>
      @enderror
    </div>

    <div class="col-md-6">
      <label for="confirmar_password" class="form-label">Confirmar senha </label>
      <input type="password" class="form-control" name="confirmar_password" id="confirmar_password" placeholder="Confirmar Senha">
      @error('confirmar_password')
        <small class="text-danger">{{$message}}</small>
      @enderror
    </div>
    
      <div class="col-md-6 " id="btn_salvar_senha">
        <button type="submit" class="btn" id="signup">Salvar</button>
      </div>
    
      
  
 </form>

         @if (!(Auth::user()->Nivel === 1 || Auth::user()->Nivel === 2))
          <div class="apagar_conta col-md-12 ">
            <h3>Apagar sua conta</h3>
            <p>Apagar permanentimente</p>
            <button type="button" class="btn" id="btn_apagar_conta" data-toggle="modal" data-target="#Modal_apagar_conta" >Apagar Conta</button>
          </div>
        @endif
      

</div>
 
 

<!-- Modal  Apagar conta-->
<div class="modal fade" id="Modal_apagar_conta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Apagar conta permanentimente</h4>
      </div>
      <form action="apagar.utente" method="post">
        @csrf
      <div class="modal-body">
          <input type="password" name="senha" placeholder="Informe a senha" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn" id="btn_apagar_conta">Apagar</button>
      </div>
    </form>
    </div>
  </div>
</div>
  {{-- -------------------------------------------------------------------- --}}
  
<!-- Modal  inserir image conta-->
<div class="modal fade" id="modal_inserir_image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Carregar uma imagem</h4>
      </div>
      <form action="{{$imagem}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
      <div class="modal-body">
          <input type="file" name="foto"  class="form-control">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn" id="signup" >Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>

     
    
    
</section>
@endsection