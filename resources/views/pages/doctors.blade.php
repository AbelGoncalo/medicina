<!-- Section: team -->
<section     id="doctor" class="doctors home-section bg-gray paddingbot-60">
    <div class="container marginbot-50">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2" >
                <div class="wow fadeInDown" data-wow-delay="0.1s">
                <div class="section-heading text-center">
                <h2 class="h-bold">Médicos</h2>
                <p>Médicos disponiveis na clinica</p>
                @if (count($medicos) === 0)  
                <p class="h4 lead text-warning">Nenhum Médico disponível.</p>
                @endif

                </div>
                </div>
                <div class="divider-short"></div>
                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12" >
                <div class="wow bounceInUp" data-wow-delay="0.2s">
                    <div id="owl-works" class="owl-carousel">
                    
                        @foreach ($medicos as $medico)
                                
                            <div class="box">
                                @if (!empty($medico->imagem))
                                <img class="foto-perfil-medico" src="{{asset('/storage/usuario'.$medico->id_usuario.'/'.$medico->imagem)}}" alt="">
                                @else
                                    <img class="foto-perfil-medico" src="{{asset('img/sem-foto.jpg')}}" alt="" class="file">
                                @endif
                                <span  class="text text-center nome-medico"><strong>{{$medico->nome}}</strong></span >
                                <span class="text text-center" id="especialidade"><strong>Especialidade</strong></span >
                                <span  class="text text-center">{{$medico->especialidade}}</span >
                            </div> 

                        @endforeach
  
                    </div>
                </div>
            </div>
        </div>
 
    </div>

   

</section>
