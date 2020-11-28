(function() {
  tinymce.create('tinymce.plugins.original_tinymce_button', {
    init: function( ed, url ) {
      ed.addButton( 'lineLeft', {
        title: 'LINE吹き出し左から',
        image: url + '/line-left.png',
        cmd: 'line_left'
      });
      ed.addCommand( 'line_left', function(ui, val) {
        let linename = '';
        let lineicon = '';
        if (val && val.linename) linename = val.linename;
        if (val && val.lineicon) lineicon = val.lineicon;
        ed.windowManager.open({
          title: 'LINE吹き出し左から',
          body: [
            {
              type: 'listbox',
              name: 'lineicon',
              label: 'アイコン',
              value: lineicon,
              'values': [
                {text: 'あかたむ', value: 'akatam'},
                {text: 'ざき', value: 'zaki'},
                {text: '男', value: 'otoko'},
                {text: '女', value: 'onna'},
              ],
            },
            {
              type: 'textbox',
              name: 'linename',
              label: '名前',
              value: linename
            }
          ],
          onsubmit: function(e) {
            var shortcode = '[line_left icon="' + e.data.lineicon + '" name="' + e.data.linename + '"][/line_left]';
            var return_text = '<div class="js-line line-left"><div class="line-left__icon line-left__icon--' + e.data.lineicon + '"><p>' + e.data.linename + '</p></div><p class="line-left__text"></p></div>';
            ed.insertContent(return_text);
          }
        });
      });
      ed.addButton( 'lineRight', {
        title: 'LINE吹き出し右から',
        image: url + '/line-right.png',
        cmd: 'line_right'
      });
      ed.addCommand( 'line_right', function(ui, val) {
        let linename = '';
        let lineicon = '';
        if (val && val.linename) linename = val.linename;
        if (val && val.lineicon) lineicon = val.lineicon;
        ed.windowManager.open({
          title: 'LINE吹き出し右から',
          body: [
            {
              type: 'listbox',
              name: 'lineicon',
              label: 'アイコン',
              value: lineicon,
              'values': [
                {text: 'あかたむ', value: 'akatam'},
                {text: 'ざき', value: 'zaki'},
                {text: '男', value: 'otoko'},
                {text: '女', value: 'onna'},
              ],
            },
            {
              type: 'textbox',
              name: 'linename',
              label: '名前',
              value: linename
            }
          ],
          onsubmit: function(e) {
            var return_text = '<div class="js-line line-right"><div class="line-right__icon line-right__icon--' + e.data.lineicon + '"><p>' + e.data.linename + '</p></div><p class="line-right__text"></p></div>';
            ed.insertContent(return_text);
          }
        });
      });
      ed.addButton( 'markerYellow', {
        title: '黄色マーカー',
        image: url + '/marker-yellow.png',
        cmd: 'marker_yellow'
      });
      ed.addCommand( 'marker_yellow', function() {
        var selected_text = ed.selection.getContent();
        var return_text = '<strong class="undeline-yellow">' + selected_text + '</strong>';
        ed.insertContent(return_text);
      });
      ed.addButton( 'markerPink', {
        title: 'ピンクマーカー',
        image: url + '/marker-pink.png',
        cmd: 'marker_pink'
      });
      ed.addCommand( 'marker_pink', function() {
        var selected_text = ed.selection.getContent();
        var return_text = '<strong class="undeline-pink">' + selected_text + '</strong>';
        ed.insertContent(return_text);
      });
      ed.addButton( 'insertSortcode', {
        title: '車の入力欄挿入',
        image: url + '/shortcode.png',
        cmd: 'insert_sortcode'
      });
      ed.addCommand( 'insert_sortcode', function() {
        var id = getParam('post')
        console.log(id);
        var selected_text = ed.selection.getContent();
        var return_text = '[listInsert ' + id + ']';
        ed.insertContent(return_text);
      });
      ed.addButton( 'kangaeLeft', {
        title: '考えごと左から',
        image: url + '/kangae-left.png',
        cmd: 'kangae_left'
      });
      ed.addCommand( 'kangae_left', function(ui, val) {
        let kangaename = '';
        let kangaeicon = '';
        if (val && val.kangaename) kangaename = val.kangaename;
        if (val && val.kangaeicon) kangaeicon = val.kangaeicon;
        ed.windowManager.open({
          title: '考えごと左から',
          body: [
            {
              type: 'listbox',
              name: 'lineicon',
              label: 'アイコン',
              value: kangaeicon,
              'values': [
                {text: 'あかたむ', value: 'akatam'},
                {text: 'ざき', value: 'zaki'},
                {text: '男', value: 'otoko'},
                {text: '女', value: 'onna'},
              ],
            },
            {
              type: 'textbox',
              name: 'kangaename',
              label: '名前',
              value: kangaename
            }
          ],
          onsubmit: function(e) {
            var shortcode = '[kangae_left icon="' + e.data.lineicon + '" name="' + e.data.linename + '"][/kangae_left]';
            var return_text = '<div class="js-line kangae-left"><div class="line-left__icon line-left__icon--' + e.data.lineicon + '"><p>' + e.data.linename + '</p></div><p class="kangae-left__text"></p></div>';
            ed.insertContent(return_text);
          }
        });
      });
      ed.addButton( 'kangaeRight', {
        title: '考えごと右から',
        image: url + '/kangae-right.png',
        cmd: 'kangae_right'
      });
      ed.addCommand( 'kangae_right', function(ui, val) {
        let kangaename = '';
        let kangaeicon = '';
        if (val && val.kangaename) kangaename = val.kangaename;
        if (val && val.kangaeicon) kangaeicon = val.kangaeicon;
        ed.windowManager.open({
          title: '考えごと右から',
          body: [
            {
              type: 'listbox',
              name: 'lineicon',
              label: 'アイコン',
              value: kangaeicon,
              'values': [
                {text: 'あかたむ', value: 'akatam'},
                {text: 'ざき', value: 'zaki'},
                {text: '男', value: 'otoko'},
                {text: '女', value: 'onna'},
              ],
            },
            {
              type: 'textbox',
              name: 'kangaename',
              label: '名前',
              value: kangaename
            }
          ],
          onsubmit: function(e) {
            var shortcode = '[kangae_right icon="' + e.data.lineicon + '" name="' + e.data.linename + '"][/kangae_right]';
            var return_text = '<div class="js-line kangae-right"><div class="line-right__icon line-right__icon--' + e.data.lineicon + '"><p>' + e.data.linename + '</p></div><p class="kangae-right__text"></p></div>';
            ed.insertContent(return_text);
          }
        });
      });
    }
  });
  tinymce.PluginManager.add( 'original_tinymce_button_plugin', tinymce.plugins.original_tinymce_button );
  function getParam(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
})();
