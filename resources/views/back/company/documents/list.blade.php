@extends('layouts.back.master-with-left-menu')
@section('title', 'Document')
@section('left-menu')
	@include('back.company.menu')
@stop
@section('breadcrumb')
{!! Breadcrumbs::render('company.documents', $company) !!}
@stop
@section('right-content')
<h3>Gestion des documents </h3>
	<button class="btn btn-primary btn-sm btn-icon icon-left" id="addDoc_btn" data-toggle="modal" data-target="#addDoc_modal" data-id="null">
    <i class="entypo-plus"></i>Ajouter</button>

<!-- Modal Add/Edit -->
  <div class="modal fade" id="addDoc_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ajout d'un document</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => route('company.documents.add', [$company_id]), 'files' => true, 'id' => "formAdd"]) !!}
        <input type="hidden" name="id">
          <div class="form-group">
            <label for="file">Fichier</label>
            <input type="file" name="files[]" multiple="multiple">
            <p class="help-block">Veuillez choisir un fichier à télécharger</p>
          </div>

          <div class="form-group">
            <input type="checkbox" name="isPrivate" class="">
            <label for="isPrivate">Fichier privé</label>
            <p class="help-block">Un fichier privé n'est pas publiquement accèsible</p>
          </div>

          <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" class="form-control">
            <p class="help-block">Nom facultatif</p>
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control">
            <p class="help-block">Description facultative</p>
          </div>

        {!! Form::close() !!}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_save">Sauvegarder</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal Delete -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Supprimer un document</h4>
        </div>

        <div class="modal-body">Voulez-vous vraiment supprimer le documents : </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <a href="" class="btn btn-danger btn-sm btn-icon icon-left" id="modal_delete_btn">
            <i class="entypo-cancel"></i>Supprimer</a>
          </div>
    </div>
  </div>
</div>


<table class="table table-bordered table-striped datatable" id="table">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Description</th>
      <th>Type</th>
      <th>Privé?</th>
      <th>Url</th>
      <th>preview</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($docs as $doc)
    <tr>
      <td>
        {{$doc->name}}
      </td>
      <td>
        {{$doc->description}}
      </td>
      <td>
        {{$doc->type}}
      </td>
      <td>
        {{$doc->isPrivate ? 'oui' : 'non'}}
      </td>
      <td>
          @if($doc->getUrl())
          <a href="{{$doc->getUrl()}}" target="_blank">{{$doc->getUrl()}}</a>
          @else
          <a href="{{route('company.documents.id', [$company_id, $doc->id])}}" target="_blank">{{$doc->filename}}</a>
          @endif
      </td>
      <td>
        @if($doc->isImage())
        <a class="img-popover" href="" data-container="body" data-placement="left" data-url="{{$doc->getUrl()}}">preview</a>

        @endif
      </td>
      <td>
        <button class="btn btn-default btn-sm btn-icon icon-left editDoc"
          data-id="{{ $doc->id }}"
          data-toggle="modal"
          data-target="#addDoc_modal">
          <i class="entypo-pencil"></i>Éditer</button>
        <button class="btn btn-danger btn stm btn-icon icon-left deleteDoc"
        data-toggle="modal"
        data-target="#delete_modal"
        data-id="{{ $doc->id }}"
        >
          <i class="entypo-cancel"></i>Supprimer</button>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>






@stop
@section('js')
@parent
<script>


var arDocs = {!! json_encode( $docs ) !!}
  , docs = {}
  , delete_url = '{!! route("company.documents.delete", [$company_id, 12345]) !!}'
  , edit_url = '{!! route("company.documents.edit", [$company_id, 12345]) !!}'
  , add_url = '{!! route("company.documents.add", [$company_id]) !!}'

$('document').ready(function() {

  arDocs.forEach(function(doc) {
    docs[doc.id] = doc;
  });

  //save
  $('#btn_save').on('click', function(evt) {

    if($('form input[name="id"]').val() != '') {
      return $("#formAdd").submit();
    }
    if($('form input[name="file"]').val() == '') {
      $('form input[name="file"]').parent().addClass('has-error');
      evt.preventDefault();
    } else {
      $("#formAdd").submit();
      //submit en ajax TODO
    }

  })

  //preview popover
  $('.img-popover').popover({
    html: true,
    trigger: 'hover',
    placement: 'left',
    content : function() {
      console.log($(this).data('url'));
      //url = $(this);
      return '<img class="img-thumbnail img-table" src="' + $(this).data('url') + '">';
    }
  })

  //edit
  $('#addDoc_modal').on('show.bs.modal', function(evt) {
    console.log("show.bs.modal")
    let id = $(evt.relatedTarget).data('id');
    let modal = $(this);
    if(id !== null) {
      modal.find("form").prop('action', edit_url.replace(/12345/, id) );
      $('input[type="file"]').prop('disabled', true);
      $('input[name="isPrivate"]').prop('checked',docs[id].isPrivate);
      $('input[name="name"]').val(docs[id].name);
      $('input[name="description"]').val(docs[id].description);
      $('input[name="id"]').val(id);

    } else {
      modal.find("form").prop('action', add_url);
      $('input[type="file"]').prop('disabled', false);
      $('input[name="isPrivate"]').prop('checked', false);
      $('input[name="name"]').val("");
      $('input[name="description"]').val("");
      $('input[name="id"]').val(null);

    }

  })


  //delete
  $('#delete_modal').on('show.bs.modal', function(evt) {
    console.log("show.bs.modal del")
    let id = $(evt.relatedTarget).data('id');
    let modal = $(this);
    modal.find("#modal_delete_btn").prop('href', delete_url.replace(/12345/, id) );
    modal.find(".modal-body").text(`Voulez-vous vraiment supprimer le documents : ${docs[id].filename} ?`);
  } )




});
</script>
@stop
@section('css')
@parent
<style>
  .img-table {
    width: unset;
  }
</style>
@stop
