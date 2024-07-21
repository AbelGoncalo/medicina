@extends('layouts.main')
@section('title','Registro Clínico')
@section('content')
   <section class="container registro_clinico ">
    <h1 class="text-center">Registro Clínico</h1>
    {{-- Apresentação dos ddos pessoais do utente --}}
    <h4 class="text-center">Dados Pessoais</h4>
    <div class="divider-short"></div>
       <div class="dados_pessoais">
       
        <div class="secao1">
            <p><strong>Nome:</strong> {{$utente->nome}}</p>
            <p><strong>Nascimento:</strong> {{ \Carbon\Carbon::parse($utente->nascimento)->format('d-m-Y') }}</p>
            <p><strong>Seguradora:</strong> {{$utente->seguro}}</p>
            <p><strong>Seguro nº:</strong> {{$utente->seguro_numero}}</p>
        </div>
        <div class="secao2">
            <p><strong>BI nº:</strong> {{$utente->bi}}</p>
            <p><strong>Sexo:</strong> {{$utente->sexo}}</p>
            <p><strong>Morada:</strong> {{$utente->endereco->morada}}</p>
            <p><strong>Localidade:</strong> {{$utente->endereco->localidade}}</p>
        </div>
        <div class="secao3">
            <p><strong>E-mail:</strong>  {{$utente->contacto->email}}</p>
            <p><strong>Telefone:</strong> {{$utente->contacto->telefone}}</p>
            <p><strong>Código Postal:</strong> {{$utente->endereco->codigo_postal}}</p>
        </div>

       </div>
       {{-- ---------------------------------------------------------------------------------- --}}

        {{-- Histórico Clínico do utente --}}
        <h4 class="text-center">Histórico Clínico</h4>
        <div class="divider-short"></div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <input type="search"  name="buscar" id="buscar" class="form-control buscar_historico" placeholder="Pesquisar Histórico ">
        
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-historico text-center" id="dataTable" width="100%" cellspacing="0">

            <thead >
                <tr>
                   
                    <th>Exame</th>
                    <th>Resultado</th>
                    <th>Diagnóstico</th>
                    <th>Procedimento</th>
                    <th>Terapêutica</th>
                    @if (Auth::user()->Nivel !== 0 )
                    
                        <th>Ações</th>
                 
                    @endif
                    
                </tr>
            </thead>
            <tbody>
            @if(isset($historico_clinicos))
                  @foreach ($historico_clinicos as $historico)
                <tr>
                   
                    <td>{{$historico->exame_efetuado ?? '...'}}</td>
                    <td>{{$historico->resultado ?? '...'}}</td>
                    <td>{{$historico->dignostico ?? '...'}}</td>
                    <td>{{$historico->procedimento ?? '...'}}</td>
                    <td>{{$historico->terapeutica ?? '...'}}</td>
                    @if(Auth::user()->Nivel === 1 )
                    {{-- Acão do Medico no RCU do utente --}}
                    @php
                        echo $historico->medico;
                        echo $medico->id_medico;
                    @endphp
                
                    <td >
                            
                        <a data-id="{{$historico->id_historico_clinico}}" class="btn btn-info fa fa-plus historico"  title="Adicionar Informações Clínicas"></a>
                            
                    </td>
               
                    @endif 
                   
                </tr>
                @endforeach 
                @else 
             <tr>
                <td colspan="6" class="alert alert-info text-center">Nenhum exame marcado</td>

             </tr>
           
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
        {{-- -------------------------------------------------------------------------- --}}
      {{-- mostrar cosltas marcadas pelo  --}}
@if (Auth::user()->Nivel === 1)
    

<h4 class="text-center">Consultas Marcadas</h4>
<div class="divider-short"></div>
 
<div class="panel panel-default">
    <div class="panel-heading">
        <input type="search"  name="buscar" id="buscar" class="form-control" placeholder="Pesquisar Consulta">

    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
<div class="table-responsive">
    <table class="table table-bordered table-hover table-consultas" id="dataTable" width="100%" cellspacing="0">

    <thead >
        <tr>
            <th>#</th>
            <th>Exame</th>
            <th>Data de Marcação</th>
            <th>Data e Hora de Realizada</th>
            
            <th>Ações</th>
            
        </tr>
    </thead>
    <tbody>
        @if (count($consulta) > 0)
            
       
        @foreach ($consulta as $consulta)

       
        <tr>
            <td>{{$consulta->id_consulta}}</td>
            <td>{{$consulta->tipo_exame}}</td>
            <td>{{ \Carbon\Carbon::parse($consulta->data_marcacao)->format('d-m-Y H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse( $consulta->data_realizacao)->format('d-m-Y H:i')  ?? 'Pendente'}}</td>
          
            <td style="display: flex; justify-content:center">
                <a data-id="{{$consulta->id_consulta}}" class="fa fa-calendar fa-lg btn btn-info btn-id-consulta"  title="Definir data de realizacao"></a>
            
                @if ($consulta->status === 0)
                <form action="/consulta.terminada" method="post">
                    @csrf
                    <input type="hidden" name="id_consulta" value="{{$consulta->id_consulta}}">
                  
                    <button type="submit" class="fa fa-check fa-lg btn btn-success " title="Marcar como terminada" style="margin-left: 1rem"></button>
                </form>
                @endif
                
                
            </td>
          
        </tr>
        @endforeach
        @else
            <tr>
                <td colspan="6" class="alert alert-info text-center" >Nenhuma Consulta marcada</td>
            </tr>
        @endif
    </tbody>
</table>
</div>


</div>
</div>
@endif







        {{-- Histório Familiar de Saúde do Utente --}}
        <div class="outros_historico">
            <div class="historico_familiar_saude">
                <h6 class="text-center">Histórico Familiar de Saúde</h6>
                 <div class="divider-short"></div>
                 <ul class="opcoes">
                     
                    @if(Auth::user()->Nivel === 2  ||  Auth::user()->Nivel === 1 )
                        @if (isset($registro_clinico->historico_saude))
                        @foreach ($registro_clinico->historico_saude as $historico )
                            <li class="fa fa-check "> {{$historico }}</li><br>
                        @endforeach
                        
                        @else
                        <li class="class='h5'">Nenhuma adicionada</li><br>
                        @endif
                    @endif
 
                </ul>
                @if(Auth::user()->Nivel !=2  && Auth::user()->Nivel !=1 )
                 <button class="btn mt-4 showfirstForm" id="signup">Adicionar</button>
                @endif
               
               <form action="/doenca" method="post" class="col-md-9 formHereditaria" id="formHereditaria">
                @csrf
             
                <div class="firstContainer " style="margin-left: 5rem">

                </div>
                <div style="display:flex; flex-direction:column;  width:300px" class="col-md-12">
                <input type="hidden" name="id_utente" value="{{$utente->id_utente}}">
                <input type="text"  id="firstInput" class="form-control col-md-4 input-doencas" placeholder="Insira  doênça hereditária">
                {{-- <label for="" class="form-label"><small>Cartão de vacina:(opcional)</small></label>
                <input type="file" name="boletim"   class="form-control  input-doencas "> --}}
                <div  style="display: flex;">
                    <button  type="button"  class=" col-md-4 btn mt-3 firstAdd" id="signup" onclick="e.preventDefault();">Inserir</button>
                    <button style="margin-left:3px"  type="submit" class=" col-md-4 btn mt-3 btn firstSave btn_save" id="signup">Salvar</button>
                    <button style="margin-left:3px"   type="button" class=" col-md-4 btn mt-3 btn cancelFirstOperation" id="signup" onclick="e.preventDefault();">Fechar</button>
                </div>
                </div>
            </form>
                
               
                
            </div>
            
            <div class="container col-md-2">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h6>Cartão de Vacina</h6>
                            <div class="divider-short"></div>
                        </div>
                        <div class="card-body" style="margin-top:20px;">
                            @if (Auth::user()->Nivel === 2  ||  Auth::user()->Nivel === 1 )
                            <div id="cartao-container" >
                                <label for="cartao">
                                    @if ($registro_clinico->boletim_vacina === null)
                                    <p>Indisponível</p>
                                    @else
                                    <a href="/cartao/{{$registro_clinico->id_utente}}">Clicar para vêr</a> 
                                @endif
                                </label>
                            </div>
                            @else
                            @if(!(Auth::user()->Nivel === 2  ||  Auth::user()->Nivel === 1 ))

                            <div id="cartao-container" >
                                @if ($registro_clinico->boletim_vacina === 'Nenhum')
                              
                                <label for="cartao" class="text-center">Clica para <br> 
                                Carregar arquivo.</label>
                                @else
                                <label for="cartao" class="text-center">Já Carregou. <br>
                                    Para substituir clica.
                                </label>
                                @endif
                            </div>
                            @endif
                            @endif
                            @if(!(Auth::user()->Nivel === 2  ||  Auth::user()->Nivel === 1 ))
                            <form action="/adicionar/cartao" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="file" name="cartao" id="cartao" style="display:none">
                                <div style="display:flex;  justify-content:center">
                                <button type="submit" style="margin-left:1px; width:150px "   class="btn mt-4 file"  id="signup">Salvar</button>
                                </div>
                            </form>
                            @endif
                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="dados_medico">
                <h6 class="text-center">Dados Médicos (<strong>Alergias:</strong>)</h6>
                <div class="divider-short"></div>
                <ul class="lista-alergia" style="margin-top: 1rem">
                @if(Auth::user()->Nivel === 2  ||  Auth::user()->Nivel === 1 )
                    @if (isset($registro_clinico->alergias) )
                        @foreach ($registro_clinico->alergias as $alergias )
                            <li class="class='fa fa-check fa h5'"> {{$alergias }}</li><br>
                        @endforeach
                       
                        @else
                          <li class="class=' h5'">Nenhuma adicionada</li><br>
                    @endif
                     
                @endif
                </ul>
                <div style="margin-top: 3rem">
                    
                    @if(Auth::user()->Nivel === 2  || Auth::user()->Nivel ===  1 )
                       <p><strong>Grupo sanguínio:</strong> <span class="grupo-sanguinio">{{$registro_clinico->grupo_sanguinio ?? 'Indisponível'}}</span></p>
                    @else
                       <p><strong>Grupo sanguínio:</strong> <span class="grupo-sanguinio">{{$registro_clinico->grupo_sanguinio ?? 'Indisponível'}}</span></p> 
                    @endif
                </div>
                @if(Auth::user()->Nivel !=2  && Auth::user()->Nivel !=1 )
                <button type="submit" class="btn mt-4 showSecondForm" id="signup" onclick="e.preventDefault();">Adicionar</button>
                @endif

                <form action="/alergia" method="post" class="formAlergia col-md-12 " id="formAlergia" style="margin-top: 3.3rem; margin-bottom:4rem">
                    @csrf
                    <div class="secondContainer form-check">
            
                    </div>
                    
                    <input type="hidden" name="id_utente" value="{{$utente->id_utente}}">
                    <input type="text" id="secondInput" class="form-control  input-doencas" placeholder="Insira alergia">
                   
                    <input type="text" name="grupo_sanguinio" id="grupo_sanguinio" placeholder="Inserir seu grupo sanguinio" class="form-control col-md-2">
                    
                    <div>
                        <button type="button"  class="btn mt-4 secondAdd btn-small" id="signup"  onclick="e.preventDefault();">Inserir</button>
                        <button type="submit" style="margin-left:1px "   class="btn mt-4 secondSave"  id="signup">Salvar</button>
                        <button  type="button" style="margin-left:1px "   class="btn mt-4 btn SecondOperation" id="signup" onclick="e.preventDefault();">Fechar</button>
                    </div>
                </form>

                

            </div>
            
        </div>
        {{-- ---------------------------------------------------------------------------------------------- --}}

        {{-- Histórico das actividades --}}
        @if(Auth::user()->Nivel === 0  )
        <div class="actividades mt-5">
            <h6 class="text-center">Histórico das actividades</h6>
            <div class="divider-short"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-medico" id="dataTable" width="100%" cellspacing="0">
                <thead >
                    <tr>
                        <th>Exames Marcados</th>
                        <th>Marcado a</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($consulta) > 0)
                    @foreach ($consulta as $consultas)
                    <tr>
                        <td>{{$consultas->tipo_exame}}</td>
                        <td>{{$consultas->created_at->diffForHumans()}}</td>
                    </tr>
                 @endforeach
                 @else
                 <tr>
                     <td colspan="4">Nenhuma actividade</td>
                 </tr>
                 @endif
                </tbody>
            </table>
            {{-- -------------------------------------------------------------------------------------- --}}
        </div>
@endif
   </section>



   <input type="hidden"  id="id" value="{{$id}}">


{{-- Modal adicionar informacao no historico clinico --}}

<div class="modal fade" id="historicoClinicoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Adicionar Informações</h4>
        </div>
        <form action="/historico/add" method="post" >
            @csrf
            <div class="col-md-6">
                <label for="data">Resultado</label>
                <input type="text" placeholder="Resultado" name="resultado" id="resultado" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="hora">Diagnostico</label>
                <input type="text" placeholder="Diagnostico" class="form-control diagnostico"  name="diagnostico" id="diagnostico">
            </div>
            <div class="col-md-6">
                <label for="data">Procedimento</label>
                <input type="text" placeholder="Procedimento" class="form-control procedimento" name="procedimento" id="procedimento">
            </div>
            <div class="col-md-6">
                <label for="hora">Terapeutica</label>
                <input type="text" placeholder="Terapeutica" class="form-control terapia"  name="terapeutica" id="terapeutica">
            </div>
            <input type="hidden" name="id_historico" class="id_historico">
            <div class="col-md-4" style="margin-top: 2.5rem" >
                <button type="submit" class="btn btn-primary" style="margin-left:48rem; margin-bottom:1rem">Salvar</button>
            </div>
        </form>
        <div class="modal-footer"></div>
        
      </div>
    </div>
  </div>

  {{-- Modal mudar data de realizacao --}}

  <div class="modal fade" id="consulta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Alterar data e hora de atendimento</h4>
        </div>
        <form action="/alterar.atendimento.consulta" method="post" >
            @csrf
            <div class="col-md-8 "  style="margin-top: 3rem">
                <label for="data">Data e hora realização</label>
                <input type="datetime-local" class="form-control" name="data" id="data">
            </div>
            <input type="hidden"  id="id_consulta" name="id_consulta"  >
            <div class="col-md-4" style="margin-top: 7rem">
                <button type="submit" class="btn btn-primary">Alterar</button>
            </div>
        </form>
        <div class="modal-footer"></div>
        
      </div>
    </div>
  </div>


  
<style>
#cartao-container{
    
    width:200px;
    height:100px;
    display:flex; 
    justify-content:center;
    align-items:center;
    background-color:#454545;
    color:#fff;
    border-radius: 5px;
    margin-bottom: 5px;
    opacity: .8;

}
#cartao-container, label{

    cursor: pointer;
    
} 

#cartao-container label a{

text-decoration: none;
color: #fff;

} 
#cartao-container label a:hover{

text-decoration: underline;


} 

</style>
     
@endsection