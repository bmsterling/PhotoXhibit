(function ($) {
    
    var Settings = (function () {
        
        var
            init = function () {
                setupTabs();
            },
            
            setupTabs = function () {
                $( "#settings" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                $( "#settings li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
            };
        
        
        return {
            init : init
        }
    })();
    
    
    $(Settings.init);
    
    px.settings = Settings;
})(jQuery, px);