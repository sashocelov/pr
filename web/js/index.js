var pStartRecognition = function(nTimeForSendParam, strRecognitionUrl) {
	var interval;
	var nTimeForSend = nTimeForSendParam;
	var recognition = new webkitSpeechRecognition();
	var final_transcript = '';
	var interim_transcript = '';
	var nCode = nTest = "";
	var pInfoBox = $('.voice-recognition-live');
	
	var timer = function() {
	              interval = setInterval(function() {
	                if (nCode == nTest) {
		                nCode = '';
		                var strResult = '';

		                if (final_transcript == '') {
		                	strResult = interim_transcript;
		                } else {
		                	strResult = final_transcript;
		                }

		               	recognition.stop();
		                clearInterval(interval);

		                if (!(strResult.toLowerCase().indexOf("вади") >= 0)) {
		                	return false;
		                }

	                  	var strRecognition = '';
		                var pTpl = pInfoBox.find('.template li').clone();
		                var dt = new Date();
						var time = ("0" + dt.getHours()).slice(-2) + ":" + ("0" + dt.getMinutes()).slice(-2) + ":" + ("0" + dt.getSeconds()).slice(-2);

		                pTpl.find('span').html(strResult + ' - ' + time);
		                $(pTpl).prependTo($('.voice-recognition-live .list'));

	                  	
					    if (final_transcript != '') {
					    	strRecognition = final_transcript;
					    } else {
					    	strRecognition = interim_transcript;
					    }

						$.post(strRecognitionUrl, {strRecognition : strRecognition});
	                  	final_transcript = '';
	                  	interim_transcript = '';
	                }
	              },nTimeForSend);
	            };
	recognition.continuous = true;
	recognition.interimResults = true;
	recognition.lang = "bg";
	recognition.start();

	recognition.onstart = function (event) {
		nCode = nTest = generateCode();
	}

	recognition.onresult = function (event) {
	if (nCode == nTest) {
	  final_transcript = '';
	  interim_transcript = '';
	  clearInterval(interval);
	  timer();
	  for (var i = event.resultIndex; i < event.results.length; ++i) {
	    if (event.results[i].isFinal) {
	      final_transcript += event.results[i][0].transcript;
	    } else {
	      interim_transcript += event.results[i][0].transcript;
	    }
	  }
	  if (final_transcript || interim_transcript) {
	  	var strRecognition = '';
	    console.log('Interim - '+interim_transcript);
	    console.log('Final - '+final_transcript);
	  }
	}
	};

	recognition.onerror = function(event) {
		if (event.error == 'no-speech') {
		  showInfo('info_no_speech');
		} else if (event.error == 'audio-capture') {
		  showInfo('info_no_microphone');
		} else {
		  showInfo('error');
		}
	};

	recognition.onend = function() {
		recognition.start();
	};


	function showInfo(strStr) {
		console.log(strStr);
	}

	function generateCode() {
		return Math.floor(Math.random() * 10000000000000001);
	}
}

var pDashboard = function(){
	var pTimer;
	var pTimer2Min;
	var strCode = '';
	var bUpdateWeather = true;
	var pHourField = $('.row-weather .weather-box .common-info .curr-hour');

	function controlWeather() {
        bindWeatherEvents();

        setHour();
        setInterval(function(){
            setHour();
        }, 60000);

        function setHour() {
            var dt = new Date();

            var strMinutes  = dt.getMinutes().toString();
            var strHours    = dt.getHours().toString();
            if (strMinutes.length == 1) {
                strMinutes = '0'+strMinutes;
            }
            if (strHours.length == 1) {
                strHours = '0'+strHours;
            }
            var time = strHours + ":" + strMinutes;
            pHourField.html(time);
        }
	}

	function loadItems() {
		if ($('.row-weather').length > 0 || $('.row-temp').length > 0) {
			$.post("site/getdashboard", {}, function(data) {
				loadGroups(data['SbedGroups']);
				loadWeather(data['CurrentWeather']);
				loadTemp(data['Temp']);
			}, 'json');
			$('.hidden').removeClass('hidden').hide();
		}
	}

	function _bindValues() {
		$('.avaliable-actions').unbind('click');
		$('.avaliable-actions').bind('click', function(){
			var strStatus = $(this).is(':checked');
			if (strStatus == true) {
				strStatus = 'on';
			} else {
				strStatus = 'off';
			}
			var nGroupId = $(this).data('group');
			$.post("site/setgroupstate", {nSbedGroupId : nGroupId, strStatus : strStatus}, function(data) {
				loadItems();
			});
		});
		$('.show-info').unbind('click');
		$('.show-info').bind('click', function() {
			$(this).parent().parent().find('.toggle-element').toggle();
		});
	}

	function loadGroups(data) {
		if (strCode != data['code']) {
			strCode = data['code'];
		  	$('.row-groups').html(data['data']);
		  	_bindValues();
		}
	}

	function loadWeather(data) {
		if (bUpdateWeather) {
			bUpdateWeather = false;
		  	$('.row-weather').html(data['data']);
		  	controlWeather();
		}
	}

	function loadTemp(data) {
	  	$('.row-temp').html(data);
	  	_bindValues();
	}

	pTimer2Min = setInterval(function() {
		bUpdateWeather = true;
	}, 120000);

	loadItems();
	
	pTimer = setInterval(function(){
		loadItems();
		// clearInterval(pTimer);
	}, 2000);
}

function bindWeatherEvents() {
	var pSlideToggleElement = $('.row-weather .slide-toggle-element');
	var pRightToggleElement = $('.row-weather .right-toggle-element');
	var pToggleElement = $('.row-weather .toggle-element');
	var pWeatherDay = $('.row-weather .weather-day-box');

    $('.row-weather .weather-box .more-info .toggle-element').bind('click', function(){
        pSlideToggleElement.slideToggle(function(){
            pToggleElement.toggle();
        });
    });

    $('.weather-box .weather-days .right-toggle-element').bind('click', function(){
        pWeatherDay.slideToggle(function(){
            pRightToggleElement.toggle();
        });
    });
}

var pGetIrCode = function(){
	var pTimer;
	function getIrCode() {
		$.post("getircode", {}, function(data) {
			if (data != '') {
				var strPrefix = $('#irdevicescommands-code').data('prefix');
				$('#irdevicescommands-code').val(strPrefix+data);
				clearInterval(pTimer);
			}
		});
	}
	$('#irdevicescommands-code').bind('click', function(e) {
		e.preventDefault();
		pTimer = setInterval(function(){
			getIrCode();
		}, 1000);
	});
}

var pExecuteIrCode = function() {
	$('.execute-ir-test').bind('click', function(e) {
		e.preventDefault();
		var strCode = $(this).data('code');

		$.post("executecode", {strCode : strCode}, function(data) {
			if (data != '') {
				
			}
		});
	});
}

if ($('.execute-ir-test').length > 0) {
	new pExecuteIrCode();
}

var calendarEvents = function(){
	$('.calendar-buttons').unbind('click');
	$('.calendar-buttons').bind('click', function(e) {
		e.preventDefault();
		$('.events-index').removeClass('show_events');
		$.post(strUrl+"/events/getcalendar", {
				date  	: $(this).parent().data('date'),
				action 	: $(this).data('action')
			}, function(data) {
			if (data != '') {
				$('.calendar').html(data);
				$('.hidden').removeClass('hidden').hide();
				new calendarEvents();
			}
		});		
	});

	$('.calendar td').unbind('click');
	$('.calendar td').bind('click', function(e) {
		e.preventDefault();
		$('.events_container').hide();
		$('.events-index').removeClass('show_events');
		var strDay = $(this).data('day');
		$('.events_container .event_box').each(function(){
			$(this).hide();
			if ($(this).data('from') <= strDay && $(this).data('to') >= strDay) {
				$(this).show();
				$('.events-index').addClass('show_events');
			}
		});
		$('.events_container').fadeIn();
	});
}

if ($('.calendar .fontawesome-angle-left').length > 0) {
	new calendarEvents();
}

var eventForm = function() {
	$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
	$('#audio-range').change(function(){
		$('#events-audio_volume').val(parseInt($(this).val()*100));
	});
}

var eventExecution = function() {
	var pIntervalVolumeUp;
	
	$('.run_event_action').bind('click', function(e) {
		e.preventDefault();

		var fMaxVolume = $(this).data('max-vol');
		var strClass = '.type-'+($(this).data('type'));
		var fVolume = fMaxVolume;

	  	if ($(strClass)[0].paused == false) {
	      	$(strClass)[0].pause();
	  	} else {
			if ($(this).data('slide-volume') == '1') {
				fVolume = 0.01;
		        pIntervalVolumeUp = setInterval(function(){
			        if (fVolume >= fMaxVolume) {
			        	clearInterval(pIntervalVolumeUp);
		        	}
		            $(strClass).prop("volume", fVolume);
		            fVolume += 0.05;

		        }, 1000);
		    }
	  		if (fVolume <= 1) {
				$(strClass).prop("volume", fVolume);
			}
			$(strClass)[0].play();
	  	}
	});
}

var dateFilter = function() {
	var pParent = $('.date-filter');
	var aDates = [];
	pParent.find('input.datepicker').change(function(e) {
		e.preventDefault();
		aDates = [];
		checkFields();
	});
	function checkFields() {
		var bEmpty = false;
		var nIndex = 0;
		pParent.find('input.datepicker').each(function() {
			if ($(this).val() == '') {
				bEmpty = true;
			}
			aDates[nIndex++] = $(this).val();
		});
		if (!bEmpty) {
			var strUrl = pParent.find('.date-filter-url').attr('href');
			window.location.href = (strUrl+'&from_date='+aDates[0]+'&to_date='+aDates[1]);

		}
	}
}

$(function() {
	if ($('.events-form').length > 0) {
		new eventForm();
	}

	if ($('.run_event_action').length > 0) {
		new eventExecution();
	}

	if ($('.action-preview').length > 0) {
		new actionEvents();
	}

	$(".datepicker").datepicker({
		dateFormat: 'dd-mm-yy',
		firstDay: 1
	});

	if ($('.date-filter').length > 0) {
		new dateFilter();
	}
});

var actionEvents = function() {
   	$('.action-preview').bind('click', function(e) {
   		e.preventDefault();
   		var strAction 	= $(this).data('action');
   		var nId 		= $(this).data('id');
   		var strStatus	= $(this).data('status');
   		getActionContent(nId, strAction, strStatus);
   	});

   	function getActionContent(nId, strAction, strStatus) {
		$.post(strUrl+"/"+strAction, {
			_csrf 		: yii.getCsrfToken(),
			nId 		: nId,
			strStatus	:strStatus
		}, function(data) {
			if (data['status'] == 'success') {
				showMessage(data['content']);
			}
		}, 'json');	
	}
}

var eventExecutionLive = function() {
    var pEventTimer;
    pEventTimer = setInterval(executeEvent, 30000);

    function executeEvent() {
		$.post(strUrl+"/events/getcurrentevents", {
			_csrf: yii.getCsrfToken()
		}, function(data) {
			$('.event_execution_container').html(data['htmlBody']);
			if ($('.run_event_action').length > 0) {
				new eventExecution();
				$('.run_event_action').click();
			}

			if (data['dialogContent'] != '' && data['dialogContent'] != undefined) {
				clearInterval(pEventTimer);

				// $('#info-message .message-submit').html(data['dialogContent']);
			 // 	$("#message-mask").show();

			 // 	$("#info-message").css({
			 // 		'top' 	: ($(window).height()/2-$("#info-message").outerHeight()/2),
			 // 		'left'	: ($(window).width()/2-$("#info-message").outerWidth()/2),
			 // 	}).show(function(){
			 // 		$('.submit_event').bind('click', function(e) {
			 // 			e.preventDefault();
			 // 			$.post(strUrl+"/events/submitevent", {id:$(this).data('event')}, function(data) {
			 // 				location.reload();
			 // 			});
			 // 		});
			 // 	});

			 	showMessage(data['dialogContent'], function() {
			 		$('.submit_event').bind('click', function(e) {
			 			e.preventDefault();
			 			$.post(strUrl+"/events/submitevent", {id:$(this).data('event')}, function(data) {
			 				location.reload();
			 			});
			 		});
			 	});
			}

		}, 'json');	
    	// clearInterval(pEventTimer);
    }

    executeEvent();
}

$('.hidden').removeClass('hidden').hide();


function showMessage(htmlContent, callback) {
	$('#info-message .message-submit').html(htmlContent);
 	$("#message-mask").show();

 	$("#info-message").css({
 		'top' 		: ($(window).height()/2-$("#info-message").outerHeight()/2 + $(document).scrollTop()),
 		'left'		: ($(window).width()/2-$("#info-message").outerWidth()/2),
 	}).show(function() {
 		if (callback !== undefined)
 			callback();
 	});

 	$('#info-message .close-block').bind('click', hideDialog);

 	function hideDialog() {
		$("#info-message").fadeOut(function(){
			$("#message-mask").hide();
		});	 	
 	}
}