(function ($) {
    
    var Gallery = (function () {
        
        var
            previousPanel,
            Selectables,
            Selected,
            init = function () {
               setPanelVisibility();
               setEvents();
               
               
            
                Selectables = new SelectablesCollection;
                Selected = new SelectedCollection;
                new SelectablesView();
                new SelectionsView();
                
                window.Selectables = Selectables;
                window.Selected = Selected;
            },
            
            setPanelVisibility = function () {
                $('.stuffbox:not(:first)').hide();//:not(:last)
            },
            
            setEvents = function () {
                $('.stuffbox .button').on('click', routeEvent);
            },
            
            routeEvent = function (e) {
                e.preventDefault();
                
                eventsMap[this.name].call(this,e);
            },
            
            eventsMap = {
            
                // we are on the select service button
                'select-service-btn' : function (e) {
                    var
                        that  = this,
                        form  = $(that).closest('form'),
                        input = form.find('input:checked'),
                        value;
                    
                    if (input.size() !== 0) {
                        value = input.get(0).value;

                        $(panelMap[value]).slideDown();
                        form.parent().slideUp();
                    }
                },
                
                'flickr-initial-btn' : function (e) {
                    var
                        that      = $(this),
                        stuffbox  = that.closest('.stuffbox'),
                        value     = $('#flickrOptions :selected').val();
                
                    previousPanel = stuffbox;
                    
                    if (value) {
                        $(panelMap[value]).slideDown();
                        stuffbox.slideUp();
                    }
                },
                
                'flickr-photoset-btn' : function (e) {
                    var
                        that      = $(this),
                        stuffbox  = that.closest('.stuffbox'),
                        value     = $.trim($('#flickr_photoset_id').val());
                        
                    previousPanel = stuffbox;
                    
                    if (!value) {
                        value     = $('#flickr_photoset_id_dd :selected').val();
                    }
                
                    if (value) {
                        $("#flickr-size-panel").slideDown();
                        stuffbox.slideUp();
                    }
                },
                
                'flickr-basic-btn' : function (e) {
                    var
                        that      = $(this),
                        stuffbox  = that.closest('.stuffbox'),
                        value     = $.trim($('#flickr-basic-url').val());
                        
                    previousPanel = stuffbox;
                
                    if (value) {
                        $("#flickr-size-panel").slideDown();
                        stuffbox.slideUp();
                    }
                },
                
                'flickr-api-btn' : function (e) {
                
                },
                
                'previous-btn' : function (e) {
                    var
                        that      = $(this),
                        stuffbox  = that.closest('.stuffbox'),
                        previous  = $('#' + that.attr('previous'));
                        
                    if (!previous.size()) {
                        previous = previousPanel;
                    }
                        
                    stuffbox.slideUp();
                    previous.slideDown();
                },
                
                'flickr-size-btn' : function (e) {
                    var
                        that      = $(this),
                        stuffbox  = that.closest('.stuffbox'),
                        previous  = $('#' + that.attr('previous')),
                        options   = stuffbox.find('select :selected'),
                        obj;
                        
                    if (!previous.size()) {
                        previous = previousPanel;
                    }
                    
                    obj = {
                        'service' : 'flickr',
                        'small'   : options.eq(0).val(),
                        'large'   : options.eq(1).val()
                    };
                    
                    if (previousPanel.attr('id') === 'flickr-basic-panel') {
                        obj.url = $('#flickr-basic-url').val();
                    }
                    
                    eventsMap.fetchImages(e,obj);
                },
                
                'fetchImages' : function (e, obj) {
                    var data = {
                        'action' : 'px_gallery',
                        'hopper' : 'getPhotos'
                    };
                    
                    $.extend(data,obj);
                    
                    jQuery.get(ajaxurl, data, function(response) {
                        if (response.result) {
                            fetchImagesSuccess(response);
                        }
                        else {
                            fetchImagesError();
                        }
                    });
                }
            },
            
            fetchImagesError = function (result) {
                
            },
            
            fetchImagesSuccess = function (result) {
                
                Selectables.reset(result.records);
                
                $('.interaction-panel').slideDown();
            },
            
            panelMap = {
                'flickr'         : '#flickr-initial-panel',
                'flickrBasic'    : '#flickr-basic-panel',
                'flickrPhotoset' : '#flickr-photoset-panel',
                'flickrSearch'   : '#flickr-search-panel',
                
                
                'smugmug' : '#smugmug-initial-panel',
                'locally' : '',
                
                'flickr-initial-previous-btn' : 'select-service-panel'
            },
            
            Photo  = Backbone.Model.extend({
                defaults : function () {
                    return {
                        "square"    : '',
                        "small"     : '',
                        "full"      : '',
                        "original"  : '',
                        "title"     : '',
                        "index"     : ''
                    };
                }
            }),
            
            SelectablesCollection = Backbone.Collection.extend({
                model : Photo
            }),
            
            SelectedCollection = Backbone.Collection.extend({
                model : Photo
            }),
            
            PhotoView = Backbone.View.extend({
                tagName : 'li',
                
                className : 'attachment',
                
                
                template: _.template($('#photoView-template').html()),
                initialize: function() {
                    this.model.bind('change', this.render,this);
                    this.model.bind('destroy', this.clear,this);
                    
                    this.$el.draggable({
                        connectToSortable : '#selections',
                        helper : 'clone',
                        revert : 'invalid',
                        scroll : false,
                        appendTo: "body",
                        tolerance: "touch"
                    });
                },
                // Re-render the titles of the todo item.
                render: function() {
                    this.$el.html(this.template(this.model.toJSON()));

                    this.$el.attr('data-cid',this.model.cid);
                    
                   // this.$el.toggleClass('done', this.model.get('done'));
                    //this.input = this.$('.edit');
                    return this;
                },

                // Remove the item, destroy the model.
                clear: function() {
                    this.model.destroy();
                }
            }),
            
            SelectablesView = Backbone.View.extend({
                el : $('#selectables'),
                
                events : {
                    'click #toggle-all' : 'toggleAllSelected'
                },
                
                initialize: function() {
                    Selectables.bind('add', this.addOne,this);
                    Selectables.bind('reset', this.addAll,this);
                    Selectables.bind('all', this.render,this);
                    
                    this.$el.slideDown();
                },
                
                toggleAllSelected : function () {
                
                },
                
                render: function() {
                
                },
                
                addOne: function(selectable) {

                    var view = new PhotoView({model:selectable});

                    this.$el.append(view.render().el);
                },
                
                addAll: function() {
                    Selectables.each(this.addOne, this);
                }
            });
            
            SelectionsView = Backbone.View.extend({
                el : $('#selections'),
                
                events : {
                    'click #toggle-all' : 'toggleAllSelected'
                },
                
                change : function () {
                    console.log('change');
                },
                
                initialize: function() {
                    Selected.bind('add', this.addOne,this);
                    Selected.bind('reset', this.addAll,this);
                    Selected.bind('all', this.render,this);
                    Selected.bind('change', this.change,this);
                    
                    this.$el.slideDown();
                    
                    this.$el.sortable({
                        placeholder: "attachment ui-state-highlight",
                        
                        receive : function (event, ui) {
                            var 
                                newItem = $(this).data().sortable.currentItem,
                                cid = $(ui.item).data('cid'),
                                model;
                                
                            newItem.remove();
                                
                            model = Selectables.getByCid(cid).toJSON();
                            
                            Selected.add(model);
                            
                        }
                    });
                    /*
                    this.$el.parent()
                    .droppable({
                        accept : '#selectables .attachment',
                        drop : function (event, ui) {
                            var 
                                cid = $(ui.draggable).data('cid'),
                                model;
                                
                            model = Selectables.getByCid(cid).toJSON();
                            
                            Selected.add(model);
                        }
                    });*/
                },
                
                toggleAllSelected : function () {
                
                },
                
                render: function() {
                
                },
                
                addOne: function(selected) {
                    var view = new PhotoView({model:selected});

                    this.$el.append(view.render().el);
                },
                
                addAll: function() {
                    // Selected.each(this.addOne, this);
                }
            });
        
        
        return {
            init : init,
            selectables : Selectables
        };
    })();
    
    
    $(Gallery.init);
    
    px.gallery = Gallery;
})(jQuery, px);