@extends('layouts.back.master-with-left-menu')
@section('title', 'Utilisateurs')
@section('breadcrumb')
    {!! Breadcrumbs::render('company.page', $company) !!}
@stop
@section('left-menu')
    @include('back.company.menu')
@stop

@section('right-content')
    <h4>{{$company->name}} : Users</h4>

    {!! Formatter::addButton(route('company.users.add', [$company->id]))!!}
    {!! Formatter::button(route('company.users.assigner', [$company->id]), 'primary', 'fa-user fa', 'Assigner')!!}

    </br></br>

    <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title">
                Rechercher
            </div>

            <div class="panel-options">
                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            </div>
        </div>

        <div class="panel-body">
           </div>
    </div>

    <table class="table table-bordered table-striped datatable" id="table">
        <thead>
        <tr>
            <th>Nom complet</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td class="search-name">{{ $user->name }}</td>
                <td class="search-last-name">{{ $user->last_name }}</td>
                <td class="search-fist-name">{{ $user->first_name }}</td>
                <td class="search-mail">{{ $user->email }}</td>
                <td data='{{$user->type->id}}' class="search-type">
                    {{ $user->type->name }}
                </td>

                <td>

                    {!! Formatter::button(route('user.details', [$user->id]), 'info', 'fa fa-eye', "Détails")!!}

                    {!! Formatter::button(route('company.users.unassign', [$company->id, $user->id]), 'warning', 'fa fa-sign-out','Désassigner')!!}
                    {!! Formatter::deleteButton($user->id)!!}
                    {!! Formatter::delete(route('user.delete', $user->id), $user->id, "Supprimer un utilisateur", "Etes-vous sûr de vouloir supprimer le compte de ".$user->email ." ?" ) !!}

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <br/>
    <br/>

@stop
@section('js')
    <!-- Laravel Javascript Validation -->
    {{ Html::script('js/jquery/dataTables.min.js') }}

    <script type='text/javascript'>
        $(document).ready(function () {
            $('#table').DataTable({
                sDom: '<"top"l>rt<"bottom"ip><"clear">',
                "order": [[0, "asc"]],
                "drawCallback": function (settings) {
                    callback();
                }
            });

            function filterColumn(i) {
                $('#table').DataTable().column(i).search(
                    $('#col' + i + '_filter').val()
                ).draw();
            }

            // recherche
            $('input.column_filter').on('keyup click', function () {
                filterColumn($(this).attr('data-column'));
            });


            /** Clique sur le nom */
            $(".search-name").click(function () {
                var value = $(this).html();
                $('#col0_filter').val(value);
                search();
            });

            /** Recherche sur la visibilité */
            $(".search-visible").click(function () {
                var value = $(this).attr('data');
                $('#visible-search').val(value);
                searchStatut($('#visible-search'));
            });

            $('#visible-search').on('change', function () {
                searchStatut($(this));
            });

            function searchStatut(src) {
                var data = src.val() >= 0 ? src.find("option:selected").text() : '';

                $('#col2_filter').val(data);
                search();
            }


            /** bouton de recherche  */
            $("#search").click(function () {
                search();
            });

            /** Recherhe */
            function search() {
                filterColumn($('#col0_filter').attr('data-column'));
                filterColumn($('#col2_filter').attr('data-column'));
            }

            /** Vidage des champs */
            $("#clear").click(function () {
                $('#col0_filter').val('');
                $('#col2_filter').val('');
                $('#visible-search').val(-1);
                search();
            });

            /**************************************************************/
            /************************* SUPPRESSION ************************/

            /**************************************************************/
            function callback() {
                $(".delete").click(function () {
                    var value = $(this).attr('data');
                    $('#modal-delete-' + value).modal('show');
                    return false;
                });


                $(".preview").click(function () {
                    var value = $(this).attr('data');
                    $('#modal-preview-' + value).modal('show');
                    return false;
                });
            }

        });
    </script>
@stop
