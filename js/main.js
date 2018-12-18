/* global $ */
var baserUrl = "http://jtoxmolbio/";

$(document).ready(function(){
	$('.toggleAuthorBox').click(function(){
		$('.authorInfoBoxDiv').toggle();
	});
	//show forms on demand sumbit page
	$('.formTrigger').click(function(){
		FormTrigger(this, this);
		
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
	
	//forms
	$('.paperForm1').submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		var url = baserUrl+"submit/ManInfo.php";
		ajax_request(formData, url, "ManInfo");
	});
	$('.reset-Form').click(function(e){
		e.preventDefault();
		var formData = new FormData();
		var url = baserUrl+"submit/resetforms.php";
		ajax_request(formData, url, "reset");
	});
	$('#paperForm2').submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		formData.append("submitType", "authorAddition");
		var url = baserUrl+"submit/AddAuthor.php";
		ajax_request(formData, url, "AddAuthor");
	});
	$('.uploadForm3').submit(function(e){
		e.preventDefault();
		var formData = new FormData();
		formData.append("submitType" , "completeForm3");
		var url = baserUrl+"submit/passForm3.php";
		ajax_request(formData, url, "passForm3");
	});
	$('.continueForm2').click(function(){
		var formData = new FormData();
		var cAuthor = $('.cAuthor').val();
		formData.append("cAuthor",cAuthor);
		formData.append("submitType", "continueForm2");
		var url = baserUrl+"submit/passForm2.php";
		ajax_request(formData, url, "passForm2");
	});
	//changing corresponding author
	$('.corresPondingAuthor').click(function(){
		if($(this).hasClass('glyphicon-ok-circle'))
		{
			$(this).removeClass('glyphicon-ok-circle');
			$(this).addClass('glyphicon-remove-circle');
			$('.cAuthor').val('');
		}
		else
		{
			$('.corresPondingAuthor').removeClass('glyphicon-ok-circle');
			$('.corresPondingAuthor').addClass('glyphicon-remove-circle');
			$(this).removeClass('glyphicon-remove-circle');
			$(this).addClass('glyphicon-ok-circle');
			$('.cAuthor').val($(this).attr('target'));
		}
	});
	// uploads triiger
	$('.triggerUpload').click(function(){
		var target = $(this).attr('target');
		var types = ".png, .jpg, .jpeg";
		if(target === "manuscript" || target === "cover")
		{
			types = ".docx, .doc";
		}
		$('.triggerFileOpen').attr('accept', types);
		$("form input[name='textHidden']").val(target);
		$('.triggerFileOpen').click();
		
	
		
	});
	$('.triggerFileOpen').change(function(){
		setTimeout($('.uploadFormMan').submit(),10000);
		
		
	});
	$('.uploadFormMan').submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		formData.append('submitType', "uploadFile");
		var url = baserUrl+"submit/UploadFile.php";
		ajax_request(formData, url, "uploadFile");
	});
	
	$(".paperForm4").submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		formData.append("submitType", "finalSubmition");
		var url = baserUrl+"submit/finalSubmition.php";
		ajax_request(formData, url, "finalSubmition");
	});
	
	//remove author
	$('.removeAuthor').click(function(){
		removeAuthor($(this));
	});
	//remove file
//	$('.file-remove').click(function(){
//		removeFile($(this));
//	});
});


function ajax_request(form, url, formType, base='')
{
	$('.loader-gif').css('display', 'block');
	resetProgess();
	$.ajax({
    xhr: function(){ return progressTrack();},
	type: "POST",
	url: url,
	data: form,
	contentType: false,
	processData: false,
	cache: false,
	success: function(data){successHandle(data, formType, base);},
	error: function(error){errorHandle(error);}
		
	});
	setTimeout(function(){
		$('.loader-gif').css('display', 'none');
	},2000);
	
}

function successHandle(data,regType, base='')
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
		else if(regType === "reset")
		{
			window.location.href = baserUrl+"submit";
		}
		else if(regType === "ManInfo")
		{
//			var nextForm = $('.paperForm2');
			FormTrigger('.triggerForm2', $('.triggerForm2'));
			$('.form1Approve').removeClass('glyphicon-remove-circle');
			$('.form1Approve').addClass('glyphicon-ok-sign');
			$('.form1Approve').css('color', 'green');
		}
		else if(regType === "AddAuthor")
		{
			var author = data.author;
			var isCAuthor = author.isCorresponding;
			$('.toggleAuthorBox').click();
			var cAuthor = $('.cAuthor').val();
			$("#paperForm2 input").val('');
			$("#paperForm2 select").val($("#paperForm2 option:first").val());
			$('.cAuthor').val(cAuthor);
			$("#paperForm2 input:submit").val("Add Author");
			$("#paperForm2 input:reset").val("Reset");
			var tr = "<tr> <td> "+author.authorTitle+" "+author.authorLastName;
			tr = tr+" | "+author.authorEmail+"</td>";
			var span = "";
			if(isCAuthor)
			{
				$('.corresPondingAuthor').removeClass('glyphicon-ok-circle');
				$('.corresPondingAuthor').addClass('glyphicon-remove-circle');
				span = "<span class=\"glyphicon glyphicon-ok-circle corresPondingAuthor\" onclick=\"TriggerCorresPonding(this)\" target=\""+author.authorEmail+"\"></span> ";
			} 
			else
			{
				span = "<span class=\"glyphicon glyphicon-remove-circle corresPondingAuthor\" onclick=\"TriggerCorresPonding(this)\" target=\""+author.authorEmail+"\"></span> ";
			}
			tr = tr+" <td> "+span+" </td>";
			tr = tr + "<td> <span class=\"glyphicon glyphicon-remove\" onclick=\"removeAuthor(this)\" target=\""+author.authorEmail+"\" ></span> </td> </tr>";
			$('.authorTableBody').append(tr);
			alert(tr);
		}
		else if(regType === "passForm2")
		{
			FormTrigger('.triggerForm3', $('.triggerForm3'));
			$('.form2Approve').removeClass('glyphicon-remove-circle');
			$('.form2Approve').addClass('glyphicon-ok-sign');
			$('.form2Approve').css('color', 'green');
		}
		else if(regType === "uploadFile")
		{
			var file = data.fileDetails;
			var tr = "<tr> <td>"+file.name+"</td>";
			tr = tr + "<td> "+file.cate+"</td>";
			tr = tr + "<td> uploaded </td>";
			tr = tr + "<td> <span class=\"glyphicon glyphicon-remove-sign\" onclick=\"removeFile(this)\" target=\""+file.cate+"\" data=\""+file.name+"|"+file.fileToken+"\" data-role=\"masterFile\"> </span> </td>";
			$('.manuscriptTableBody').append(tr);
			if(file.cate === "manuscript")
				$(".previewManUrl").attr("href", file.url);
		}
		else if(regType === "passForm3")
		{
			FormTrigger('.triggerForm4', $('.triggerForm4'));
			$('.form3Approve').removeClass('glyphicon-remove-circle');
			$('.form3Approve').addClass('glyphicon-ok-sign');
			$('.form3Approve').css('color', 'green');
			$(".tableReviewBody").html($('.manuscriptTableBody').html());
			$(".tableReviewBody span").attr("data-role","slaveFile");
			
		}
		else if(regType === "authorLevelAlter" || regType === "masterFile" || regType === "slaveFile")
		{
			$(base).parents("tr").remove();
			if(data.target === "figures" || data.target === "manuscript" || data.target === "cover")
			{
				$('.form3Approve').addClass('glyphicon-remove-circle');
				$('.form3Approve').removeClass('glyphicon-ok-sign');
				$('.form3Approve').css('color', 'red');
			
			}
			if(regType === "slaveFile")
			{
				$(".manuscriptTableBody").html($(".tableReviewBody").html());
				alert("slave is clicked should change master");
				$(".manuscriptTableBody span").attr("data-role", "masterFile")
			}
			else
			{
				$(".tableReviewBody").html($(".manuscriptTableBody").html());
				alert("master is clicked should change slave");
				$(".tableReviewBody span").attr("data-role", "slaveFile")
			}
		}
		else if(regType === "finalSubmition")
		{
			window.location.href=baserUrl+"tracks?sb=success&token="+data.mantoken;
//			alert("Submition success ");
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

function removeAuthor(base)
{
	var target = $(base).attr('target');
	var formData = new FormData();
	formData.append('target', target);
	var url = baserUrl+'submit/alterAuthor.php';
	formData.append('submitType', 'authorLevelAlter');
	ajax_request(formData, url, 'authorLevelAlter', base);
}
function removeFile(filer)
{
	var target = $(filer).attr('target');
	var data = $(filer).attr('data');
	var role = $(filer).attr("data-role");
	var formData = new FormData();
	var url = baserUrl+"submit/alterFile.php";
	formData.append('submitType', 'fileLevelAlter');
	formData.append('target', target);
	formData.append('data', data);
	ajax_request(formData, url, role, filer);
}
function FormTrigger(bar, formbar)
{
	var currentform = $('.currentForm');
	var currentBar = $('.currentTrigger');
	var targetForm = $(bar).attr('target');
	$(currentform).css('display','none');
	$('.'+targetForm).css('display','block');
	$(currentBar).removeClass('active');
	$(currentBar).removeClass('currentTrigger');
	$(currentform).removeClass('currentForm');
	
	$(bar).addClass('active');
	$(formbar).addClass('currentTrigger');
	$('.'+targetForm).addClass('currentForm');
}
function TriggerCorresPonding(object){
	if($(object).hasClass('glyphicon-ok-circle'))
	{
		$(object).removeClass('glyphicon-ok-circle');
		$(this).addClass('glyphicon-remove-circle');
		$('.cAuthor').val('');
	}
	else
	{
		$('.corresPondingAuthor').removeClass('glyphicon-ok-circle');
		$('.corresPondingAuthor').addClass('glyphicon-remove-circle');
		$(object).removeClass('glyphicon-remove-circle');
		$(object).addClass('glyphicon-ok-circle');
		$('.cAuthor').val($(object).attr('target'));
	}
}