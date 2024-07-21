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
         padding: 1rem;
    
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
            <h2>Relatório de Utentes </h2>
        
        <table border="1">
            <thead>
                <tr>
              
                    <th>Nome</th>
                    <th>Genero</th>
                    <th>Seguro</th>
                    <th>Seguro nº</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    
                 
                 
                </tr>
            </thead>
            <tbody>
                @foreach ($dados as $dado)
                    <tr>
                        
                        <td>{{$dado->nome}}</td>
                        <td>{{$dado->sexo}}</td>
                        <td>{{$dado->seguro}}</td>
                        <td>{{$dado->seguro_numero}}</td>
                        <td>{{$dado->contacto->telefone}}</td>
                        <td>{{$dado->contacto->email}}</td>

                      
                   
                    </tr>
                @endforeach
               
            </tbody>
        </table>
    
    <p>Data: {{date('d-m-Y H:i:s')}}</p>
    </section>
</body>
</html>