/**
 * jQuery Yii CEditableGridView plugin file.
 *
 * @author Árpád Tóth <toth.arpad@pdk.hu>
 */

$(document).ready(function() {
	$("table").on( "click", ".ceditable_grid_view_addbtn", function() {
		var html = $(this).closest('tr').html() ;
		var result = html.match(/input name=\"(.*?)"/) ;
		var sorszam_hozzaad = false ;
		if (result != null) {
			var input_html = result[0] ;
			if(!/___\d\]/.test(input_html)) {
				sorszam_hozzaad = true ;
			}
		}
		var sorszam = html.substr(html.indexOf('addbtn_') + 7, 2) ;
		if (isNaN(sorszam)) {
			sorszam = sorszam.substr(0, 1) ;
		}
		var uj_sorszam = parseInt(sorszam) + 1 ;
		var uj_html = html.replace('addbtn_' + sorszam, 'addbtn_' + uj_sorszam) ;
/*		if (sorszam_hozzaad) {
			uj_html = uj_html.replace(/input name=\"(.*?)"/, 'input name="$1___' + uj_sorszam + '"')
		}
		else
		{
			uj_html = uj_html.replace('___' + sorszam, '___' + uj_sorszam) ;
		}*/
		$(this).closest('tbody').append('<tr class="selected">' + uj_html + '</tr>') ;
		$(this).hide();
		$(this).parent().parent().parent().parent().find(".empty").hide();
	});
})
