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
    }
  });
  tinymce.PluginManager.add( 'original_tinymce_button_plugin', tinymce.plugins.original_tinymce_button );
})();
