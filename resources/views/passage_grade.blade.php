@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Passage de grade</h1>
    <p>Cliquer sur le bouton pour calculer les nouveaux chiffres perso, chiffres équipe, prime de parrainage et le prime d'animation.</p>
    <p>Cette opération va mettre à jour les grades.</p>
    <div class="alert alert-success" role="alert" style="display: none">
        Votre mise à jour a été effectué avec succès.
      </div>
    <div><img style="display: none" src="{{asset('loading_icon.gif')}}" id="loading"/></div>
    <button id="grade" class="btn btn-primary mt-4">Calculer</button>
</div>
@endsection

@section('js')
<script type="text/javascript">
      
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $("#grade").click(function(e){
        $('#loading').show();
        e.preventDefault();
     
        $.ajax({
           type:'GET',
           url:"{{ route('calcul.new_rank') }}",
           //data:{title:title, body:body},
           success:function(data){
            $('#loading').hide();
            $('.alert-success').show();

                
           }
        });
    
    });

  
</script>
@endsection