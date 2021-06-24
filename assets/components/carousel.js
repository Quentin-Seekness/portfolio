const carousel = {
    init: function() {

        console.log('carousel.js is charged');
    },
}

// https://codepen.io/jibbon/pen/BoisC/
$.global = new Object();

$.global.item = 1;
$.global.total = 0;

$(document).ready(function() 
{
    var SlideCount = $('#slides li').length;
	
   $.global.item = 0;
    $.global.total = SlideCount; 

        for(var i=2; i<=SlideCount; i++) {

                $("#slides li:nth-child("+i+")").addClass('dead');
        }
        
            
        $('#left').click(function() { Slide('back'); }); 
        $('#right').click(function() { Slide('forward'); }); 
                
});

function Slide(direction)
{   
    if (direction == 'back') { var $target = $.global.item - 1; }
    if (direction == 'forward') { var $target = $.global.item + 1; }  
    
    if ($target == -1) { DoIt($.global.total-1); } 
    else if ($target == $.global.total) { DoIt(0); }  
    else { DoIt($target); }
    
}

function DoIt(target)
{
    var $actualtarget = target+1;
    
    $("#slides li:nth-child("+$actualtarget+")").removeClass('dead');
    $("#slides li:nth-child("+target+")").addClass('dead');

    if (target == 0) { $("#slides li:nth-child("+$.global.total+")").addClass('dead'); }
    if (target == $.global.total-1) { $("#slides li:nth-child(1)").addClass('dead'); }
    
    $.global.item = target;  
    $('#count').html($.global.item+1);
}

  document.addEventListener('DOMContentLoaded', carousel.init());