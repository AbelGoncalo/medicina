@extends('admin.dashboard')
@section('titulo','Listar Utentes')
@section('conteudo')
<section class="listar_medicos">
    <div class="card mb-4">
        <a href="#" class=" btn-add-medico btn btn-primary" data-toggle="modal" data-target="#myModal" title="Endereços dos Utentes"><i class="fa fa-map"></i><span> Endereços de Utentes</span></a>

        <div class="card-body mt-4 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                     <input type="search"  name="buscar" id="buscar" class="form-control" placeholder="Pesquisar Utente">

                </div>
                <!-- /.panel-heading -->
                @if (count($utentes) > 0)
                <a style="margin: 15px" href="/relatorio.utente" target="_blank" id="relatorio"  class=" btn btn-primary">Imprimir Relatório</a>
                @endif
                <div class="panel-body">
            <div class="table-responsive">
                <table  class="table table-bordered table-hover table-utente" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="hide">#</th>
                            <th>Nome</th>
                            <th>Sexo</th>
                            <th>Nascimento</th>
                            <th>BI nº</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th>Ações</th>

                        </tr>
                    </thead>
                  
                    <tbody>
                        @if (count($utentes) > 0)
                            
                        @foreach ($utentes as $utente)
                            
                       
                        <tr>
                            <td class="hide">{{$utente->id_utente}}</td>
                            <td>{{$utente->nome}}</td>
                            <td>{{$utente->sexo}}</td>
                            <td>{{ \Carbon\Carbon::parse($utente->nascimento)->format('d-m-Y')}}</td>
                            <td>{{$utente->bi}}</td>
                            <td>{{ $utente->contacto->telefone}}</td>
                            <td>{{$utente->contacto->email}}</td>
                            <td class="admin-acoes-rcu-utente gap-3">
                         
                                <a href="/mostrar/{{$utente->id_utente}}" class="btn btn-info fa fa-eye fa-lg" title="Vêr RCU"></a>
                                
                                
                                     <a  id="btn-email" class="btn btn-success fa fa-send" title="Enviar Email" style="margin-left: 1rem"></a>
                              
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <tr>
                            <td colspan="8" class=" text-center alert alert-info">Utente <strong>{{Request('buscar')}}</strong> não  encontrado! Adicionar</a></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
</section>

{{-- Modal Endereco de Utentes --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
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
                                <th>[#Id]</th>
                                <th>Nome</th>
                                <th>Morada</th>
                                <th>Localidade</th>
                                <th>Cod.Postal</th>
                            </tr>
                        </thead>
                      
                        <tbody>
                            @foreach ($utentes as $utente)
                                
                           
                            <tr>
                                <td>{{$utente->id_utente}}</td>
                                <td>{{$utente->nome}}</td>
                                <td>{{$utente->endereco->morada}}</td>
                                <td>{{$utente->endereco->localidade}}</td>
                                <td>{{$utente->endereco->codigo_postal}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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



  <!-- Modal enviar email  -->
 
 


  <div class="modal fade" id="enviarEmailModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" >Enviar email para: <span id="titleModal"></span>  </h4>
        </div>
        
         <form action="/enviar/email" method="post">
          @csrf
          <div class="col-md-12">
              <input type="hidden"  name="email" id="email" class="form-control">
          </div>
          <div class="col-md-12">
              <textarea name="textconteudo" placeholder="Digite sua mensagem" class="form-control" id="textconteudo" ></textarea>
          </div>
          <div class="col-md-6 " >
            <button style="margin-left:49rem" type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>
         <div class="modal-footer"></div>
        </div>

    
      </div>
    </div>
  </div>
    <!-- Fim do Modal enviar email   -->
    



@endsection