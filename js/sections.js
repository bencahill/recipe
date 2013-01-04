// Re-calculates section id's for sections and ingredients
function sectionCalc() {
	sectionId = 0;
	positionId = 1;
	$ingredients = $('#mmf_sortable .mmf_row:not(.section)');
	$("#mmf_sortable .mmf_row").each(function() {
		$this = $(this);
		if( $this.hasClass("section") ) {
			sectionId++;
		} else {
			if( ($ingredients.index($this)+1) != $ingredients.length ) {
				$this.find("[id^=Ingredient]").filter("[id*=section]").val(sectionId);
				$this.find("[id^=Ingredient]").filter("[id*=position]").val(positionId);
				positionId++;
			}
		}
	});
	$("#mmf_sortable .mmf_row:not(.section)").last().find("[id^=Ingredient]").filter("[id*=section]").val('');
}

function addRemoveLink( target ) {
	$(target).find('td:last').append('<span><a onclick="if(confirm(\'Delete this item?\')) $(this).parent().parent().parent().remove(); return false;" href="#">Remove</a></span>');
}

function updateColumns() {
	$.expr[':']['nth-of-type'] = function(elem, i, match) {
		var parts = match[3].split("+");
		return (i + 1 - (parts[1] || 0)) % parseInt(parts[0], 10) === 0;
	};
	columns = $('#Recipe_columns').val();
	$('.mmf_table tr:not(.section)').each(function() {
		$this = $(this);
		$this.find('td:lt('+(columns+1)+')').show();
		$this.find('th:lt('+(columns+1)+')').show();
		$this.find('td:not(:nth-of-type(7)):gt('+columns+')').hide();
		$this.find('th:not(:nth-of-type(7)):gt('+columns+')').hide();
		$this.find('td:last').css('width',((6-columns)*12)+'%');
	});
	$(".mmf_table.yields").width($('.mmf_table:not(.yields) thead').width());
	if( columns <= 3 ) {
		$('.mmf_table th:nth-child(2), .mmf_table td:nth-child(2), .mmf_table th:nth-child(3), .mmf_table td:nth-child(3), .mmf_table th:nth-child(4), .mmf_table td:nth-child(4), .mmf_table th:nth-child(5), .mmf_table td:nth-child(5), .mmf_table th:nth-child(6), .mmf_table td:nth-child(6)').width((columns == 3 ? 15 : 20) + '%');
	} else {
		$('.mmf_table th:nth-child(2), .mmf_table td:nth-child(2), .mmf_table th:nth-child(3), .mmf_table td:nth-child(3), .mmf_table th:nth-child(4), .mmf_table td:nth-child(4), .mmf_table th:nth-child(5), .mmf_table td:nth-child(5), .mmf_table th:nth-child(6), .mmf_table td:nth-child(6)').width('10%');
	}
}
