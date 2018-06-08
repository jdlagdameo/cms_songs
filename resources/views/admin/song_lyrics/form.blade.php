<!-- Modal Form -->
<div id="modal-form" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form-header">Add Song Lyrics</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="song-form">
                    @csrf
                    <!-- Title -->
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Title:</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" maxlength="50" required autofocus
                                   class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                   id="title" placeholder="Enter Title">
                        </div>
                    </div>

                    <!-- Artist -->
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="artist">Artist:</label>
                        <div class="col-sm-10">
                            <input type="text" name="artist" maxlength="50" required
                                   class="form-control{{ $errors->has('artist') ? ' is-invalid' : '' }}"
                                   id="artist" placeholder="Enter Artist">
                        </div>
                    </div>

                    <!-- Lyrics -->
                    <!-- Artist -->
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="artist">Artist:</label>
                        <div class="col-sm-10">
                                <textarea type="text" name="lyrics" required style="resize: none" rows="10"
                                          class="form-control{{ $errors->has('lyrics') ? ' is-invalid' : '' }}"
                                          id="lyrics" placeholder="Enter Lyrics"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary pull-right" onclick="submit()">Submit</button>
            </div>
        </div>

    </div>
</div>


<!-- Modal Lyrics-->
<div id="modal-lyrics" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lyrics-header"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <p id="container-lyrics" class="text-center"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary pull-right" onclick="submit()">Submit</button>
            </div>
        </div>

    </div>
</div>
