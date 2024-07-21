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
            <h2>Relatório de Exames </h2>
        
        <table border="1">
            <thead>
                <tr>
              
                    <th>#</th>
                    <th>Exame</th>
                  
                  
                 
                </tr>
            </thead>
            <tbody>
                @foreach ($exames as $exame)
                    <tr>
                        
                        <td>{{$exame->id_exame}}</td>
                        <td>{{$exame->nome}}</td>
                       
                     
                   
                    </tr>
                @endforeach
               
            </tbody>
        </table>
    
    <p>Data: {{date('d-m-Y H:i:s')}}</p>
    </section>
</body>
</html>