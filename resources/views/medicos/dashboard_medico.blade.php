@extends('layouts.main')
@section('title','Untentes')
@section('content')
   <section class="container registro_clinico  utentes">
       <h3>Consultas marcadas com o Sr(a).</h3>
    <div class="table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading">
                <input type="search"  name="buscar" id="buscar" class="form-control" placeholder="Pesquisar Utente">
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
        <table class=" table table-bordered table-hover table-utente " id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th  class="hide">#</th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Nascimento</th>
                    <th>Exame Marcado</th>
                    <th>Data a ser realizada</th>
                    <th>Ações</th>

                </tr>
            </thead>
          
            <tbody>
                @if (count($consultas) > 0)
                    
                @foreach ($consultas as $consulta)
                    
               
                <tr>
                    {{-- <td class="hide">{{$utente->id_utente}}</td> --}}
                    <td>{{$consulta->nome}}</td>
                    <td>{{$consulta->sexo}}</td>
                    <td>{{$consulta->nascimento}}</td>
                    <td>{{$consulta->tipo_exame}}</td>
                    <td>{{\Carbon\Carbon::parse($consulta->data_realizacao)->format('d/m/Y H:i')?? 'Ainda não definida'}}</td>
             
                    
                    <td class="admin-acoes-rcu-utente gap-3" >
                        
                        <a href="/mostrar/{{$consulta->id_utente}}" class="btn btn-info fa fa-eye fa-lg" title="Vêr RCU"></a>

                    </td>
                </tr>
                @endforeach

                @else
                    <tr >
                    <td colspan="9" class=" text-center alert alert-info">Sr(a) {{Auth::user()->nome}}, Nenhuma consulta foi marcada consigo de momento.<strong></td>
                    </tr>
                @endif
            </tbody>
        </table>
        
    </div>
        </div>




        
   </section>




     
  
 
@endsection