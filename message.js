/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.onload=function(){
	document.getElementById("compose").onclick= compose_message;
        document.getElementById("inbox").onclick= view_messages;
        //view_messages;
        //readMsg;
	//setInterval(function(){view_messages();},120000);
	
};

function compose_message(){
	console.log("The on click works");
	var compose_panel=[
		'<div id ="compose_window">',
		'<div id="new_message">',
		'<div id="header"><strong> New Message </strong></div>',
		'</div>',
		'<form>',
		'<fieldset>',
		'<strong>To</strong><br> <input type="text" id ="recipient" name="recipient" class="textfield"> <br>',
		'<strong>Subject</strong><br> <input type="text" id="subject" name="subject" class="textfield"> <br><br>',
		'<strong>Message</strong><br> <textarea  id = "msg_content" name="message_content" cols="40" rows="5"></textarea> <br>',
		'<button id="Send"> <strong> Send </strong> </button>',
		'</fieldset>',
		'</form>',
		'</div>',
		'<div id="Response"></div>'
		
	].join('');
	document.getElementById("page-content").innerHTML= compose_panel;
	document.getElementById("Send").onclick= createMessage;
        
	
}



function createMessage(){
    
    var rec = document.getElementById("recipient").value;
    var sub = document.getElementById("subject").value;
    var bod = document.getElementById("msg_content").value;
        
    new Ajax.Request("action.php",
	{
		parameters: {a:'createmessage', to:rec, subject:sub, body:bod},
		method: "get",
		onSuccess: function(data){alert(data.responseText);},
		onCreate: function(response){
			var t = response.transport;
			t.setRequestheader = t.setRequestHeader.wrap(function(original, k, v){
				if(/^(accept|accept-language|content-lanuage)$/i.test(k))
					return original(k,v);
				if(/^content-type$/i.test(k) &&
					/^ (application\/x-form-urlencoded|multipart\/form-data|text\/plain)(;.+)?$/i.text(v))
					return original(k,v);
				return;});
			}
	});
}

function view_messages()
{
	
	new Ajax.Request("action.php",
	{
		parameters: {a:'getmessage'},
		method: "get",
		onSuccess: printData,
		onCreate: function(response){
			var t = response.transport;
			t.setRequestheader = t.setRequestHeader.wrap(function(original, k, v){
				if(/^(accept|accept-language|content-lanuage)$/i.test(k))
					return original(k,v);
				if(/^content-type$/i.test(k) &&
					/^ (application\/x-form-urlencoded|multipart\/form-data|text\/plain)(;.+)?$/i.text(v))
					return original(k,v);
				return;});
			}
	});
}
function printData(data)
{
    var table = "<table border = '1' id ='table_header'><tr><th id ='header1'>FROM</th><th id ='header2'>RECIPIENT</th><th id ='header3'>SUBJECT</th></tr>";
    var response = data.responseXML;
    var message = response.getElementsByTagName("MESSAGE");
    for (var i = 0; i<message.length;i++){
        table = table +"<tr>";
        var msg_ID = message[i].getElementsByTagName("ID");
        {
            try{
                table = table+ "<td>" + msg_ID[0].firstChild.nodeValue +"</td>";
            }
            catch(er){
                table = table + "<td></td>";
            }
        }
        var recipient_id = message[i].getElementsByTagName("TO");
        { 
            try{table = table + "<td>"+ recipient_id[0].firstChild.nodeValue + "</td>";}
            catch(er){
                table = table + "<td></td>";
            }
        }
        
        var msg_content = message[i].getElementsByTagName("SUBJECT");
        {
            try{
                table = table + "<td onclick='readMsg();'>" + msg_content[0].firstChild.nodeValue+"</td>";
            }catch(er){
                table = table + "<td></td>";
            }
        }
        var pageContent = document.getElementById("page-content");
        
    }
    table = table +"</table>";
    pageContent.innerHTML = table ;
    
    
    
       // var xmlContent = 
       
        
}
    
function readMsg(){
   // var sub = document.getElementById("subject").value;
    new Ajax.Request("messageList.php",
    { 
		method: "get",
        onSuccess: getData
    });
    }	
	//$('content').replaceChild($('content').innerText,|Replace with data|);
	
function getData(data){
    var pageContent = document.getElementById("page-content");
    pageContent.innerHTML =data.responseText;
}