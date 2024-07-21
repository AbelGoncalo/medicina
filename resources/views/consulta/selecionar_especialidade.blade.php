@extends('layouts.main')
@section('title','Marcar Consulta')
@section('content')
<section class="container  flex">
    <div class="col-md-5 selecionar">
        <div class="row">
            <h4 class="">Selecionar Especialidade</h4>

            <form action="{{$action}}" method="post">
                 @csrf
                <div class="row">
                    <select name="especialidade" id="especialidade" class="form-control">
                        <option selected disabled>Selecionar</option>
                        @foreach ($especialidades as $item)
                        
                        <option value="{{$item->id_especialidade}}">{{$item->especialidade}}</option>
                            
                        @endforeach
                    </select>
                </div>
                <div class=" flex-end">
                <div class="row">
                    <input type="submit" id="signup" value="Próximo >" class="btn col-md-12">
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
     

<style>
    .selecionar{
        margin: 12rem 0;
    }
    .flex{
        display: flex;
        justify-content: center;
        align-content: center;
    }
    
    select{
        height: 5rem !important;
        padding: 1rem !important;
        font-size: 18px !important;
    }
</style>

@endsection
