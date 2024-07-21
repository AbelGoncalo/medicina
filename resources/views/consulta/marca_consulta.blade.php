@extends('layouts.main')
@section('title','Marcar Consulta')
@section('content')
    <section class=" container">
        <div  class="col-md-12 form_marcar_consuta">
            <form action="{{$action}}" method="post" class="col-md-5 " enctype="multipart/form-data">
                @csrf
                <h2 class="text-center">Marcar Consulta</h2>
                <div class="divider-short"></div>
               
                <div class="mb-3">
                <label for="tipo_exame">Tipo de Exame</label>
                <select name="tipo_exame" id="tipo_exame" class="form-control">
                    <option selected disable  >--Selecionar--</option>
                    @if(count($exames) > 0)
                    @foreach ($exames as $exame)
                        <option   value="{{$exame->nome ?? ''}}">{{$exame->nome}}</option>
                    @endforeach
                    @else
                    <option selected disabled >Exames indisponiveis </option>

                    @endif
                   
                </select>
                @error('tipo_exame')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="medico">Médico</label>
                <select name="id_medico" id="id_medico" class="form-control">
                    <option selected disable value="">Selecionar...</option>
                    @if(count($medicos) > 0)
                    @foreach ($medicos as $medico)
                        <option value="{{$medico->id_medico}}">{{$medico->nome ." - ".$medico->especialidade}}</option>
                    @endforeach
                    @else
                    <option selected disabled >Médicos indisponiveis </option>
                    @endif
                    @error('id_medico')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </select>
                @error('medico')
                <small class="text-danger">{{$message}}</small>
                @enderror
                <input type="hidden" name="id_utente" value="{{$utente->id_utente}}">
            </div>
                <label for="anexo">Anexos<small>(opcional)</small></label>
                <input type="file" name="anexo" id="anexo" class="form-control">
                <div class="btn_marcar_consulta">
                   <button type="submit" class="btn" id="signup">Marcar consulta</button>
                </div>
            </form>
            
        </div>
       
    </section>

@endsection
