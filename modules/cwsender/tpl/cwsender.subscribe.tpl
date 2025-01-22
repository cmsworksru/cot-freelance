<!-- BEGIN: MAIN -->

<div class="panel panel-default">
	<div class="panel-body">
		<form action="{SUBS_ID|cot_url('cwsender', 'm=subscribe&a=send&id='$this)}" method="post" class="form-horizontal">
			<div class="form-group">
				<div class="col-md-4">
					<input type="text" name="rname" class="form-control" placeholder="{PHP.L.cwsender_subscribe_name}">
				</div>
				<div class="col-md-4">
					<input type="text" name="remail" class="form-control" placeholder="{PHP.L.cwsender_subscribe_email}">
				</div>
				<div class="col-md-4">
					<button class="btn btn-lg btn-primary" type="submit">{PHP.L.Submit}</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- END: MAIN -->