<!-- BEGIN: MAIN -->
<div class="breadcrumb">
  <div class="container"><h1>{PHP.L.Events_title_new}</h1></div>
</div>

<div class="container">
<!-- IF {EVENTS_COUNT} != 0 -->
    <div class="well">
        <!-- BEGIN: EV_ROWS -->
        <div class="media padding10 {EV_ROW_STYLER}">
            <div class="row">
                <div class="col-md-10 text">
                <!-- IF {EV_ROW_AREA} == 'offers' -->
                    <!-- IF {EV_ROW_TYPE} == 'addoffer' -->
                       {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_addoffer}:
                       <div><a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a></div>
                    <!-- ENDIF -->
                    <!-- IF {EV_ROW_TYPE} == 'setperformer' -->
                       {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_setperformer}:
                       <div><a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a></div>
                    <!-- ENDIF -->
                    <!-- IF {EV_ROW_TYPE} == 'refuselastperformer' OR {EV_ROW_TYPE} == 'refuse' -->
                       {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_refuselastperformer}:
                       <div><a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a></div>
                    <!-- ENDIF -->
                    <!-- IF {EV_ROW_TYPE} == 'addpost' -->
                       {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_addpost}:
                       <div><a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a></div>
                    <!-- ENDIF -->
                    <!-- IF {EV_ROW_TYPE} == 'addpost_offer' -->
                       {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_addpost_offer}:
                       <div><a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a></div>
                    <!-- ENDIF -->
                <!-- ENDIF -->
                <!-- IF {EV_ROW_AREA} == 'sbr' -->
                      <!-- IF {EV_ROW_TYPE} == 'new' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_sbr_new} <a href="{EV_ROW_SBR_URL}" target="_blank"><strong>№ {EV_ROW_SBR_ID}</strong></a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'edit' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_sbr_edit} <a href="{EV_ROW_SBR_URL}" target="_blank"><strong>№ {EV_ROW_SBR_ID}</strong></a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'emp_cancel' -->
                      {PHP.L.Events_sbr_cancel} <a href="{EV_ROW_SBR_URL}" target="_blank"><strong>№ {EV_ROW_SBR_ID}</strong></a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'refuse' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_sbr_refuse} <a href="{EV_ROW_SBR_URL}" target="_blank"><strong>№ {EV_ROW_SBR_ID}</strong></a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'confirm' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_sbr_confirm} <a href="{EV_ROW_SBR_URL}" target="_blank"><strong>№ {EV_ROW_SBR_ID}</strong></a>. {PHP.L.Events_sbr_need} <a href="{EV_ROW_SBR_ID|cot_url('sbr', 'a=pay&id='$this)}">{PHP.L.Events_sbr_reserve_money}</a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'paid' -->
                      {PHP.L.Events_sbr_paid} <a href="{EV_ROW_SBR_URL}" target="_blank"><strong>№ {EV_ROW_SBR_ID}</strong></a>. {PHP.L.Events_sbr_start}
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'addpost' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_sbr_addpost} <a href="{EV_ROW_SBR_URL}" target="_blank"><strong>№ {EV_ROW_SBR_ID}</strong></a>
                      <!-- ENDIF -->
                  <!-- ENDIF -->
                  <!-- IF {EV_ROW_AREA} == 'reviews' -->
                      <!-- IF {EV_ROW_TYPE} == 'add1' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_rev_add_pos} <a href="{EV_REVLINK}" target="_blank"><strong>{PHP.L.Events_rev}</strong></a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'add-1' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_rev_add_neg} <a href="{EV_REVLINK}" target="_blank"><strong>{PHP.L.Events_rev}</strong></a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'edit1' OR {EV_ROW_TYPE} == 'edit-1' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_rev_edit} <a href="{EV_REVLINK}" target="_blank"><strong>{PHP.L.Events_rev}</strong></a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'del' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_rev_del}
                      <!-- ENDIF -->
                  <!-- ENDIF -->
                  <!-- IF {EV_ROW_AREA} == 'marketorders' -->
                      <!-- IF {EV_ROW_TYPE} == 'buy' -->
                      {PHP.L.Events_market_buy}. <a href="{EV_ROW_ORDER_ID|cot_url('marketorders', 'id='$this)}" target="_blank">{PHP.L.Events_market_order} № {EV_ROW_ORDER_ID}</a>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'sell' -->
                      {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_market_sell_order}. <a href="{EV_ROW_ORDER_ID|cot_url('marketorders', 'id='$this)}" target="_blank">{PHP.L.Events_market_order} № {EV_ROW_ORDER_ID}</a>. <small>{PHP.L.Events_market_sell_guarant}</small>
                      <!-- ENDIF -->
                      <!-- IF {EV_ROW_TYPE} == 'paid' -->
                      {PHP.L.Events_market_order_paid} <a href="{EV_ROW_ORDER_ID|cot_url('marketorders', 'id='$this)}" target="_blank">№ {EV_ROW_ORDER_ID}</a>
                      <!-- ENDIF -->
                  <!-- ENDIF -->
                </div>
                <div class="col-md-2">
                    {EV_ROW_DATE_STAMP|cot_build_timeago($this)}
                </div>
            </div>
        </div>
        <!-- END: EV_ROWS -->
    </div>

    <!-- IF {PAGINATION} -->
    <div><ul class="pagination {PHP.R.admin-pagination-list-class}">{PREVIOUS_PAGE}{PAGINATION}{NEXT_PAGE}</ul></div>
    <!-- ENDIF -->

<!-- ELSE -->
    <div class="alert alert-info">{PHP.L.Events_empty_new}</div>
<!-- ENDIF -->
</div>
<!-- END: MAIN -->