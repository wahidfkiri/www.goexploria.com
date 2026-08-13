@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
	{!! Breadcrumbs::render('company.follower', $company) !!}
@stop
@section('left-menu')
	@include('back.company.menu')
@stop

@section('right-content')
<h4>{{$company->name}} : Abonnés</h4>

@if (count_of($followers) > 0)

<label>Supprimer les abonnés sélectionnés : 
  <button class="button delete_selected btn btn-danger delete btn-sm btn-icon icon-left" name="delete">Supprimer</button>
</label>
<form name="form_follower" method="post" action="{{ route('company.follower.remove.selected', [$company->id]) }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="company_id" value="{{$company->id}}">
  <table class='table table-striped'>
  	<tr>
      <th><input type="checkbox" name="select_all" id="select_all"></th>
  		<th>Nom</th>
  		<th>Email</th>
  		<th>Actions</th>
  	</tr>
  	@foreach($followers as $key => $follower)
          <tr>
              <td><input type="checkbox" class="checkbox_row" name="email[]" value="{{$follower->email}}"></td>
              <td>{{$follower->name}}</td>
              <td class="email">{{$follower->email}}</td>
              <td>
              	{!! Formatter::deleteButton($key)!!}

  				{!! Formatter::delete(route('company.follower.remove', [$company->id, $follower->email]), $key, "Retirer un abonnement", "Voulez-vous vraiment retirer l'abonnement à votre newsletter à " .$follower->name ." ?" ) !!}
  			</td>
          </tr>
      @endforeach
  </table>
  {!! Formatter::delete("#", "selected", "Retirer un abonnement", "Voulez-vous vraiment retirer l'abonnement aux abonnés sélectionnés ?" ) !!}
</form>
{!! $followers->render() !!}
@else
	Aucun abonné à la newsletter
@endif
@stop


@section('js')

<script type="text/javascript">
	$(document).ready(function() {

      //delete individual
	    $(".delete").click(function(){
	        var value = $(this).attr('data');
		    $('#modal-delete-'+value).modal('show');

	    	return false;
	    });

      //show modal
      $(".delete_selected").click( () => {
        $('#modal-delete-selected').modal('show');
        return false;
      });

      //submit on modal accept
      $("#modal-delete-selected .btn-danger").click(() => {
        $("form[name=form_follower]").submit();
      });

      //select all
      $("#select_all").change((ev) => {
        $(".checkbox_row").prop('checked', $("#select_all").prop('checked'));
      })

      //deprecated
      // create an array of all selected email address
      function getSelectedEmail() {
        $("form[name=form_follower] .checkbox_row:checked")
           .parent()
           .siblings(".email")
           .map((idx, el)=> {
           return $(el).text()
        }).toArray()
      }

} );
</script>
@stop
