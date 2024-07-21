@extends('admin.dashboard')
@section('titulo','Consultas')
@section('conteudo')
<section class="col-md-11">
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
 
            <h4 class="h1 text text-center">Consultas Marcadas</h4>
            <div class="panel panel-default" style="width:100rem">
                <div class="panel-heading">
                    <input type="search"  name="buscar" id="buscar" class="form-control" placeholder="Pesquisar Consulta">

                </div>
                <!-- /.panel-heading -->
                @if (count($consultas) > 0)
                <a style="margin: 15px" href="/relatorio.consulta" target="_blank" id="relatorio"  class=" btn btn-primary">Imprimir Relatório</a>
              
                @endif
                <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-consultas" id="dataTable"  cellspacing="0">
            
                <thead >
                    <tr>
                     
                        <th>Exame</th>
                        <th>Codigo do utente</th>
                        <th>Medico</th>
                        <th>Data de Marcação</th>
                        <th>Data e Hora de Realizada</th>
                        <th>Anexo</th>
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @if (count($consultas) > 0)
                        
                   
                    @foreach ($consultas as $consulta)

                   
                    <tr>
                        <td style="display: none">{{$consulta->id_consulta}}</td>
                        <td>{{$consulta->tipo_exame}}</td>
                        <td>{{$consulta->id_utente}}</td>
                        <td>{{$consulta->medico->nome}}</td>
                        <td>{{\Carbon\Carbon::parse($consulta->data_marcacao)->format('d-m-Y H:i')}}</td>
                        <td>{{ ($consulta->data_realizacao === null) ? 'Pendente':\Carbon\Carbon::parse($consulta->data_realizacao)->format('d-m-Y H:i')}}</td>
                        <td>
                            @if($consulta->anexos === "Nenhum")
                            Nenhum
                            @else

                                <a target="_blank" href="/download/{{$consulta->id_consulta}}">Visualizar</a>
                            @endif
                        </td>
                        <td>
                        <a data-id="{{$consulta->id_consulta}}" class="btn btn-info btn-consultas"  title="Definir data de realizacao">
                            <i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
                        </a>
                        <a href="{{$consulta->id_consulta}}/remover" class="btn btn-danger "  title="Remover consulta">
                            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                        </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="alert alert-info text-center" >Nenhuma Consulta marcada</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{$consultas->links('pagination::bootstrap-4')}}
            </div>

 
</div>
</div>


 

  
  <!-- Modal definir data e hora de atendimento -->
  <div class="modal fade" id="consulta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Definir data e hora de atendimento</h4>
        </div>
        <form action="/atendimento.consulta" method="post" >
            @csrf
            <div class="col-md-8 "  style="margin-top: 3rem">
                <label for="data">Data e hora realização</label>
                <input type="datetime-local" class="form-control" name="data" id="data">
            </div>
            <input type="hidden"  id="id_consulta" name="id_consulta"  >
            <div class="col-md-4" style="margin-top: 5.5rem">
                <button type="submit" class="btn btn-primary">Definir</button>
            </div>
        </form>
        <div class="modal-footer"></div>
        
      </div>
    </div>
  </div>
</section>
 

 
@endsection