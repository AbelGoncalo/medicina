@extends('admin.dashboard')
@section('titulo','Listar Especialidades')
@section('conteudo')
<section class="listar_medicos col-md-11  ">
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
<a href="#" class=" btn-add-medico btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i><span> Adicionar Especialidade Médica</span></a>

<div class="card-body mt-4 ">
  <div class="panel panel-default">
    <div class="panel-heading">
      <input type="search"  name="buscar" id="buscar" class="form-control" placeholder="Pesquisar Especialidade">

    </div>
    <!-- /.panel-heading -->
    @if (count($especialidades) > 0)
    <a style="margin: 15px" href="/relatorio.especialidade" target="_blank" id="relatorio"  class=" btn btn-primary">Imprimir Relatório</a>
    @endif
    <div class="panel-body">
    <div class="table-responsive">
        <table  id="tabelaEspecialidade" class="table  table-bordered table-hover table-especialidade" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="hide">#</th>
                    <th>Especialidade</th>
                    <th class="img">Imagem</th>
                    <th>Ações</th>

                </tr>
            </thead>
          
            <tbody>
              @if (count($especialidades) > 0)
                
            
                @foreach ($especialidades as $especialidade)
                    <tr>
                    <td class="hide">{{$especialidade->id_especialidade}}</td>
                    <td>{{$especialidade->especialidade}}</td>
                    <td class="img">{{$especialidade->imagem}} </td>
                    <td class="action">
                        <a href="#"  class="btn btn-warning fa fa-edit edit" title="Alterar Registros"></a>
                          <button type="submit" onclick="excluirRegistro('.excluirEspecialidade','/especialidade/deletar/'+{{$especialidade->id_especialidade}})" class="btn btn-danger fa fa-trash excluirEspecialidade" data-id="{{$especialidade->id_especialidade}}" title="Excluir Registros"></button>
                     
                      </td>
                </tr>

                  @endforeach
                  @else
                  <tr>
                  <td colspan="4" class=" text-center alert alert-info">Especialidades <strong>{{Request('buscar')}}</strong> não  encontrada! Adicionar</td>
                  </tr>
                  @endif

            </tbody>
        </table>
        {{$especialidades->links('pagination::bootstrap-4')}}
    </div>
</div>
</div>
</div>
</div>


<!-- Modal Adicionar especialidade -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Adicionar especialidade </h4>
</div>
<div class="">
<form action="{{$action}}" method="post" class="col-md-12 form-add-especialidade" enctype="multipart/form-data">
    @csrf

    <div class="col-md-12">
        <label for="especialidade" class="form-label ">Especialidade</label>
        <input type="text"  class="form-control col-md-12"   name="especialidade" id="especialidade" value="{{old("especialidade")}}" >
    </div>
    <div class="col-md-12">
      <label for="" class="form-label ">Imagem</label>
      <input type="file" name="imagem" id="imagem" class="form-control" value="{{old("imagem")}}">

    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-add-especialidade ">Salvar</button>
    </div>

</div>

<div class="modal-footer">

</div>
</form>
</div>
</div>
</div>
</div>
<!-- Fim do Modal Adicionar especilidade -->

<!-- Modal Editar especilidade -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Editar especialidade </h4>
</div>
<div class="">
  <form action="/editar.especialidade" id="editForm" id="editForm" method="post" class="col-md-12 form-add-especialidade" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="col-md-12">
          <label for="nome" class="form-label ">Especialidade</label>
          <input type="text"  class="form-control col-md-12"   name="nome" id="EditEspecialidade" >

      </div>
      <div class="col-md-12">
        <label for="" class="form-label ">Imagem</label>
        <input type="file" name="imagem" id="imagem" class="form-control" >
        <img id="EditImagem" style="width:100px;height:100px; margin-top:1rem"> 
     
      </div>
      <input type="hidden" name="id_especialidade" id="id">
      <div class="col-md-12">
          <button type="submit" class="btn btn-primary btn-add-especialidade " id="btnEdit">Atualizar</button>
      </div>
  
</div>

<div class="modal-footer">
  
</div>
</form>
</div>
</div>
</div>
<!-- Fim do Modal Editar especilidade -->
</section>





@endsection