
$(document).on('ready ajaxSuccess', function() {
	if ($.fn.jqm === undefined) {
		return;
	}
	$('.jqmWindowVerification').jqm({ trigger: 'a.trigger_jgm_vrf'});
});

function vrf_win_jqm(url) {
  $('.jqmWindowVerification').jqm({ajax: 'index.php?r=verification&action=image&imgurl='+url});
}



function  printing_machine(text,id, speed )
{
	var pi = pii = 0;
	var divid = document.getElementById(id);

		inter = setInterval( function(){
			pii++; pi++;
			if (pii >= text.length) clearInterval(inter);
			if(pi <= text.length)divid.innerText = text.substring (0,pi);
		},speed);
}

window.onload = function() {
	const verifyLink = document.getElementById('linkverifi');
	if (verifyLink === null) {
		return;
	}
	var ch = document.getElementById('confirm');
	verifyLink.onclick = function () {
		if (!ch.checked){
			printing_machine(text_vf_error, 'errors_confirm' , 20);
			return false;
		}
	};
};