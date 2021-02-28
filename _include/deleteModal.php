  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#deleteModal" data-access="<?=$user["access"]?>" data-uid="<?=$user["UID"]?>" data-user="<?=$user["email"]?>">Delete</button>


  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog">

          <div class="modal-content">

              <div class="modal-header">
                  
                  <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                      <span aria-hidden="true">&times;</span>

                  </button>

              </div>

              <form>

                  <div class="modal-body">

                      <div class="form-group">

                          <label for="uid" class="col-form-label">UID</label>

                          <input type="text" class="form-control" id="input-uid" name="uid">

                      </div>

                  </div>

                  <div class="modal-footer">

                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                      <button type="submit" class="btn btn-danger">Confirm Delete</button>

                  </div>

              </form>

          </div>

      </div>

  </div>
