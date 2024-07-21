<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$titulo}}</title>
 <style>
     table{
         border-collapse: collapse;
         text-align: center;
         width:700px;
         padding: 2rem;
    
     }
    
      
      h1,h2{
         text-align: center;
     }
     img{
         width: 80px;
         margin-left: 310px;
     }
     p{
         text-align:right;
     }
 </style>
</head>
<body>
    <section>
    
            <img src="img/logo.svg" alt="Logotipo da clinica">
            <h1>Clinica Kerubim</h1>
            <h2>Relatório de Consultas </h2>
        
        <table border="1">
            <thead>
                <tr>
              
                    <th>Exame</th>
                    <th>Data de marcação</th>
                    <th>Data de realização</th>
                    <th>Obs.</th>
                    <th>Médico</th>
                 
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $dado)
                    <tr>
                        
                        <td>{{$dado->tipo_exame}}</td>
                        <td>{{\Carbon\Carbon::parse($dado->data_marcacao)->format('d-m-Y H:i') }}</td>
                        <td>{{\Carbon\Carbon::parse($dado->data_realizacao)->format('d-m-Y H:i')}}</td>
                        <td>{{($dado->status === 1)? 'Realizada':'Pendente'}}</td>
                        <td>{{$dado->medico->nome}}</td>
                   
                    </tr>
                @endforeach
               
            </tbody>
        </table>
    
    <p>Data: {{date('d-m-Y H:i:s')}}</p>
    </section>
</body>
</html>