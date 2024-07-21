@extends('layouts.main')
@section('title','Exames')
@section('content')
    <section class="container " id="container-exame">
        <div class="row col-md-10 table-margin ">
                <h1 class="title-exame">Exames disponíveis</h1>
            
            <table class=" table-margin table table-striped table-hover col-md-12">
                
                <tbody>
                    @if ($exames->count() > 0)
                    @foreach ($exames as $item)
                        
                    <tr class="items">
                        <td>{{ $item->nome}}</td>
                    </tr>
                    @endforeach
                    @else
                    <div class="alert alert-info text-center">
                        <p>Nenhum exame disponível de momento. <a href="..#facilities">Voltar</a></p>
                    </div>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <style>
        #container-exame{
            margin-top:10rem !important;
            margin-bottom:8rem !important;
        }
          .table-margin,.title-exame{
            margin:1rem 6rem;
        } 
        .items{
            font-weight: bolder;
            text-transform: uppercase;
            font-size: 20px;
        } 
    </style>
@endsection