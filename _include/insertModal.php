<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewUser">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewUserLabel">Add new user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="../admin/insert.php">
            <div class="modal-body">
                <label for="Email" class="sr-only">Email:</label>
                <input type="email" name="Email" placeholder="Email" class="form-control" required autofocus>
                <label for="Password" class="sr-only">Password:</label>
                <input type="password" name="Password" placeholder="Password" class="form-control" required autofocus>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
                </form>
        </div>
    </div>
</div>

