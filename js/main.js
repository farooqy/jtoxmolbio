/* global $ */
var baserUrl = "http://jtoxmolbio/";

$(document).ready(function(){
	$('.toggleAuthorBox').click(function(){
		$('.authorInfoBoxDiv').toggle();
	});
	//show forms on demand sumbit page
	$('.formTrigger').click(function(){
		var currentform = $('.currentForm');
		var currentBar = $('.currentTrigger');
		var targetForm = $(this).attr('target');
		$(currentform).css('display','none');
		$('.'+targetForm).css('display','block');
		$(currentBar).removeClass('active');
		$(currentBar).removeClass('currentTrigger');
		$(currentform).removeClass('currentForm');
		$(this).addClass('active');
		$(this).addClass('currentTrigger');
		$('.'+targetForm).addClass('currentForm');
		
	});
	
	//on register
	$('.registerForm').submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		var country = $('.bfh-selectbox-option').text();
		formData.append('registerCountry', country);
		formData.append('registerUser', true);
		var url = baserUrl+'register/registerHandle.php';
		ajax_request(formData, url, 'register');
	});
	//on lgoin
	$('.loginForm').submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		formData.append('loginUser', true);
		var url = baserUrl+'login/handleLogin.php';
		ajax_request(formData, url, 'login');
	});
	
	//profile page
	if($('div').hasClass('profilePage'))
	{
		$('.profileDiv').css('display','none');
		var formData = new FormData();
		formData.append('requestType', 'profile');
		var url = baserUrl+'profile/getProfile.php';
		ajax_request(formData, url, 'profileGet');
	}
	$('.changeProfile').click(function(){
		var target = $(this).attr('target');
		var input  = $('.'+target).val();
		var formData = new FormData();
		formData.append("target", target);
		formData.append("value", input);
		if(target === "userPassword")
		{
			input = $('.userPasswordOld').val();
			var input_extra = $('.userPasswordNew').val();
			formData.append("value", input);
			formData.append("value_extra",input_extra);
		}
		var url = baserUrl+'profile/update.php';
		ajax_request(formData, url, 'updateProfile');
	});
});


function ajax_request(form, url, formType)
{
	resetProgess();
	$.ajax({
    xhr: function(){ return progressTrack();},
	type: "POST",
	url: url,
	data: form,
	contentType: false,
	processData: false,
	cache: false,
	success: function(data){successHandle(data, formType);},
	error: function(error){errorHandle(error);}
		
	});
}

function successHandle(data,regType)
{
	data = JSON.parse(data);
	if(data.isSuccess === false)
	{
		alert(data.errorMessage);
		processError(data.errorMessage);
	}
	else if(data.isSuccess === true)
	{
		if(regType === "register" || regType === "login")
		{
			if($('div').hasClass('redirect'))
			{
				var page = $('.redirect').attr('target');
				window.location.href = baserUrl+page;
			}
			else
			{
				window.location.href = baserUrl;
			}	
		}
		else if(regType === "profileGet")
		{
			alert("data "+JSON.stringify(data.data));
			$('.userFirstName').val(data.data.firstName);
			$('.userLastName').val(data.data.lastName);
			$('.userEmailAddress').val(data.data.email);
			$('.userInstitute').val(data.data.institution);
			$('.userDepartment').val(data.data.department);
			$('.userCountry').val(data.data.country);
			$('.userTitle').val(data.data.salutation);
			$('.profileDiv').css('display','block');
		}
		else
		{
			alert("success done");
		}
			
	}
	else
	{
		alert("error processing the request, please contact admin "+data.isSuccess);
	}
}
function errorHandle(error)
{
	$('.errorDiv').text(error.state+ " "+ error.statusText);
	$('.errorDiv').css('display',"block");
	alert(JSON.stringify("ERROR: "+error.status+" "+error.statusText));
}
function processError(message)
{
	$('.errorDiv').text(message);
	$('.errorDiv').css('display',"block");
}
function resetProgess()
{
	$('.progress').css('display','none');
	$('.progress-bar').css('width','0%');
	$('.errorDiv').css('display','none');
	$('.errorDiv').text('');
}
function progressTrack() {
	var xhr = new window.XMLHttpRequest();

	// Upload progress
	xhr.upload.addEventListener("progress",function(evt)
	{
		if (evt.lengthComputable) 
		{
			var percentComplete = Math.round((evt.
											  loaded / evt.total)*100);
			$('.progress').css('display','block');
			$('.progress-bar').css('width',percentComplete+'%');
		   	$('.progress-bar').text(percentComplete+'% Complete');

		   if(percentComplete === 100)
		   {
			   $('.progress-bar').text('Done');
		   }

		}
   }, false);

   // Download progress
   xhr.addEventListener("progress", function(evt){
	   if (evt.lengthComputable) 
	   {
		   var percentComplete = Math.round((
			 evt.loaded / evt.total)*100);
		   // Do something with download progress
			$('.progress').css('display','block');
			$('.progress-bar').css('width',percentComplete+'%');
		   	$('.progress-bar').text(percentComplete+'% Complete');

		   if(percentComplete === 100)
		   {
			   $('.progress-bar').text('Done');
		   }
	   }
   }, false);

   return xhr;
}
