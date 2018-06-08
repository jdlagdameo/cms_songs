@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Manage Songs</li>
        </ol>
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> List of Songs
                    </div>
                    <div class="card-body">
                        <button data-toggle="modal" data-target="#modal-form" class="btn btn-info btn-sm"  onclick="openModal(this)"><i
                                    class="fa fa-plus-circle"></i> Add New Song Lyrics
                        </button>
                        <br/><br/>
                        <div class="table-responsive">
                            <table id="table-song-lyrics" class="table table-bordered" id="dataTable" width="100%"
                                   cellspacing="0">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Title</th>
                                    <th style="width: 30%">Artist</th>
                                    <th style="width: 25%">Logs</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="width: 30%">Title</th>
                                    <th style="width: 30%">Artist</th>
                                    <th style="width: 25%">Logs</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid-->

    <!-- forms -->
    @include('admin.song_lyrics.form')

    @push('scripts')
        <script type="text/javascript">
            var id = "";
            $("#modal-lyrics").on("hidden.bs.modal", function () {
                $("#lyrics-header").html("");
                $("#container-lyrics").html("");
            });

            $("#modal-form").on("hidden.bs.modal", function () {
                id = "";
                document.getElementById("song-form").reset();
            });

            var table =$('#table-song-lyrics').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{route('song_lyrics_data')}}',
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'artist', name: 'artist'},
                    {data: 'logs', name: 'logs', orderable: false, searchable: false},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });

            /**
             * Form Submit
             *
             */
            // Form Submit
            function submit() {
                var title = $("#title").val();
                var artist = $("#artist").val();
                var lyrics = $("#lyrics").val();
                var url = '{{URL::to('api/song_lyrics')}}' + (id == "" ? "" : "/" + id);
                var data = {
                    title: title,
                    artist: artist,
                    lyrics: lyrics,
                    _token: "{{csrf_token()}}"
                };

                if (id == "") {
                    $.ajax({
                        type: "POST",
                        url: url,
                        cache: false,
                        dataType: "json",
                        //method:method,
                        data: data,
                        beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer {{Auth()->user()->api_token}}' ); },
                        success: function (response) {
                            if (response.success) {
                                swal("Success", response.message, "success");
                                table.ajax.reload();
                                $('#modal-form').modal('hide');
                                document.getElementById("song-form").reset();
                            } else {
                                swal("Invalid Entry", response.message, "warning");
                                $("#" + response.field).focus();
                            }
                        }
                    });
                } else {
                    if(!confirm("Are you sure you want to updated this record?")){
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: url,
                        cache: false,
                        dataType: "json",
                        method: "PUT",
                        data: data,
                        beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer {{Auth()->user()->api_token}}' ); },
                        success: function (response) {
                            if (response.success) {
                                swal("Success", response.message, "success");
                                table.ajax.reload();
                                $('#modal-form').modal('hide');
                                document.getElementById("song-form").reset();
                            } else {
                                swal("Invalid Entry", response.message, "warning");
                                $("#" + response.field).focus();
                            }
                        }
                    });
                }
            }
            
            function openLyricsModal(e) {
                var c_id = $(e).attr("data-value");
                $.ajax({
                    type: "GET",
                    contentType: 'application/json',
                    url: "{{URL::to('api/song_lyrics')}}/" + c_id,
                    cache: false,
                    dataType: "json",
                    data: {id: c_id, _token: "{{csrf_token()}}"},
                    beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer {{Auth()->user()->api_token}}' ); },
                    success: function (response) {
                        var data = response.data;
                        $("#lyrics-header").html(data.title + '<br><small>By: '+data.artist+'</small>');
                        $("#container-lyrics").html(nl2br (data.lyrics, false));
                    }
                });
            }

            function openModal(e) {
                id = (typeof $(e).attr("data-value") == "undefined"?"":$(e).attr("data-value"));

                if (id != "" && id !== undefined) {
                    console.log("Bearer {{Auth()->user()->api_token}}");
                    $("#form-header").html("Edit Song Lyrics");
                    $.ajax({
                        type: "GET",
                        contentType: 'application/json',
                        url: "{{URL::to('api/song_lyrics')}}/" + id,
                        cache: false,
                        dataType: "json",
                        data: {id: id, _token: "{{csrf_token()}}"},
                        beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer {{Auth()->user()->api_token}}' ); },
                        success: function (response) {
                            var data = response.data;
                            $("#title").val(data.title);
                            $("#artist").val(data.artist);
                            $("#lyrics").val(data.lyrics);
                        }
                    });
                } else {
                    $("#form-header").html("Add Song Lyrics");
                }

            }
            /**
             * Delete Record
             * @param e
             */
            function deleteItem(e){
                var id = $(e).attr("data-value");
                if(confirm("Are you sure you want to delete this record?")){
                    $.ajax({
                        type:"POST",
                        method: 'DELETE',
                        contentType: 'application/json',
                        url:"{{URL::to('api/song_lyrics')}}/" + id,
                        cache:false,
                        dataType:"json",
                        data:{_token:"{{csrf_token()}}"},
                        beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer {{Auth()->user()->api_token}}' ); },
                        success:function(response){
                            if(response.deleted){
                                swal("Success", response.message, "success");
                                table.ajax.reload();
                            }else{
                                swal("Delete Song Lyrics", response.message, "error");
                            }
                        }
                    });
                }
            }

            function nl2br (str, is_xhtml) {
                // http://kevin.vanzonneveld.net
                // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +   improved by: Philip Peterson
                // +   improved by: Onno Marsman
                // +   improved by: Atli Þór
                // +   bugfixed by: Onno Marsman
                // +      input by: Brett Zamir (http://brett-zamir.me)
                // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +   improved by: Brett Zamir (http://brett-zamir.me)
                // +   improved by: Maximusya
                // *     example 1: nl2br('Kevin\nvan\nZonneveld');
                // *     returns 1: 'Kevin<br />\nvan<br />\nZonneveld'
                // *     example 2: nl2br("\nOne\nTwo\n\nThree\n", false);
                // *     returns 2: '<br>\nOne<br>\nTwo<br>\n<br>\nThree<br>\n'
                // *     example 3: nl2br("\nOne\nTwo\n\nThree\n", true);
                // *     returns 3: '<br />\nOne<br />\nTwo<br />\n<br />\nThree<br />\n'
                var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
            }
        </script>
    @endpush

@endsection
