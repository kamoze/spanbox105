    jQuery(document).ready(function ($) {
        $('.tabset0').pwstabs();
        $('.tabset1').pwstabs({
            effect: 'scale',
            defaultTab: 3,
            containerWidth: '600px'
        });
        $('.tabset2').pwstabs({
            effect: 'slideleft',
            defaultTab: 2,
            containerWidth: '600px'
        });
        $('.tabset3').pwstabs({
            effect: 'slidetop',
            defaultTab: 3,
            containerWidth: '600px'
        });
        $('.tabset4').pwstabs({
            effect: 'slidedown',
            defaultTab: 2,
            containerWidth: '600px'
        });
        $('.tabset5').pwstabs({
            effect: 'slideright',
            defaultTab: 1,
            containerWidth: '600px'
        });
        $('.tabset6').pwstabs({
            effect: 'slidedown',
            defaultTab: 2,
            containerWidth: '600px',
            rtl: true
        });
        $('.tabset7').pwstabs({
            effect: 'slidedown',
            defaultTab: 2,
            containerWidth: '600px',
            horizontalPosition: 'bottom'
        });
        $('.tabset8').pwstabs({
            effect: 'slideleft',
            defaultTab: 1,
            containerWidth: '600px',
            tabsPosition: 'vertical',
            verticalPosition: 'left'
        });
        $('.tabset9').pwstabs({
            effect: 'slideright',
            defaultTab: 1,
            containerWidth: '600px',
            tabsPosition: 'vertical',
            verticalPosition: 'right'
        });
        $('.tabset10').pwstabs({
            effect: 'none',
            containerWidth: '600px'
        });
        $('.tabset11').pwstabs({
            effect: 'scale',
            containerWidth: '600px'
        });

        // Colors Demo
        $('.pws_demo_colors a').click(function (e) {
            e.preventDefault();
            $('.pws_tabs_container').removeClass('pws_theme_cyan pws_theme_grey pws_theme_violet pws_theme_green pws_theme_yellow pws_theme_gold pws_theme_orange pws_theme_red pws_theme_purple pws_theme_dark_cyan pws_theme_dark_grey pws_theme_dark_violet pws_theme_dark_green pws_theme_dark_yellow pws_theme_dark_gold pws_theme_dark_orange pws_theme_dark_red pws_theme_dark_purple').addClass('pws_theme_'+$(this).attr('data-demo-color') );
        });

    });