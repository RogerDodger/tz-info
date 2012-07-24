jQuery(document).ready(function() {
	/* Shameless ripping of Tinyboard's local-time.js */
	var zeropad = function(num, count) {
		return [Math.pow(10, count - num.toString().length), num].join('').substr(1);
	};
	
	var makeLocalTime = function() {
		var t = new Date($(this).attr('datetime'));
		
		$(this).text(
			// day
			["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"][t.getDay()] + ", " +
			// date
			zeropad(t.getDate(), 2) + " " + 
			["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", 
				"Oct", "Nov", "Dec"][t.getMonth()] + " " + 
			t.getFullYear() + " " +
			// time
			zeropad(t.getHours(), 2) + ":" + 
			zeropad(t.getMinutes(), 2) + ":" + 
			zeropad(t.getSeconds(), 2)
		);
	};

	$('time').each(makeLocalTime);
});