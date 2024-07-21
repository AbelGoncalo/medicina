@extends("layouts.main")
@section("title","Contacto")
@section("content")
    <section class="mt-5 container form_signup">
        <form action="/enviar.mensagem" method="post" class="col-md-5">
            @csrf
            <h4 class=" text text-center display-5">Contacta-nos</h4>
            <label for="assunto">Assunto</label>
            <input type="text" name="assunto" id="assunto" placeholder="Assunto" class="form-control">
            <label for="assunto">Mensagem</label>
            <textarea name="mensagem" id="mensagem" cols="30" rows="10" maxlength="300" placeholder="Mensagem" class="form-control" style="resize: none"></textarea>
            <input type="hidden" name="email" value="kerubim.ao@gmail.com">
            <input type="submit" value="Enviar"  id="signup" class="col-md-12 btn">
        </form>
    </section>
@endsection