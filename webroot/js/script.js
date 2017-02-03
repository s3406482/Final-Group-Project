/*
 * DOM loaded
 */
$(document).ready(function() {
    // max pixel width for mobile devices. based on media queries for mobiles & tablets for our framework
    // http://foundation.zurb.com/sites/docs/v/5.5.3/media-queries.html
    var maxMobileWidth = 1024;
    
    // hide navigation elements if screen width the same or less than maxMobileWidth
    if ($(window).width() <= maxMobileWidth)
        minimizeNavigationMenus();
    
    // attach event handler to navigation menus
    $('ul.side-nav li.heading').click(accordionChangeState);
});

/*
 * page render complete (images etc)
 */
$(window).on('load', function() {
    // if Flash message is visible set a timer to hide it after 5 seconds
    if ($('div.message').is(':visible')) {
        setTimeout(function() {
            $('div.message').click();
        }, 5000);
    }
});


/* 
 * change accordion state of each navigation ul clicked
 */
function accordionChangeState() {
    var menuHidden;
    
    // check if menu is already hidden. if "angle" is up then it is visible/maximized
    if ($(this).children('i').hasClass('fa-angle-up'))
        menuHidden = false;
    else
        menuHidden = true;

    // currently $(this) is the 'li.heading' that is clicked. need to process this and all other 'li' elements inside
    // the current 'ul'
    $(this).parent().children().each(function() {
        // if has class of heading then change angle up/down else hide or show the 'li' element
        if ($(this).hasClass('heading')) {
            if (!menuHidden)
                $(this).children('i').removeClass('fa-angle-up').addClass('fa-angle-down');
            else 
                $(this).children('i').removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            if (menuHidden)
                $(this).show();
            else
                $(this).hide();
        }
    });
}


/*
 * minimize navigation menu's as detected resolution is a mobile or tablet screen width
 */
function minimizeNavigationMenus() {
    // get each child 'li' element of the 'li.side-nanv' and either hide it or change to down angle
    $('ul.side-nav').children('li').each(function() {
        if ($(this).hasClass('heading'))
            $(this).children('i').removeClass('fa-angle-up').addClass('fa-angle-down');
        else
            $(this).hide();
    });
}