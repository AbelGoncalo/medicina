<?php

namespace App\Http\Controllers;

use App\Mail\emailRecuperarSenha;
use App\Models\Consulta;
use App\Models\Contacto;
use App\Models\Endereco;
use App\Models\Medico;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Utente;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Svg\Tag\Rect;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**Chamar formulario de login */
    public function index(){
        $action = "/entrar";
        return view('users.login',compact('action'));
    }
    /** logar no sistema, autenticar usuario*/
    public function logar(Request $request)
    {
        //Validacao das credencias
        $this->validate($request,[
            'email'=>'bail|required|email',
            'password'=>'bail|required|min:8'
        ]);

        /**Verificar se existe uma conta de usuario */
        $usuario =  User::where('email',$request->email)->first();
        if(!$usuario){

            return redirect()->back()->with('msg','Não existe uma conta com esse email.');
           
        }
        /**Verificar as credencias usuario 
             * e senha e redereciona-lo para o seu nivel de acesso */
        $credencias = [
            'email'=>$request->email,
            'password'=>$request->password
        ];
    
        if(Auth::attempt($credencias,true)){

                if(Auth::user()->Nivel === 0){

                    return redirect('/')->with('success','Seja Bem-vindo Utente '.Auth::user()->nome.'!');

                }elseif(Auth::user()->Nivel === 1){

                    return redirect('/dashboard.medico')->with('success','Seja Bem-vindo Médico '.Auth::user()->nome.'!');

                }else{

                    return redirect('/admin.dashboard')->with('success','Seja Bem-vindo Administrador '.Auth::user()->nome.'!');
                }
                
                
        }

         return redirect()->back()->with('msg','Senha inválida.');

        

    
}

   

    /** Sair do sistema*/
    public function Sair()
    {
        Auth::logoutCurrentDevice();
            return redirect('/logar');
    }

    /** Mostrar perfil de usuario logado */
    public function perfil(){
        if(Auth::check()){
            
                $id_usuario = Auth::user()->id_usuario;
                if(Auth::user()->Nivel === 0){
                    $usuario = Utente::where('id_usuario',$id_usuario)->first();

                }elseif(Auth::user()->Nivel === 1){

                    $usuario = Medico::where('id_usuario',$id_usuario)->first();
                } else{

                    $usuario = User::where('id_usuario',$id_usuario)->first();
                }
            
                $imagem = "/alterar.imagem";
                $senha = "/alterar.senha";
                $action_utente = "/alterar.perfil.utente";
                $action_medico = "/alterar.perfil.medico";
                $action_admin = "/alterar.perfil.admin";
                $apagar_conta = "/apagar.utente";
                return view('users.perfil',['imagem'=>$imagem,'senha'=>$senha,'action_utente'=>$action_utente,'action_medico'=>$action_medico,'action_admin'=>$action_admin,'usuario'=>$usuario,'apagar_utente'=>$apagar_conta]);
   
        } 
            return redirect('/');
    }
/**-------------------------------------------------- */

/** ---------------actulizar perfil de usuario -------------*/
     /**Alterar dados pessoais utente  */
     public function alterar_dados_utente(Request $request)
     {
        if(Auth::check()){
        if(Auth::user()->Nivel === 0){

                //  dd($request->all()) ;
             $this->validate($request,[
                 'nome_utente'=>'bail|required',
                 'nascimento'=>'bail|required',
                 'bi'=>'bail|required|min:15|max:15',
                 'telefone'=>'bail|required|min:9|max:13',
                 'sexo'=>'bail|required',
                 'seguro'=>'bail|required',
                 'seguro_numero'=>'bail|required',
                 'morada'=>'bail|required',
                 'localidade'=>'bail|required',
                 'email_utente'=>'bail|required|email',

        
             ]);

             $data_actual = new DateTime("now");
             $ano=Carbon::parse($request->nascimento)->format("Y");
             $ano_actual=Carbon::parse($data_actual)->format("Y");
     
                 if($ano >  $ano_actual || $ano < 1905){
                     return redirect()->back()->with('warning','Data de nascimento inválida.');
                 }
            
               /**Verificar se o email já existe no banco de dados*/
            $user = User::where('email',$request->email_utente)->first();
            $contacto = Contacto::where('email',$request->email_utente)->first();
               if(isset($user->email)  || isset($contacto->email_utente)){
                   if($user->email === $request->email_utente || $contacto->email === $request->email_utente){
                       return redirect()->back()->with('warning','Já existe uma conta com esse email! Utiliza outro.');
                    }
               }

             $data_actual = new DateTime("now");
             $ano=Carbon::parse($request->nascimento)->format("Y");
             $ano_actual=Carbon::parse($data_actual)->format("Y");
     
            if($ano >  $ano_actual){
                return redirect()->back()->with('warning','Data de nascimento inválida.');
            }
        
        $id_usuario = Auth::user()->id_usuario;
        
        $utente = Utente::where('id_usuario',$id_usuario)->first();
        $utente->nome = $request->nome_utente;
        $utente->nascimento = $request->nascimento;
        $utente->bi = $request->bi;
        $utente->sexo = $request->sexo;
        $utente->seguro = $request->seguro;
        $utente->seguro_numero = $request->seguro_numero;
        $utente->save();
        $contacto = Contacto::find($utente->id_contacto);
        $contacto->telefone = $request->telefone;
        $contacto->email  = $request->email_utente;
        $contacto->save();

        $utente->endereco->update($request->all());
        $usuario = User::find($utente->id_usuario);
        $usuario->nome  = $request->nome_utente;
        $usuario->email  = $request->email_utente;
        $usuario->save();


         if($utente){
            
             return  redirect()->back()->with('success','Dados editados com sucesso');

         }else{
             return redirect()->back()->with('error','Erro ao editar os dodos');
        }
        
    }
    return  redirect()->back();

               
     
       }
       return  redirect()->back();
     }
    /**-------------------------------------------------------- */
        /**Alterar dados pessoais medico  */

        public function alterar_dados_medico(Request $request){
            if(Auth::check()){
                if(Auth::user()->Nivel === 1){  
                    $this->validate($request,[
                    'nome_medico'=>'bail|required',
                    'nascimento'=>'bail|required',
                    'bi'=>'bail|required|min:15|max:15',
                    'email_medico'=>'bail|required|email',
                    'telefone'=>'bail|required|min:9|max:13',
                    'morada'=>'bail|required',
                    'localidade'=>'bail|required',
           
                ]);
   /**Verificar se o email já existe no banco de dados*/
    $user = User::where('email',$request->email_medico)->first();
    $contacto = Contacto::where('email',$request->email_medico)->first();
   
       if(isset($user->email)||isset($contacto->email)){
           if($user->email === $request->email_medico || $contacto->email === $request->email_medico){
               return redirect()->back()->with('warning','Já existe uma conta com esse email! Utiliza outro.');
            }
       }
            /**Actualizar dados pessoais do Medico */
            $id_usuario = Auth::user()->id_usuario;
            $medico = Medico::where('id_usuario',$id_usuario)->first();
            $medico->nome =$request->nome_medico;
            $medico->update($request->all());
            $medico->endereco->update($request->all());

            $contacto = Contacto::findOrFail($medico->id_contacto);
            $contacto->telefone = $request->telefone;
            $contacto->email = $request->email_medico;
            $contacto->save();

            $usuario = User::findOrFail($medico->id_usuario);
            $usuario->nome = $request->nome_medico;
            $usuario->email = $request->email_medico;
            $usuario->save();


                
        
            if($medico && $usuario && $contacto){
                
                return  redirect()->back()->with('success','Dados editados com sucesso');

            }else{

            
                return redirect()->back()->with('error','Erro ao editar os dodos');
            }



            }
            return redirect()->back();

        }
        return redirect()->back();

        }
    /**Carregar imagem de usuario */
    public function carregar_imagem(Request $request){
        $id_usuario = Auth::user()->id_usuario;

        $this->validate($request,['foto'=>'required']);
                if($request->has('foto') && $request->hasFile('foto')){
                    $imagem = $request->file('foto');
                    $extensao = $imagem->getClientOriginalExtension();
                    $nome_imagem = md5($imagem->getClientOriginalName()).'.'.$extensao ;
                    $request->file('foto')->storeAs('public/usuario'.$id_usuario."/",$nome_imagem);
               
                }
            
                $foto = DB::update('update users set imagem = ? where id_usuario = ?',[$nome_imagem,$id_usuario]);

                if($foto){

                    
                    return redirect()->back()->with('success','Foto de perfil alterada');
                }
    
    }
 
   
    /**------------Alterar dados pessoais Admin----------------- */
    public function alterar_dados_admin(Request $request){

        if(Auth::check()){
            if(Auth::user()->Nivel === 2){
                $this->validate($request,[
                    'nome'=>'required',
                    'email_admin'=>'required'

                ]);

                  /**Verificar se o email já existe no banco de dados*/
                $user = User::where('email',$request->email_admin)->first();
                if(isset($user->email)){
                       if($user->email === $request->email_admin){
                           return redirect()->back()->with('warning','Já existe uma conta com esse email! Utiliza outro.');
                        }
                   }
                    /**Actualizar dados pessoais do admin */
                $id_usuario = Auth::user()->id_usuario;
                $admin = User::where('id_usuario',$id_usuario)->first();
                $admin->nome = $request->nome;
                $admin->email = $request->email_admin;
                $admin->save();
        if($admin){
            
            return  redirect()->back()->with('success','Dados editados com sucesso');

        }else{

        
            return redirect()->back()->with('error','Erro ao editar os dodos');
        }



        }
        return redirect()->back();
    }
    }

   /**Alterar senha de usuario */
   public function alterar_senha(Request $request){



            $this->validate($request,[
            'actual_password'=>'required|min:8',
            'nova_password'=>'required|min:8',
            'confirmar_password'=>'required|min:8'

            ]);
         $id_usuario = Auth::user()->id_usuario;
         $usuario = User::find($id_usuario);
         
         
        if($usuario){
                
    if(password_verify($request->actual_password,$usuario->password) ){
               
                  
          if($request->nova_password === $request->confirmar_password){
          
                        
               $nova_password = password_hash($request->nova_password,PASSWORD_DEFAULT);
                 $senha = DB::update('update users set password = ? where id_usuario = ?',[$nova_password,$id_usuario]);

                if($senha){
                      return redirect()->back()->with('success','Senha alterada com sucesso');
                 }else{
                     return redirect()->back()->with('error','Erro ao alterar senha.');

                 }
                 return redirect()->back()->with('warning','A senha informada não existe.');

               }
                 
                 }

            return redirect()->back()->with('warning','A senha actual é inválida! Digite a senha correcta.');


                    
      
    
    
}

}

   
/**------------------------------------------------------------------------- */

    /**-------------Apagar Conta de Usuario---------------- */
        public function apagar_conta(Request $request){
          
            /**Verificar se existe uma sessao  */
        if(Auth::check()){
              /**id do usuario logado */
            $id_usuario = Auth::user()->id_usuario;
            /**Usuario logado */
            $usuario = User::find($id_usuario);

            /**Verificar se a senha digitada e igual a 
             * armazenada no banco de dados */
            $db_senha = $usuario->password;
            $verificar_senha = password_verify($request->senha,$db_senha);
 
            /**Se for verdade apagar a conta e voltar 
             * a pagina inicial */
            if($verificar_senha){
               
                $utente = Utente::where('id_usuario',$id_usuario)->first();
                 $utente->delete();
                 $utente->endereco->delete();
                 $utente->contacto->delete();
                 Consulta::destroy($id_usuario);
                 User::destroy($id_usuario);

    
                return redirect('/')->with('success','Sua conta foi Apagada permanentimente.');
            }else{

                return redirect()->back()->with('error','A senha digita esta errada');
            }
        }

        }
    /**---------------------- redefinicao da senha, caso el senha esquecida-------------------------------- */
    public function redefinir_senha(Request $request){

        $this->validate($request,[

            'email'=>'bail|email|required'
        ]);

            /**Verificar se existe um usuario com o email digitado */
            $usuario = User::where('email','=',$request->email)->first();

            if($usuario->count()===0){
             
                return redirect()->back()->with('warning','O email digitado não está associado a nenhuma conta de usuário.');
            }
            
             $usuario = $usuario->first();
             $nova_senha =  $this->criarCodigo();
             try
             {
           
            /**Enviar email ao usurio com o código de recupeçao de senha*/
                Mail::to($usuario->email)->send(new emailRecuperarSenha($nova_senha));
                 // /**Actualizar a senha do usuario para a nova senha */
             $usuario->password = password_hash($nova_senha,PASSWORD_DEFAULT);
             $usuario->save();
                return redirect()->back()->with('success','Foi enviado um email com a sua nova senha! Verifica seu email');
            }catch(\Exception $ex)
            {

                return redirect()->back()->with('error',' Erro ao redefinir senha! Verifica sua conexao com a internet, e tente novamente');
            }

            
    }
        // Metodo que retorna a view para alterar a senha
        public function recuperar_senha(){
            $action = "/nova.senha";
            return view('users.recuperar_senha',compact('action'));
        }



    /**Metodo que gera codigo para redefinir a senha */
      public function  criarCodigo(){
        $valor = "";
        $catecteres = "abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890?!&$#@";
            for($i=0;$i<10;$i++){
                $index = rand(0,strlen($catecteres));

                $valor.=substr($catecteres,$index,1);

            }
        return $valor;
    }

}

