jQuery(document).ready(function(){
    var show = localStorage.getItem('show');
    if(show === 'true'){
        jQuery('#upper-menu-cockie').hide();
    }else{
      jQuery('#upper-menu-cockie').show();
    }

    jQuery("#added-btn").click(function(event){
        event.preventDefault();
        jQuery('#upper-menu-cockie').hide();
        localStorage.setItem('show', 'true');
    });
});
