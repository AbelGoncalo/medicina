@extends('layouts.main')
@section('title','Cadastrar-se')
@section('content')
<section class="mt-5 container form_signup">
     
     <form action="{{$action}}" method="POST" class="col-md-9 ">
       @csrf
       {{-- Apresentacao do formulario --}}
       <div class="row">
          <div class="text-center">
            <h2 class="h-bold">Cadastra-se aqui</h2>
          </div>
          <div class="divider-short"></div>
        </div> 
        {{-- Fim --}}
        {{-- Construcao do campo nome , data nascimento e bi  --}}
          <div class="field">
            <div class="col-md-12">
              <label for="nome" class="form-label">Nome Completo</label>
              <input type="text" class="form-control" name="nome" id="nome" placeholder="Utilizador" value="{{old("nome")}}">
            @error('nome')
              <small class="text-danger">{{$message}}</small>
            @enderror
            </div>
            {{-- -------------------------------------- --}}
            <div class="col-md-12">
              <label for="nascimento" class="form-label">Data Nascimento</label>
              <input type="date" class="form-control" name="nascimento" id="nascimento" value="{{old("nascimento")}}">
              @error('nascimento')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
            {{-- -------------------------------------- --}}
            <div class="col-md-12">
              <label for="bi" class="form-label">BI nº</label>
              <input type="text" maxlength="15" class="form-control" name="bi" id="bi" placeholder="BI Nº" value="{{old("bi")}}">
              @error('bi')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
        {{-- ------------------------------------------ --}}

        {{-- Construcao do campo sexo seguradora e numero de seguro  --}}
        <div class="field">
         
          {{-- -------------------------------------- --}}
          <div class="col-md-12" style="margin-top:1rem ">
            <label for="sexo" class="form-label">Genero</label>
            <select name="sexo" id="sexo" class="form-control">
              <option  selected disabled >Selecionar...</option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
            </select>
              @error('sexo')
                <small class="text-danger">{{$message}}</small>
              @enderror
          </div>
          <div class="col-md-12">
            <label for="seguro" class="form-label">Seguradora</label>
            <input type="text" value="{{old("seguro")}}" class="form-control" name="seguro" id="seguro" placeholder="Seguradora">
            @error('seguro')
              <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
          {{-- -------------------------------------- --}}
          <div class="col-md-12">
            <label for="seguro_numero" class="form-label">Seguro nº</label>
            <input type="number" value="{{old("seguro_numero")}}"  class="form-control" name="seguro_numero" id="data_nascimento">
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
          <input type="text" value="{{old("morada")}}" class="form-control" name="morada" id="morada" placeholder="Morada">
          @error('morada')
            <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        {{-- -------------------------------------- --}}
        <div class="col-md-12">
          <label for="localidade" class="form-label">Localidade</label>
          <input type="text" value="{{old("localidade")}}" class="form-control" name="localidade" id="localidade" placeholder="Localidade">
          @error('localidade')
              <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
        <div class="col-md-12">
          <label for="codigo_postal" class="form-label">Código Postal</label>
          <input maxlength="8" type="text" value="{{old("codigo_postal")}}" onkeypress="$(this).mask('00000-000')" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="00000-000">
          @error('codigo_postal')
              <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>
    {{-- ------------------------------------------ --}}
    {{-- Construcao do campo email, telefone password --}}
    <div class="field">
      <div class="col-md-12">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" value="{{old("email")}}" class="form-control" name="email" id="email" placeholder="email@gmail.com">
        @error('email')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div>
      {{-- -------------------------------------- --}}
      <div class="col-md-12">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="tel" value="{{old("telefone")}}" onkeypress="$(this).mask('999-999-999')" class="form-control" name="telefone" id="telefone" maxlength="9" onkeypress="$(this).mask('999-999-999')" placeholder="999-999-999">
        @error('telefone')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div>
      <div class="col-md-12">
        <label for="password" class="form-label">Senha</label>
        <input type="password"  class="form-control" name="password" id="password" placeholder="********">
        @error('password')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div>

      <div class="col-md-12">
        <label for="comfir_senha" class="form-label">Confirmar Senha</label>
        <input type="password" class="form-control" name="comfir_senha" id="comfir_senha" placeholder="********">
        @error('comfir_senha')
          <small class="text-danger">{{$message}}</small>
        @enderror
      </div>
    </div>
  {{-- ------------------------------------------ --}}
  <div class="field">
    <div class="col-md-12 " id="container_btn">
      <button type="submit" class="btn" id="signup">Cadastrar</button>
    </div>
  </div>
  </div>
  
     </form>


</section>
@endsection

 