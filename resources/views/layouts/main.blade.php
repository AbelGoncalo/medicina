<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website,Clinica, hospitalar">
    <meta name="author" content="Abel Gonçalo João">

    <title>@yield('title')</title>
	
    {{-- <!-- style admin dashboard -->
    <link href="admin/css/styles.css" rel="stylesheet" /> --}}
    {{-- Sweetalert css --}}
    <link rel="stylesheet" href="/admin/css/sweetalert2.min.css">

    <!-- FontAwesome/Pacote de icones -->
    <link href="/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/css/fontawesome.min.css" rel="stylesheet" type="text/css">
    <!-- css -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="plugins/cubeportfolio/css/cubeportfolio.min.css">
	<link href="/css/nivo-lightbox.css" rel="stylesheet" />
	<link href="/css/nivo-lightbox-theme/default/default.css" rel="stylesheet" type="text/css" />
	<link href="/css/owl.carousel.css" rel="stylesheet" media="screen" />
    <link href="/css/owl.theme.css" rel="stylesheet" media="screen" />
	<link href="/css/animate.css" rel="stylesheet" />
    <link href="/css/style.css" rel="stylesheet">
    <!--<link href="css/owl.theme.css" rel="stylesheet" media="screen" />-->
	<link href="/css/animate.css" rel="stylesheet" />
    <!-- Custom Style -->
    <link rel="stylesheet" href="/css/custom.css">
    
    <link href="/css/style.css" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="/css/custom.css">
	<!-- boxed bg -->
	<link id="bodybg" href="/bodybg/bg1.css" rel="stylesheet" type="text/css" />
	<!-- template skin -->
	<link id="t-colors" href="/color/default.css" rel="stylesheet">


</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom" >
    <!--Menu page -->
@include('pages.menu')
@yield('content')
<!--Footer page -->
@include('pages.footer')
@include('sweetalert::alert')

<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/script_rcu.js"></script>
<script src="/admin/js/sweetalert2.all.min.js"></script>
<script src="/admin/js/scriptEditarRegistro.js"></script>
<script src="/js/alterarHorario.js"></script>

{{-- Jquery Mask --}}
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
@include('pages.alertas')

<script>
     /*Pesquisar exame*/
     $("#buscar").keyup(function(){
             let valor  = $(this).val().toLowerCase();

            $('.table-utente tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
            })
          }) 
          /*fim*/
</script>
<script>
    /**Adicionar informacoes no historico clinico */
    $(document).ready(function() {
    $(".historico").click(function(){
    
            let id = $(this).attr('data-id');
            $('.id_historico').attr('value',id);
            $('#historicoClinicoModal').modal('show');
    })
    })
     </script>

     <script>
         
        //  $(document).ready(function(){
   
        //      $('#tipo_exame').change(function(){ 
        //         let exame =  $(this).val().toLowerCase();
        //         $('#tipo_exame option').filter(function(){
        //             $(this).toggle($(this).text().toLowerCase().indexOf(exame) > -1)
        //         })
               
        // })
        //  })
     </script>
</body>

</html>