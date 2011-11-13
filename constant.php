<?php

  include('constant_sp.php');

  // DB coordination

	define("LOGIN_PAGE_ID", "1");
	define("WELCOME_PAGE_ID", "2");
	define("EDITMENU_PAGE_ID", "5");
	define("USERGROUPS_PAGE_ID", "6");
	define("ACCESSRIGHTS_PAGE_ID", "7");
	define("PROFILE_PAGE_ID", "8");
	define("USERLIST_PAGE_ID", "12");
	define("FAKEGROUP_PAGE_ID", "15");
	define("ACTIVATIONMAIL_PAGE_ID", "18");
  define("DISACTIVATIONMAIL_PAGE_ID", "19");
  define("LOG_PAGE_ID", "23");
  define("CALENDAR_PAGE_ID", "24");
  define("RESETPW_PAGE_ID", "26");
  define("RESETPWMAIL_PAGE_ID", "27");
  define("DOCUMENT_PAGE_ID", "29");
  define("PERINFO_PAGE_ID", "33");
  define("MANINFO_PAGE_ID", "34");
  define("EVENTTYPE_PAGE_ID", "35");
  define("EVENTDIS_PAGE_ID", "44");
  define("ANOUN_PAGE_ID", "60");
  define("INSCRIP_PAGE_ID", "62");
  define("NEWDOCMAIL_PAGE_ID", "64");
  define("GETUSERLIST_PAGE_ID", "66");
  
  define("MAINLINK_SR_ID", "1");
  
  define("NB_ROW_INSTGROUP", "4");
  
  // Text variables
  
  define("TXT_NO_GROUP", "No Group");
  define("TXT_MENU_ADDGROUP", "Add Group");
  define("TXT_LOGIN", "Login");
  define("TXT_PASSWD", "Password");
  define("TXT_CONNEXION", "Connexion");
  define("TXT_PW_RESET", "Password reset");
  define("TXT_ADD_USERGROUP", "Add user group");
  define("TXT_GROUPNAME", "Group name");
  define("TXT_CANCEL", "Cancel");
  define("TXT_ADD", "ADD");
  define("TXT_NAME", "Name");
  define("TXT_NOUSERINGROUP", "No user in this group");
  define("TXT_NORIGHTS", " --- ");
  define("TXT_READ", "Read");
  define("TXT_READWRITE", "* EDIT *");
  define("TXT_UPDATE", "Update");
  define("TXT_MALE", "Male");
  define("TXT_FEMALE", "Female");
  define("TXT_COM_PHONE", "e.g. 0041 79 632 65 78");
  define("TXT_TOUPDATE", "Need update to save changes.");
  define("TXT_NOSUBM", "* Main menu *");
  define("TXT_POSITION", "");
  define("TXT_SETSUBMENU", "Set to submenu");
  define("TXT_MENU_ADDPAGE", "Add Page");
  define("TXT_ADD_PAGE", "Add Page");
  define("TXT_GROUP", "Group");
  define("TXT_NOINST", "Both institutions");
  define("TXT_NOGROUPININST", "No groups");
  define("TXT_RENAME", "Rename");
  define("TXT_RENAMEGROUP", "Rename group");
  define("TXT_RENAMEPAGE", "Rename page");
  define("TXT_MENU_ADDSEP", "Add Separator");
  define("TXT_FAKEGROUP", "Fake Group");
  define("TXT_CANCELFG", "Cancel Fake Group");
  define("TXT_DETAILS", "Details");
  define("TXT_EDIT", "Edit");
  define("TXT_OK", "OK");
  define("TXT_ADDUSER", "Add User");
  define("TXT_ADD_USER_FT", "New User");
  define("TXT_ACTIVATED", "Activated");
  define("TXT_NOTACTIVATED", "Deactivated");
  define("TXT_ACTIVATEUSER", "Activate User");
  define("TXT_DISACTIVATEUSER", "Deactivate User");
  define("TXT_WARNING_ACTUSER", "A mail will be sent to the user with his login informations. This mail can be configurated in the mail administration section.");
  define("TXT_WARNING_DISACTUSER", "WARNING : the user password will be erased. A mail will be sent to the user. This mail can be configurated in the mail administration section.");
  define("TXT_ACTIVATE", "ACTIVATE");
  define("TXT_DISACTIVATE", "DEACTIVATE");
  define("TXT_NOREPLYTO", "Undefined");
  define("TXT_OBJECT", "Object");
  define("TXT_REPLY", "Reply to");
  define("TXT_NOEVENT", "No event in this category.");
  define("TXT_EVENTTITLE", "Title");
  define("TXT_ADDEVENT", "Add Event");
  define("TXT_DATE", "Date");
  define("TXT_REPEAT", "Repeat");
  define("TXT_NOREPEAT", "Unique event");
  define("TXT_DAYREPEAT", "Day");
  define("TXT_WEEKREPEAT", "Week");
  define("TXT_UNTIL", "Until");
  define("TXT_SHDESC", "Short desc.");
  define("TXT_DESC", "Description");
  define("TXT_400CHAR", "400 char max");
  define("TXT_SKIPWE", "exclude week-ends");
  define("TXT_FROM", "From");
  define("TXT_TO", "To");
  define("TXT_TIME", "Time");
  define("TXT_TITLE", "Title");
  define("TXT_DATES", "Date(s)");
  define("TXT_REMOVE", "Remove");
  define("TXT_ADDDATE", "Add Date");
  define("TXT_DELETE", "Delete");
  define("TXT_DELETEPAGE", "Delete Page");
  define("TXT_WARNING_DELETEPAGE", "WARNING : this page and all informations about it will be definitively removed.");
  define("TXT_DELETEUSER", "Delete User");
  define("TXT_WARNING_DELETEUSER", "WARNING : this user and all informations about it will be definitively removed.");
  define("TXT_CHANGELOGIN", "Change login/password");
  define("TXT_CHANGE", "Change");
  define("TXT_LEAVEBLANK", "Leave blank for no change");
  define("TXT_ADDCOURSE", "Add Course");
  define("TXT_AUTHOR", "Author");
  define("TXT_INCHARGE", "Contact person");
  define("TXT_DELETEEVENT", "Delete Event");
  define("TXT_WARNING_DELETEEVENT", "WARNING : this event and all informations about it will be definitively removed.");
  define("TXT_RESETPW", "Reset Password");
  define("TXT_RETURN", "Return");
  define("TXT_INFORM", "Informative (only in full calendar)");
  define("TXT_INSCRI", "Inscription (inscription required)");
  define("TXT_IMPORTANT", "Important (in all personal calendars)");
  define("TXT_SUBSCRIBE", "Register");
  define("TXT_SUBSCRIBED", "Registered");
  define("TXT_MANAGE", "Administer");
  define("TXT_INSCRIPS", "Inscriptions");
  define("TXT_FULL", "Full");
  define("TXT_PERSONAL", "Personal");
  define("TXT_TESTS", "Tests");
  define("TXT_NOINSCRIP", "No inscription");
  define("TXT_NOTEST", "No test");
  define("TXT_MENU_ADDTEST", "Add Test");
  define("TXT_NA", "N/A");
  define("TXT_POND", "Ponderation");
  define("TXT_AVERAGE", "Average");
  define("TXT_ADDACT", "Add activity");
  define("TXT_NODOC", "No document available");
  define("TXT_ADDDOC", "Upload Document");
  define("TXT_UPLOAD", "Upload");
  define("TXT_RENAMEDOC", "Rename document");
  define("TXT_DELETEDOC", "Delete document");
  define("TXT_WARNING_DELETEDOC", "WARNING : this document and all informations about it will be definitively removed.");
  define("TXT_ECTS", "ECTS");
  define("TXT_LINK", "Link");
  define("TXT_NOCOURSE", "No course subscribed.");
  define("TXT_NOTES", "Notes");
  define("TXT_NONE", "* None *");
  define("TXT_COURSES", "Courses");
  define("TXT_ACTIVITIES", "Activities");
  define("TXT_NOACTIVITY", "No activity.");
  define("TXT_STUDENTS", "Students");
  define("TXT_DOCUMENTS", "Documents");
  define("TXT_LINK", "Link");
  define("TXT_ADDEVTYPE", "Add event type");
  define("TXT_NOEVTYPE", "No events type");
  define("TXT_COLOR", "Color");
  define("TXT_INSCMOD", "Inscription mode");
  define("TXT_OBLIGATORY", "Obligatory");
  define("TXT_INSC", "Inscription");
  define("TXT_ISECTS", "Use credits");
  define("TXT_ISMANEV", "Managed event");
  define("TXT_YES", "YES");
  define("TXT_NO", "No");
  define("TXT_DELETEEVTYPE", "Delete event type");
  define("TXT_NEWEVTYPE", "Select new event type for orphelin events.");
  define("TXT_ADDAUTHOR", "Add Author");
  define("TXT_STUDENT", "Student");
  define("TXT_ROOM", "Room");
  define("TXT_DISABLE", "Disable");
  define("TXT_ENABLE", "Enable");
  define("TXT_EDITDATE", "Edit Date");
  define("TXT_SPRING", "Spring");
  define("TXT_AUTUMN", "Autumn");
  define("TXT_ISPRIO", "Use Priority");
  define("TXT_PRIOCH", "Priority choice");
  define("TXT_CHOOSE", "CHOOSE");
  define("TXT_CHOICE", "choice");
  define("TXT_ISTEST", "Use test");
  define("TXT_BYCHOICE", "By choice");
  define("TXT_SHOWALL", "Show all");
  define("TXT_NOANOUN", "No anouncements for the moment.");
  define("TXT_ANOUN", "Anouncement");
  define("TXT_EXPIRE", "Expire");
  define("TXT_PUBLIED", "Published");
  define("TXT_EXPIRED", "Expired");
  define("TXT_UNREADAN", "Unread anouncement(s) : ");
  define("TXT_TABEL", "TABLE");
  define("TXT_EVTYPE", "Ev. Type");
  define("TXT_RESENDMAIL", "Reset PW");
  define("TXT_TOTAL", "TOTAL");
  define("TXT_CLOSED", "Closed");
  define("TXT_ONEWAY", "One way");
  define("TXT_OPEN", "Open");
  define("TXT_UNSUBSC", "Unsubscribe");
  define("TXT_LASTMODIF", "Last modified");
  define("TXT_EVENT", "Event");
  define("TXT_ALL", "Root");
  define("TXT_SHOWOMY", "Show only my documents.");
  define("TXT_SHOWOUL", "Show only unused documents.");
  define("TXT_SENDEMAIL", "Send email to students.");
  define("TXT_ADMIN", "Administration");
  define("TXT_MAINDB", "*** Main intranet ***");
  define("TXT_ADDFOLDER", "Add folder");
  define("TXT_MOVE", "Move");
  define("TXT_PARENTF", "Parent folder");
  define("TXT_ALLEVENTS", "All events");
  define("TXT_ALLGROUPS", "All groups");
  define("TXT_ECHO", "Normal page");
  define("TXT_EXCEL", "Excel");
  define("TXT_GENERATE", "Generate");
  define("TXT_SPLINKS", "Links");
  define("TXT_PAGES", "Pages");
  define("TXT_SPRIGHTS", "Special rights");
  define("TXT_WELCOME", "Welcome");
  define("TXT_ADDLINK", "Add link");

  define("TXT_forename", "Forename");
  define("TXT_surname", "Surname");
  define("TXT_email", "E-mail");
  define("TXT_birth_date", "Birth date");
  define("TXT_sex", "Gender");
  define("TXT_address", "Address");
  define("TXT_post_code", "Postal code");
  define("TXT_city", "City");
  define("TXT_country", "Country");
  define("TXT_phone", "Phone");
  define("TXT_mobile", "Mobile");
  
  date_default_timezone_set('Europe/Berlin');
      
  if(basename($_SERVER["PHP_SELF"]) == "index.php"){ // charge javascript constants only on client-side.
  ?>
  
  <SCRIPT LANGUAGE="JavaScript">
  <!-- 
  
  function getTXT(str){
    
    switch(str){
      
      <?php
      
      $phpconst = get_defined_constants(true);
      $userconst = $phpconst['user'];
      foreach($userconst as $key => $value){
        if(preg_match("/^TXT_/", $key)){
          $txtconst[$key] = $value;
        }
      }
      foreach($txtconst as $key => $value){
        echo "case \"".$key."\":\n";
        echo "return \"".$value."\";\n";
        echo "break;\n\n";
      }
      
      ?>
      
      case "102" :
        return "ERROR : You don't have rights to access this page or you are not connected.";
        break;
      
      case "104" :
        return "ERROR : this page seem's not to be coded yet.\nPlease contact the webmaster for more informations.";
        break;
        
      case "203" :
        return "ERROR : You are not connected.";
        break;
        
      case "204" :
        return "ERROR : Request not reconised.\nPlease contact the webmaster for more informations.";
        break;
        
      case "205" :
        return "ERROR : Parameter missing.\nPlease contact the webmaster for more informations.";
        break;
        
      case "206" :
        return "ERROR : You don't have rights to perform this request or you are not connected.";
        break;
        
      case "209" :
        return "ERROR : This is already in the database.";
        break;
        
      case "210" :
        return "ERROR : The passwords didn't match.";
        break;
        
      case "301" :
        return "ERROR : You have to fill all required fields.";
        break;
        
      case "302-1" :
        return "ERROR : The value in field \"";
        break;
        
      case "302-2" :
        return "\" is not allowed.";
        break;
        
      case "303" :
        return "ERROR : No such mail in the database.";
        break;
        
      case "304" :
        return "A mail with your new password has been sent.";
        break;
        
      default :
        return false;
      
    }
    
  }

  //-->
  </SCRIPT>
  
  <?php
  }
  
  
	define("DEBUG_LEVEL", "1");
  
  // profile fields
  
  $_SERVER['user_fields'][0] = array('forename', '1', '', '^[a-zA-Z\134s\134-]+$', '50');
  $_SERVER['user_fields'][1] = array('surname', '1', '', '^[a-zA-Z\134s\134-]+$', '50');
  $_SERVER['user_fields'][2] = array('email', '1', '', '^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$', '50');
  $_SERVER['user_fields'][3] = array('birth_date', '2', '', '');
  $_SERVER['user_fields'][4] = array('sex', '3', '', '');
  $_SERVER['user_fields'][5] = array('address', '1', '', '', '100');
  $_SERVER['user_fields'][6] = array('post_code', '1', '', '', '10');
  $_SERVER['user_fields'][7] = array('city', '1', '', '', '50');
  $_SERVER['user_fields'][8] = array('country', '1', '', '', '50');
  $_SERVER['user_fields'][9] = array('phone', '1', TXT_COM_PHONE, '', '25');
  $_SERVER['user_fields'][10] = array('mobile', '1', TXT_COM_PHONE, '', '25');

  // administration user fields

  $_SERVER['user_ad_fields'][0] = array('admission_date', '1', '', '^[0-9]{4}\134-[0-9]{2}\134-[0-9]{2}$', '');
  $_SERVER['user_ad_fields'][1] = array('admission_date', '1', '', '^[0-9]{4}\134-[0-9]{2}\134-[0-9]{2}$', '');
  

?>
