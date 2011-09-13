
var jaboxes = [];
var jaboxoverlay = null;
showBox = function (box,focusobj, caller, e) {
	//Add overlay
	if (!jaboxoverlay) {
		jaboxoverlay = new Element ('div', {id:"jabox-overlay"}).injectBefore ($(box));
		jaboxoverlay.setStyle ('opacity', 0.01);
		jaboxoverlay.addEvent ('click', function (e) {
			jaboxes.each(function(box){
				if (box.status=='show') {
					box.status = 'hide';
					var fx = new Fx.Style (box,'opacity');
					fx.stop();
					fx.start (box.getStyle('opacity'), 0);
					if (box._caller) box._caller.removeClass ('show');
				}
			},this);
			jaboxoverlay.setStyle ('display', 'none');
		});
	}
	
	caller.blur();
	//new Event(e).stop ();
	box=$(box);
	if (!box) return;
	if ($(caller)) box._caller = $(caller);
	if (!jaboxes.contains (box)) {
		jaboxes.include (box);
		//box.addEvent ('click', function (e) {/*new Event(e).stop ();*/});
	}
	
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
		jaboxoverlay.setStyle ('display', 'none');
	} else {
		jaboxes.each(function(box1){
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
		jaboxoverlay.setStyle ('display', 'block');
	}
}
