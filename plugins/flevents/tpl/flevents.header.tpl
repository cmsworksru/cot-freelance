<!-- BEGIN: MAIN -->
<li id="notifications-menu" class="us_rm dropdown">
  <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-bell-o"></i> <span class="label label-warning">{EVENTS_COUNT}</span> </a>
  <ul class="dropdown-menu">
    <li class="header textcenter"><!-- IF {EVENTS_COUNT} > 0 -->У вас {EVENTS_COUNT|cot_declension($this, 'Events_n')}<!-- ELSE -->{PHP.L.Events_empty_new}<!-- ENDIF --></li>
    <li>
      <ul id="sl_scro1" class="menu">
        <!-- IF {EVENTS_COUNT} > 0 -->
        <!-- BEGIN: EV_ROWS -->
        <li class="padding10 {EV_ROW_STYLER}"> 
          <!-- IF {EV_ROW_AREA} == 'offers' --> 
              <!-- IF {EV_ROW_TYPE} == 'addoffer' --> 
              {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_addoffer} <a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a> 
              <!-- ENDIF --> 
              <!-- IF {EV_ROW_TYPE} == 'setperformer' --> 
              {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_setperformer} <a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a> 
              <!-- ENDIF --> 
              <!-- IF {EV_ROW_TYPE} == 'refuselastperformer' OR {EV_ROW_TYPE} == 'refuse' --> 
              {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_refuselastperformer} <a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a> 
              <!-- ENDIF --> 
              <!-- IF {EV_ROW_TYPE} == 'addpost' --> 
              {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_addpost} <a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a> 
              <!-- ENDIF --> 
              <!-- IF {EV_ROW_TYPE} == 'addpost_offer' --> 
              {PHP.L.User} {EV_ROW_USER_NAME} {PHP.L.Events_addpost_offer} <a href="{EV_ROW_PRJ_URL}" target="_blank"><strong>{EV_ROW_PRJ_SHORTTITLE}</strong></a> 
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
          <div><small>{EV_ROW_DATE_STAMP|cot_build_timeago($this)}</small></div>
        </li>
        <!-- END: EV_ROWS --> 
        <!-- ENDIF -->
      </ul>
    </li>
    <li class="footer"><a href="{PHP|cot_url('flevents')}">Посмотреть все</a></li>
  </ul>
</li>
<!-- END: MAIN -->