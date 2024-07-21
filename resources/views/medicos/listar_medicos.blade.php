@extends('admin.dashboard')
@section('titulo','Listar Médico')
@section('conteudo')
<section class="listar_medicos col-md-12">
    <div class="card mb-4">
      @if ($errors->all() )
        <div class="alert alert-danger container col-md-11 offset-md-3">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          @foreach($errors->all() as $error)
            <p>{{$error}}</p>
          @endforeach
        </div>
      @endif
        <a href="#" class="btn btn-primary btn-add-medico"data-toggle="modal" data-target="#formModal" title="Adicionar  Médico"> <i class="fa fa-plus"></i><span> Adicionar Médicos</span></a>
        <a href="#" class="btn btn-primary btn-add-medico" data-toggle="modal" data-target="#myModal" title="Endereço do Médico"> <i class="fa fa-map"></i><span> Endereços dos Médicos</span></a>
       
      <div class="card-body mt-4 ">
        <div class="panel panel-default">
          <div class="panel-heading">
            <input type="search"  name="buscar" id="buscar" class="form-control" placeholder="Pesquisar Médico">
          </div>
          <!-- /.panel-heading -->
          @if (count($medicos) > 0)
          <a style="margin: 15px" href="/relatorio.medico" target="_blank" id="relatorio"  class=" btn btn-primary">Imprimir Relatório</a>
          @endif
          <div class="panel-body">
            <div class="table-responsive " >
                <table  class=" table table-bordered table-hover table-medico " id="tabelaMedico" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="hide">#</th>
                            <th>Nome</th>
                            <th>Gênero</th>
                            <th>Nascimento</th>
                            <th>BI nº</th>
                            <th>Especialidade</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th class="hide">Morada</th>
                            <th class="hide">Localidade</th>
                            <th class="hide">Codigo Postal</th>

                            <th>Ações</th>

                        </tr>
                    </thead>
                  
                    <tbody>
                        @if (count($medicos) > 0)
                            
                        
                        @foreach ($medicos as $medico)
                            
                       
                        <tr>
                            <td class="hide">{{$medico->id_medico}}</td>
                            <td>{{$medico->nome}}</td>
                            <td>{{$medico->sexo}}</td>
                            <td>{{ \Carbon\Carbon::parse($medico->nascimento)->format("d-m-Y")}}</td>
                            <td>{{$medico->bi}}</td>
                            <td>{{$medico->especialidade}}</td>
                            <td>{{$medico->contacto->telefone }}</td>
                            <td>{{$medico->contacto->email}}</td>
                            <td class="hide">{{$medico->endereco->morada}}</td>
                            <td class="hide">{{$medico->endereco->localidade}}</td>
                            <td class="hide">{{$medico->endereco->codigo_postal}}</td>

                            <td class="action">
                                <a href="#" class="btn btn-warning fa fa-edit editMedico" title="Alterar Registros"></a>
                                  <button type="submit" onclick="excluirRegistro('.excluirMedico','/medico/deletar/'+{{$medico->id_medico}})" class="btn btn-danger fa fa-trash excluirMedico" data-id="{{$medico->id_medico}}" title="Excluir Registros"></button>
                              </td>
                        </tr>
                          @endforeach
                            @else

                            <tr>
                              <td colspan="9" class=" text-center alert alert-info">Médico(a) <strong>{{Request('buscar')}}</strong> não  encontrado(a)!</a></td>

                            </tr>

                          @endif
                        </tbody>
                      </table>
                      <div>
                        {{$medicos->links('pagination::bootstrap-4')}}
                      </div>
                  </div>
              </div>
          </div>
       
</section>



{{-- Modal Endereco de Medicos --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Endereços dos Médicos</h4>
      </div>
      <div class="modal-body">
          <div class="card-body mt-4 ">
              <div class="table-responsive">
                  <table class="table table-bordered table-hover table-medico" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th class="hide">[#Id]</th>
                              <th>Nome</th>
                              <th>Morada</th>
                              <th>Localidade</th>
                              <th>Cod.Postal</th>
                          </tr>
                      </thead>
                    
                      <tbody>
                          @foreach ($medicos as $medico)
                              
                         
                          <tr>
                              <td class="hide">{{$medico->id_medico}}</td>
                              <td>{{$medico->nome}}</td>
                              <td>{{$medico->endereco->morada}}</td>
                              <td>{{$medico->endereco->localidade}}</td>
                              <td>{{$medico->endereco->codigo_postal}}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  {{$medicos->links('pagination::bootstrap-4')}}
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
            </div>
      </div>
      </div>
    </div>
  </div>
</div>
{{-- -------------------------------------------------------------------------------------------------------- --}}
{{-- Modal adicionar medico --}}
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Adicionar Médico</h4>
      </div>
      <div class="">
          <div class="card-body mt-4 ">
            <form action="{{$action}}" method="post" class="col-md-12 form-add-medico">
              @csrf
              <div class="col-md-4">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" value="{{old("nome")}}" class="form-control" name="nome" id="nomeMed" placeholder="Utilizador">
         
              </div>
  
              <div class="col-md-4">
                  <label for="nascimento" class="form-label">Data Nascimento</label>
                  <input type="date" value="{{old("nascimento")}}" class="form-control" name="nascimento" id="nascimentoMed" >
               
                </div>
  
                <div class="col-md-4">
                  <label for="bi" class="form-label">BI nº</label>
                  <input type="text" maxlength="15" class="form-control" name="bi" id="biMed" placeholder="Número do BI">
                
                </div>
                <div class="col-md-4">
                  <label for="sexo" class="form-label">Gênero</label>
                  <select name="sexo" id="sexoMed" class="form-control">
                    <option  selected disabled >Selecionar...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                  </select>
                   
                </div>
  
                <div class="col-md-4">
                  <label for="especialidade" class="form-label">Especialidade</label>
                  <select name="especialidade" id="especialidadeMed" class="form-control">
                    <option  selected disabled >Selecionar...</option>
                    @foreach ($especialidades as $especialidade)
                    <option value="{{$especialidade->especialidade ?? ''}}">{{$especialidade->especialidade ?? ''}}</option>
                    @endforeach
                  </select>
               
                </div>
  
                <div class="field">
                  <div class="col-md-4">
                    <label for="morada" class="form-label">Morada</label>
                    <input type="text" value="{{old("morada")}}" class="form-control" name="morada" id="moradaMed" placeholder="Morada">
               
                  </div>
  
                  <div class="col-md-4">
                      <label for="localidade" class="form-label">Localidade</label>
                      <input type="text" value="{{old("localidade")}}" class="form-control" name="localidade" id="localidadeMed" placeholder="Localidade">
                   
                    </div>
  
                    <div class="col-md-4">
                      <label for="codigo_postal" class="form-label">Código Postal</label>
                      <input type="text" value="{{old("codigo_postal")}}" class="form-control" name="codigo_postal" id="codigo_postalMed" onkeypress="$(this).mask('00000-000')" class="form-control" placeholder="00000-000" >
                  
                    </div>
  
                    <div class="col-md-4">
                      <label for="telefone" class="form-label">Telefone</label>
                      <input type="tel" maxlength="9" value="{{old("telefone")}}" class="form-control" name="telefone" id="telefoneMed" placeholder="999-999-999" onkeypress="$(this).mask('999-999-999')" class="form-control" name="telefone" id="telefone" onkeypress="$(this).mask('999-999-999')" >
                 
                    </div>
  
                    <div class="col-md-4">
                      <label for="email" class="form-label">E-mail</label>
                      <input type="email" value="{{old("email")}}" class="form-control" name="email" id="emailMed" placeholder="E-mail">
                   

                    </div>
                    
                    <div class="field">
                      <div class="col-md-4 " id="container_btn">
                        <button type="submit" class="btn btn-primary btn-salvar-medico">Salvar</button>
                      
                      </div>
                    </div>
                  </div>
          
          </div>
              <div class="modal-footer ">
              </div>
          </form>
      </div>
      </div>
    </div>
  </div>
 

{{-- ------------------------- Modal Editar Medico----------------------------------- --}}

<div class="modal fade" id="EditMedicoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Médico</h4>
      </div>
      <div class="">
          <div class="card-body mt-4 ">
            <form action="/medico.editar"  method="post" class="col-md-12 form-add-medico formEdit" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="col-md-4">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Utilizador">
        
              </div>
  
              <div class="col-md-4">
                  <label for="nascimento" class="form-label">Data Nascimento</label>
                  <input type="date" class="form-control" name="nascimento" id="nascimento" >
            
                </div>
  
                <div class="col-md-4">
                  <label for="bi" class="form-label">BI nº</label>
                  <input type="text" maxlength="15" class="form-control" name="bi" id="bi" placeholder="Número do BI">
             
                </div>
                <div class="col-md-4">
                  <label for="sexo" class="form-label">Sexo</label>
                  <select name="sexo" id="sexo" class="form-control">
                    <option  selected disabled >Selecionar...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                  </select>
                 
                </div>
  
                <div class="col-md-4">
                  <label for="especialidade" class="form-label">Especialidade</label>
                  <select name="especialidade" id="especialidade" class="form-control">
                    <option  selected disabled >Selecionar...</option>
                    @foreach ($especialidades as $especialidade)
                    <option value="{{$especialidade->especialidade ?? ''}}">{{$especialidade->especialidade ?? ''}}</option>
                    @endforeach
                  </select>
                
                </div>
  
                <div class="field">
                  <div class="col-md-4">
                    <label for="morada" class="form-label">Morada</label>
                    <input type="text" class="form-control" name="morada" id="morada" placeholder="Morada">
              
                  </div>
  
                  <div class="col-md-4">
                      <label for="localidade" class="form-label">Localidade</label>
                      <input type="text" class="form-control" name="localidade" id="localidade" placeholder="Localidade">
                 
                    </div>
  
                    <div class="col-md-4">
                      <label for="codigo_postal" class="form-label">Código Postal</label>
                      <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" placeholder="Código Postal">
               
                    </div>
  
                    <div class="col-md-4">
                      <label for="telefone" class="form-label">Telefone</label>
                      <input maxlength="9" onkeypress="$(this).mask('999-999-999')" class="form-control" name="telefone" id="telefone" onkeypress="$(this).mask('999-999-999')" placeholder="999-999-999" type="tel" class="form-control" name="telefone" id="telefone">
                 
                    </div>
  
                    <div class="col-md-4">
                      <label for="email" class="form-label">E-mail</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
             
                      <input type="hidden" name="id" id="id_medico">
                
                    </div>
                    <div class="field">
                      <div class="col-md-4 " id="container_btn">
                        <button type="submit" class="btn btn-primary btn-salvar-medico">Salvar</button>

                      </div>
                    </div>
                  </div>
          
          </div>
              <div class="modal-footer ">
              </div>
          </form>
      </div>
      </div>
    </div>
  </div>
</div>
 
@endsection
