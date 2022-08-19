<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(Session::has('alert'))
          <p>berhasil regis</p>
        @endif
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">user_nik</label>
                <div class="col-sm-10">
                <input type="text" name="user_nik" class="form-control" id="inputText3">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">user_name</label>
                <div class="col-sm-10">
                <input type="text" name="user_name" class="form-control" id="inputtext4">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">user_password</label>
                <div class="col-sm-10">
                <input type="password" name="user_password" class="form-control" id="inputPassword3">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">user_photo</label>
                <div class="col-sm-10">
                <input type="file"  name="user_photo" class="form-control" id="inputFile3">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">user_email</label>
                <div class="col-sm-10">
                <input type="email" name="user_email" class="form-control" id="inputtext4">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>