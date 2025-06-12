"use strict";

(function () {
  tinymce.PluginManager.add('madelab_mce_dropbutton', function (editor, url) {
    editor.addButton('madelab_mce_dropbutton', {
      text: 'Boxes',
      // icon: 'format-painter',
      type: 'menubutton',
      menu: [{
        text: 'Box Gray',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4" style="background-color: #f5f5f5; padding: 20px;"><h2>Title</h2><p class="mb-0">Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><p></p>');
        }
      }, {
        text: 'Box Yellow',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4" style="background-color: #fec402; padding: 20px;"><h2>Title</h2><p class="mb-0">Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><p></p>');
        }
      }, {
        text: 'Box Lemon',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4" style="background-color: #e1e558; padding: 20px;"><h2>Title</h2><p class="mb-0">Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><p></p>');
        }
      }, {
        text: 'Box Green',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4" style="background-color: #2cb34a; padding: 20px;"><h2>Title</h2><p class="mb-0">Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><p></p>');
        }
      }, {
        text: 'Box Red',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4 text-white" style="color:#fff; background-color: #dc3545; padding: 20px;"><h2 class="text-white" style="color:#fff;">Title</h2><p class="mb-0">Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><p></p>');
        }
      }, {
        text: 'Box Black',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4 text-white" style="color:#fff; background-color: #000; padding: 20px;"><h2 class="text-white" style="color:#fff;">Title</h2><p class="mb-0">Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><p></p>');
        }
      }]
    });
    editor.addButton('madelab_mce_dropbutton2', {
      text: 'Elements',
      // icon: 'temporary-placeholder',
      type: 'menubutton',
      menu: [{
        text: 'Button',
        onclick: function onclick() {
          editor.insertContent('<p><a class="btn btn-dark text-white rounded-0" href="#">Button</a></p><p></p>');
        }
      }, {
        text: 'Horizontal Rule',
        onclick: function onclick() {
          editor.insertContent('<hr>');
        }
      }, {
        text: 'Blockquote',
        onclick: function onclick() {
          editor.insertContent('<blockquote class="made-section blockquote"><p class="mb-0">Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p><footer>Someone famous in</footer></blockquote><p></p>');
        }
      }, {
        text: '2 Columns',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section" style="position:relative"><div class="row mb-4" style="position:relative"><div style="position:relative" class="col-lg-6"><h2>Title</h2><p>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><div style="position:relative" class="col-lg-6"><h2>Title</h2><p>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div></div>/div><p></p>');
        }
      }, {
        text: '3 Columns',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section" style="position:relative"><div class="row mb-4" style="position:relative"><div style="position:relative" class="col-lg-4"><h2>Title</h2><p>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><div style="position:relative" class="col-lg-4"><h2>Title</h2><p>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div><div style="position:relative" class="col-lg-4"><h2>Title</h2><p>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p></div></div></div><p></p>');
        }
      }, {
        text: 'Table',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section"><table class="table table-striped"><thead><tr><th scope="col">#</th><th scope="col">First</th><th scope="col">Last</th><th scope="col">Handle</th></tr></thead><tbody><tr><th scope="row">1</th><td>Mark</td><td>Otto</td><td>@mdo</td></tr><tr><th scope="row">2</th><td>Jacob</td><td>Thornton</td><td>@fat</td></tr><tr><th scope="row">3</th><td>Larry</td><td>the Bird</td><td>@twitter</td></tr></tbody></table></div><p></p>');
        }
      }, {
        text: 'Alert Primary',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4"><div class="alert alert-primary" role="alert">Primary alert—check it out!</div></div><p></p>');
        }
      }, {
        text: 'Alert Danger',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4"><div class="alert alert-danger" role="alert">Danger alert—check it out!</div></div><p></p>');
        }
      }, {
        text: 'Alert Warning',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4"><div class="alert alert-warning" role="alert">Warning alert—check it out!</div></div><p></p>');
        }
      }, {
        text: 'Card',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4"><div class="card"><div class="card-header">Header</div><div class="card-body"><h5 class="card-title">Secondary card title</h5><p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p></div></div></div><p></p>');
        }
      }, {
        text: 'Card Dark',
        onclick: function onclick() {
          editor.insertContent('<div class="made-section mb-4"><div class="card text-bg-dark bg-dark"><div class="card-header text-white">Header</div><div class="card-body"><h5 class="card-title text-white">Secondary card title</h5><p class="text-white card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p></div></div></div><p></p>');
        }
      }]
    });
  });
})();