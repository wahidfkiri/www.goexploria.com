@extends('layouts.back.master-with-left-menu')
@section('title', 'Etablissements')
@section('breadcrumb')
    {!! Breadcrumbs::render('company.edit.infos', $company) !!}
@stop
@section('left-menu')
    @include('back.company.menu')
@stop

@section('right-content')
    <h4>{{$company->name}} - Achats</h4>
    {!! Form::open(array('route' => array('company.edit.achats', $company->id), 'method' => 'post','name' => 'companyForm', 'id' => 'editForm', 'files' => true)) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">


        <h4>Détails de l'entreprise</h4>
        <table class='table user'>
            <tr>
                <td>{{ Form::label('hide_facturation', "Cacher le bouton de facturation?") }}</td>
                <td>{{ Form::checkbox('hide_facturation', 'hide', ($company->hide_facturation == false || $company->hide_facturation == 0) ? false : true) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('last_invoice_number', "Dernier numéro de facture") }}</td>
                <td>{{ Form::text('last_invoice_number', 'F-' . date('y') . str_pad($company->last_invoice_number, 3, '0', STR_PAD_LEFT), ['class' => 'form-control', "data-validate" => "required", 'disabled' => 'disabled']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_no_tps', "No TPS") }}</td>
                <td>{{ Form::text('achats_no_tps', $company->achats_no_tps, ['class' => 'form-control', 'placeholder'=>'No TPS', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_no_tvq', "No TVQ") }}</td>
                <td>{{ Form::text('achats_no_tvq', $company->achats_no_tvq, ['class' => 'form-control', 'placeholder'=>'No TVQ', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_neq', "NEQ") }}</td>
                <td>{{ Form::text('achats_neq', $company->achats_neq, ['class' => 'form-control', 'placeholder'=>'NEQ', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_frais_transport', "Frais de transport") }}</td>
                <td>{{ Form::number('achats_frais_transport', $company->achats_frais_transport, ['class' => 'form-control', 'placeholder' => 'Frais de transport', 'step' => '0.01']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_frais_admin', "Frais d'administration") }}</td>
                <td>{{ Form::number('achats_frais_admin', $company->achats_frais_admin, ['class' => 'form-control', 'placeholder' => 'Frais d\'administration', 'step' => '0.01']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_reduction', "Pourcentage de réduction") }}</td>
                <td>{{ Form::number('achats_reduction', $company->achats_reduction, ['class' => 'form-control', 'placeholder' => 'Pourcentage de réduction', 'step' => '0.01', 'min' => 0, 'max' => 100]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_cheque', "Chèque à l'ordre de :") }}</td>
                <td>{{ Form::text('achats_cheque', $company->achats_cheque, ['class' => 'form-control', 'placeholder'=>'Chèque à l\'ordre de', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_succursale', "Dépot direct - Succursale") }}</td>
                <td>{{ Form::text('achats_succursale', $company->achats_succursale, ['class' => 'form-control', 'placeholder'=>'Dépot direct - Succursale', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_transit', "Dépot direct - Transit") }}</td>
                <td>{{ Form::text('achats_transit', $company->achats_transit, ['class' => 'form-control', 'placeholder'=>'Dépot direct - Transit', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_compte', "Dépot direct - Compte") }}</td>
                <td>{{ Form::text('achats_compte', $company->achats_compte, ['class' => 'form-control', 'placeholder'=>'Dépot direct - Compte', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_payment_button', "Code du bouton de paiement") }}</td>
                <td>{{ Form::textarea('achats_payment_button', $company->achats_payment_button, ['class' => 'form-control', 'placeholder'=>'Code du bouton de paiement', "data-validate" => "required"]) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_marche_a_suivre', "Marche à suivre") }}</td>
                <td>{!! Form::textarea('achats_marche_a_suivre', $company->achats_marche_a_suivre, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) !!}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_instructions', "Instructions") }}</td>
                <td>{!! Form::textarea('achats_instructions', $company->achats_instructions, ['class' => 'ckeditor form-control', 'placeholder' => 'Contenu']) !!}</td>
            </tr>
            <tr>
                <td>{{ Form::label('achats_note', "Note") }}</td>
                <td>{{ Form::text('achats_note', $company->achats_note, ['class' => 'form-control', 'placeholder'=>'Note', "data-validate" => "required"]) }}</td>
            </tr>
        </table>
        <h4>Commande / Produits / Services</h4>
        <table class='table user'>
            <tr>
                <td>{{ Form::label('versements', "Nombre de versements") }}</td>
                <td>{{ Form::number('versements', $company->versements, ['class' => 'form-control', 'placeholder' => 'Nombre de versements', 'step' => '1', 'min' => 0, 'max' => 100]) }}</td>
            </tr>
        </table>
        <table class='table user achats-list'>
            @if (!empty($achats))
                @foreach ($achats as $keyAchat => $achat)
                    <tr class="achats-template achats-template{{ $keyAchat }}">
                        <td><label for="achats[{{ $keyAchat }}]">Achat</label></td>
                        <td><input class="form-control" placeholder="Nom" name="achats[{{ $keyAchat }}][name]" type="text"
                                   value="{{ $achat['name'] }}"></td>
                        <td><input class="form-control" placeholder="0,00" name="achats[{{ $keyAchat }}][price]"
                                   type="number" value="{{ $achat['price'] }}" min="0" step="0.01"></td>
                        <td>
                            <input class="form-control" name="achats[{{ $keyAchat }}][image]" type="file"><br>
                            @if (isset($achat['image']))
                                <input class="form-control" name="achats[{{ $keyAchat }}][oldimage]" type="hidden" value="{{ $achat['image'] }}"><br>
                                @if (!empty($achat['image']))
                                    <img src="{{ url('/') }}/uploads/achats/{{ $achat['image'] }}" style="width: auto; max-height: 100px;">
                                @endif
                            @endif
                        </td>
                        @if (isset($achat['url']))
                            <td><input class="form-control" placeholder="URL" name="achats[{{ $keyAchat }}][url]" type="text"
                                   value="{{ $achat['url'] }}"></td>
                        @else
                            <td><input class="form-control" placeholder="URL" name="achats[{{ $keyAchat }}][url]" type="text"
                                       value=""></td>
                        @endif
                        <td>
                            @if (isset($achat['order']))
                                <input class="form-control" placeholder="0" name="achats[{{ $keyAchat }}][order]"
                                   type="number" value="{{ $achat['order'] }}" step="1">
                            @else
                                <input class="form-control" placeholder="0" name="achats[{{ $keyAchat }}][order]"
                                       type="number" value="0" min="0" step="1">
                            @endif
                        </td>
                        <td>
                            <button class="form-control remove-achats">X</button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                            <!-- custom.js -->
                    @if (!empty($achats))
                        <button class="add-achats" data-qty="{{ count_of($achats) }}" style="margin-bottom: 8px;">Ajouter un
                            achat
                        </button>
                    @else
                        <button class="add-achats" data-qty="0" style="margin-bottom: 8px;">Ajouter un achat</button>
                    @endif
        </table>

        {{ Form::submit('Modifier')}}
    {!! Form::close() !!}

@stop


@section('js')

    {!! JsValidator::formRequest('App\Http\Requests\EditCompanyInfosRequest', '#editForm'); !!}

    <script src="{!! asset('js/back/jquery.form.js') !!}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $(".delete").click(function () {
                var value = $(this).attr('data');
                $('#modal-delete-' + value).modal('show');

                return false;
            });
        });
    </script>
@stop
