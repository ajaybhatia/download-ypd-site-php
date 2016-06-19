$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

$("#menu-toggle-2").click(function(e) {
	e.preventDefault();
    $("#wrapper").toggleClass("toggled-2");
    $('#menu ul').hide();
});

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

		// show only selected table
		$('table').not(deviceID).css('display', 'none');
		$('table').not(deviceID).next().css('display', 'none');
		$(deviceID).css('display', 'table');
		$(deviceID).next().css('display', 'block');
		$('[class$=flashing]').css('display', 'none');
	});
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
});