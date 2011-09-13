/*
# ------------------------------------------------------------------------
# JA T3v2 Plugin - Template framework for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - GNU/GPL V2, http://www.gnu.org/licenses/gpl2.html. For details 
# on licensing, Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
# Extra js for popup button on top menu
*/

var boxes = [];
showBox = function (box,focusobj, caller) {
	box=$(box);
	if (!box) return;
	if ($(caller)) box._caller = $(caller);
	boxes.include (box);
	if (box.getStyle('display') == 'none') {
		box.setStyles({
			display: 'block',
			opacity: 0
		});
	}
	if (box.status == 'show') {
		//hide
		box.status = 'hide';
		var fx = new Fx.Style (box,'opacity');
		fx.stop();
		fx.start (box.getStyle('opacity'), 0);
		if (box._caller) box._caller.removeClass ('show');
	} else {
		boxes.each(function(box1){
			if (box1!=box && box1.status=='show') {
				box1.status = 'hide';
				var fx = new Fx.Style (box1,'opacity');
				fx.stop();
				fx.start (box1.getStyle('opacity'), 0);
				if (box1._caller) box1._caller.removeClass ('show');
			}
		},this);
		box.status = 'show';
		var fx = new Fx.Style (box,'opacity',{onComplete:function(){if($(focusobj))$(focusobj).focus();}});
		fx.stop();
		fx.start (box.getStyle('opacity'), 1);
		
		if (box._caller) box._caller.addClass ('show');
	}
}