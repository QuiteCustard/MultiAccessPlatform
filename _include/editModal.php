$('#editModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var uid = button.data('uid') // Extract info from data-* attributes
  var user = button.data('user') // Extract info from data-* attributes
  var access = button.data('access') // Extract info from data-* attributes

  var modal = $(this)
  modal.find('.modal-title').text('Editing user: ' + user)
  modal.find('.input-uid').val(uid)
  modal.find('.input-email').val(user)

})