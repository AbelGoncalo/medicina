@extends('admin.dashboard')
@section('titulo','Painel Administrativo')
@section('conteudo')
<div class="container-fluid">
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$utentes ?? '0'}}</div>
                            <div>Utentes</div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user-md fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$medicos ?? '0'}}</div>
                            <div>Médicos</div>
                        </div>
                    </div>
                </div>
                 
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-medkit fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$exames ?? '0'}}</div>
                            <div>Exames</div>
                        </div>
                    </div>
                </div>
                 
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-handshake fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$consultas  ?? '0'}}</div>
                            <div>Consultas</div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> 
                
                    <span class="text text-center">Gráfico de Consultas Marcadas</span>
        
                    
                
                <div class="pull-right">
                    
                </div>
            </div>
            <!-- grafico-->
            <div class="panel-body">
                <canvas id="myChart" width="400" height="150"></canvas>
             </div>
        </div>
    </div>

    
        
 </div>
</div>
         

@endsection