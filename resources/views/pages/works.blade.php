 <section id="facilities" class="home-section paddingbot-60" >
        <div class="container marginbot-50">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="wow fadeInDown" data-wow-delay="0.1s">
                    <div class="section-heading text-center">
                    <h2 class="h-bold">Nossas Especialidades</h2>
                    <p>Especialidade disponíveis na clínica</p>
                    @if (count($especialidades) === 0)  
                    <p class="h4 lead text-warning">Nenhuma Especialidade disponível.</p>
                    @endif 
                    </div>
                    </div>
                    <div class="divider-short"></div>
                </div>
            </div>
        </div>
    </section> 
     <section style="margin-bottom: 3rem" id="testimonial" class="home-section paddingbot-60 parallax" data-stellar-background-ratio="0.5">
       
        <div class="carousel-reviews broun-block">
            <div class="container">
                <div class="row">
                    <div id="carousel-reviews" class="carousel slide" data-ride="carousel">
                    
                        <div class="carousel-inner">
                            
                               
                            <div class="item active">
                                @foreach ($especialidades as $especialidade)

                                <div class="col-md-4 col-sm-6">
                                    <div class="person-text rel text-light">					
                                        <a href="ver/{{$especialidade->id_especialidade}}" title="Vê exame dessa especialidade">
                                            @if (isset($especialidade->imagem))
                                            <img  src="{{asset('storage/especialidade/'.$especialidade->imagem)}}" alt="{{$especialidade->especialidade}}" class="person img-rounded" />
                                           @else
                                           <img  src="/img/sem-foto.png" alt="" class="person img-rounded" />

                                            @endif
                                        </a>
                                        <p>{{$especialidade->especialidade}}</p>
                                        

                                    </div> 
                                   
                                </div>
                                 @endforeach
                            </div>
                            
                          
                          
                        </div>
                        
                          
                    </div>
                </div>
            </div>
        </div>
            </section> 
          

