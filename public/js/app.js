var setAllInputForRow = function ($row) {
  var $allInput = $row.find('[data-all-permissions]');
  var $inputs = $row.find('input').not($allInput);
  var allChecked = $inputs.length === $inputs.filter(':checked').length;

  $allInput.prop('checked', allChecked);
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
      $('[data-editor-text]').val(editor.getContent());
    })
  }
});

$(document).on('change', '[data-permission-row] input:not([data-all-permissions])', function () {
  setAllInputForRow($(this).closest('[data-permission-row]'));
});

$(document).on('change', '[data-all-permissions]', function () {
  $(this)
    .closest('[data-permission-row]')
    .find('input')
    .prop('checked', $(this).prop('checked'));
});

$(function () {
  $('[data-permission-row]').each(function () {
    setAllInputForRow($(this));
  });
});

//# sourceMappingURL=app.js.map
