<?php

namespace App\Http\Controllers;


use App\Mail\FaleConosco;
use Illuminate\Http\Request;
use App\Models\Medico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function GuzzleHttp\Promise\all;

class HomeController extends Controller
{
    public function index(){

        $medicos = DB::table('medicos')
      ->join('users','users.id_usuario','medicos.id_usuario')
      ->get();

      /**--------------------------------------------- */
      // $especialidades = DB::table('especialidades')
      // ->get();
      $especialidades = DB::table('especialidades')->get();
        return view('/welcome',['especialidades'=>$especialidades,'medicos'=>$medicos]);
    }

    public function fala_conosco()
    {
        return view("pages.contacto");
    }
    public function contacto(Request $request)
    {
     
        try
        {
            Mail::to($request->email)->send(new FaleConosco($request->assunto,$request->mensagem));
            return redirect()->back()->with('success','Email enviado com sucesso');
       
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error','Erro ao enviar e-mail! Verifica sua conexao com a internet, e tente novamente.');


        }


    }
}
