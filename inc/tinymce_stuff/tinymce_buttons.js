(function() {
    tinymce.create('tinymce.plugins.seasaltpress', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
	       
	       ed.addButton('columns', {
                title : 'Columns',
                cmd : 'columns'
            });
            
         ed.addButton('content-column', {
                title : 'Centered Content Column',
                cmd : 'content-column'
          });
         
          ed.addButton('break-out', {
                title : 'Break-out-of-columns',
                cmd : 'break-out'
            });
            
          ed.addButton('button-link', {
                title : 'Button-link',
                cmd : 'button-link'
            });
            
          ed.addButton('wrap', {
                title : 'wrap container',
                cmd : 'wrap'
            });
            
            
            
            
         ed.addCommand('columns', function() {
	         var number = prompt("How many columns do you want? ");
            var selected_text = ed.selection.getContent() ? ed.selection.getContent()  : 'Put content here';
            
            var return_text = '';
            return_text = '<div class="row">';
            
            for(var i = 0; i < number; i++){
	            return_text +='<div class="col-1-' + number + '"><p>' + selected_text + '</p></div>';
	            }
	            return_text += ' </div> Text After columns';
            ed.execCommand('mceInsertContent', 0, return_text);
        });
        
        
        ed.addCommand('content-column', function() {
	          var selected_text = ed.selection.getContent() ? ed.selection.getContent()  : 'Put content here';
            
            var return_text = '';
            return_text = '<div class="row"><div class="content-column"><p>' + selected_text + '</p></div></div>';
	            
            ed.execCommand('mceInsertContent', 0, return_text);
        });
        
        ed.addCommand('break-out', function() {
	      var selected_text = ed.selection.getContent() ? ed.selection.getContent()  : 'Put content here';
	      
	      	var return_text = '<div class="break-out"> <div class="inside-break-out">' + selected_text + ' </div> </div>';
	      	ed.execCommand('mceInsertContent', 0, return_text);  
	      });
	      
	      ed.addCommand('button-link', function() {
	      	var selected_text = ed.selection.getContent() ? ed.selection.getContent()  : 'Link Text';
	      	
	      	var return_text = '<a href="#" class="button">' + selected_text + ' </a>';
	      	ed.execCommand('mceInsertContent', 0, return_text);  
	      });
	      
	      
       ed.addCommand('wrap', function() {
      	var selected_text = ed.selection.getContent() ? ed.selection.getContent()  : 'insert columns';
      	
      	var return_text = '<div class="wrap">' + selected_text + ' </div>';
      	ed.execCommand('mceInsertContent', 0, return_text);  
      });
 
        },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Sea Salt Press Buttons',
                author : 'Shamai',
                authorurl : 'http://saltnpixels.com',
                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                version : "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add( 'seasaltpress', tinymce.plugins.seasaltpress );
})();