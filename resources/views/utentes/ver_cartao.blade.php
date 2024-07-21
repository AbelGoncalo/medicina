  
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Ver Cartão de Vacina</title>
  </head>
  <body>
      
    {{-- <embed  src="/cartaoVacina/{{$cartao}}" type="application/pdf" > --}}
      <object data="/cartaoVacina/{{$cartao}}" type="application/pdf"></object>
      
  </body>
  </html>