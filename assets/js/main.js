$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$("#menu-toggle-2").click(function(e) {
	e.preventDefault();
    $("#wrapper").toggleClass("toggled-2");
    $('#menu ul').hide();
});

var _deviceID = '#yutopia';

function initMenu() {
	$('#menu ul').hide();
	$('#menu ul').children('.current').parent().show();
	//$('#menu ul:first').show();
	$('#menu li a').click(function() {
		var checkElement = $(this).next();
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			//return false;
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('#menu ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
			//return false;
		}

		// Toggle active class
		$('#menu li a').not(this).parent().removeClass('active');
		$(this).parent().addClass('active');

		// Replace whitespace with '-'
		var deviceName = $.trim($(this).text().toLowerCase());
		deviceName = deviceName.replace(/ /g, '-');
		
		// Make device id
		var deviceID = '#' + deviceName;
		_deviceID = deviceID;

		toggleDeviceTable(deviceID);
		
		makeFirstLiActive();
	});

	makeFirstLiActive();
}

$(document).ready(function() {
	initMenu();

	$('.item-instruct').click(function() {
		var deviceName = $.trim($(this).parent().parent().children('a').first().text()).toLowerCase();
		var deviceClass = "." + deviceName + "-flashing";
		$(deviceClass).css('display', 'block');
	});

	$('.js-build-path').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('data-val');
		var href = $(this).attr('data-href');
		var object = $(this);

		$.ajax({
			type: 'GET',
			url: 'helpers/update_downloads.php',
			data: 'id=' + id,
			dataType: 'text',
			success: function(data) {
				window.location.href = href;
				object.parent().parent().children('td').eq(5).html(data);
			}
		});
	});

	$('.js-yuos-build-path').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('data-val');
		var href = $(this).attr('data-href');
		var object = $(this);

		bootbox.dialog({
	  		message: "You shall, by downloading any YUOS firmware and or software, "
	  			+ "be deemed to have agreed to and accepted the following terms and conditions:<br><br>"
	  			+ "YUOS firmware and software downloads shall apply to specific YU models and "
	  			+ "are for use within specific territories only. The responsibility to ensure "
	  			+ "the compatibility of your YUOS to download any specific YUOS firmware and or"
	  			+ "software shall be solely vested in you; "
				+ "downloading an incorrect / inappropriate firmware and or software "
				+ "may cause malfunction to your YU product and you agree to discharge us "
				+ "against any liability for the same.<br><br>"
				+ "<b>*NOTE:Yunique & yuphoria</b><br>"
 				+ "YUOS firmware will only support Data Network in VoLTE Simcards "
 				+ "& doesnot support IMS Voice calls with out Jio Join app in VoLTE Simcards "
 				+ "Like Relience Jio.<br>"
 				+ "Please stay updated here for further releases.<br><br>"
 				+ "<b>*For YUreka/Yureka + YUOS firmware will not contain VoLTE support.<br><br>"
 				+ "This Firmare will Force Encrypt Userdata, Flashing This on your device "
 				+ "may wipe/format your internal storage.",
			title: "Terms & Conditions",
			buttons: {
				success: {
					label: "I Agree",
					className: "btn-success",
					callback: function() {
						$.ajax({
							type: 'GET',
							url: 'helpers/update_downloads.php',
							data: 'id=' + id,
							dataType: 'text',
							success: function(data) {
								window.location.href = href;
								object.parent().parent().children('td').eq(5).html(data);
							}
						});
					}
				},
				danger: {
					label: "I don't Agree",
					className: "btn-danger",
					callback: function() {
					}
				}
			}
		});
	});

	// Table Pagination
	$('table.paginated').each(function() {
	    var currentPage = 0;
	    var numPerPage = 10;
	    var $table = $(this);
	    $table.bind('repaginate', function() {
	        $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
	    });
	    $table.trigger('repaginate');
	    var numRows = $table.find('tbody tr').length;
	    var numPages = Math.ceil(numRows / numPerPage);
	    var $pager = $('<div class="pager"></div>');
	    for (var page = 0; page < numPages; page++) {
	        $('<span class="page-number"></span>').text(page + 1).bind('click', {
	            newPage: page
	        }, function(event) {
	            currentPage = event.data['newPage'];
	            $table.trigger('repaginate');
	            $(this).addClass('active').siblings().removeClass('active');
	        }).appendTo($pager).addClass('clickable');
	    }
	    $pager.insertAfter($table).find('span.page-number:first').addClass('active');
	});

	$('#yu-open-os').click(function () {
		$(this).removeClass('active');
		$('#yu-os').addClass('active');
		
		if (_deviceID.includes('-'))
			_deviceID = _deviceID.split('-')[0];

		toggleDeviceTable(_deviceID);
	});

	$('#yu-os').click(function () {
		$(this).removeClass('active');
		$('#yu-open-os').addClass('active');
		
		_deviceID += '-yuos';
		
		toggleDeviceTable(_deviceID);
	});
});

function toggleDeviceTable(id) {
	/* code section for showing only selected table and it's pager */
	// hide all table except selected device one
	$('table').not(id).css('display', 'none');
	// hide all pager except current table's
	$('table').not(id).next().css('display', 'none');
	// show current table only
	$(id).css('display', 'table');
	// show current table's pager only
	$(id).next().css('display', 'block');
	// show current table's (device's) flashing instructions
	$('[class$=flashing]').css('display', 'none');
}

function makeFirstLiActive() {
	$('.nav-tabs li:nth-child(1)').addClass('active');
}