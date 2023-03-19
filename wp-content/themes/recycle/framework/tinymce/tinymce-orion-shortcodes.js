(function() {
    tinymce.PluginManager.add( 'orion_menu', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('orion_menu', {
            title: 'Orion addons',
            type: 'menubutton',
            icon: 'icon orion-icon',
            menu: [
                {
                    text: 'Dropcaps',
                    value: 'dropcaps',
                     onclick: function() {
                        editor.windowManager.open( {
                            title: 'Add a letter',
                            body: [{
                                type: 'textbox',
                                name: 'title',
                                label: 'First letter'
                            },
                            {
                                type: 'textbox',
                                name: 'word',
                                label: 'rest of the word'
                            },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '<span class="dropcap">' + e.data.title + '</span>' + e.data.word);
                            }
                        });
                    }
                },
                {
                    text: 'Buttons',
                    value: 'buttons',
                     onclick: function() {
                        editor.windowManager.open( {
                            title: 'Add a button',
                            body: [{
                                type: 'textbox',
                                name: 'title',
                                label: 'Button text'
                            },
                            {
                                type: 'textbox',
                                name: 'url',
                                label: 'URL'
                            },
                            {
                                type: 'listbox',
                                name: 'size',
                                label: 'Size',
                                values : [
                                    { text: 'Normal', value: 'btn-md' },
                                    { text: 'Tiny', value: 'btn-xs' },
                                    { text: 'Small', value: 'btn-sm' },
                                    { text: 'Large', value: 'btn-lg' },
                                ],                                
                            },
                            {
                                type: 'listbox',
                                name: 'color',
                                label: 'Color',
                                values : [
                                    { text: 'Default', value: '' },                                
                                    { text: 'Primary theme color', value: 'btn-c1' },
                                    { text: 'Secondary theme color', value: 'btn-c2' },
                                    { text: 'Tertiary theme color', value: 'btn-c3' },
                                    { text: 'Blue', value: 'btn-blue' },
                                    { text: 'Green', value: 'btn-green' },
                                    { text: 'Pink', value: 'btn-pink' },
                                    { text: 'Yellow', value: 'btn-yellow' },
                                    { text: 'Orange', value: 'btn-orange' },
                                    { text: 'Red', value: 'btn-red' },
                                    { text: 'Black', value: 'btn-black' },
                                    { text: 'White', value: 'btn-white' },
                                ],                                
                            },                            
                            {
                                type: 'listbox',
                                name: 'style',
                                label: 'Style',
                                values : [
                                    { text: 'Flat', value: 'btn-flat' },                                
                                    { text: 'Wire', value: 'btn-wire' },
                                    { text: 'Empty', value: 'btn-empty' },
                                ],                                
                            },   
                            {
                                type: 'listbox',
                                name: 'borderstyle',
                                label: 'Rounding',
                                values : [
                                    { text: 'None', value: '' },  
                                    { text: 'Slightly rounded', value: 'btn-round-2' },                                
                                    { text: 'Completely rounded', value: 'btn-round' },
                                ],                                
                            },
                            {
                                type: 'checkbox',
                                name: 'fullwidth',
                                label: 'Full width',                            
                            },                                                                                       
                            ],
                            onsubmit: function( e ) {
                                var btn_aligment = '';
                                if (e.data.fullwidth == true) {
                                    btn_aligment = 'block';
                                }
                                editor.insertContent( '<a href="'+ e.data.url +'" class="btn ' + btn_aligment + ' ' + e.data.size + ' ' + e.data.style + ' ' + e.data.color + ' ' + e.data.borderstyle + '">' + e.data.title + '</a>');
                            }
                        });
                    }
                },
                {
                    text: 'Lead text',
                    value: 'lead',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Add lead text',
                            body: [{
                                type: 'textbox',
                                multiline :true,
                                name: 'text',
                                label: 'text'
                            },                                                                                 
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '<p class="lead">' +  e.data.text +'</p>');
                            }
                        });
                    }
                },
                {
                    text: 'Small text',
                    value: 'smalltext',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Add small text',
                            body: [{
                                type: 'textbox',
                                multiline :true,
                                name: 'text',
                                label: 'text'
                            },                                                                                 
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent( '<small>' +  e.data.text +'</small>');
                            }
                        });
                    }
                },                
                {
                    text: 'List',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'List',
                            body: [
                                {
                                    type: 'listbox',
                                    name: 'style',
                                    label: 'Style',
                                    'values': [
                                        {text: 'Arrow', value: 'list-arrow'},                                      
                                        {text: 'Checkmark', value: 'list-checklist'},
                                        {text: 'Star', value: 'list-star'},                                
                                    ]
                                },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent('<ul class="' + e.data.style + '"><li>Lorem ipsum</li><li>Lorem ipsum</li><li>Lorem ipsum</li></ul>');
                            }
                        });
                    }
                },
                {
                    text: 'Ordered list',
                    onclick: function() {
                        editor.insertContent('<ol class="ordered-list"><li>Lorem ipsum</li><li>Lorem ipsum</li><li>Lorem ipsum</li></ol>');
                    }
                },                

                {
                    text: 'Multicolumn text',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'multicolumn',
                            body: [
                                {
                                    type: 'listbox',
                                    name: 'columns',
                                    label: 'Columns',
                                    'values': [
                                        {text: '1 column', value: 'multi-column-1'},                                      
                                        {text: '2 Columns', value: 'multi-column-2'},
                                        {text: '3 Columns', value: 'multi-column-3'},
                                        {text: '4 Columns', value: 'multi-column-4'},
                                    ]
                                },
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent('<div class="' + e.data.columns + '">Enter Multi column text here</div>');
                            }
                        });
                    }
                },                
                {
                    text: 'Divider',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Divider',
                            body: [
                                {
                                    type: 'colorpicker',
                                    name: 'hrcolor',
                                    label: 'Divider color'
                                },
                                {
                                    type: 'textbox',
                                    name: 'hrheight',
                                    label: 'Height in px'
                                },
                                {
                                    type: 'textbox',
                                    name: 'hrwidth',
                                    label: 'Width in %'
                                },  
                                {
                                    type: 'listbox',
                                    name: 'style',
                                    label: 'Style',
                                    'values': [
                                        {text: 'Solid', value: 'solid'},                                      
                                        {text: 'Dashed', value: 'dashed'},
                                        {text: 'Dotted', value: 'doted'},
                                        {text: 'Double', value: 'double'},                                
                                    ]
                                },                                
                            ],
                            onsubmit: function( e ) {
                                editor.insertContent('<hr style="border-top-width: ' + e.data.hrheight + 'px; border-top-color: ' + e.data.hrcolor + '; border-style: ' + e.data.style + '; width: ' + e.data.hrwidth + '%;" >');
                            }
                        });
                    }
                },    
           ]            
        });
    });
})();