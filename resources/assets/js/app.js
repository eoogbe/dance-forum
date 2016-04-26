var setRowChecked = function (permissionRow, input) {
  var rowInputs = permissionRow.querySelectorAll('input[type="checkbox"]');
  var allChecked = true;

  if (input.className === 'all-permissions') {
    for (var i = 0; i < rowInputs.length; ++i) {
      if (rowInputs[i].className !== 'all-permissions') {
        rowInputs[i].checked = input.checked;
      }
    }
  } else {
    for (var i = 0; i < rowInputs.length; ++i) {
      if (rowInputs[i].className !== 'all-permissions') {
        allChecked = allChecked && input.checked;
      }
    }

    permissionRow.querySelector('.all-permissions').checked = allChecked;
  }
};

tinymce.init({
  selector: '.editor',
  auto_focus: 'content',
  menubar: false,
  toolbar: 'undo redo | fontsizeselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | blockquote | removeformat',
  setup: function (editor) {
    editor.on('focus', function () {
      editor.selection.select(editor.getBody(), true);
      editor.selection.collapse(false);
    });
    editor.on('submit', function () {
      document.querySelector('.editor-text').value = editor.getContent();
    })
  }
});

document.addEventListener('change', function(e) {
  var permissionRow = e.target.parentNode.parentNode;

  if (permissionRow.className === 'permission-row') {
    setRowChecked(permissionRow, e.target);
  }
}, true);
