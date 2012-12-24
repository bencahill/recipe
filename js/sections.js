// Re-calculates section id's for sections and ingredients
function sectionCalc() {
	sectionId = 0;
	$("#mmf_sortable .view").each(function() {
		$this = $(this);
		if( $this.hasClass("id_section_copy") ) {
			// $this.find("[id^=Recipe_section]").val(sectionId);
			sectionId++;
		} else {
			$this.find("[id^=Ingredient]").filter("[id*=section]").val(sectionId);
		}
	});
	$("#mmf_sortable .view:not(.id_section_copy)").last().find("[id^=Ingredient]").filter("[id*=section]").val('');
}

function addRemoveLink( target ) {
	$(target).append('<span><a onclick="if(confirm(\'Delete this item?\')) $(this).parent().parent().remove(); return false;" href="#">Remove</a></span>');
}
