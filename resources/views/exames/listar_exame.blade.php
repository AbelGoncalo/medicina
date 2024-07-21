@extends('admin.dashboard')
@section('titulo','Listar Exames')
@section('conteudo')
<section class="listar_medicos col-md-11">
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
        <a href="#" class=" btn-add-medico btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i><span> Adicionar Exame</span></a>

        <div class="card-body mt-4 ">
          <div class="panel panel-default">
            <div class="panel-heading">
              <input type="search"  name="buscar" id="buscar" class="form-control" placeholder="Pesquisar Exame">

            </div>
            @if (count($exames) > 0)
            <a style="margin: 15px" href="/relatorio.exame" target="_blank" id="relatorio"  class=" btn btn-primary">Imprimir Relatório</a>
            @endif
            <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover tabela-exame " id="tabelaExame" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="hide">#</th>
                            <th>Exame</th>
                            <th>Especialidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                  
                    <tbody>
                      @if (count($exames) > 0)
                        
                        @foreach ($exames as $exame)
                            
                       
                            <tr>
                            <td class="hide">{{$exame->id_exame}}</td>
                            <td>{{$exame->nome}}</td>
                            <td>{{$exame->especialidade}}</td>

                            <td class="action">
                                <button type="submit" class="btn btn-warning fa fa-edit editExame " title="Alterar Registros"></button> &nbsp;
                                <button type="submit" class="btn btn-danger fa fa-trash deleteExame " title="Excluir Registros" onclick="excluirRegistro('.deleteExame','/exame/deletar/'+{{$exame->id_exame}})" data-id="{{$exame->id_exame}}"></button>
                            </td>
                        </tr>
                          @endforeach

                          @else
                          <tr>
                            <td colspan="4" class=" text-center alert alert-info">Exame <strong>{{Request('buscar')}}</strong> não  encontrado! <a class="active" href="/exame.listar">Clica aqui para vêr Todos</a></td>
                          </tr>
                      @endif
                    </tbody>
                </table>
                {{$exames->links('pagination::bootstrap-4')}}

            </div>
        </div>
    </div>
</div>
</section>

<!-- Modal adicionar exame-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Adicionar exame</h4>
      </div>
      <div class="">
        {{-- form --}}
        <form action="{{$action}}" method="post" class="col-md-12 form-add-exame">
          @csrf
          <div class="col-md-12">
              <label for="nome">Exame</label>
              <input type="text"  class="form-control"   name="nome" id="nome" value="{{old("nome")}}" >
 
          </div>
          <div class="col-md-12">
              <label for="especialidade">Especialidade</label>
              <Select name="id_especialidade" id="id_especialidade"   class="form-control">
                  <option selected  disabled>Selecionar...</option>
                  @foreach ($especialidades as $especialidade)
                      <option value="{{$especialidade->id_especialidade}}">{{$especialidade->especialidade}}</option> 
                  @endforeach
                 
              </Select>
      
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-add-exame">Salvar</button>
          </div>
      </div>
      <div class="modal-footer"></div>
    </form>
    </div>
  </div>
</div>


<!-- Modal editar exame-->
<div class="modal fade" id="exameModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar exame</h4>
      </div>
      <div class="">
        {{-- form --}}
        <form action="/exame.editar" method="post" class="col-md-12 form-add-exame">
          @csrf
          @method('PUT')
          <div class="col-md-12">
              <label for="nome">Exame</label>
              <input type="text"  class="form-control"   name="nome" id="nomeExame" >
      
          </div>
          <div class="col-md-12">
              <label for="especialidade">Especialidade</label>
              <Select name="id_especialidade" id="id_especialidadeExame"   class="form-control">
                  <option selected  disabled>Selecionar...</option>
                  @foreach ($especialidades as $especialidade)
                      <option value="{{$especialidade->id_especialidade}}">{{$especialidade->especialidade}}</option> 
                  @endforeach
                 
              </Select>
              <input type="hidden" name="id_exame" id="id_Exame">
  
        
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-add-exame">Salvar</button>
          </div>
      </div>
      <div class="modal-footer"></div>
    </form>
    </div>
  </div>
</div>


 
@endsection
