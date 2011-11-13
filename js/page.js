
<SCRIPT LANGUAGE="JavaScript">
<!-- 


var pages=new Array();
var pagenum=0;
var attached=true;


function pan_startmoov(event){
  if(!attached){
    dragStart(event, 'panel')
  }
}

function pan_toggle(){
  if(attached){
    pan_detach();
  }else{
    pan_attach();
  }
}

function pan_detach(){
  document.getElementById("toggle").src="img/toggle.png";
  document.getElementById("panel").style.position = 'absolute';
  document.getElementById("panel").style.top = '5%';
  document.getElementById("panel").style.left = '5%';
  attached=false;
}

function pan_attach(){
  document.getElementById("panel").style.top = 0;
  document.getElementById("panel").style.left = 0;
  document.getElementById("panel").style.position = 'relative';
  document.getElementById("toggle").src="img/toggle_r.png";
  attached=true;
}

function calendarModCheck(){
  
  var calendar_mod = document.getElementById("calendar_mod").value;
  var chboxe = document.getElementsByClassName('evtype');
  var checkedb = "";
  var first=false;
  
  for(var i=0; i<chboxe.length; i++){
    checkedb += "&";
    checkedb += chboxe[i].id;
    checkedb += "=";
    checkedb += chboxe[i].checked;
  }
  loadPage(document.this_am_page, '', '', '', 'calendar_mod='+calendar_mod+checkedb);
  
}

function checkRepeatUntil(){
  
  var repeattype = getRadioCheckedValue("repeattype");
  
  switch(repeattype){
    case "0":
      document.getElementById("until").style.display = 'none';
      document.getElementById("skipwediv").style.display = 'none';
      break;
      
    case "1":
      document.getElementById("until").style.display = 'block';
      document.getElementById("skipwediv").style.display = 'block';
      break;
      
    case "2":
      document.getElementById("until").style.display = 'block';
      document.getElementById("skipwediv").style.display = 'none';
      break;
    
  }
  
}

function getRadioCheckedValue(radio_name)
{

   var oRadio = document['forms'][0];
   for(var i = 0; i < oRadio.length; i++)
   {
      if(oRadio[i].checked)
      {
         return oRadio[i].value;
      }
   }
}

function display_error(err){
  
    alert(getTXT(err));
    
}

function loadMessage(message) {

  try{ document.getElementById("messagecontent").innerHTML = message; }
  catch(e){alert(e);}
      
}

function pwmd5(){
  document.getElementById("pw1").value = MD5(document.getElementById("pw1").value);
  document.getElementById("pw2").value = MD5(document.getElementById("pw2").value);
  
}

function custRequest(req){
    
  ajaxObject = get_ajaxObject();
  
  if(req.indexOf('page_id=') !=-1){
    ajaxObject.onreadystatechange = ajaxPageRequest;
  }else{
    ajaxObject.onreadystatechange = ajaxCustRequest;
  }
  cookvaluea = Get_Cookie("adhmidsuser");
  cookvalueb = Get_Cookie("adhmidsdb");
  
  //alert(cookvalueb);
  
  var parameters = "key="+cookvaluea+"&"+"sdb="+cookvalueb+"&"+req;
  
  ajaxObject.open("POST", "ajaxServer.php", true);
  ajaxObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajaxObject.send(parameters);
  
}

function ajaxAnounRequest(){
  if(ajaxObject.readyState == 4 && ajaxObject.status==200)
  {
    document.getElementById("anoun").innerHTML = ajaxObject.responseText;
  }
}

function checkAnoun(){
  hideDialogBox()
  
  cookvalue = Get_Cookie("adhmidsuser");
  
  ajaxObject = get_ajaxObject();
  
  ajaxObject.onreadystatechange = ajaxAnounRequest;
  
  
  cookvaluea = Get_Cookie("adhmidsuser");
  cookvalueb = Get_Cookie("adhmidsdb");
  
  request = "ajaxServer.php?key=";
  request += cookvaluea;
  request += "&sdb=";
  request += cookvalueb;
  request += "&anounrefresh=1";
  
  ajaxObject.open("GET", request, true);
  ajaxObject.send(null); 
  
  
}

function loadPage(page_id, menu_req, submenu_req, edit, adreq){
  
  hideDialogBox();
  
  showLoading();
    
  if(menu_req=='undefined'){
    menu_req=='';
  }
  if(submenu_req=='undefined'){
    submenu_req=='';
  }
  if(edit=='undefined'){
    edit=='';
  }
  
  cookvalue = Get_Cookie("adhmidsuser");
  
  ajaxObject = get_ajaxObject();
  
  ajaxObject.onreadystatechange = ajaxPageRequest;
  
  request = "ajaxServer.php?key=";
  request += cookvalue;
  request += "&page_id=";
  request += page_id;
  if(menu_req=="1"){
    request += "&menu_req=1";
  }
  if(edit=="1"){
    request += "&edit=1";
  }
  if(typeof(adreq)!="undefined"){
    request += "&"+adreq;
  }
    
  ajaxObject.open("GET", request, true);
  ajaxObject.send(null); 
  
}

function showDialogBox(code, width, height){
  
  document.getElementById("dialogbox").innerHTML = code;
  document.getElementById("dialogbox").style.display = 'block';
  
  width = document.getElementById("dialogbox").offsetWidth;
  height = document.getElementById("dialogbox").offsetHeight;
  leftmarg = (document.width - width)/2;
  topmarg = (window.innerHeight - height)/2;
  
    
  //document.getElementById("dialogbox").style.width = width;
  //document.getElementById("dialogbox").style.height = height;
  document.getElementById("dialogbox").style.left = leftmarg;
  document.getElementById("dialogbox").style.top = topmarg;
}

function hideDialogBox(){
  
  document.getElementById("dialogbox").style.display = 'none';
  document.getElementById("dialogbox").innerHTML = '&nbsp;';
  
}

function checkRegexp(){
  for(var i=0; i<arguments.length; i=i+2){
    if((arguments[i+1]!='')&&(arguments[i+1]!="undefined")){
      var regexp = new RegExp(arguments[i+1]);
      if(!regexp.test(document.getElementById(arguments[i]).value)){
          alerttxt = getTXT("302-1");
          alerttxt = alerttxt+getTXT("TXT_"+arguments[i]);
          alerttxt = alerttxt+getTXT("302-2");
          alert(alerttxt);
          document.getElementById(arguments[i]).focus()
          return false;
      }
    }
  }
  return true;
}

function setReq(){
  
  request='';
  novalue=false;
  firstarg=true;
  for(var i=0; i<arguments.length; i=i+3){
    if(arguments[i+1]){
      if(document.getElementById(arguments[i]).value == ''){
        novalue=true;
      }
    }
    
    if(!firstarg){
      request += '&';
    }
    
    if(arguments[i+2]==false){
      request += arguments[i];
    }else{
      request += arguments[i+2];
    }
    request += '='
    if(document.getElementById(arguments[i]).type!='radio'){
      if(document.getElementById(arguments[i]).type=='checkbox'){
        request += document.getElementById(arguments[i]).checked;
      }else{
        request += escape(document.getElementById(arguments[i]).value);
      }
    }else{
      request += getRadioCheckedValue('arguments[i]');
    }
    firstarg=false;
  }
  
  request += '&this_page=';
  request += document.this_am_page;
    
  if(novalue){
    display_error("301");
  }else{    
    custRequest(request);
  }
  
}


function ajaxCustRequest(){
  
  hideDialogBox();
    
  if(ajaxObject.readyState == 4 && ajaxObject.status==200)
  {
    result = ajaxObject.responseText.split("cfbd1b8e9ad1b607839f6aeff42e2c2d");

    switch(result[0])  // resultat de la requete
    {
    case "0":
      break;
    case "201":
      break;
    case "202":
      loadPage(result[1], result[2], result[3], result[4], result[5]);
      break;
    case "203":
      display_error("203");
      break;
    case "204":
      display_error("204");
      break;
    case "205":
      display_error("205");
      break;
    case "206":
      display_error("206");
      break;
    case "207":
      showDialogBox(result[1], result[2], result[3]);
      checkJsElements();
      break;
    case "209":
      display_error("209");
      break;
    case "210":
      display_error("210");
      break;
    default:
      alert(ajaxObject.responseText);
      break;
    }
    
    loadMessage('&nbsp;');

  }
  
}

function checkIsOpen(){
  if(document.getElementById('evtype_isinsc') && document.getElementById('evtype_isopen')){
    if(document.getElementById('evtype_isinsc').value=="1"){
      document.getElementById('evtype_isopen').disabled='';
    }else{
      document.getElementById('evtype_isopen').disabled='disabled';
    }
  }
}

function checkJsElements(){
  if(document.getElementById('pageedition')){
    delete CKEDITOR.instances[ 'pageedition' ];
    CKEDITOR.replace( 'pageedition',
    {
      toolbar :
      [
        { name: 'src', items : ['Source' ] },
        { name: 'clipboard', items : [ 'Undo','Redo' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','RemoveFormat' ] },
        { name: 'paragraph', items : [ 'NumberedList', 'BulletedList', '-','Outdent', 'Indent', '-','JustifyLeft','JustifyCenter', 'JustifyRight','JustifyBlock' ] },
        { name: 'links', items : [ 'Link','Unlink' ] },
        { name: 'insert', items : [ 'Image','Table','HorizontalRule','SpecialChar' ] },
        { name: 'styles', items : [ 'Styles','Format','FontSize' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'tools', items : [ 'Maximize' ] },
        { name: 'save', items : ['AjaxSave'] }
      ],
            filebrowserBrowseUrl : 'browse.php',
            filebrowserUploadUrl : 'upload.php'

    });
  }else{
    delete CKEDITOR.instances[ 'pageedition' ];
  }
  
  if(document.getElementById('mailedition')){
    delete CKEDITOR.instances[ 'mailedition' ];
    CKEDITOR.replace( 'mailedition',
    {
      toolbar :
      [
        { name: 'src', items : ['Source' ] },
        { name: 'clipboard', items : [ 'Undo','Redo' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','RemoveFormat' ] },
        { name: 'paragraph', items : [ 'NumberedList', 'BulletedList', '-','Outdent', 'Indent', '-','JustifyLeft','JustifyCenter', 'JustifyRight','JustifyBlock' ] },
        { name: 'links', items : [ 'Link','Unlink' ] },
        { name: 'insert', items : [ 'Image','Table','HorizontalRule','SpecialChar' ] },
        { name: 'styles', items : [ 'Styles','Format','FontSize' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'tools', items : [ 'Maximize' ] },
        { name: 'save', items : ['AjaxSaveMail'] }
      ],
            filebrowserBrowseUrl : 'browse.php',
            filebrowserUploadUrl : 'upload.php'

    });
  }else{
    delete CKEDITOR.instances[ 'mailedition' ];
  }
  
  if(document.getElementById('birth_date')){
    Calendar.setup(
				{
					inputField : 'birth_date',
					ifFormat
					: "%Y-%m-%d",
					button
					: "triggerbirth_date"
				}
			);
  }
  
  if(document.getElementById('event_date')){
    Calendar.setup(
				{
					inputField : 'event_date',
					ifFormat
					: "%Y-%m-%d",
					button
					: "trigger"
				}
			);
  }
  
  if(document.getElementById('until_date')){
    Calendar.setup(
				{
					inputField : 'until_date',
					ifFormat
					: "%Y-%m-%d",
					button
					: "trigger2"
				}
			);
  }
  
  if(document.getElementById('anoun_expire')){
    Calendar.setup(
				{
					inputField : 'anoun_expire',
					ifFormat
					: "%Y-%m-%d",
					button
					: "trigger"
				}
			);
  }
  
  if(document.getElementById('evtype_color')){
    var element = document.getElementById('evtype_color');
    var myPicker = new jscolor.color(element , {});
  }
}

function showLoading(){
  
  width=200;
  height=80;
  
  if(navigator.appName=="Microsoft Internet Explorer"){
    leftmarg = (document.body.offsetWidth - width)/2;
    topmarg = (document.body.offsetHeight - height)/2;
  }else{
    leftmarg = (document.width - width)/2;
    topmarg = (window.innerHeight - height)/2;
  }
    
  document.getElementById("loading").style.width = width;
  document.getElementById("loading").style.height = height;
  document.getElementById("loading").style.left = leftmarg;
  document.getElementById("loading").style.top = topmarg;
  document.getElementById("loading").style.display = 'block';
  
}

function hideLoading(){
  
  document.getElementById("loading").style.display = 'none';
  
}

function page_forw(){
  if(pagenum+1 in pages){
    document.getElementById("messagecontent").innerHTML = '&nbsp;';
    document.getElementById("pagecontent").innerHTML = pages[pagenum+1][1];
    submenu_show(pages[pagenum+1][0]);
    pagenum=pagenum+1;
    document.this_am_page = pagenum;
    checkJsElements();
    check_forw();
    check_return();
  }
}

function page_return(){
  if(pagenum-1 in pages){
    document.getElementById("messagecontent").innerHTML = '&nbsp;';
    document.getElementById("pagecontent").innerHTML = pages[pagenum-1][1];
    var id = pages[pagenum-1][0];
    pagenum=pagenum-1;
    document.this_am_page = pagenum;
    submenu_show(id);
    checkJsElements();
    check_return();
    check_forw();
  }
}

function check_return(){
  if(pagenum-1 in pages){
    document.getElementById("return").src="img/arrow-round.png";
  }else{
    document.getElementById("return").src="img/arrow-round_f.png";
  }
}

function check_forw(){
  if(pagenum+1 in pages){
    document.getElementById("forw").src="img/arrow-round_r.png";
  }else{
    document.getElementById("forw").src="img/arrow-round_r_f.png";
  }
}

function submenu_show(id){
  
  var className = 'submenudiv';
  var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
  var allElements = document.getElementsByTagName("*");
  var element;

  
  for (var i = 0; (element = allElements[i]) != null; i++) {
    var elementClass = element.className;
    if (elementClass && elementClass.indexOf(className) != -1 && hasClassName.test(elementClass))
      element.style.display = 'none';
  }
  
  var divid = "submenu"+id;
      
  if(document.getElementById(divid)){
    document.getElementById(divid).style.display = 'block';
  }
}

function ajaxPageRequest(){
    
  if(ajaxObject.readyState == 4 && ajaxObject.status==200)
  {
    hideLoading();
    
    result = ajaxObject.responseText.split("cfbd1b8e9ad1b607839f6aeff42e2c2d");

    switch(result[2])  // resultat de la requete de page
    {
    case "0":
      break;
    case "101":
      pages.splice((pagenum+1), (pages.length - pagenum));
      pages[pages.length] = new Array(result[0], result[1]);
      pagenum = pages.length-1;
      check_forw();
      check_return();
      document.getElementById("messagecontent").innerHTML = '&nbsp;';
      document.getElementById("pagecontent").innerHTML = result[1];
      document.this_am_page = result[0];
      checkJsElements();
      break;
    case "102":
      display_error("102");
      //alert(ajaxObject.responseText);
      break;
    case "104":
      display_error("104");
      break;
    case "106":
      document.getElementById("pagecontent").innerHTML = result[1];
      result[4]="0";
      break;
    default:
      result[4]="0";
      alert(ajaxObject.responseText);
      break;
    }
    

    switch(result[4])  // resultat de la requete de menu
    {
    case "0":
      break;
    case "1":
      document.getElementById("menucontent").style.display = 'block';
      document.getElementById("menulogo").style.display = 'block';
      document.getElementById("menutop").style.display = 'block';
      document.getElementById("menubot").style.display = 'block';
      document.getElementById("menucontent").innerHTML = result[3];
      submenu_show(result[0]);
      break;
    default:
      alert(ajaxObject.responseText);
      break;
    }
    try{
      document.getElementById("anoun").style.width = (document.width - 500);
    }
    catch(e){ //internet explorer ?
      document.getElementById("anoun").style.width = (document.body.offsetWidth - 500);
    }
    document.getElementById("anoun").innerHTML = result[5];
  }
  
}

//var dposition=0;
//var dmsg="VOTRE TEXTE DEFILANT";
//var dmsg="     "+dmsg;
//var dlongue=dmsg.length;
//var dfois=(70/dmsg.length)+1;
//function textdefil() {
  //document.getElementById("anoun").innerHTML=dmsg.substring(dposition,dposition+70);
  //dposition++;
  //if(dposition == dlongue) dposition=0;
    //setTimeout("textdefil()",100);
//}

//textdefil();


  floatingMenu.add('loading', { centerX: true, centerY: true, snap: false });
      
//-->
</script>
