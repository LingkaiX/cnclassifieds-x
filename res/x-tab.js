(function() {
    /* Register the buttons */
    tinymce.create('tinymce.plugins.insertSC', {
         init : function(ed, url) {
              /**
              * Inserts shortcode content
              */
              ed.addButton( 'button_eek', {
                   title : 'Insert shortcode',
                   image : '../wp-includes/images/smilies/icon_eek.gif',
                   onclick : function() {
                        var shortcode=`[x-tab-start]
                        [x-tab-item-start id="1" name="tab1"]
                        <p>this is item 1.</p>
                        [x-tab-item-end]
                        [x-tab-item-start name="tab2"]
                        <p>this is item 2.</p>
                        [x-tab-item-end]
                        [x-tab-item-start name="tab3"]
                        <p>this is item 3.</p>
                        [x-tab-item-end]
                        [x-tab-end]`;
                        ed.execCommand('mceInsertContent', 0, shortcode);
                   }
              });
              /**
              * Adds HTML tag to selected content
              */
            //   ed.addButton( 'button_green', {
            //        title : 'Add span',
            //        image : '../wp-includes/images/smilies/icon_mrgreen.gif',
            //        cmd: 'button_green_cmd'
            //   });
            //   ed.addCommand( 'button_green_cmd', function() {
            //        var selected_text = ed.selection.getContent();
            //        var return_text = '';
            //        return_text = '<h1>' + selected_text + '</h1>';
            //        ed.execCommand('mceInsertContent', 0, return_text);
            //   });
         },
         createControl : function(n, cm) {
              return null;
         },
    });
    /* Start the buttons */
    tinymce.PluginManager.add( 'insertSC', tinymce.plugins.insertSC );
})();