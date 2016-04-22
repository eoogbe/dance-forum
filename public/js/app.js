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

//# sourceMappingURL=app.js.map
