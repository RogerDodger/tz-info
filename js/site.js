$(function() {
	$(".timezone").each(function() {
		$(this).autocomplete({source: "lib/timezones.php"});
	});
	
	$(".time").each(function() {
		var name = $(this).attr('name');
		$(this).autocomplete({source: "lib/timestrings.php?list="+name+"&"});
	});
	
	$('a').filter(function(i) {
		return !(
			/^.*#/.test( $(this).attr('href') ) || $(this).attr('title')
		);
	}).attr({
		title: 'Open link in new tab',
		target: '_blank',
	});
});