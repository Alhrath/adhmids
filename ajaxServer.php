<?php

	include("sql_fonc.php");
	include("page_fonc.php");
	include("login_fonc.php");
	include("sp_fonc.php");
	include("req_fonc.php");
	include("constant.php");
  include("error_fonc.php");
  include("get_fonc.php");
  include("mail_fonc.php");
  
  sql_connect();
  
  $reqres=0;
  $mreqres=0;
  $user = login_checkKey();
			
  if(isset($_REQUEST['page_id'])){  //  ################### page request
    $query = "SELECT * FROM page WHERE id = '".$_REQUEST['page_id']."'";
    $result = mysql_query($query);
    $page = mysql_fetch_object($result);
        
    if(!isset($_REQUEST['edit'])){
      $_REQUEST['edit']="0";
    }
    
    if(isset($page->submenu_attach) && $page->submenu_attach != "0"){
      echo $page->submenu_attach;
    }elseif(isset($page->id)){
      echo $page->id;
    }
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    
    if($_REQUEST['edit']!="1"){
      if(!login_checkAuth($user, $page, "4")){
        //echo "[][][]".$user->login."[][][]";
        $reqres=102;
      }else{
        if($page->id){
          
          switch($page->type){
            
            case "1":
              if(!empty($user)){$ar = login_getAuth($user, $page);}else{$ar="0";}
              $reqres = page_fix($page, $user, $ar);
              break;
            
            case "2":
              $query = "SELECT * FROM page_content WHERE page_id = ".$_REQUEST['page_id'];
              $result = mysql_query($query);
              $content = mysql_fetch_object($result);
              
              if($page->id == WELCOME_PAGE_ID){
                echo "<table width=100%><tr><td>";
              }
              if($content->id){echo $content->content;$reqres=101;}else{$reqres=105;}
              if($page->id == WELCOME_PAGE_ID){
                echo "</td><td width=150px>";
                echo "<table width=100%>
                        <tr>
                          <td valign=\"TOP\" align=center>";
                      sp_rightBox($user);
                echo "    </td>
                        </tr>
                      </table>";
                echo "</td></tr></table>";
              }
              break;
              
            case "3":
              $resreq=107;
              break;
              
            case "7":
              $reqres = page_automail($user, $page);
              break;
              
              
            CASE "8" :
              $ar = login_getAuth($user, $page);
              if($ar>="4"){
                $query = "SELECT * FROM event_type WHERE page_id = ".$_REQUEST['page_id'];
                $result = mysql_query($query);
                $event_type = mysql_fetch_object($result);
                if(!isset($_REQUEST['event_id'])){
                  sp_eventList($event_type->id);
                }else{
                  $ar = login_getAuth($user, $page, false, $_REQUEST['event_id']);
                  if(!isset($_REQUEST['edit_ev'])){$_REQUEST['edit_ev']="false";};
                  if(($_REQUEST['edit_ev']=="1")&&($ar>="5")){
                    sp_eventEdit();
                  }elseif(isset($_REQUEST['man_ev'])&&($ar>="5")){
                    sp_eventMan();
                  }else{
                    sp_eventDetail();
                  }
                }
                $reqres = "101";
              }else{
                $reqres = "102";
              }
              break;
          }
        }else{
          $reqres=103;
        }
      }
      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      
      echo $reqres;
      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      
      if(!isset($_REQUEST['menu_req'])){
        $_REQUEST['menu_req'] = null;
      }
      
      if($user != null){
        
        echo page_menu($user, $page);
        $mreqres=1;
        
      }
      
      echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
      
      echo $mreqres;
    }else{
      if(!login_checkAuth($user, $page, "6")){
        $reqres=102;
      }else{
        if($page->type == "2"){
          $query = "SELECT * FROM page_content WHERE page_id = ".$_REQUEST['page_id'];
          $result = mysql_query($query);
          $content = mysql_fetch_object($result);
          
          if(empty($content)){$content->content = '';}
          ?>
          
          <form method="POST" action="index.php">
          <input type="hidden" id="reqtype" value="editpage">
          <input type="hidden" id="pagech_id" value="<?php echo $page->id; ?>">
          <textarea id="pageedition" name="pageedition"><?php echo $content->content ?></textarea>
          </form>
          
          <?php
                  
          echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
          echo "101";
          echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
          echo "0";
          echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
          echo "0";
        }elseif($page->type == "7"){
          $query = "SELECT * FROM page_automail WHERE page_id = ".$_REQUEST['page_id'];
          $result = mysql_query($query);
          $content = mysql_fetch_object($result);
          ?>
          
          <form method="POST" action="index.php">
          <input type="hidden" id="reqtype" value="editmail">
          <input type="hidden" id="pagech_id" value="<?php echo $page->id; ?>">
          <table width=100%>
            <tr>
              <td align=center>
                <b><?php echo TXT_OBJECT; ?></b> : <input id="object" value="<?php echo $content->obj ?>">
              </td>
              <td align=left>
                <b><?php echo TXT_REPLY; ?></b> : <select id="replyto">
                <?php sp_setReplytoOption($page->id); ?>
                </select>
              </td>
            </tr>
            <tr><td colspan=2 align=center>
              <hr/>
              <textarea id="mailedition" name="mailedition"><?php echo $content->content ?></textarea>
            </td></tr>
          </table>
          </form>
          
          <?php
                  
          echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
          echo "101";
          echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
          echo "0";
          echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
          echo "0";
        }

      }

    }
        
    echo "cfbd1b8e9ad1b607839f6aeff42e2c2d";
    sp_checkAnoun();
    
    
  }elseif(isset($_REQUEST['anounrefresh'])){
    
    if(!empty($user)){
      
      sp_checkAnoun();
      
    }
    
  }else{  // ###################  custom request
  
    if(isset($_REQUEST['key']) && strlen($_REQUEST['key'])=="32"){
      
      $query = "SELECT * FROM user WHERE skey = '".$_REQUEST['key']."'";
      $result = mysql_query($query);
      $user = mysql_fetch_object($result);
          
    }
    
    if(isset($user)){
      
      if(!isset($_REQUEST['reqtype'])){$_REQUEST['reqtype']="0";}
            
      switch($_REQUEST['reqtype']){
        
        case "switch_page_pos":
          req_switchPagePos($user);
          break;
        
        case "addgroup_form":
          req_addGroup_form($user);
          break;
        
        case "addpage_form":
          req_addPage_form($user);
          break;
        
        case "addgroup":
          req_addGroup($user);
          break;
        
        case "addpage":
          req_addPage($user);
          break;
        
        case "chugroup":
          req_chugroup($user);
          break;
        
        case "charg":
          req_charg($user);
          break;
        
        case "editpage":
          req_updatePage($user);
          break;
        
        case "editmail":
          req_updateMail($user);
          break;
        
        case "updateprofile":
          req_updateProfile($user);
          break;
        
        case "tosubmenu":
          req_toSubmenu($user);
          break;
          
        case "chgroupinst":
          req_chGroupInst($user);
          break;
          
        case "renameGroup_form":
          req_renameGroup_form($user);
          break;
          
        case "chgroupname":
          req_renameGroup($user);
          break;
          
        case "renamePage_form":
          req_renamePage_form($user);
          break;
          
        case "chpagename":
          req_renamePage($user);
          break;
          
        case "addseparator":
          req_addsep($user);
          break;
          
        case "fakegroup_form":
          req_fakeGroup_form($user);
          break;
          
        case "fakegroup":
          req_fakeGroup($user);
          break;
          
        case "cfakegroup":
          req_cfakeGroup($user);
          break;
          
        case "userdetail":
          req_userDetail($user);
          break;
          
        case "userdetailedit":
          req_userDetailEdit($user);
          break;
          
        case "adduser_form":
          req_addUser_form($user);
          break;
          
        case "addevent_form":
          req_addEvent_form($user);
          break;
          
        case "addevent":
          req_addEvent($user);
          break;
          
        case "adduser":
          req_addUser($user);
          break;
          
        case "activateuser_conf":
          req_activateuser_conf($user);
          break;
          
        case "disactivateuser_conf":
          req_disactivateuser_conf($user);
          break;
          
        case "activateuser":
          req_activateuser($user);
          break;
          
        case "disactivateuser":
          req_disactivateuser($user);
          break;
          
        case "remevdate":
          req_removeDate($user);
          break;
          
        case "updateevent":
          req_updateEvent($user);
          break;
          
        case "adddate":
          req_addDate($user);
          break;
          
        case "adddate_form":
          req_addDate_form($user);
          break;
          
        case "remPage_conf":
          req_remPage_conf($user);
          break;
          
        case "removePage":
          req_removePage($user);
          break;
          
        case "remevent_conf":
          req_remEvent_conf($user);
          break;
          
        case "removeEvent":
          req_removeEvent($user);
          break;
          
        case "userremove_conf":
          req_remUser_conf($user);
          break;
          
        case "removeUser":
          req_removeUser($user);
          break;
          
        case "chlopw_form":
          req_chlopw_form($user);
          break;
          
        case "chlopw":
          req_chlopw($user);
          break;
          
        case "remevauthor":
          req_removeAuthor($user);
          break;
          
        case "addauthor_form":
          req_addAuthor_form($user);
          break;
          
        case "addauthor":
          req_addAuthor($user);
          break;
          
        case "evsub":
          req_evSub($user);
          break;
          
        case "reminsc":
          req_remInsc($user);
          break;
          
        case "addtest_form":
          req_addTest_form($user);
          break;
          
        case "remtest":
          req_remTest($user);
          break;
          
        case "addtest":
          req_addTest($user);
          break;
          
        case "editPond_form":
          req_editPond_form($user);
          break;
          
        case "editPond":
          req_editPond($user);
          break;
          
        case "editnote_form":
          req_editNote_form($user);
          break;
          
        case "editNote":
          req_editNote($user);
          break;
          
        case "adddoc_form":
          req_addDoc_form($user);
          break;
          
        case "renameDoc_form":
          req_renameDoc_form($user);
          break;
          
        case "renameDoc":
          req_renameDoc($user);
          break;
          
        case "remDoc_conf":
          req_remDoc_conf($user);
          break;
          
        case "removeDoc":
          req_removeDoc($user);
          break;
          
        case "linkdoc_form":
          req_linkDoc_form($user);
          break;
          
        case "linkdoc":
          req_linkDoc($user);
          break;
          
        case "addevtype_form":
          req_addEvType_form($user);
          break;
          
        case "addevtype":
          req_addEvType($user);
          break;
          
        case "editevtype_form":
          req_editEvType_form($user);
          break;
          
        case "editevtype":
          req_editEvType($user);
          break;
          
        case "delevtype_conf":
          req_remEvType_conf($user);
          break;
          
        case "remevtype":
          req_removeEvType($user);
          break;
          
        case "updateUserDetail":
          req_updateUserDetail($user);
          break;
          
        case "disableevent":
          req_disableEvent($user);
          break;
          
        case "editdate_form":
          req_editDate_form($user);
          break;
          
        case "editdate":
          req_editDate($user);
          break;
          
        case "enableevent":
          req_enableEvent($user);
          break;
          
        case "evprio_form":
          req_evPrio_form($user);
          break;
          
        case "evprio":
          req_evPrio($user);
          break;
          
        case "showdates":
          req_showDates($user);
          break;
          
        case "remlinkdoc":
          req_remlinkDoc($user);
          break;
          
        case "addanoun_form":
          req_addAnoun_form($user);
          break;
          
        case "addanoun":
          req_addAnoun($user);
          break;
          
        case "anoundet":
          req_anounDet($user);
          break;
          
        case "choicetable":
          req_choiceTable($user);
          break;
          
        case "resendmail":
          req_resendMailAct($user);
          break;
          
        case "setinsc":
          req_setInsc($user);
          break;
          
        case "unsetinsc":
          req_unsetInsc($user);
          break;
          
        case "unsubsc":
          req_unsubsc($user);
          break;
          
        case "addfolder_form":
          req_addFolder_form($user);
          break;
          
        case "addfolder":
          req_addFolder($user);
          break;
          
        case "doctofolder":
          req_docToFolder($user);
          break;
          
        case "doctofolder_form":
          req_docToFolder_form($user);
          break;
          
        case "addlink_form":
          req_addLink_form($user);
          break;
          
        case "addlink":
          req_addLink($user);
          break;
          
        case "remlink":
          req_remLink($user);
          break;
          
          
        default:
          echo "204";
          break;
          
      }
      
    }else{
      
      echo "203";
      
    }
    
  }
  
  //sql_makeSDb('adhmids2', '', '');

?>
