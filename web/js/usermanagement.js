// JavaScript Document


$(document).ready(
	function(){
		$(".moreuserdetails").css("display","none");
		$(".norecords").css("display","none");
	});
	
	
// clear all fields

$(document).ready(
	function(){
		$(".submituser .clear").click(
		function( event ) {
            event.preventDefault();
            $(".username").val('');
			$(".displayname").val('');
			$(".password").val('');
			$(".department").val('');
			$(".active").val('');
			$(".conven").val('');
        });
});

// show and hide password

$(document).ready(
	function(){
		$(".showpass").click(
		function( event ) {
            event.preventDefault();
            $(this).parent().parent().find(".uniqpass").show();
			$(this).parent().parent().find(".uniqpassstar").hide();
        });
});

$(document).ready(
	function(){
		$(".hidepass").click(
		function( event ) {
            event.preventDefault();
			$(this).parent().parent().find(".uniqpass").hide();
			$(this).parent().parent().find(".uniqpassstar").show();
        });
});

// generate username

$(document).ready(
	function(){
		$(".genuser").click(
		function( event ) {
            event.preventDefault();
			
			if($(".displayname").val() !="")
			{	
				 var myText =$(this).parent().find('.displayname').val();
				 var t= myText.split(/^([a-zA-Z]+).*\s([a-zA-Z])[a-zA-Z]+$/);
				 var temp2=t[1]+t[2];
				 var temp1=$(this).parent().find('.conven').val();
				 var temp3=temp1+"."+temp2;
				 $(".username").val(temp3);
			}
			if($(".conven").val() =="")
			{
				 var myText=$(this).parent().find('.displayname').val();
				 var t= myText.split(/^([a-zA-Z]+).*\s([a-zA-Z])[a-zA-Z]+$/);
				 var temp2=t[1]+t[2];
				 $(".username").val(temp2);
			}
        });
});

// generate password

$(document).ready(
	function(){
		$(".genpass").click(
		function( event ) {
            event.preventDefault();
			var chars = "123456789ABCDEFGHIJKLMNPQRSTUVWTZabcdefghiklmnpqrstuvwyz";
			var string_length = 8;
			var randomstring = '';
			for (var i=0; i<string_length; i++) 
			{
				var rnum = Math.floor(Math.random() * chars.length);
				randomstring += chars.substring(rnum,rnum+1);
			}
			$(".password").val(randomstring);
        });
});

// user validation

function Checkuser() 
{
	if(document.input.displayname.value=="")
   {
      alert('Please enter display name.');
      document.input.displayname.focus();
      return false;
   }
  if(document.input.username.value=="")
   {
      alert('Please enter user name.');
      document.input.username.focus();
      return false;
   }
    if(document.input.password.value=="")
   {
      alert('Please enter password.');
      document.input.password.focus();
      return false;
   }
   if(document.input.department.value=="")
   {
      alert('Please Select Department.');
      document.input.department.focus();
      return false;
   }
   //return true;
}

// update user

    $(document).ready(
	function(){
		 $(".updateuser").click(
		 function( event ) {
            event.preventDefault();
			$("#viewuser").css("display","none");
			$("#updateuser").css("display","block");
             var temp=$(this).parent().parent().find('.unidisname').text();
             $(".displayname").val(temp);
			 var temp=$(this).parent().parent().find('.unicenter').text();
             $(".conven").val(temp);
			 var temp=$(this).parent().parent().find('.uniquser').text();
             $(".username").val(temp);
			 var temp=$(this).parent().parent().find('.uniqpass').text();
             $(".password").val(temp);
			 var temp=$(this).parent().parent().find('.unidept').text();
             $(".department").val(temp);
			 var temp=$(this).parent().parent().find('.uniactive').text();
			 if(temp == "Y")
			 {
             	$(".disacts").val(temp).attr('checked','checked');
			 }
			 else
			 {
				 $(".disact").val(temp).attr('checked','checked');
			 }
	});
});

// ajax call to disable user
  
$(document).ready(
	function(){
		$(".disableuser").click(
		function( event ) {
            event.preventDefault(); 
			var userdata=$(this).parent().parent().find(".uniquser").text();									
			var bdata="udata="+userdata;
			$.ajax({
			   type: "POST",
			   url: "viewuser.php",
			   data: bdata,
			   async: true,
			   success: function(data)
						{
							alert("User Disabled");
							window.location.href ='viewuser.php';
						}
				}); 
	   });
	   
   });	 

// ajax call to enable user

$(document).ready(
	function(){
		$(".enableuser").click(
		function( event ) {
            event.preventDefault(); 
			var userdata=$(this).parent().parent().find(".uniquser").text();									
			var bdata="edata="+userdata;
			$.ajax({
			   type: "POST",
			   url: "viewuser.php",
			   data: bdata,
			   async: true,
			   success: function(data)
						{
							alert("User Enabled");
							window.location.href ='viewuser.php';
						}
				}); 
	   });
   });	
   
   // display add more details in adduser.php
   
   $(document).ready(
	function(){
		$(".moredetailsimg").click(
		function( event ) {
            event.preventDefault();
			$(".moreuserdetails").css("display","block");
        });
});

  $(document).ready(
	function(){
		$(".closedetailsimg").click(
		function( event ) {
            event.preventDefault();
			$(".moreuserdetails").css("display","none");
        });
});
