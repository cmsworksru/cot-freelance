<!-- BEGIN: MAIN -->
{FILE "{PHP.cfg.system_dir}/admin/tpl/warnings.tpl"}

<h2>{PHP.L.payments_history}</h2>

<div class="block button-toolbar">
	<div class="wrapper" style="display: flex">
		<form action="{PHP.p|cot_url('admin', 'm=payments&p='$this)}" method="post" class="w-60">
			<div style="display: flex; gap: 10px">
				<input type="text" class="form-control" name="sq" value="{PHP.sq}">
				<button type="submit" class="btn btn-default">{PHP.L.Search}</button>
			</div>
		</form>
		<div class="w-40 text-end">
			<a href="{PHP|cot_url('admin', 'm=payments')}" class="button btn<!-- IF !{PHP.p} --> btn-success special<!-- ENDIF -->">{PHP.L.payments_allusers}</a>
			<a href="{PHP|cot_url('admin', 'm=payments&p=payouts')}" class="button btn<!-- IF {PHP.p} == 'payouts' --> btn-success special<!-- ENDIF -->">{PHP.L.payments_payouts}</a>
			<a href="{PHP|cot_url('admin', 'm=payments&p=transfers')}" class="button btn<!-- IF {PHP.p} == 'transfers' --> btn-success special<!-- ENDIF -->">{PHP.L.payments_transfers}</a>
		</div>
	</div>
</div>

<!-- BEGIN: PAYMENTS -->
<div class="block">
	<div class="wrapper">
		<!-- IF {PHP.cfg.payments.balance_enabled} -->
		<p>
			<strong>{PHP.L.payments_siteinvoices}:</strong> {PHP.L.payments_debet}: {INBALANCE} {PHP.cfg.payments.valuta}
			| {PHP.L.payments_credit}: {OUTBALANCE} {PHP.cfg.payments.valuta} | {PHP.L.payments_balance}: {BALANCE} {PHP.cfg.payments.valuta}
		</p>
		<!-- ENDIF -->
		<div><strong>{PHP.L.payments_allpayments}:</strong> {CREDIT} {PHP.cfg.payments.valuta}</div>
	</div>
</div>

<div class="block">
	<table class="cells">
	<thead>
		<tr>
			<th class="coltop">#</th>
			<th class="coltop">{PHP.L.User}</th>
			<th class="coltop">{PHP.L.Date}</th>
			<th class="coltop"></th>
			<th class="coltop">{PHP.L.payments_summ}</th>
			<th class="coltop">{PHP.L.payments_desc}</th>
			<th class="coltop">{PHP.L.payments_area}</th>
			<th class="coltop">{PHP.L.payments_code}</th>
			<th class="coltop">{PHP.L.Status}</th>
		</tr>
	</thead>
	<tbody>
	<!-- BEGIN: PAY_ROW -->
	<tr>
		<td <!-- IF {PAY_ROW_SYSTEM} OR {PAY_ROW_METHOD} OR {PAY_ROW_PS_PAYMENT_ID} OR {PAY_ROW_PS_TRANSACTION} -->rowspan="3"<!-- ENDIF --> style="vertical-align: middle;">
			{PAY_ROW_ID}
		</td>
		<td><a href="{PAY_ROW_USER_ID|cot_url('admin', 'm=payments&id='$this)}">{PAY_ROW_USER_NICKNAME}</a></td>
		<td>{PAY_ROW_ADATE|cot_date('datetime_medium', $this)}</td>
		<td class="centerall"><!-- IF {PAY_ROW_AREA} == 'balance' -->+<!-- ELSE -->-<!-- ENDIF --></td>
		<td style="text-align: right;">{PAY_ROW_SUMM|number_format($this, 2, '.', ' ')}</td>
		<td>{PAY_ROW_DESC}</td>
		<td>{PAY_ROW_AREA}</td>
		<td>{PAY_ROW_CODE}</td>
		<td>{PAY_ROW_STATUS}</td>
	</tr>
	<!-- IF {PAY_ROW_SYSTEM} OR {PAY_ROW_METHOD} OR {PAY_ROW_PS_PAYMENT_ID} OR {PAY_ROW_PS_TRANSACTION} -->
	<tr>
		<td colspan="3">
			<!-- IF {PAY_ROW_SYSTEM} -->{PHP.L.payments_payment_system}: <b>{PAY_ROW_SYSTEM}</b><br><!-- ENDIF -->
			<!-- IF {PAY_ROW_METHOD} -->{PHP.L.payments_payment_method}: {PAY_ROW_METHOD}<!-- ENDIF -->
		</td>
		<td colspan="6">
			<!-- IF {PAY_ROW_PS_PAYMENT_ID} -->
			{PHP.L.payments_payment_id} ({PHP.L.payments_payment_id_hint}): {PAY_ROW_PS_PAYMENT_ID}<br>
			<!-- ENDIF -->
			<!-- IF {PAY_ROW_PS_TRANSACTION} -->
			{PHP.L.payments_transaction} {PHP.L.payments_transaction_hint}: {PAY_ROW_PS_TRANSACTION}
			<!-- ENDIF -->
		</td>
	<tr>
	<!-- ENDIF -->
	<!-- END: PAY_ROW -->
	</tbody>
	</table>

	<!-- IF {PAGINATION} -->
	<div class="paging">
		{PREVIOUS_PAGE}{PAGINATION}{NEXT_PAGE}
		<span>{PHP.L.Total}: {TOTAL_ENTRIES}, {PHP.L.Onpage}: {ENTRIES_ON_CURRENT_PAGE}</span>
	</div>
	<!-- ENDIF -->
</div>
<!-- END: PAYMENTS -->

<!-- BEGIN: PAYOUTS -->
<div class="block">
	<table class="cells">
	<thead>
		<tr>
			<th class="span2">{PHP.L.User}</th>
			<th class="span2">{PHP.L.payments_summ}</th>
			<th>{PHP.L.Description}</th>
			<th>{PHP.L.Date}</th>
			<th>{PHP.L.Status}</th>
			<th>{PHP.L.Action}</th>
		</tr>
	</thead>
	<!-- BEGIN: PAYOUT_ROW -->
		<tr>
			<td>{PAYOUT_ROW_USER_NAME}</td>
			<td>{PAYOUT_ROW_SUMM}</td>
			<td>{PAYOUT_ROW_DETAILS}</td>
			<td><!-- IF {PAYOUT_ROW_DATE} > 0 -->{PAYOUT_ROW_DATE|cot_date('d.m.Y H:i',$this)}<!-- ELSE -->&mdash;<!-- ENDIF --></td>
			<td>{PAYOUT_ROW_LOCALSTATUS}</td>
			<td>
				<!-- IF {PAYOUT_ROW_STATUS} == 'process' -->
				<a href="{PAYOUT_ROW_DONE_URL}">{PHP.L.Confirm}</a>
				<a href="{PAYOUT_ROW_CANCEL_URL}">{PHP.L.Cancel}</a>
				<!-- ENDIF -->
			</td>
		</tr>
	<!-- END: PAYOUT_ROW -->
	</table>
</div>
<!-- END: PAYOUTS -->

<!-- BEGIN: TRANSFERS -->
<div class="block">
	<table class="cells">
	<thead>
		<tr>
			<th class="span2">{PHP.L.payments_balance_transfers_from}</th>
			<th class="span2">{PHP.L.payments_balance_transfers_for}</th>
			<th class="span2">{PHP.L.payments_summ}</th>
			<th>{PHP.L.Description}</th>
			<th>{PHP.L.Date}</th>
			<th>{PHP.L.Done}</th>
			<th>{PHP.L.Status}</th>
			<th>{PHP.L.Action}</th>
		</tr>
	</thead>
	<!-- BEGIN: TRANSFER_ROW -->
		<tr>
			<td><a href="{TRANSFER_ROW_FROM_DETAILSLINK}">{TRANSFER_ROW_FROM_FULL_NAME}</a></td>
			<td><a href="{TRANSFER_ROW_FOR_DETAILSLINK}">{TRANSFER_ROW_FOR_FULL_NAME}</a></td>
			<td>{TRANSFER_ROW_SUMM}</td>
			<td>{TRANSFER_ROW_COMMENT}</td>
			<td>{TRANSFER_ROW_DATE|cot_date('d.m.Y H:i',$this)}</td>
			<td><!-- IF {TRANSFER_ROW_DONE} > 0 -->{TRANSFER_ROW_DONE|cot_date('d.m.Y H:i',$this)}<!-- ELSE -->&mdash;<!-- ENDIF --></td>
			<td>{TRANSFER_ROW_LOCALSTATUS}</td>
			<td>
				<!-- IF {TRANSFER_ROW_STATUS} == 'process' -->
				<a href="{TRANSFER_ROW_DONE_URL}">{PHP.L.Confirm}</a>
				<a href="{TRANSFER_ROW_CANCEL_URL}">{PHP.L.Cancel}</a>
				<!-- ENDIF -->
			</td>
		</tr>
	<!-- END: TRANSFER_ROW -->
	</table>
</div>
<!-- END: TRANSFERS -->
			
<!-- END: MAIN -->