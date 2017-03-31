$(function() {
	var nTime = 0;
	var pInterval = setInterval(function() { 
		nTime += 100;
		console.log('in');
	}, 100);

	runRequest();

	function runRequest() {
		$.post( strUrl, function() {
		  	alert(nTime);

		  	clearRequestInterval();
		});
	}

	function clearRequestInterval() {
		clearInterval(pInterval);
	}
});