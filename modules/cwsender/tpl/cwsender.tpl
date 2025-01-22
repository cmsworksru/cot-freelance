<!-- BEGIN: MAIN -->

<!-- BEGIN: SUBSCRIBE -->
	<h1>{PHP.L.cwsender_subscribe_title} "{SUBS_TITLE}"</h1>
	
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	
	<!-- IF {PHP.status} == 'subs_ok' -->
	<div class="alert alert-success">{PHP.L.cwsender_subscribe_status_subs_ok}</div>
	<!-- ENDIF -->
	
	{PHP.id|cwsender_subscribe($this)}
		
<!-- END: SUBSCRIBE -->

<!-- BEGIN: UNSUBSCRIBE -->
	<h1>{PHP.L.cwsender_unsubscribe_title} "{SUBS_TITLE}"</h1>
	
	<!-- IF {PHP.status} == 'unsubs_ok' -->
	<div class="alert alert-success">{PHP.L.cwsender_unsubscribe_status_unsubs_ok}</div>
	<!-- ENDIF -->
	
	<!-- IF {PHP.status} == 'unsubs_fail' -->
	<div class="alert alert-success">{PHP.L.cwsender_unsubscribe_status_unsubs_fail}</div>
	<!-- ENDIF -->
	
	<!-- IF {PHP.status} == 'unsubs_notfound' -->
	<div class="alert alert-success">{PHP.L.cwsender_unsubscribe_status_unsubs_notfound}</div>
	<!-- ENDIF -->
		
<!-- END: UNSUBSCRIBE -->
				
<!-- END: MAIN -->