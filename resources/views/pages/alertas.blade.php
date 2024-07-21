{{-- Mostrar mensagens de alerta --}}
        {{-- Mesagens de sucesso--}}
        @if (Session::has('success'))
            <script>
                Swal.fire({
                  
                    position: 'center',
                    icon: 'success',
                    title: "{!!Session::get('success')!!}",
                    showConfirmButton: true,
                   
            })
            </script>
        @endif
        {{-- Fim das mensagens de sucesso --}}

          {{-- Mesagens de erro--}}
          @if (Session::has('error'))
          <script>
              Swal.fire({
             
                  position: 'center',
                  icon: 'error',
                  title: "{!!Session::get('error')!!}",
                  showConfirmButton: true,
                  
          })
          </script>
      @endif
      {{-- Fim das mensagens de erro --}}
 
          {{-- Mesagens de Aviso--}}
          @if (Session::has('warning'))
          <script>
              Swal.fire({
             
                  position: 'center',
                  icon: 'warning',
                  title: "{!!Session::get('warning')!!}",
                  showConfirmButton: true,
                
          })
          </script>
      @endif
      {{-- Fim das mensagens de aviso --}}