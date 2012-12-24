// Re-calculates section id's for sections and ingredients
function sectionCalc() {
	sectionId = 0;
	positionId = 1;
	$("#mmf_sortable .mmf_row").each(function() {
		$this = $(this);
		if( $this.hasClass("section") ) {
			sectionId++;
		} else {
			$this.find("[id^=Ingredient]").filter("[id*=section]").val(sectionId);
			$this.find("[id^=Ingredient]").filter("[id*=position]").val(positionId);
			positionId++;
		}
	});
	$("#mmf_sortable .mmf_row:not(.section)").last().find("[id^=Ingredient]").filter("[id*=section]").val('');
}

function addRemoveLink( target ) {
	$(target).append('<span><a onclick="if(confirm(\'Delete this item?\')) $(this).parent().parent().remove(); return false;" href="#">Remove</a></span>');
}
