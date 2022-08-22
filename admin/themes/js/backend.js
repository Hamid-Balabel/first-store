$(function (){

    'use strict';
    
    // hide placeholder in form focuse
    

    $('[placeholder]').focus(function(){

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder','');

    }).blur(function(){

        $(this).attr('placeholder', $(this).attr('data-text'));
        
    });

    $('input').each(function(){
        if ($(this).attr('Required') === 'required'){
            $(this).after('<span class="astrisk">*</span>');
        }
    }); 

    // show password
    var passField= $('.password');

    $('.show-pass').hover(function(){
        passField.attr('type','text');
    }, function(){
        passField.attr('type','password');
    });

    // confirm message for deleting

    $('.confirm').click(function(){
        return confirm('you are sure for deleting?');
    });


}); 