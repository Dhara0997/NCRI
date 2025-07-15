jQuery(document).ready(function($){
    
    // Header - Dark on Scroll
	jQuery(window).scroll(function() {    
	    var scroll = jQuery(window).scrollTop();
	
	    if (scroll >= 1) {
	        jQuery("#header").addClass("scroll");
	    } else {
	        jQuery("#header").removeClass("scroll");
	    }
	});
	
	// SMOOTH SCROLL
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	jQuery(function() {
		
		var adminBar = 0;
		if(jQuery('#wpadminbar').length) {
			adminBar = jQuery('#wpadminbar').outerHeight();
		}
		
		var scrollOffset = adminBar + 40;
		jQuery('a[href*="#"]').smoothscroll({
			duration: 800,
			easing: 'swing',
			//offset: -130,
			offset: -scrollOffset, // headerHeight value used from sticky header
			hash: true,
			focus: false,
		});
	});
	
	// MOBILE NAVIGATION PANEL
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	// Toggle Panel
	$('#nav-toggle').click(function() {
		$(this).toggleClass('active');
		$('#nav-panel').toggleClass('active');
	});
	
	// Accordion function for nav menu
	$('#nav-panel .menu').find('.menu-item-has-children > a').click(function() {
		
		if($(this).parent('.menu-item-has-children').hasClass('active')){
			$('.menu-item-has-children').removeClass('active');
			$(this).parent('.menu-item-has-children').removeClass('active');
			$(this).parent('.menu-item-has-children').find('.sub-menu').slideToggle(300);
			//$(this).parent('.menu-item-has-children').find('.sub-menu').stop(true, true).slideToggle(300);
			return false;
		}
		else {
			$('.menu-item-has-children').removeClass('active');
			$(this).parent('.menu-item-has-children').addClass('active');
			$('.menu-item-has-children').not(this).find('.sub-menu').slideUp();
			$(this).parent('.menu-item-has-children').find('.sub-menu').slideToggle(300);
			return false;
		}
		
	});
	
	// Close Panel on overlay click
	$('#nav-panel .nav-panel__overlay').click(function() {
		if($('#nav-panel').hasClass('active')){
			$('#nav-panel').removeClass('active');
			$('#nav-toggle').removeClass('active');
		}
	});
	

});

// if (jQuery('body').hasClass('home')) {
// 	
// 	drawLines();
// 
// 	jQuery(window).resize(function(){
// 		drawLines();
// 	});
// 	
// 	function drawLines(){
// 		
// 		var Aoffset = jQuery(".circle--1").offset();
// 		var Awidth = jQuery(".circle--1").outerWidth();
// 		var Aheight = jQuery(".circle--1").outerHeight();
// 		
// 		var AcenterX = Aoffset.left + Awidth / 2;
// 		var AcenterY = Aoffset.top + Aheight / 2;
// 		
// 		var Boffset = jQuery(".circle--2").offset();
// 		var Bwidth = jQuery(".circle--2").outerWidth();
// 		var Bheight = jQuery(".circle--2").outerHeight();
// 		
// 		var BcenterX = Boffset.left + Bwidth / 2;
// 		var BcenterY = Boffset.top + Bheight / 2;
// 		
// 		var Coffset = jQuery(".circle--3").offset();
// 		var Cwidth = jQuery(".circle--3").outerWidth();
// 		var Cheight = jQuery(".circle--3").outerHeight();
// 		
// 		var CcenterX = Coffset.left + Cwidth / 2;
// 		var CcenterY = Coffset.top + Cheight / 2;
// 		
// 		var Doffset = jQuery(".circle--4").offset();
// 		var Dwidth = jQuery(".circle--4").outerWidth();
// 		var Dheight = jQuery(".circle--4").outerHeight();
// 		
// 		var DcenterX = Doffset.left + Dwidth / 2;
// 		var DcenterY = Doffset.top + Dheight / 2;
// 		
// 		var Eoffset = jQuery(".circle--5").offset();
// 		var Ewidth = jQuery(".circle--5").outerWidth();
// 		var Eheight = jQuery(".circle--5").outerHeight();
// 		
// 		var EcenterX = Eoffset.left + Ewidth / 2;
// 		var EcenterY = Eoffset.top + Eheight / 2;
// 		
// 		var Foffset = jQuery(".circle--6").offset();
// 		var Fwidth = jQuery(".circle--6").outerWidth();
// 		var Fheight = jQuery(".circle--6").outerHeight();
// 		
// 		var FcenterX = Foffset.left + Fwidth / 2;
// 		var FcenterY = Foffset.top + Fheight / 2;
// 		
// 		var Goffset = jQuery(".circle--7").offset();
// 		var Gwidth = jQuery(".circle--7").outerWidth();
// 		var Gheight = jQuery(".circle--7").outerHeight();
// 		
// 		var GcenterX = Goffset.left + Gwidth / 2;
// 		var GcenterY = Goffset.top + Gheight / 2;
// 		
// 		var Hoffset = jQuery(".home-tech__area-image.three").offset();
// 		var Hwidth = jQuery(".home-tech__area-image.three").outerWidth();
// 		var Hheight = jQuery(".home-tech__area-image.three").outerHeight();
// 		
// 		var HcenterX = Hoffset.left + Hwidth / 2;
// 		var HcenterY = Hoffset.top + Hheight / 2;
// 		
// 		jQuery(".line").remove();
// 		
// 		jQuery('#content').line(AcenterX, AcenterY, BcenterX, BcenterY, {color:"#c3c4c7", stroke: '0', zindex:0, class:'line'});
// 		jQuery('#content').line(BcenterX, BcenterY, CcenterX, CcenterY, {color:"#c3c4c7", stroke: '0', zindex:0, class:'line'});
// 		jQuery('#content').line(CcenterX, CcenterY, DcenterX, DcenterY, {color:"#c3c4c7", stroke: '0', zindex:0, class:'line'});
// 		jQuery('#content').line(DcenterX, DcenterY, EcenterX, EcenterY, {color:"#c3c4c7", stroke: '0', zindex:0, class:'line'});
// 		jQuery('#content').line(EcenterX, EcenterY, FcenterX, FcenterY, {color:"#c3c4c7", stroke: '0', zindex:0, class:'line'});
// 		jQuery('#content').line(FcenterX, FcenterY, GcenterX, GcenterY, {color:"#c3c4c7", stroke: '0', zindex:0, class:'line'});
// 		jQuery('#content').line(GcenterX, GcenterY, HcenterX, HcenterY, {color:"#c3c4c7", stroke: '0', zindex:0, class:'line'});
// 		
// 		//jQuery('.line').attr('data-scroll','');	
// 	
// 	}
// 
// }
