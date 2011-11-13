<?php

function req_addAnoun_form($user){
  
  
  $query = "SELECT * FROM page WHERE id = '".ANOUN_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  if(login_checkAuth($user, $page, "6")){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      <h2><?php echo TXT_ADD." ".TXT_ANOUN; ?></h2>
      <table>
      <tr><td><b><?php echo TXT_TITLE; ?> : </b></td><td><input size="35" type="text" id="anoun_title"></td></tr>
      <tr><td colspan=2><textarea id="anoun_body" cols="50" rows="14"></textarea></td></tr>
      <tr><td><b><?php echo TXT_EXPIRE; ?> : </b></td><td><input readonly="readonly" type="text" id="anoun_expire"><button id="trigger">...</button></td></tr>
      </table>
      <input type="hidden" id="reqtype_db" value="addanoun">
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('reqtype_db', true, 'reqtype', 'anoun_title', true, false, 'anoun_body', true, false, 'anoun_expire', true, false)"><?php echo TXT_ADD;?></a>

      
      </center>
      
      <?php
      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "550";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "400";

  }else{
    echo "206";
  }
}

function req_switchPagePos($user){
  
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['page1_id']) && isset($_REQUEST['page2_id'])){
  
      $query = "SELECT pos FROM page WHERE id = '".$_REQUEST['page1_id']."'";
      $result = mysql_query($query);
      $page1 = mysql_fetch_object($result);
        
      $query = "SELECT pos FROM page WHERE id = '".$_REQUEST['page2_id']."'";
      $result = mysql_query($query);
      $page2 = mysql_fetch_object($result);
     
      $query = "UPDATE page SET pos='".$page2->pos."'WHERE id = '".$_REQUEST['page1_id']."'";
      $result = mysql_query($query);
     
      $query = "UPDATE page SET pos='".$page1->pos."'WHERE id = '".$_REQUEST['page2_id']."'";
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EDITMENU_PAGE_ID;
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "1";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_addGroup_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERGROUPS_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    echo "207";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    ?>
    
    <center>
    
    <h2><?php echo TXT_ADD_USERGROUP; ?></h2>
    <form method=post action="#" onsubmit="return false">
    <p><?php echo TXT_GROUPNAME; ?> :</p><input type="text" id="group_name">
    <input type="hidden" id="reqtype" value="addgroup">
    </form>
    
    <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('group_name', true, false, 'reqtype', true, false)"><?php echo TXT_ADD;?></a>
    
    </center>
    
    <?php
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "250";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "200";
    
  }else{
    echo "206";
  }
  
}

function req_addFolder_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['folder_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_ADDFOLDER; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <p><?php echo TXT_NAME; ?> :</p><input type="text" id="folder_name">
      <input type="hidden" id="reqtype" value="addfolder">
      <input type="hidden" id="folder_id" value="<?php echo $_REQUEST['folder_id']; ?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('folder_name', true, false, 'reqtype', true, false, 'folder_id', true, false)"><?php echo TXT_ADD;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_addLink_form($user){

  $page = new stdClass();
  $page->id = -1 * MAINLINK_SR_ID;
  $page->name="Main links";
  $page->auth_type="2";
  
  if(login_checkAuth($user, $page, "4")){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_ADDLINK; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <p><?php echo TXT_NAME; ?> :</p><input type="text" id="link_name">
      <p><?php echo TXT_LINK; ?> :</p><input type="text" id="link_link">
      <input type="hidden" id="reqtype" value="addlink">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('link_name', true, false, 'reqtype', true, false, 'link_link', true, false)"><?php echo TXT_ADD;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
  }else{
    echo "206";
  }
  
}

function req_addTest_form($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){
    if(isset($_REQUEST['event_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_MENU_ADDTEST; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <p><?php echo TXT_NAME; ?> :</p><input type="text" id="test_name">
      <input type="hidden" id="reqtype" value="addtest">
      <input type="hidden" id="event_id" value="<?php echo $_REQUEST['event_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('test_name', true, false, 'reqtype', true, false, 'event_id', true, false)"><?php echo TXT_ADD;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_addEvType_form($user){
  
  $query = "SELECT * FROM `page` WHERE id='".EVENTTYPE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page)>="6"){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_ADDEVTYPE; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <table>
      <tr><td><b><?php echo TXT_NAME; ?> : </b></td><td><input type="text" id="evtype_name"></td></tr>
      <tr><td><b><?php echo TXT_COLOR; ?> : </b></td><td align=center> #<input size=6 type="text" id="evtype_color" value="a5a5a5"></td></tr>
      <tr><td><b><?php echo TXT_INSCMOD; ?> : </b></td><td align=center><select id="evtype_isinsc" onchange="checkIsOpen();">
                                                            <option value=0><?php echo TXT_NOINSCRIP;?></option>
                                                            <option value=1><?php echo TXT_INSC;?></option>
                                                            <option value=2><?php echo TXT_OBLIGATORY;?></option>
                                                            </select></td></tr>
      <tr><td>&nbsp;</td><td align=center><select id="evtype_isopen" disabled>
                                                            <option value=0><?php echo TXT_CLOSED;?></option>
                                                            <option value=1><?php echo TXT_ONEWAY;?></option>
                                                            <option value=2><?php echo TXT_OPEN;?></option>
                                                            </select></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISMANEV; ?> : </b><input type="checkbox" checked=checked id="evtype_manev"></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISECTS; ?> : </b><input type="checkbox" checked=checked id="evtype_isects"></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISTEST; ?> : </b><input type="checkbox" checked=checked id="evtype_istest"></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISPRIO; ?> : </b><input type="checkbox" checked=checked id="evtype_isprio"></td></tr>
      </table>
      <input type="hidden" id="reqtype" value="addevtype">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('evtype_name', true, false, 'reqtype', true, false, 'evtype_color', true, false, 'evtype_isinsc', true, false, 'evtype_isopen', false, false, 'evtype_isects', true, false, 'evtype_isprio', true, false, 'evtype_istest', true, false, 'evtype_manev', true, false)"><?php echo TXT_ADD;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "350";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "300";
      
  }else{
    echo "206";
  }
  
}

function req_editEvType_form($user){
  
  $query = "SELECT * FROM `page` WHERE id='".EVENTTYPE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page)>="6"){
    if(isset($_REQUEST['evtype_id'])){
      $query = "SELECT `event_type`.*, `page`.`auth_mod` FROM `event_type`, `page` WHERE `event_type`.`id`='".$_REQUEST['evtype_id']."' and `event_type`.`page_id` = `page`.`id`";
      $result = mysql_query($query);
      $event_type = mysql_fetch_object($result);
      

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      
      
      ?>
      
      
      <center>
      
      <h2><?php echo TXT_ADDEVTYPE; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <table>
      <tr><td><b><?php echo TXT_NAME; ?> : </b></td><td><input type="text" id="evtype_name" value="<?php echo $event_type->name; ?>"></td></tr>
      <tr><td><b><?php echo TXT_COLOR; ?> : </b></td><td align=center> #<input size=6 type="text" class="color" id="evtype_color" value="<?php echo $event_type->color; ?>"></td></tr>
      <tr><td><b><?php echo TXT_INSCMOD; ?> : </b></td><td align=center><select id="evtype_isinsc" onchange="checkIsOpen();">
                                                            <option value=0<?php if($event_type->is_insc=="0"){echo " selected=\"selected\"";}?>><?php echo TXT_NOINSCRIP;?></option>
                                                            <option value=1<?php if($event_type->is_insc=="1"){echo " selected=\"selected\"";}?>><?php echo TXT_INSC;?></option>
                                                            <option value=2<?php if($event_type->is_insc=="2"){echo " selected=\"selected\"";}?>><?php echo TXT_OBLIGATORY;?></option>
                                                            </select></td>
      <tr><td>&nbsp;</td><td align=center><select id="evtype_isopen"<?php if($event_type->is_insc!="1"){echo " disabled";}?>>
                                                            <option value=0<?php if($event_type->is_open=="0"){echo " selected=\"selected\"";}?>><?php echo TXT_CLOSED;?></option>
                                                            <option value=1<?php if($event_type->is_open=="1"){echo " selected=\"selected\"";}?>><?php echo TXT_ONEWAY;?></option>
                                                            <option value=2<?php if($event_type->is_open=="2"){echo " selected=\"selected\"";}?>><?php echo TXT_OPEN;?></option>
                                                            </select></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISMANEV; ?> : </b><input type="checkbox" id="evtype_manev"<?php if($event_type->auth_mod=="3"){echo " checked=\"checked\"";}?>></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISECTS; ?> : </b><input type="checkbox" id="evtype_isects"<?php if($event_type->is_ects=="1"){echo " checked=\"checked\"";}?>></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISTEST; ?> : </b><input type="checkbox" id="evtype_istest"<?php if($event_type->is_test=="1"){echo " checked=\"checked\"";}?>></td></tr>
      <tr><td colspan=2 align=center><b><?php echo TXT_ISPRIO; ?> : </b><input type="checkbox" id="evtype_isprio"<?php if($event_type->is_prio=="1"){echo " checked=\"checked\"";}?>></td></tr>
      </table>
      <input type="hidden" id="reqtype" value="editevtype">
      <input type="hidden" id="evtype_id" value="<?php echo $_REQUEST['evtype_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('evtype_istest', true, false,'evtype_isprio', true, false, 'evtype_id', true, false, 'evtype_name', true, false, 'reqtype', true, false, 'evtype_color', true, false, 'evtype_isinsc', true, false, 'evtype_isopen', false, false, 'evtype_isects', true, false, 'evtype_manev', true, false)"><?php echo TXT_EDIT;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "350";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "300";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_unsubsc($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="2"){
    if(isset($_REQUEST['event_id']) && isset($_REQUEST['user_id'])){

      $query = "DELETE FROM `event_insc` WHERE `event_id` = ".$_REQUEST['event_id']." and `user_id` = ".$_REQUEST['user_id'];
      $result = mysql_query($query);
      
      $query = "DELETE FROM `event_prio` WHERE `event_id` = ".$_REQUEST['event_id']." and `user_id` = ".$_REQUEST['user_id'];
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$_REQUEST['event_id'];
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_editPond_form($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){
    if(isset($_REQUEST['event_id']) && isset($_REQUEST['test_id'])){
  
      $query = "SELECT * FROM `test` WHERE id='".$_REQUEST['test_id']."'";
      $result = mysql_query($query);
      $test = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo $test->name; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <b><?php echo TXT_POND; ?> : </b><input size=3 type="text" id="test_pond" value="<?php echo $test->pond;?>">
      <input type="hidden" id="reqtype" value="editPond">
      <input type="hidden" id="event_id" value="<?php echo $_REQUEST['event_id'];?>">
      <input type="hidden" id="test_id" value="<?php echo $_REQUEST['test_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('test_pond', true, false, 'reqtype', true, false, 'event_id', true, false, 'test_id', true, false)"><?php echo TXT_EDIT;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "150";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_editNote_form($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){
    if(isset($_REQUEST['event_id']) && isset($_REQUEST['test_id']) && isset($_REQUEST['user_id'])){
  
      $query = "SELECT * FROM `test` WHERE id='".$_REQUEST['test_id']."'";
      $result = mysql_query($query);
      $test = mysql_fetch_object($result);
  
      $query = "SELECT * FROM `user_profile` WHERE user_id='".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user_profile = mysql_fetch_object($result);
  
      $query = "SELECT * FROM `test_note` WHERE test_id='".$_REQUEST['test_id']."' and user_id='".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $note = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo $test->name; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <b><?php echo $user_profile->forename." ".$user_profile->surname; ?> : </b><input size=3 type="text" id="test_note" value="<?php if(!empty($note)){echo $note->note;}?>">
      <input type="hidden" id="reqtype" value="editNote">
      <input type="hidden" id="event_id" value="<?php echo $_REQUEST['event_id'];?>">
      <input type="hidden" id="test_id" value="<?php echo $_REQUEST['test_id'];?>">
      <input type="hidden" id="user_id" value="<?php echo $_REQUEST['user_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('test_note', true, false, 'reqtype', true, false, 'event_id', true, false, 'test_id', true, false, 'user_id', true, false)"><?php echo TXT_EDIT;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "150";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_addDate_form($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['event_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_ADDDATE; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <input type="text" readonly="readonly" id="event_date" size=10><button id="trigger">...</button><br/>
      <br/>
      <table>
      <tr><td>
      <b><?php echo TXT_REPEAT; ?> : </td><td>
      <input onchange="checkRepeatUntil();" type=radio value=0 id="typerepeat" name="typerepeat" checked="checked"> <?php echo TXT_NOREPEAT; ?><br/>
      <input onchange="checkRepeatUntil();" type=radio value=1 id="typerepeat" name="typerepeat"> <?php echo TXT_DAYREPEAT; ?><br/>
      <input onchange="checkRepeatUntil();" type=radio value=2 id="typerepeat" name="typerepeat"> <?php echo TXT_WEEKREPEAT; ?><br/>
      </td>
      <td align=center>
      <div id="until" style="display:none;">
      &nbsp;&nbsp;&nbsp;<b><?php echo TXT_UNTIL; ?> </b>
      <input type="text" id="until_date" size="10"><button id="trigger2">...</button></div>
      <div id="skipwediv" style="display:none;">
      <input type="checkbox" id="skipwe" value="1" checked="checked"> <?php echo TXT_SKIPWE; ?>
      </div>
      </td></tr>
      </table>
      <br/><hr/>
      <?php echo TXT_ROOM; ?> : <input type="text" id="date_room" size="25"><br/>
      <?php echo TXT_TIME; ?> : 
      <?php
      sp_setTimeOptionsHH('btimehh', $event->btime, true);  sp_setTimeOptionsMM('btimemm', $event->btime, true);
      echo " - ";
      sp_setTimeOptionsHH('etimehh', $event->etime, true);  sp_setTimeOptionsMM('etimemm', $event->etime, true);
      ?>
      <input type="hidden" id="reqtype_db" value="adddate">
      <input type="hidden" id="event_id" value="<?php echo $_REQUEST['event_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('event_date', true, false, 'reqtype_db', true, 'reqtype', 'event_id', true, false, 'date_room', false, false, 'btimehh', false, false, 'etimehh', false, false, 'btimemm', false, false, 'etimemm', false, false, 'typerepeat', true, false, 'until_date', false, false, 'skipwe', true, false)"><?php echo TXT_ADD;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "500";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "350";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_showDates($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['event_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      <center>
      
      <h2><?php echo $event->title; ?></h2>
      <br/>
      
      <?php
      
      $query2 = "SELECT * FROM `event_date` WHERE event_id = '".$_REQUEST['event_id']."' ORDER BY `date`";
      $result2 = mysql_query($query2);
      $nbdate=mysql_num_rows($result2);
      $i=0;
      echo "<table>";
      echo "<tr><td>";
      while($event_date = mysql_fetch_object($result2)){
        $i++;
        echo "<span class=\"\">".date('D d M Y', strtotime($event_date->date))."</span><br/>";
        if($nbdate>=10 && ($i%10)==0){
          echo "</td><td style=\"padding-left:20px;\">";
        }
      }
      echo "</td></tr>";
      echo "</table>";
      ?>
      
      <br/>
      <a class="insidelink" href="javascript:hideDialogBox()"><?php echo TXT_OK; ?></a>
      
      </center>
            
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "600";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "350";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_evPrio_form($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['event_id']) && isset($_REQUEST['event_type']) && isset($_REQUEST['user_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_PRIOCH; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <input type="hidden" id="reqtype_db" value="evprio">
      <input type="hidden" id="event_id" value="<?php echo $_REQUEST['event_id'];?>">
      <input type="hidden" id="user_id" value="<?php echo $_REQUEST['user_id'];?>">
      <?php
      
      $query2 = "SELECT `date` FROM `event_date` WHERE event_id = '".$event->id."' ORDER BY `date`";
      $result2 = mysql_query($query2);
      $event_date = mysql_fetch_object($result2);
      
      $this_sem = get_semester(strtotime($event_date->date));
      
      //echo $this_sem."<br/>";
      
      $nbev = 0;
      $query = "SELECT `id` FROM `event` WHERE type = '".$_REQUEST['event_type']."'";
      $result = mysql_query($query);
      while($eventl = mysql_fetch_object($result)){
        $query2 = "SELECT `date` FROM `event_date` WHERE event_id = '".$eventl->id."' ORDER BY `date`";
        $result2 = mysql_query($query2);
        $event_date = mysql_fetch_object($result2);
        
        if(!empty($event_date)){
          if(get_semester(strtotime($event_date->date))==$this_sem){
            $nbev++;
          }
        }
      }
                    
      $query = "SELECT `event_prio`.`priority`, `event`.`id` FROM `event`, `event_prio` WHERE `event_prio`.`user_id` = '".$_REQUEST['user_id']."' and `event_prio`.`event_id`=`event`.`id` and `event`.`type`='".$_REQUEST['event_type']."'";
      $result = mysql_query($query);
      while($eventl = mysql_fetch_object($result)){
        $query2 = "SELECT `date` FROM `event_date` WHERE event_id = '".$eventl->id."' ORDER BY `date`";
        $result2 = mysql_query($query2);
        $event_date = mysql_fetch_object($result2);
        
        if(get_semester(strtotime($event_date->date))==$this_sem){
          $evchosen[$eventl->priority]=true;
        }
      }
      
      echo "<select id=\"event_prio\">";
      
      for($i=0;$i<$nbev;$i++){
        if(!isset($evchosen[($i+1)])){
          echo "<option value=".($i+1).">".get_choiceNum($i+1)."</option>";
        }
      }
      
      echo "</select>";
      
      ?>
      
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('user_id', true, false, 'reqtype_db', true, 'reqtype', 'event_id', true, false, 'event_prio', true, false)"><?php echo TXT_CHOOSE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "300";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "150";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_editDate_form($user){
  
  $query = "SELECT * FROM event_date WHERE id = '".$_REQUEST['date_id']."'";
  $result = mysql_query($query);
  $event_date = mysql_fetch_object($result);
  
  $query = "SELECT * FROM event WHERE id = '".$event_date->event_id."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['date_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_EDITDATE; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <input type="text" readonly="readonly" id="event_date" size=10 value="<?php echo $event_date->date;?>"><button id="trigger">...</button><br/><br/><hr/>
      <?php echo TXT_ROOM; ?> : <input type="text" id="date_room" size="25"><br/>
      <?php echo TXT_TIME; ?> : 
      <?php
      sp_setTimeOptionsHH('btimehh', $event_date->btime, true);  sp_setTimeOptionsMM('btimemm', $event_date->btime, true);
      echo " - ";
      sp_setTimeOptionsHH('etimehh', $event_date->etime, true);  sp_setTimeOptionsMM('etimemm', $event_date->etime, true);
      ?>
      <input type="hidden" id="reqtype_db" value="editdate">
      <input type="hidden" id="date_id" value="<?php echo $_REQUEST['date_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('event_date', true, false, 'reqtype_db', true, 'reqtype', 'date_id', true, false, 'date_room', false, false, 'btimehh', false, false, 'etimehh', false, false, 'btimemm', false, false, 'etimemm', false, false)"><?php echo TXT_EDIT;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "300";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_docToFolder_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['doc_id'])){
      
      $query = "SELECT * FROM doc WHERE id = '".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
      $doc = mysql_fetch_object($result);
      
      $query = "SELECT * FROM doc_folder WHERE doc_id = '".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
      $doc_folder = mysql_fetch_object($result);
      
      if($doc_folder->folder_id != "0"){
        $query = "SELECT * FROM folder WHERE id = '".$doc_folder->folder_id."'";
        $result = mysql_query($query);
        $folder = mysql_fetch_object($result);
      }
      
      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      
      echo "<input type=hidden id=reqtype value=doctofolder>";
      echo "<input type=hidden id=doc_id value=".$_REQUEST['doc_id'].">";
      echo "<select id=\"movefolder\">";
      if($doc_folder->folder_id != "0"){
        echo "<option value=".$folder->folder_id.">".TXT_PARENTF."</option>";
      }
      $query = "SELECT * FROM folder WHERE folder_id = '".$doc_folder->folder_id."'";
      $result = mysql_query($query);
      while($nfolder = mysql_fetch_object($result)){
        echo "<option value=".$nfolder->id.">".$nfolder->name."</option>";
      }
      
      echo "</select>";
      echo "<br/><br/>";
      echo "<a class=\"insidesmlink\" href=\"javascript:hideDialogBox()\">".TXT_CANCEL."</a> | <a href=\"javascript:setReq('reqtype', true, false, 'movefolder', true, 'folder_id', 'doc_id', true, false)\" class=\"insidesmlink\">".TXT_MOVE."</a>";
  
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "300";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
}

function req_docToFolder($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['doc_id']) && isset($_REQUEST['folder_id'])){
      
      
      $query = "UPDATE `doc_folder` SET `folder_id` = '".$_REQUEST['folder_id']."' WHERE `doc_id`='".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo DOCUMENT_PAGE_ID;
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "folder_id=".$_REQUEST['folder_id'];
  
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_linkDoc_form($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['event_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_DOCUMENTS; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <input type="hidden" id="reqtype_sp" value="linkdoc_form">

      <input type="checkbox" id="showomy" 
      <?php if(!isset($_REQUEST['showomy'])){echo "";}
      elseif($_REQUEST['showomy']=="true"){echo "checked=\"checked\"";}
       ?>
       onchange="setReq('reqtype_sp', true, 'reqtype', 'showomy', true, false, 'showoul', true, false, 'event_id', true, false, 'folder_id', true, false)">
       <?php echo TXT_SHOWOMY; ?>
       <br/><input type="checkbox" id="showoul" 
      <?php if(!isset($_REQUEST['showoul'])){echo "";}
      elseif($_REQUEST['showoul']=="true"){echo "checked=\"checked\"";}
       ?>
       onchange="setReq('reqtype_sp', true, 'reqtype', 'showomy', true, false, 'showoul', true, false, 'event_id', true, false, 'folder_id', true, false)">
       <?php echo TXT_SHOWOUL; ?>
       <br/><input type="checkbox" id="sendemail">
       <?php echo TXT_SENDEMAIL; ?>
       <br/><br/>
       
       <?php
        if(!isset($_REQUEST['folder_id'])){
          $_REQUEST['folder_id']="0";
        }
        
        if($_REQUEST['folder_id']=="all"){
          $folder_id="0";
        }else{
          $folder_id=$_REQUEST['folder_id'];
        }
        
        echo "<input type=hidden id=folder_id value=".$_REQUEST['folder_id'].">";
       
        echo "<table cellpadding=2>";
        echo "<tr><TD>";
        echo "<b>/</b>";
        echo "<a href=\"javascript:document.getElementById('folder_id').value=0;setReq('reqtype_sp', true, 'reqtype', 'showomy', true, false, 'showoul', true, false, 'event_id', true, false, 'folder_id', true, false)\" class=\"insidesmlink\">".TXT_ALL."</a>";
        echo "<b>/</b>";
        if($_REQUEST['folder_id']!="all" && $_REQUEST['folder_id']!="0"){
          sp_folderLink($_REQUEST['folder_id'], "2");
        }
        
        echo "</td><td>";
        
        $query = "SELECT * FROM `folder` WHERE `folder_id` = '".$folder_id."'";
        $result = mysql_query($query);
        while($folder = mysql_fetch_object($result)){
          echo "<a href=\"javascript:document.getElementById('folder_id').value=".$folder->id.";setReq('reqtype_sp', true, 'reqtype', 'showomy', true, false, 'showoul', true, false, 'event_id', true, false, 'folder_id', true, false)\" class=\"insidesmlink\">".$folder->name."</a><br/>";
        }
        
        echo "</TD></tr>";
        echo "</table>";
       ?>
      
      <select id="doc_id">
      <?php
      if(!isset($_REQUEST['showomy'])){
        $where = "'1'";
      }elseif($_REQUEST['showomy']=="true"){
        $where = "`doc_author`.`user_id` = '".USER_ID."'";
      }else{
        echo $_REQUEST['showomy'];
        $where = "'1'";
      }
      
      $where .= " and `doc_folder`.`folder_id` = '".$_REQUEST['folder_id']."'";
                  
      $query = "SELECT `doc`.* FROM `doc`, `doc_author`, `doc_folder` WHERE `doc`.`id` = `doc_folder`.`doc_id` and `doc`.`id` = `doc_author`.`doc_id` and ".$where." ORDER BY `name`";
      $result = mysql_query($query);
      while($doc = mysql_fetch_object($result)){
        $notshow=false;
        if(!isset($_REQUEST['showoul'])){
          $_REQUEST['showoul']="false";
        }
        if($_REQUEST['showoul']=="true"){
          $query2 = "SELECT `id` FROM `event_doc` WHERE `doc_id` = '".$doc->id."'";
          $result2 = mysql_query($query2);
          if(mysql_num_rows($result2)!="0"){
            $notshow=true;
          }
        }
        if(!isset($doclist[$doc->id]) && !$notshow){
          echo "<option value=\"".$doc->id."\">".$doc->name."</option>";
          $doclist[$doc->id] = true;
        }
      }
      ?>
      </select>
      <input type="hidden" id="reqtype_db" value="linkdoc">
      <input type="hidden" id="event_id" value="<?php echo $_REQUEST['event_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('doc_id', true, false, 'sendemail', true, false, 'reqtype_db', true, 'reqtype', 'event_id', true, false)"><?php echo TXT_ADD;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "150";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_addDoc_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){

    echo "207";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    ?>
    
    <center>
    
    <h2><?php echo TXT_ADDDOC; ?></h2>
    <iframe name="UPRESULT" id="UPRESULT" width=250 height=75 frameborder=0>&nbsp;</iframe><br/><br/>
    <form target="UPRESULT" id="uploadform" enctype="multipart/form-data" method=post action="uploaddoc.php">
    <b><?php echo TXT_NAME; ?> : </b><input type="text" name="file_name"><br/><br/>
    <input type="file" name="file">
    <input type="hidden" name="reqtype_db" value="adddoc">
    <input type="hidden" name="key" value="<?php echo $_COOKIE['adhmidsuser'];?>">
    </form>
    
    <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:document.getElementById('uploadform').submit()"><?php echo TXT_UPLOAD;?></a>
    
    </center>
    
    <?php
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "350";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "300";
    
  }else{
    echo "206";
  }
  
}

function req_addAuthor_form($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['event_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_ADDAUTHOR; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <select id="author_id">
      <?php
      $query = "SELECT `user`.*, `user_profile`.`forename`, `surname`, `access_right_g`.`group_id`, `page_id`, `right` FROM `user`, `user_profile`, `access_right_g` WHERE (`access_right_g`.`right`='6' or `access_right_g`.`right`='5') and `access_right_g`.`page_id`='".get_TypeToPage($event->type)."' and `access_right_g`.`group_id`=`user`.`group_id` and `user_profile`.`user_id`=`user`.`id`";
      $result = mysql_query($query);
      while($user = mysql_fetch_object($result)){
        echo "<option value=".$user->id.">".$user->forename." ".$user->surname."</option>";
      }
      ?>
      </select>
      <input type="hidden" id="reqtype_db" value="addauthor">
      <input type="hidden" id="event_id" value="<?php echo $_REQUEST['event_id'];?>">
      </form>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('author_id', true, false, 'reqtype_db', true, 'reqtype', 'event_id', true, false)"><?php echo TXT_ADD;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_addEvent_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($_REQUEST['event_type'])."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    echo "207";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    ?>
    
    <center>
    
    <h2><?php echo get_addEventTxt($_REQUEST['event_type']); ?></h2>
    <form method=post action="#" onsubmit="return false">
    <table>
    <tr><td valign=center align=right><b><?php echo TXT_EVENTTITLE; ?> : </b><input type="text" id="event_title" size="60"><br/>
    <?php echo TXT_ROOM; ?> : <input type="text" id="event_room" size="30">
    <input type="hidden" id="reqtype" value="addevent"><input type="hidden" id="event_type" value="<?php echo $_REQUEST['event_type']?>"></td>
    <td style="padding-left:20px;">
    <table>
    <tr><td><b><?php echo TXT_FROM; ?> : </b></td><td><?php sp_setTimeOptionsHH('btimehh'); sp_setTimeOptionsMM('btimemm'); ?><br/></td></tr>
    <tr><td><b><?php echo TXT_TO; ?> : </b></td><td><?php sp_setTimeOptionsHH('etimehh'); sp_setTimeOptionsMM('etimemm'); ?></td>
    </tr>
    </table>
    </td>
    <?php if(get_ectsStatus($_REQUEST['event_type'])){?>
    <td style="padding-left:20px;"><b><?php echo TXT_ECTS;?></b><br/><input type="text" size=3 id="ects"></td>
    <?php }else{echo "<input type=hidden id=\"ects\" value=\"\">";} ?>
    </tr>
    </table>
    <table>
    <tr><td><p><b><?php echo TXT_DATE; ?> : </b><input type="text" id="event_date" size="10"><button id="trigger">...</button></p>
    </td>
    <td>&nbsp;&nbsp;&nbsp;<b><?php echo TXT_REPEAT; ?> : </td>
    <td>
      </b><input onchange="checkRepeatUntil();" type=radio value=0 id="typerepeat" name="typerepeat" checked="checked"> <?php echo TXT_NOREPEAT; ?><br/>
      </b><input onchange="checkRepeatUntil();" type=radio value=1 id="typerepeat" name="typerepeat"> <?php echo TXT_DAYREPEAT; ?><br/>
      </b><input onchange="checkRepeatUntil();" type=radio value=2 id="typerepeat" name="typerepeat"> <?php echo TXT_WEEKREPEAT; ?><br/>
    </td>
    <td align=center>
    <div id="until" style="display:none;">
    &nbsp;&nbsp;&nbsp;<b><?php echo TXT_UNTIL; ?> </b>
    <input type="text" id="until_date" size="10"><button id="trigger2">...</button></div>
    <div id="skipwediv" style="display:none;">
    <input type="checkbox" id="skipwe" value="1" checked="checked"> <?php echo TXT_SKIPWE; ?>
    </div>
    </td>
    </tr>
    </table>
    <table>
    <tr><td>
    <b><?php echo TXT_SHDESC; ?> : </b><br/><?php echo TXT_400CHAR; ?></td><td><textarea id="sh_desc" cols=80 rows=4></textarea><br/>
    </td></tr><tr><td>
    <b><?php echo TXT_DESC; ?> : </b></td><td><textarea id="desc" cols=80 rows=10></textarea>
    </td></tr>
    </table>
    </form>
    
    <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('event_room', false, false, 'event_type', true, false, 'event_title', true, false, 'reqtype', true, false, 'event_date', false, false, 'typerepeat', true, false, 'until_date', false, false, 'skipwe', true, false, 'sh_desc', false, false, 'desc', false, false, 'btimehh', true, false, 'etimehh', true, false, 'btimemm', true, false, 'etimemm', true, false, 'ects', false, false)"><?php echo TXT_ADD;?></a>
    
    </center>
    
    <?php
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "850";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "550";
    
  }else{
    echo "206";
  }
  
}

function req_activateuser_conf($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){
  
      $query = "SELECT * FROM user_profile WHERE user_id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user_profile = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_ACTIVATEUSER; ?></h2>
      <h3><?php echo $user_profile->forename." ".$user_profile->surname;?></h3>
      <p><?php echo TXT_WARNING_ACTUSER; ?></p>
      
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:custRequest('reqtype=activateuser&user_id=<?php echo $_REQUEST['user_id']; ?>')"><?php echo TXT_ACTIVATE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "220";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_remPage_conf($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['pagech_id'])){
  
      $query = "SELECT * FROM page WHERE id = '".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      $page = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_DELETEPAGE; ?></h2>
      <h3><?php echo $page->name;?></h3>
      <p><?php echo TXT_WARNING_DELETEPAGE; ?></p>
      
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:custRequest('reqtype=removePage&pagech_id=<?php echo $_REQUEST['pagech_id']; ?>')"><?php echo TXT_DELETE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_remDoc_conf($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6", false, $_REQUEST['doc_id'])){
    if(isset($_REQUEST['doc_id'])){
  
      $query = "SELECT * FROM doc WHERE id = '".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
      $doc = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_DELETEDOC; ?></h2>
      <h3><?php echo $doc->name;?></h3>
      <p><?php echo TXT_WARNING_DELETEDOC; ?></p>
      
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:custRequest('reqtype=removeDoc&doc_id=<?php echo $_REQUEST['doc_id']; ?>')"><?php echo TXT_DELETE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_remEvent_conf($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){
    if(isset($_REQUEST['event_id'])){
  
      $query = "SELECT * FROM page WHERE id = '".$_REQUEST['event_id']."'";
      $result = mysql_query($query);
      $event = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_DELETEEVENT; ?></h2>
      <h3><?php echo $page->name;?></h3>
      <p><?php echo TXT_WARNING_DELETEEVENT; ?></p>
      
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:custRequest('reqtype=removeEvent&event_id=<?php echo $_REQUEST['event_id']; ?>')"><?php echo TXT_DELETE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_remEvType_conf($user){
  
  $query = "SELECT * FROM `page` WHERE id='".EVENTTYPE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page)>="6"){
    if(isset($_REQUEST['evtype_id'])){
  
      $query = "SELECT * FROM event_type WHERE id = '".$_REQUEST['evtype_id']."'";
      $result = mysql_query($query);
      $event_type = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_DELETEEVTYPE; ?></h2>
      <h3><?php echo $event_type->name;?></h3>
      <?php echo TXT_NEWEVTYPE; ?><br/>
      <select id="nevtype_id">
      <?php
      $query = "SELECT * FROM event_type WHERE id != '".$_REQUEST['evtype_id']."'";
      $result = mysql_query($query);
      while($event_type = mysql_fetch_object($result)){
        echo "<option value=\"".$event_type->id."\">".$event_type->name."</option>";
      }
      ?>
      </select>
      <input type=hidden id="reqtype" value="remevtype">
      <input type=hidden id="evtype_id" value="<?php echo $_REQUEST['evtype_id'];?>"><br/><br/>
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('reqtype', true, false, 'evtype_id', true, false, 'nevtype_id', true, false)"><?php echo TXT_DELETE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "220";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_remUser_conf($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){
  
      $query = "SELECT * FROM user_profile WHERE user_id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user_profile = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_DELETEUSER; ?></h2>
      <h3><?php echo $user_profile->forename." ".$user_profile->surname;?></h3>
      <p><?php echo TXT_WARNING_DELETEUSER; ?></p>
      
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:custRequest('reqtype=removeUser&user_id=<?php echo $_REQUEST['user_id']; ?>')"><?php echo TXT_DELETE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_disactivateuser_conf($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){
  
      $query = "SELECT * FROM user_profile WHERE user_id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user_profile = mysql_fetch_object($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_DISACTIVATEUSER; ?></h2>
      <h3><?php echo $user_profile->forename." ".$user_profile->surname;?></h3>
      <p><?php echo TXT_WARNING_DISACTUSER; ?></p>
      
      
      <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:custRequest('reqtype=disactivateuser&user_id=<?php echo $_REQUEST['user_id']; ?>')"><?php echo TXT_DISACTIVATE;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "200";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_addUser_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    echo "207";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    ?>
    
    <center>
    
    <h2><?php echo TXT_ADD_USER_FT; ?></h2>
    <form method=post action="#" onsubmit="return false">
    <?php
    $u_profile['id'] = false;
    sp_profileTable($u_profile, "6", 'user_fields', 'adduser');
    
    ?><a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a><?php
    
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "620";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "480";
    
  }else{
    echo "206";
  }
  
}

function req_renameGroup($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERGROUPS_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['group_id']) && isset($_REQUEST['group_name'])){
      
      $query = "UPDATE `group` SET `name`='".$_REQUEST['group_name']."' WHERE id = '".$_REQUEST['group_id']."'";
      $result = mysql_query($query);
      
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERGROUPS_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_renameDoc($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6", false, $_REQUEST['doc_id'])){
    if(isset($_REQUEST['doc_id']) && isset($_REQUEST['doc_name'])){
      
      $query = "UPDATE `doc` SET `name`='".$_REQUEST['doc_name']."' WHERE id = '".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
      
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo DOCUMENT_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_removeDate($user){
  
  $query = "SELECT `event_id` FROM `event_date` WHERE id='".$_REQUEST['date_id']."'";
  $result = mysql_query($query);
  $eventd = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `event` WHERE id='".$eventd->event_id."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['date_id'])){
      $query = "SELECT event_id FROM event_date WHERE id = '".$_REQUEST['date_id']."'";
      $result = mysql_query($query);
      $event_id = mysql_fetch_object($result);

      $query = "DELETE FROM `event_date` WHERE `id` = ".$_REQUEST['date_id'];
      $result = mysql_query($query);

      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$event_id->event_id."&edit_ev=1";
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_remInsc($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){
    if(isset($_REQUEST['event_id']) && isset($_REQUEST['user_id'])){

      $query = "DELETE FROM `event_insc` WHERE `event_id` = '".$_REQUEST['event_id']."' and `user_id` = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);

      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$event->id."&man_ev=1";
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_remTest($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){
    if(isset($_REQUEST['test_id'])){

      $query = "DELETE FROM `test` WHERE `id` = '".$_REQUEST['test_id']."'";
      $result = mysql_query($query);

      $query = "DELETE FROM `test_note` WHERE `event_id` = '".$_REQUEST['event_id']."'";
      $result = mysql_query($query);

      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$event->id."&man_ev=1";
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_removeAuthor($user){
  
  $query = "SELECT event_id FROM event_author WHERE id = '".$_REQUEST['author_id']."'";
  $result = mysql_query($query);
  $event_id = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `event` WHERE id='".$event_id->event_id."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['author_id'])){
      $query = "SELECT event_id FROM event_author WHERE id = '".$_REQUEST['author_id']."'";
      $result = mysql_query($query);
      $event_id = mysql_fetch_object($result);

      $query = "DELETE FROM `event_author` WHERE `id` = ".$_REQUEST['author_id'];
      $result = mysql_query($query);

      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$event_id->event_id."&edit_ev=1";
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_removePage($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['pagech_id'])){
  
      $query = "SELECT * FROM page WHERE id = '".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      $pagerm = mysql_fetch_object($result);

      $query = "DELETE FROM `page` WHERE `id` = ".$_REQUEST['pagech_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `page_automail` WHERE `page_id` = ".$_REQUEST['pagech_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `page_content` WHERE `page_id` = ".$_REQUEST['pagech_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `access_right_g` WHERE `page_id` = ".$_REQUEST['pagech_id'];
      $result = mysql_query($query);
      
      if($page->menu_level=="1"){

        $query = "UPDATE `page` SET submenu_attach='0' WHERE `submenu_attach` = ".$_REQUEST['pagech_id'];
        $result = mysql_query($query);
        
        sp_recheckPagePos();
        
      }else{
        sp_recheckPagePos($pagerm->submenu_attach);
      }

      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EDITMENU_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_removeDoc($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6", false, $_REQUEST['doc_id'])){
    if(isset($_REQUEST['doc_id'])){
  
      $query = "SELECT * FROM doc WHERE id = '".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
      $doc = mysql_fetch_object($result);

      $query = "DELETE FROM `doc` WHERE `id` = ".$_REQUEST['doc_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `doc_author` WHERE `doc_id` = ".$_REQUEST['doc_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `event_doc` WHERE `doc_id` = ".$_REQUEST['doc_id'];
      $result = mysql_query($query);
      
      unlink('upload/doc/'.$doc->file.'.'.$doc->ext);

      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo DOCUMENT_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_removeEvent($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['event_id'])){
  
      $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
      $result = mysql_query($query);
      $eventrm = mysql_fetch_object($result);

      $query = "DELETE FROM `event` WHERE `id` = ".$_REQUEST['event_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `event_date` WHERE `event_id` = ".$_REQUEST['event_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `event_author` WHERE `event_id` = ".$_REQUEST['event_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `event_insc` WHERE `event_id` = ".$_REQUEST['event_id'];
      $result = mysql_query($query);
  
      $query = "SELECT * FROM test WHERE `event_id` = ".$_REQUEST['event_id'];
      $result = mysql_query($query);
      while($test = mysql_fetch_object($result)){

        $query = "DELETE FROM `test` WHERE `id` = ".$test->id;
        $result = mysql_query($query);

        $query = "DELETE FROM `test_note` WHERE `test_id` = ".$test->id;
        $result = mysql_query($query);
        
      }
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EVENTDIS_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_disableEvent($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['event_id'])){

      $query = "UPDATE `event` SET `disable` = '1' WHERE `id` = ".$_REQUEST['event_id'];
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_enableEvent($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['event_id'])){

      $query = "UPDATE `event` SET `disable` = '0' WHERE `id` = ".$_REQUEST['event_id'];
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EVENTDIS_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_removeEvType($user){
  
  $query = "SELECT * FROM page WHERE id = '".EVENTTYPE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['evtype_id']) && isset($_REQUEST['nevtype_id'])){
  
      $query = "SELECT * FROM event_type WHERE id = '".$_REQUEST['evtype_id']."'";
      $result = mysql_query($query);
      $event_type = mysql_fetch_object($result);
      
      $query = "SELECT * FROM `page` WHERE id = '".$event_type->page_id."'";
      $result = mysql_query($query);
      $etpage = mysql_fetch_object($result);

      $query = "DELETE FROM `event_type` WHERE `id` = ".$_REQUEST['evtype_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `page` WHERE `id` = ".$etpage->id;
      $result = mysql_query($query);
      
      if($etpage->menu_level=="1"){
        sp_recheckPagePos();
      }else{
        sp_recheckPagePos($etpage->submenu_attach);
      }
      
      $query = "UPDATE `event` SET `type`='".$_REQUEST['nevtype_id']."' WHERE `type` = ".$_REQUEST['evtype_id'];
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EVENTTYPE_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_removeUser($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){

      $query = "DELETE FROM `user` WHERE `id` = ".$_REQUEST['user_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `user_profile` WHERE `user_id` = ".$_REQUEST['user_id'];
      $result = mysql_query($query);

      $query = "DELETE FROM `log` WHERE `user_id` = ".$_REQUEST['user_id'];
      $result = mysql_query($query);

      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERLIST_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_renameGroup_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERGROUPS_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['group_id'])){
  
      $query = "SELECT * FROM `group` WHERE id = '".$_REQUEST['group_id']."'";
      $result = mysql_query($query);
      $group = mysql_fetch_object($result);
  
      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_RENAMEGROUP; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <input type="text" id="group_name" value="<?php echo $group->name;?>">
      <input type="hidden" id="reqtype" value="chgroupname">
      <input type="hidden" id="group_id" value="<?php echo $group->id; ?>">
      </form>
      
      <a href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> <a href="javascript:setReq('group_name', true, false, 'group_id', true, false, 'reqtype', true, false)"><?php echo TXT_RENAME;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "150";
    
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_renameDoc_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6", false, $_REQUEST['doc_id'])){
    if(isset($_REQUEST['doc_id'])){
  
      $query = "SELECT * FROM `doc` WHERE id = '".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
      $doc = mysql_fetch_object($result);
  
      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_RENAMEDOC; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <input type="text" id="doc_name" value="<?php echo $doc->name;?>">
      <input type="hidden" id="reqtype" value="renameDoc">
      <input type="hidden" id="doc_id" value="<?php echo $doc->id; ?>">
      </form>
      
      <a href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> <a href="javascript:setReq('doc_name', true, false, 'doc_id', true, false, 'reqtype', true, false)"><?php echo TXT_RENAME;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "150";
    
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_renamePage($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['pagech_id']) && isset($_REQUEST['page_name'])){
      
      $query = "UPDATE `page` SET `name`='".$_REQUEST['page_name']."' WHERE id = '".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EDITMENU_PAGE_ID;
      
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_renamePage_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['pagech_id'])){
  
      $query = "SELECT * FROM `page` WHERE id = '".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      $page = mysql_fetch_object($result);
  
      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      ?>
      
      <center>
      
      <h2><?php echo TXT_RENAMEPAGE; ?></h2>
      <form method=post action="#" onsubmit="return false">
      <input type="text" id="page_name" value="<?php echo $page->name;?>">
      <input type="hidden" id="reqtype" value="chpagename">
      <input type="hidden" id="pagech_id" value="<?php echo $page->id; ?>">
      </form>
      
      <a class="insidelink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> <a class="insidelink" href="javascript:setReq('page_name', true, false, 'pagech_id', true, false, 'reqtype', true, false)"><?php echo TXT_RENAME;?></a>
      
      </center>
      
      <?php
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "250";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "150";
    
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_chlopw_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".PROFILE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){

    echo "207";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    ?>
    
    <center>
    
    <h2><?php echo TXT_CHANGELOGIN; ?></h2>
    <form method=post action="#" onsubmit="return false">
    <b><?php echo TXT_LOGIN; ?></b><br/>
    <input type="text" id="login" value="<?php echo $user->login;?>">
    <input type="hidden" id="reqtype" value="chlopw">
    <br/><br/>
    <b><?php echo TXT_PASSWD; ?></b><br/>
    <?php echo TXT_LEAVEBLANK; ?><br/>
    <input type="password" id="pw1" value=""><br/>
    <input type="password" id="pw2" value="">
    </form>
    
    <a class="insidelink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> <a class="insidelink" href="javascript:pwmd5();setReq('login', true, false, 'pw1', false, false, 'pw2', false, false, 'reqtype', true, false);"><?php echo TXT_CHANGE;?></a>
    
    </center>
    
    <?php
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "250";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "350";
    
      
  }else{
    echo "206";
  }
  
}

function req_addsep($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){

    $query = "INSERT INTO `page` (`name`, `type`, `menu_level`, `pos`) VALUES ('-----', '4', '1', '9999')";
    $result = mysql_query($query);
    
    sp_recheckPagePos();
      
    echo "202";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo EDITMENU_PAGE_ID;
    
  }else{
    echo "206";
  }
  
}

function req_addPage_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    echo "207";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    ?>
    
    <center>
    
    <h2><?php echo TXT_ADD_PAGE; ?></h2>
    <form method=post action="#" onsubmit="return false">
    <p><?php echo TXT_NAME; ?> :</p><input type="text" id="page_name">
    <input type="hidden" id="reqtype" value="addpage">
    </form>
    
    <a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> | <a class="insidesmlink" href="javascript:setReq('page_name', true, false, 'reqtype', true, false)"><?php echo TXT_ADD;?></a>
    
    </center>
    
    <?php
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "250";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "200";
    
  }else{
    echo "206";
  }
  
}

function req_updatePage($user){
  
  $query = "SELECT * FROM page WHERE id = '".$_REQUEST['pagech_id']."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['pagech_id']) && isset($_REQUEST['pageedition'])){
      
      $query = "UPDATE page_content SET `content`='".$_REQUEST['pageedition']."' WHERE page_id = '".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo $_REQUEST['pagech_id'];
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_chlopw($user){
  
  $query = "SELECT * FROM page WHERE id = '".PROFILE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['login']) && isset($_REQUEST['pw1']) && isset($_REQUEST['pw2'])){
      
      if($_REQUEST['pw1']!=$_REQUEST['pw2']){
        echo "210";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      }else{
        
        if($_REQUEST['pw1']=="d41d8cd98f00b204e9800998ecf8427e" || strlen($_REQUEST['key'])!="32"){
          $query = "UPDATE user SET `login`='".$_REQUEST['login']."' WHERE id = '".$user->id."'";
          $result = mysql_query($query);
        }else{
          $query = "UPDATE user SET `login`='".$_REQUEST['login']."', `pw`='".$_REQUEST['pw1']."' WHERE id = '".$user->id."'";
          $result = mysql_query($query);
        }
        
        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo PROFILE_PAGE_ID;
      }
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_updateMail($user){
  
  $query = "SELECT * FROM page WHERE id = '".$_REQUEST['pagech_id']."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['pagech_id']) && isset($_REQUEST['mailedition']) && isset($_REQUEST['object']) && isset($_REQUEST['replyto'])){
      
      $query = "UPDATE page_automail SET `content`='".$_REQUEST['mailedition']."', `obj`='".$_REQUEST['object']."', `replyto_id`='".$_REQUEST['replyto']."' WHERE page_id = '".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo $_REQUEST['pagech_id'];
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_updateEvent($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6", false, $_REQUEST['event_id'])){
    if(isset($_REQUEST['event_room']) && isset($_REQUEST['btimehh']) && isset($_REQUEST['etimehh']) && isset($_REQUEST['btimemm']) && isset($_REQUEST['etimemm']) && isset($_REQUEST['event_id']) && isset($_REQUEST['sh_desc']) && isset($_REQUEST['desc']) && isset($_REQUEST['event_title'])){
      
      
      $_REQUEST['desc'] = str_replace( '%u2019'  , 'iuzehenndasd' , $_REQUEST['desc']);
      $_REQUEST['sh_desc'] = str_replace( '%u2019'  , 'iuzehenndasd' , $_REQUEST['sh_desc']);
      $_REQUEST['event_title'] = str_replace( '%u2019'  , 'iuzehenndasd' , $_REQUEST['event_title']);
      
      $_REQUEST['desc'] = unescape( $_REQUEST['desc'] );
      $_REQUEST['sh_desc'] = unescape( $_REQUEST['sh_desc'] );
      $_REQUEST['event_title'] = unescape( $_REQUEST['event_title'] );
      
      $_REQUEST['desc'] = htmlentities( $_REQUEST['desc'] );
      $_REQUEST['sh_desc'] = htmlentities( $_REQUEST['sh_desc'] );
      $_REQUEST['event_title'] = htmlentities( $_REQUEST['event_title'] );
      
      $_REQUEST['desc'] = str_replace( 'iuzehenndasd'  , '&rsquo;' , $_REQUEST['desc']);
      $_REQUEST['sh_desc'] = str_replace( 'iuzehenndasd'  , '&rsquo;' , $_REQUEST['sh_desc']);
      $_REQUEST['event_title'] = str_replace( 'iuzehenndasd'  , '&rsquo;' , $_REQUEST['event_title']);
      
      $_REQUEST['desc'] = nl2br( $_REQUEST['desc'] );
      $_REQUEST['sh_desc'] = nl2br( $_REQUEST['sh_desc'] );
      $_REQUEST['event_title'] = nl2br( $_REQUEST['event_title'] );
      
      $_REQUEST['event_title'] = addslashes( $_REQUEST['event_title'] );


      $query = "UPDATE event SET ";
      if(get_ectsStatus($event->type)){$query .= "`ects`='".$_REQUEST['ects']."', ";}
      $query .= "`room`='".$_REQUEST['event_room']."',`btime`='".$_REQUEST['btimehh'].":".$_REQUEST['btimemm']."', `etime`='".$_REQUEST['etimehh'].":".$_REQUEST['etimemm']."', `sh_desc`='".$_REQUEST['sh_desc']."', `desc`='".$_REQUEST['desc']."', `title`='".$_REQUEST['event_title']."' WHERE id = '".$_REQUEST['event_id']."'";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$_REQUEST['event_id']."&edit_ev=1";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_updateProfile($user){
  
  $query = "SELECT * FROM page WHERE id = '".PROFILE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  $missingparam=false;
  
  if(login_checkAuth($user, $page, "6")){
    foreach($_SERVER['user_fields'] as $key => $value){
      if(!isset($_REQUEST[$value[0]])){$missingparam=true;}
    }
    if(!$missingparam){
      
      $first=true;
      
      $query = "UPDATE user_profile SET ";
      foreach($_SERVER['user_fields'] as $key => $value){
        if($first){$first=false;}else{$query .= ", ";}
        $query .= "`".$value[0]."`='".$_REQUEST[$value[0]]."'";
      }
      $query .= " WHERE user_id = '".$user->id."'";
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      if(!empty($_REQUEST['this_page'])){
        echo $_REQUEST['this_page'];
      }else{
        echo PROFILE_PAGE_ID;
      }
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_updateUserDetail($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  $missingparam=false;
  
  if(login_checkAuth($user, $page, "6")){
    foreach($_SERVER['user_fields'] as $key => $value){
      if(!isset($_REQUEST[$value[0]])){$missingparam=true;}
    }
    if(!isset($_REQUEST['user_id'])){$missingparam=true;}
    if(!$missingparam){
      
      $first=true;
      
      $query = "UPDATE user_profile SET ";
      foreach($_SERVER['user_fields'] as $key => $value){
        if($first){$first=false;}else{$query .= ", ";}
        $query .= "`".$value[0]."`='".$_REQUEST[$value[0]]."'";
      }
      $query .= " WHERE user_id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      if(!empty($_REQUEST['this_page'])){
        echo $_REQUEST['this_page'];
      }else{
        echo PROFILE_PAGE_ID;
      }
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_toSubmenu($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['pagech_id']) && isset($_REQUEST['tosubmenu_id'])){
      
      if($_REQUEST['tosubmenu_id']=="0"){
        $menu_level="1";
        $query2 = "SELECT submenu_attach FROM page WHERE id = '".$_REQUEST['pagech_id']."'";
        $result2 = mysql_query($query2);
        $oldpage = mysql_fetch_object($result2);
      }else{
        $menu_level="2";
      }
      
      
      $query = "UPDATE page SET `pos`='9999', `menu_level`='".$menu_level."', `submenu_attach`='".$_REQUEST['tosubmenu_id']."' WHERE `id`='".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      
      sp_recheckPagePos();
      if(empty($oldpage)){
        sp_recheckPagePos($_REQUEST['tosubmenu_id']);
      }else{
        sp_recheckPagePos($oldpage->submenu_attach);
      }
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EDITMENU_PAGE_ID;
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "1";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addGroup($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERGROUPS_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['group_name'])){
      
      $query = "INSERT INTO `group` (`name`) VALUES ('".$_REQUEST['group_name']."')";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERGROUPS_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addFolder($user){
  
  $query = "SELECT * FROM page WHERE id = '".DOCUMENT_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['folder_name']) && isset($_REQUEST['folder_id'])){
      
      $query = "INSERT INTO `folder` (`name`, `folder_id`) VALUES ('".$_REQUEST['folder_name']."', '".$_REQUEST['folder_id']."')";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo DOCUMENT_PAGE_ID;
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "folder_id=".$_REQUEST['folder_id'];
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addEvType($user){
  
  $query = "SELECT * FROM page WHERE id = '".EVENTTYPE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['evtype_name']) && isset($_REQUEST['evtype_color']) && isset($_REQUEST['evtype_isinsc']) && isset($_REQUEST['evtype_isopen']) && isset($_REQUEST['evtype_isects']) && isset($_REQUEST['evtype_isprio']) && isset($_REQUEST['evtype_istest']) && isset($_REQUEST['evtype_manev'])){
      
      if($_REQUEST['evtype_istest']=="true"){
        $_REQUEST['evtype_istest']=1;
      }elseif($_REQUEST['evtype_istest']=="false"){
        $_REQUEST['evtype_istest']=0;
      }
      if($_REQUEST['evtype_isprio']=="true"){
        $_REQUEST['evtype_isprio']=1;
      }elseif($_REQUEST['evtype_isprio']=="false"){
        $_REQUEST['evtype_isprio']=0;
      }
      if($_REQUEST['evtype_isects']=="true"){
        $_REQUEST['evtype_isects']=1;
      }elseif($_REQUEST['evtype_isects']=="false"){
        $_REQUEST['evtype_isects']=0;
      }
      if($_REQUEST['evtype_manev']=="true"){
        $_REQUEST['evtype_manev']=1;
      }elseif($_REQUEST['evtype_manev']=="false"){
        $_REQUEST['evtype_manev']=0;
      }
      
      $query = "INSERT INTO `page` (`name`, `type`, `menu_level`, `submenu_attach`, `pos`, `auth_type`, `auth_mod`) VALUES ('".$_REQUEST['evtype_name']."', '8', '2', '".CALENDAR_PAGE_ID."', '9999', '2', '".($_REQUEST['evtype_manev']+2)."')";
      $result = mysql_query($query);

      $page_id = mysql_insert_id();
      
      sp_recheckPagePos(CALENDAR_PAGE_ID);
      
      $query = "INSERT INTO `access_right_g` (`page_id`, `group_id`, `right`) VALUES ('".$page_id."', '".$user->group_id."', '4')";
      $result = mysql_query($query);
      
      $query = "INSERT INTO `event_type` (`name`, `color`, `is_insc`, `is_open`, `is_ects`, `is_test`, `is_prio`, `page_id`) VALUES ('".$_REQUEST['evtype_name']."', '".$_REQUEST['evtype_color']."', '".$_REQUEST['evtype_isinsc']."', '".$_REQUEST['evtype_isopen']."', '".$_REQUEST['evtype_isects']."', '".$_REQUEST['evtype_istest']."', '".$_REQUEST['evtype_isprio']."', '".$page_id."')";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EVENTTYPE_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_editEvType($user){
  
  $query = "SELECT * FROM page WHERE id = '".EVENTTYPE_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['evtype_istest']) && isset($_REQUEST['evtype_id']) && isset($_REQUEST['evtype_name']) && isset($_REQUEST['evtype_color']) && isset($_REQUEST['evtype_isinsc']) && isset($_REQUEST['evtype_isopen']) && isset($_REQUEST['evtype_isects']) && isset($_REQUEST['evtype_isprio']) && isset($_REQUEST['evtype_manev'])){
      
      
      if($_REQUEST['evtype_isprio']=="true"){
        $_REQUEST['evtype_isprio']=1;
      }elseif($_REQUEST['evtype_isprio']=="false"){
        $_REQUEST['evtype_isprio']=0;
      }
      if($_REQUEST['evtype_istest']=="true"){
        $_REQUEST['evtype_istest']=1;
      }elseif($_REQUEST['evtype_istest']=="false"){
        $_REQUEST['evtype_istest']=0;
      }
      if($_REQUEST['evtype_isects']=="true"){
        $_REQUEST['evtype_isects']=1;
      }elseif($_REQUEST['evtype_isects']=="false"){
        $_REQUEST['evtype_isects']=0;
      }
      if($_REQUEST['evtype_manev']=="true"){
        $_REQUEST['evtype_manev']=1;
      }elseif($_REQUEST['evtype_manev']=="false"){
        $_REQUEST['evtype_manev']=0;
      }
      
      $query = "UPDATE `event_type` SET `name`='".$_REQUEST['evtype_name']."', `color`='".$_REQUEST['evtype_color']."', `is_insc`='".$_REQUEST['evtype_isinsc']."', `is_open`='".$_REQUEST['evtype_isopen']."', `is_prio`='".$_REQUEST['evtype_isprio']."', `is_ects`='".$_REQUEST['evtype_isects']."', `is_test`='".$_REQUEST['evtype_istest']."' WHERE `id`='".$_REQUEST['evtype_id']."'";
      $result = mysql_query($query);

      $query = "SELECT page_id FROM `event_type` WHERE id='".$_REQUEST['evtype_id']."'";
      $result = mysql_query($query);
      $event_type = mysql_fetch_object($result);
      
      $page_id = $event_type->page_id;
      
      $query = "UPDATE `page` SET `auth_mod`='".($_REQUEST['evtype_manev']+2)."', `name`='".$_REQUEST['evtype_name']."' WHERE `id`='".$page_id."'";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EVENTTYPE_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addTest($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){

    if(isset($_REQUEST['test_name']) && isset($_REQUEST['event_id'])){
      
      $query = "INSERT INTO `test` (`event_id`, `name`) VALUES ('".$_REQUEST['event_id']."', '".$_REQUEST['test_name']."')";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$_REQUEST['event_id']."&man_ev=1";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_editPond($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){

    if(isset($_REQUEST['test_pond']) && isset($_REQUEST['event_id']) && isset($_REQUEST['test_id'])){
        
      $query = "UPDATE `test` SET `pond`='".$_REQUEST['test_pond']."' WHERE `id` = '".$_REQUEST['test_id']."'";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$_REQUEST['event_id']."&man_ev=1";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_editNote($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $_REQUEST['event_id'])>="6"){

    if(isset($_REQUEST['test_note']) && isset($_REQUEST['event_id']) && isset($_REQUEST['test_id']) && isset($_REQUEST['user_id'])){
      
      $query = "SELECT * FROM `test_note` WHERE test_id='".$_REQUEST['test_id']."' and user_id='".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $note = mysql_fetch_object($result);
      
      if(empty($note)){
        
        $query = "INSERT INTO `test_note` (`test_id`, `user_id`, `note`) VALUES ('".$_REQUEST['test_id']."', '".$_REQUEST['user_id']."', '".$_REQUEST['test_note']."')";
        $result = mysql_query($query);
        
      }else{        
        $query = "UPDATE `test_note` SET `note`='".$_REQUEST['test_note']."' WHERE `test_id` = '".$_REQUEST['test_id']."' and `user_id` = '".$_REQUEST['user_id']."'";
        $result = mysql_query($query);
      }
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$_REQUEST['event_id']."&man_ev=1";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_editDate($user){
  
  $query = "SELECT * FROM event_date WHERE id = '".$_REQUEST['date_id']."'";
  $result = mysql_query($query);
  $event_date = mysql_fetch_object($result);
  
  $query = "SELECT * FROM event WHERE id = '".$event_date->event_id."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_getAuth($user, $page, false, $event->id)>="6"){

    if(isset($_REQUEST['date_id']) && isset($_REQUEST['event_date'])){
           
      $query = "UPDATE `event_date` SET `date`='".$_REQUEST['event_date']."', `room`='".$_REQUEST['date_room']."', `btime`='".$_REQUEST['btimehh'].":".$_REQUEST['btimemm'].":00', `etime`='".$_REQUEST['etimehh'].":".$_REQUEST['etimemm'].":00' WHERE `id` = '".$_REQUEST['date_id']."'";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$event_date->event_id."&edit_ev=1";
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addDate($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['event_date']) && isset($_REQUEST['event_id'])){
  
/*
      $query = "SELECT id FROM `event_date` WHERE (event_id = '".$_REQUEST['event_id']."' and date = '".$_REQUEST['event_date']."')";
      $result = mysql_query($query);
      $is_date = mysql_fetch_object($result);
         
      if(!empty($is_date)){
        echo "209";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      }else{
*/
        
        $event_id = $_REQUEST['event_id'];
              
        if($_REQUEST['typerepeat']!="0"){
          if($_REQUEST['event_date']!="" && $_REQUEST['event_date']!="0000-00-00"){
            $dtime = strtotime( $_REQUEST['event_date'] );
            $utime = 64800+(strtotime( $_REQUEST['until_date'] ));
            
            if($_REQUEST['typerepeat']=="1"){$gap="86400";}elseif($_REQUEST['typerepeat']=="2"){$gap="604800";}
            
            $dtime+=43200;
            
            for($ctime=$dtime; $ctime<=$utime; $ctime+=$gap){
              
              echo $_REQUEST['skipwe'];
              
              if(!($_REQUEST['skipwe']=="1"&&$_REQUEST['typerepeat']=="1"&&date('N', $ctime)>="6")){
              
                $date = date('Y-m-d', $ctime)."\n";
                
                $query = "INSERT INTO `event_date` (`event_id`, `date`, `room`, `btime`, `etime`) VALUES ('".$event_id."', '".$date."', '".$_REQUEST['date_room']."', '".$_REQUEST['btimehh'].":".$_REQUEST['btimemm'].":00', '".$_REQUEST['etimehh'].":".$_REQUEST['etimemm'].":00')";
                $result = mysql_query($query);
              
              }
            }
          }
        }else{
          
          $query = "INSERT INTO `event_date` (`event_id`, `date`, `room`, `btime`, `etime`) VALUES ('".$_REQUEST['event_id']."', '".$_REQUEST['event_date']."', '".$_REQUEST['date_room']."', '".$_REQUEST['btimehh'].":".$_REQUEST['btimemm'].":00', '".$_REQUEST['etimehh'].":".$_REQUEST['etimemm'].":00')";
          $result = mysql_query($query);
          
        }

        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo get_TypeToPage($event->type);
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "event_id=".$_REQUEST['event_id']."&edit_ev=1";
      //}
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addLink($user){
  

  $page = new stdClass();
  $page->id = -1 * MAINLINK_SR_ID;
  $page->name="Main links";
  $page->auth_type="2";
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['link_name']) && isset($_REQUEST['link_link'])){
          
        $query = "INSERT INTO `link` (`name`, `link`, `pos`) VALUES ('".$_REQUEST['link_name']."', '".$_REQUEST['link_link']."', '9999')";
        $result = mysql_query($query);
        
        sp_recheckLinkPos();

        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo WELCOME_PAGE_ID;

    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_remLink($user){
  

  $page = new stdClass();
  $page->id = -1 * MAINLINK_SR_ID;
  $page->name="Main links";
  $page->auth_type="2";
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['link_id'])){
        
        $query = "DELETE FROM `link` WHERE `id` = '".$_REQUEST['link_id']."'";
        $result = mysql_query($query);
        
        sp_recheckLinkPos();

        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo WELCOME_PAGE_ID;

    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_evPrio($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['event_prio']) && isset($_REQUEST['event_id']) && isset($_REQUEST['user_id']) && $_REQUEST['user_id']==USER_ID){
  
      $query = "SELECT id FROM `event_prio` WHERE (event_id = '".$_REQUEST['event_id']."' and user_id = '".$_REQUEST['user_id']."')";
      $result = mysql_query($query);
      $is_prio = mysql_fetch_object($result);
         
      if(!empty($is_prio)){
      
        $query = "UPDATE `event_prio` SET priority='".$_REQUEST['event_prio']."' WHERE (event_id = '".$_REQUEST['event_id']."' and user_id = '".$_REQUEST['user_id']."')";
        $result = mysql_query($query);
              
        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo get_TypeToPage($event->type);
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "event_id=".$_REQUEST['event_id'];
        
      }else{
      
        $query = "INSERT INTO `event_prio` (`event_id`, `user_id`, `priority`) VALUES ('".$_REQUEST['event_id']."', '".$_REQUEST['user_id']."', '".$_REQUEST['event_prio']."')";
        $result = mysql_query($query);
                      
        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo get_TypeToPage($event->type);
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "event_id=".$_REQUEST['event_id'];
      }
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_linkDoc($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['doc_id']) && isset($_REQUEST['event_id']) && isset($_REQUEST['sendemail'])){
  
      $query = "SELECT id FROM `event_doc` WHERE (event_id = '".$_REQUEST['event_id']."' and doc_id = '".$_REQUEST['doc_id']."')";
      $result = mysql_query($query);
      $is_doc = mysql_fetch_object($result);
         
      if(!empty($is_doc)){
        echo "209";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      }else{
      
        $query = "INSERT INTO `event_doc` (`event_id`, `doc_id`) VALUES ('".$_REQUEST['event_id']."', '".$_REQUEST['doc_id']."')";
        $result = mysql_query($query);
        
        if($_REQUEST['sendemail']=="true"){
          
          if(defined('MAIN_URL')){
            $url = MAIN_URL;
          }else{$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
            $url = substr  ( $url  , "0"  , (strrpos($url, "/")+1));
          }

          $query = "SELECT * FROM doc WHERE id = '".$_REQUEST['doc_id']."'";
          $result = mysql_query($query);
          $doc = mysql_fetch_object($result);
  
          $data['event_title'] = $event->title;
          $data['doc_name'] = $doc->name;
          $data['link'] = "<a href=\"".$url."upload/doc/".$doc->file.".".$doc->ext."\">".$doc->name."</a>";
          
          $studlist = get_evStudents($event->id);
          
          $students = "";
          
          foreach($studlist as $key => $value){
            $query = "SELECT * FROM `user_profile` WHERE user_id = '".$value."'";
            $result = mysql_query($query);
            $uprof = mysql_fetch_object($result);
            
            $students .= $uprof->email.";";
          }
          
          mail_sendMail($students, NEWDOCMAIL_PAGE_ID, $data);
        }
              
        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo get_TypeToPage($event->type);
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "event_id=".$_REQUEST['event_id']."&man_ev=1";
      }
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_choiceTable($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['event_id'])){
      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
  
      $query = "SELECT * FROM `event` WHERE `id` = '".$_REQUEST['event_id']."'";
      $result = mysql_query($query);
      $event = mysql_fetch_object($result);
  
      $query = "SELECT * FROM `event_type` WHERE `id` = '".$event->type."'";
      $result = mysql_query($query);
      $event_type = mysql_fetch_object($result);

      echo "<table align=center width=100%>";

      echo "<tr><td>&nbsp;</td>";
      
      $n=1;
      
      $query2 = "SELECT * FROM `event` WHERE `type` = '".$event->type."'";
      $result2 = mysql_query($query2);
      while($evl = mysql_fetch_object($result2)){
        $evtab[$n]=$evl->title;
        echo "<td><b>".$n."</b></td>";
        $n++;
      }
        
      $query = "SELECT `user`.* FROM `user`, `access_right_g` WHERE `access_right_g`.`group_id` = `user`.`group_id` and `access_right_g`.`page_id` = '".$event_type->page_id."' and `access_right_g`.`right`='2'";
      $result = mysql_query($query);
      while($user = mysql_fetch_object($result)){
        $query2 = "SELECT * FROM `user_profile` WHERE `user_id` = '".$user->id."'";
        $result2 = mysql_query($query2);
        $user_profile = mysql_fetch_object($result2);
        
        
        echo "</tr>";
        
        echo "<tr>";
        echo "<td><b>".$user_profile->forename." ".$user_profile->surname."</b></td>";
        
        $query2 = "SELECT * FROM `event` WHERE `type` = '".$event->type."'";
        $result2 = mysql_query($query2);
        while($evl = mysql_fetch_object($result2)){
          
          $query3 = "SELECT * FROM `event_insc` WHERE `user_id` = '".$user->id."' and `event_id`='".$evl->id."'";
          $result3 = mysql_query($query3);
          if(mysql_num_rows($result3)!="0"){
            echo "<td>X</td>";
          }else{
            $query3 = "SELECT * FROM `event_prio` WHERE `user_id` = '".$user->id."' and `event_id`='".$evl->id."'";
            $result3 = mysql_query($query3);
            if(mysql_num_rows($result3)!="0"){
              $prio = mysql_fetch_object($result3);
              echo "<td>".$prio->priority."</td>";
            }else{
              echo "<td>-</td>";
            }
          }
          
        }
        
        echo "</tr>";
      }
      
      echo "</table><br/><center>";
      
      foreach($evtab as $key => $value){
        echo "<b>".$key."</b> ".$value."<br/>";
      }
      
      ?><br/><a class="insidesmlink" href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a></center><?php

      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "350";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "300";

    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
}
      
function req_remlinkDoc($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['doc_id']) && isset($_REQUEST['event_id'])){
        
      $query = "DELETE FROM `event_doc` WHERE `event_id`='".$_REQUEST['event_id']."' and `doc_id`='".$_REQUEST['doc_id']."'";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($event->type);
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "event_id=".$_REQUEST['event_id']."&man_ev=1";

    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_evSub($user){
  
  $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['event_id']) && isset($_REQUEST['user_id'])){
  
      $query = "SELECT id FROM `event_insc` WHERE (event_id = '".$_REQUEST['event_id']."' and user_id = '".$_REQUEST['user_id']."')";
      $result = mysql_query($query);
      $is_insc = mysql_fetch_object($result);
         
      if(!empty($is_insc)){
        echo "209";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      }else{
      
        $query = "INSERT INTO `event_insc` (`event_id`, `user_id`) VALUES ('".$_REQUEST['event_id']."', '".$_REQUEST['user_id']."')";
        $result = mysql_query($query);
  
        $query = "SELECT * FROM event WHERE id = '".$_REQUEST['event_id']."'";
        $result = mysql_query($query);
        $event = mysql_fetch_object($result);
                            
        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo get_TypeToPage($event->type);
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "event_id=".$_REQUEST['event_id']."";
        if(isset($_REQUEST['comebevent'])){
          echo "&man_ev=1";
        }
      }
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_anounDet($user){
  
  $query = "SELECT * FROM `page` WHERE id='".ANOUN_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['anoun_id'])){

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";

      $query = "SELECT * FROM `anoun` WHERE `id`='".$_REQUEST['anoun_id']."'";
      $result = mysql_query($query);
      $anoun = mysql_fetch_object($result);
      
      $query = "SELECT * FROM `anoun_read` WHERE `anoun_id`='".$_REQUEST['anoun_id']."' and `user_id`='".USER_ID."'";
      $result = mysql_query($query);
      if(mysql_num_rows($result)=="0"){
        $query = "INSERT INTO `anoun_read` (`anoun_id`, `user_id`) VALUES ('".$_REQUEST['anoun_id']."', '".USER_ID."')";
        $result = mysql_query($query);
      }
      
      echo "<center>";
      echo "<h2>".$anoun->title."</h2>";
      echo "<hr/>";
      echo $anoun->body;
      ?><br/><br/><br/><a class="insidelink" href="javascript:checkAnoun();"><?php echo TXT_OK; ?></a><?php

      echo "</center>";
      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "350";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "300";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
  
}
      
function req_addAnoun($user){
  
  $query = "SELECT * FROM `page` WHERE id='".ANOUN_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['anoun_title']) && isset($_REQUEST['anoun_body']) && isset($_REQUEST['anoun_expire'])){
      
    $_REQUEST['anoun_body'] = htmlentities( $_REQUEST['anoun_body'] );
    $_REQUEST['anoun_title'] = htmlentities( $_REQUEST['anoun_title'] );
    
    $_REQUEST['anoun_body'] = nl2br( $_REQUEST['anoun_body'] );
    $_REQUEST['anoun_title'] = nl2br( $_REQUEST['anoun_title'] );
    
    $_REQUEST['anoun_body'] = addslashes( $_REQUEST['anoun_body'] );
    $_REQUEST['anoun_title'] = addslashes( $_REQUEST['anoun_title'] );

  
    $query = "INSERT INTO `anoun` (`title`, `body`, `expire`, `author_id`, `publish`) VALUES ('".$_REQUEST['anoun_title']."', '".$_REQUEST['anoun_body']."', '".$_REQUEST['anoun_expire']."', '".USER_ID."', NOW())";
    $result = mysql_query($query);
          
    echo "202";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo ANOUN_PAGE_ID;
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addAuthor($user){
  
  $query = "SELECT * FROM `event` WHERE id='".$_REQUEST['event_id']."'";
  $result = mysql_query($query);
  $event = mysql_fetch_object($result);
  
  $query = "SELECT * FROM `page` WHERE id='".get_TypeToPage($event->type)."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['author_id']) && isset($_REQUEST['event_id'])){
  
      $query = "SELECT id FROM `event_author` WHERE (event_id = '".$_REQUEST['event_id']."' and user_id = '".$_REQUEST['author_id']."')";
      $result = mysql_query($query);
      $is_auth = mysql_fetch_object($result);
         
      if(!empty($is_auth)){
        echo "209";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      }else{
      
        $query = "INSERT INTO `event_author` (`event_id`, `user_id`) VALUES ('".$_REQUEST['event_id']."', '".$_REQUEST['author_id']."')";
        $result = mysql_query($query);
              
        echo "202";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo get_TypeToPage($event->type);
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
        echo "event_id=".$_REQUEST['event_id']."&edit_ev=1";
      }
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addEvent($user){
  
  $query = "SELECT * FROM page WHERE id = '".get_TypeToPage($_REQUEST['event_type'])."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "5")){
    if(isset($_REQUEST['event_room']) && isset($_REQUEST['btimehh']) && isset($_REQUEST['btimemm']) && isset($_REQUEST['etimehh']) && isset($_REQUEST['etimemm']) && isset($_REQUEST['event_type']) && isset($_REQUEST['event_title']) && isset($_REQUEST['event_date']) && isset($_REQUEST['typerepeat']) && isset($_REQUEST['until_date']) && isset($_REQUEST['skipwe']) && isset($_REQUEST['sh_desc']) && isset($_REQUEST['desc'])){
      
      $_REQUEST['desc'] = htmlentities( $_REQUEST['desc'] );
      $_REQUEST['sh_desc'] = htmlentities( $_REQUEST['sh_desc'] );
      $_REQUEST['event_title'] = htmlentities( $_REQUEST['event_title'] );
      
      $_REQUEST['desc'] = nl2br( $_REQUEST['desc'] );
      $_REQUEST['sh_desc'] = nl2br( $_REQUEST['sh_desc'] );
      $_REQUEST['event_title'] = nl2br( $_REQUEST['event_title'] );
      
      $_REQUEST['event_title'] = addslashes( $_REQUEST['event_title'] );
      
      $query = "INSERT INTO `event` (`room`, `title`, `sh_desc`, `desc`, `btime`, `etime`, `type`, `ects`) VALUES ('".$_REQUEST['event_room']."', '".$_REQUEST['event_title']."', '".$_REQUEST['sh_desc']."', '".$_REQUEST['desc']."', '".$_REQUEST['btimehh'].":".$_REQUEST['btimemm']."', '".$_REQUEST['etimehh'].":".$_REQUEST['etimemm']."', '".$_REQUEST['event_type']."', '".$_REQUEST['ects']."')";
      $result = mysql_query($query);
      
      $event_id = mysql_insert_id();
      
      $query = "INSERT INTO `event_author` (`event_id`, `user_id`) VALUES ('".$event_id."', '".USER_ID."')";
      $result = mysql_query($query);
            
      if($_REQUEST['typerepeat']!="0"){
        if($_REQUEST['event_date']!="" && $_REQUEST['event_date']!="0000-00-00"){
          $dtime = strtotime( $_REQUEST['event_date'] );
          $utime = 64800+(strtotime( $_REQUEST['until_date'] ));
          
          if($_REQUEST['typerepeat']=="1"){$gap="86400";}elseif($_REQUEST['typerepeat']=="2"){$gap="604800";}
          
          $dtime+=43200;
          
          for($ctime=$dtime; $ctime<=$utime; $ctime+=$gap){
            
            if(!($_REQUEST['skipwe']=="true"&&$_REQUEST['typerepeat']=="1"&&date('N', $ctime)>="6")){
            
              $date = date('Y-m-d', $ctime)."\n";
              
              $query = "INSERT INTO `event_date` (`event_id`, `date`) VALUES ('".$event_id."', '".$date."')";
              $result = mysql_query($query);
            
            }
          }
        }
      }else{
        $query = "INSERT INTO `event_date` (`event_id`, `date`) VALUES ('".$event_id."', '".$_REQUEST['event_date']."')";
        $result = mysql_query($query);
      }
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo get_TypeToPage($_REQUEST['event_type']);
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addUser($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['email'])){
      
      $query = "INSERT INTO `user` (`login`, `level`, `group_id` ) VALUES ('".$_REQUEST['email']."', '1', '0')";
      $result = mysql_query($query);
      
      $used_id = mysql_insert_id();
      
      $query = "INSERT INTO `user_profile` (`user_id`";
      foreach($_SERVER['user_fields'] as $key => $value){
        $query .= ", `".$value[0]."`";
      }
      $query .= ") VALUES ('".$used_id."'";
      foreach($_SERVER['user_fields'] as $key => $value){
        $query .= ", '".$_REQUEST[$value[0]]."'";
      }
      $query .= ")";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERLIST_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}
      
function req_addPage($user){
  
  $query = "SELECT * FROM page WHERE id = '".EDITMENU_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['page_name'])){
      
      $query = "INSERT INTO `page` (`name`, `type`, `menu_level`, `submenu_attach`, `pos`, `auth_type`) VALUES ('".$_REQUEST['page_name']."', '2', '1', '0', '9999', '2')";
      $result = mysql_query($query);
      
      $p_id = mysql_insert_id();
      
      $query = "INSERT INTO `page_content` (`page_id`) VALUES ('".$p_id."')";
      $result = mysql_query($query);
      
      sp_recheckPagePos();
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo EDITMENU_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_charg($user){
  
  $query = "SELECT * FROM page WHERE id = '".ACCESSRIGHTS_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['group_id']) && isset($_REQUEST['pagech_id']) && isset($_REQUEST['right'])){
  
      $query = "SELECT * FROM access_right_g WHERE `group_id` = '".$_REQUEST['group_id']."' and `page_id` = '".$_REQUEST['pagech_id']."'";
      $result = mysql_query($query);
      $accri = mysql_fetch_object($result);
      
      if(empty($accri)){
        
        $query = "INSERT INTO access_right_g (`right`, `group_id`, `page_id`) VALUES ('".$_REQUEST['right']."', '".$_REQUEST['group_id']."', '".$_REQUEST['pagech_id']."')";
        $result = mysql_query($query);
        
      }else{
        
        $query = "UPDATE `access_right_g` SET `right`='".$_REQUEST['right']."' WHERE `group_id` = '".$_REQUEST['group_id']."' and `page_id` = '".$_REQUEST['pagech_id']."'";
        $result = mysql_query($query);
        
      }
          
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo ACCESSRIGHTS_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
  
}

function req_chugroup($user) {
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['group_id']) && isset($_REQUEST['user_id'])){
      
      $query = "UPDATE user SET group_id='".$_REQUEST['group_id']."'WHERE id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
            
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERLIST_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_chGroupInst($user) {
  
  $query = "SELECT * FROM page WHERE id = '".USERGROUPS_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['group_id']) && isset($_REQUEST['inst_id'])){
      
      $query = "UPDATE `group` SET inst_id='".$_REQUEST['inst_id']."' WHERE id = '".$_REQUEST['group_id']."'";
      $result = mysql_query($query);
                  
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERGROUPS_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_fakeGroup_form($user){
  
  $query = "SELECT * FROM page WHERE id = '".FAKEGROUP_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){

    echo "207";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    
    ?>
    
    <center>
    
    <h2><?php echo TXT_FAKEGROUP; ?></h2>
    <form method=post action="#" onsubmit="return false">
    <select id="group_id">
    <?php
    
    $query = "SELECT * FROM `group` WHERE '1'";
    $result = mysql_query($query);
    while($group = mysql_fetch_object($result)){
      if($group->id != $user->group_id){
        echo "<option value=\"".$group->id."\">".$group->name."</option>";
      }
    }
    
    ?>
    </select>
    <input type="hidden" id="reqtype" value="fakegroup">
    </form>
    
    <a href="javascript:hideDialogBox()"><?php echo TXT_CANCEL; ?></a> <a href="javascript:setReq('group_id', true, false, 'reqtype', true, false)"><?php echo TXT_FAKEGROUP;?></a>
    
    </center>
    
    <?php
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "250";
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    echo "150";
    
      
  }else{
    echo "206";
  }
  
}

function req_userDetail($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "4")){
    if(isset($_REQUEST['user_id'])){
      
      
      $query = "SELECT * FROM `user_profile` WHERE user_id='".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $u_profile = mysql_fetch_array($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      
      echo "<br/><center>";
      sp_profileTable($u_profile, "4", $field = 'user_fields');
      echo "<br/><a class=\"insidesmlink\" href=\"javascript:hideDialogBox()\">".TXT_OK."</a>";
      echo "</center>";
      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "400";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "400";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_userDetailEdit($user){
  
  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){
      
      
      $query = "SELECT * FROM `user_profile` WHERE user_id='".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $u_profile = mysql_fetch_array($result);

      echo "207";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      
      echo "<br/><center>";
      sp_profileTable($u_profile, "6", $field = 'user_fields', 'updateUserDetail');
      echo "<br/><a class=\"insidesmlink\" href=\"javascript:hideDialogBox()\">".TXT_CANCEL."</a>";
      echo "</center>";
      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "620";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo "450";
    
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_fakeGroup($user){

  $query = "SELECT * FROM page WHERE id = '".FAKEGROUP_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['group_id'])){
      
      login_FGCookie($user, $_REQUEST['group_id']);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo WELCOME_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_cfakeGroup($user){
  login_FGCookie($user, '0');
      
  echo "202";
  echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
  echo WELCOME_PAGE_ID;
}

function req_activateuser($user){

  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){

      $query = "SELECT * FROM user WHERE id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user = mysql_fetch_object($result);

      $query = "SELECT * FROM user_profile WHERE user_id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user_profile = mysql_fetch_object($result);
      
      $password = login_setPw($user->id);
      
      $data['login'] = $user->login;
      $data['password'] = $password;
      $data['forename'] = $user_profile->forename;
      $data['surname'] = $user_profile->surname;
      
      mail_sendMail($user_profile->email, ACTIVATIONMAIL_PAGE_ID, $data);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERLIST_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_resendMailAct($user){

  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){

      $query = "SELECT * FROM user WHERE id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user = mysql_fetch_object($result);

      $query = "SELECT * FROM user_profile WHERE user_id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user_profile = mysql_fetch_object($result);
      
      $password = login_setPw($user->id);
      
      $data['login'] = $user->login;
      $data['password'] = $password;
      $data['forename'] = $user_profile->forename;
      $data['surname'] = $user_profile->surname;
      
      mail_sendMail($user_profile->email, ACTIVATIONMAIL_PAGE_ID, $data);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERLIST_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_setInsc($user){

  $query = "SELECT * FROM page WHERE id = '".INSCRIP_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['insc_id'])){
      
      $query = "DELETE FROM `event_insc` WHERE `id` = ".$_REQUEST['insc_id'];
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo INSCRIP_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_unsetInsc($user){

  $query = "SELECT * FROM page WHERE id = '".INSCRIP_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id']) && isset($_REQUEST['event_id'])){
      
      $query = "INSERT INTO `event_insc` (`user_id`, `event_id`) VALUES ('".$_REQUEST['user_id']."', '".$_REQUEST['event_id']."')";
      $result = mysql_query($query);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo INSCRIP_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

function req_disactivateuser($user){

  $query = "SELECT * FROM page WHERE id = '".USERLIST_PAGE_ID."'";
  $result = mysql_query($query);
  $page = mysql_fetch_object($result);
  
  if(login_checkAuth($user, $page, "6")){
    if(isset($_REQUEST['user_id'])){

      $query = "SELECT * FROM user WHERE id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user = mysql_fetch_object($result);

      $query = "SELECT * FROM user_profile WHERE user_id = '".$_REQUEST['user_id']."'";
      $result = mysql_query($query);
      $user_profile = mysql_fetch_object($result);
      
      $data['forename'] = $user_profile->forename;
      $data['surname'] = $user_profile->surname;
      
      $query = "UPDATE `user` SET `pw` = '' WHERE `id` =".$user->id." ;";
      $result = mysql_query($query);

      mail_sendMail($user_profile->email, DISACTIVATIONMAIL_PAGE_ID, $data);
      
      echo "202";
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      echo USERLIST_PAGE_ID;
      
    }else{
      echo "205";
    }
  }else{
    echo "206";
  }
  
}

?>
