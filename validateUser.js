/* 
 *validate the user information entered in the form
 */
window.onload = function(){
    loginValidate();
    validateForm();
    }





 
 var register = document.getElementById("register");
 register.onclick = function(){
	prompt("Enter Admin Password to Add user");
 };
function set(formVal)
{
    formVal.style.background ="yellow";
    
}

function reset(formVal){
      
    formVal.style.background ="white";
}
function validateForm()

{
    var digitPattern = /\d/;
    var upperCasePattern = /[A-Z]+/;
    var charPattern = /[a-z]/;
     
    
    var pwd = document.forms["createUserForm"]["user_pwd"].value;
    
    
    if(!digitPattern.test(pwd)){
        alert("Invalid!\n Password must contain a number");
    }
    else if(!upperCasePattern.test(pwd)){
        alert("Invalid! \n Password must contain a Captital Letter");
    }
    
    else if(!charPattern.test(pwd)){
        
        alert("Invalid! Password nust contain a letter");
    }
    
    else if(pwd.length < 8){
        alert("Invalid! Password must be atleast 8 char long");
        
    }
    else {return true;}
}
function loginValidate(){
    
     var pwd = document.forms["loginform"]["user_pwd"].value;
    
    var val = /((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,})/;
    
    if(!(val.test(pwd))){
        alert("Invalid Password!");
        return false;
    }
    
    
}