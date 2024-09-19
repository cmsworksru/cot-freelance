<!-- BEGIN: MAIN -->

<!-- BEGIN: UPDATE -->
	<div class="block">
		<h3>{PHP.L.adminqv_update_notice}:</h3>
		<p>{ADMIN_HOME_UPDATE_REVISION} {ADMIN_HOME_UPDATE_MESSAGE}</p>
	</div>
<!-- END: UPDATE -->
	{FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}
<!-- BEGIN: MAINPANEL -->
	{ADMIN_HOME_MAINPANEL}
<!-- END: MAINPANEL -->

<div class="row">
	<!-- BEGIN: SIDEPANEL -->
	<div class="span3 pull-left">
		{ADMIN_HOME_SIDEPANEL}
	</div>
	<!-- END: SIDEPANEL -->
</div>
	
<hr/>

<div class="row">
	<div class="span4">
		<div class="block">
			<h3>{PHP.L.home_site_props}</h3>
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=main')}">{PHP.L.core_main}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=title')}">{PHP.L.core_title}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=theme')}">{PHP.L.core_theme}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=menus')}">{PHP.L.core_menus}</a></li>
				<li><a href="{PHP|cot_url('admin','m=config&n=edit&o=core&p=locale')}">{PHP.L.core_locale}</a></li>
				<li><a href="{PHP|cot_url('admin','m=extrafields')}">{PHP.L.Extrafields}</a></li>
			</ul>
		</div>
	</div>
</div>
<!-- END: MAIN -->