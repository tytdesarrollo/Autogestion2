jQuery(document).ready(function($){
	var is_menu_modal_animating = false;
	//open menu navigation
	$('.menu-modal-trigger').on('click', function(){
		triggerMenuModalNav(true);
	});
	//close menu navigation
	$('.content-menu-modal .close-menu-modal').on('click', function(){
		triggerMenuModalNav(false);
	});
	$('.content-menu-modal').on('click', function(event){
		if($(event.target).is('.content-menu-modal')) {
			triggerMenuModalNav(false);
		}
	});

	function triggerMenuModalNav($bool) {
		//check if no nav animation is ongoing
		if( !is_menu_modal_animating) {
			is_menu_modal_animating = true;
			
			//toggle list items animation
			$('.content-menu-modal').toggleClass('in', $bool).toggleClass('out', !$bool).find('li:last-child').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
				$('.content-menu-modal').toggleClass('is-visible', $bool);
				if(!$bool) $('.content-menu-modal').removeClass('out');
				is_menu_modal_animating = false;
			});
			
			//check if CSS animations are supported... 
			if($('.menu-modal-trigger').parents('.no-csstransitions').length > 0 ) {
				$('.content-menu-modal').toggleClass('is-visible', $bool);
				is_menu_modal_animating = false;
			}
		}
	}
});