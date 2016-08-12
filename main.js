(function(){
    window.onload = function () {
        var ajaxMessage = [];
        var can = true;
        var fileCollection = new Array();

        

        // Fast Authorization 
        if(window.localStorage.name != "" && window.localStorage.password != ""){
            $.ajax({
                url: 'signin.php',
                type: "POST",
                data: ({ name: window.localStorage.name, password: window.localStorage.password }),
                success: function (msg) {
                    if (msg == 1) {
                        auth.style.display = "none";  // Hide Auth
                        chat.style.display = "block"; // Show Chat

                        runShowMessage();
                    } else if (msg == 2) {
                        var el = document.createElement('span');
                        el.innerHTML = "- " + "Name and password do not match.<br>";
                        divError.appendChild(el);
                        return false;
                    }
                },
                error: function () {
                    return false;
                }
            });
        }
        
	    // Show Authorization Form
	    document.getElementById('Authorization').onclick = function () {
	        var divSignup = document.getElementById('divSignup');
	        var divSignin = document.getElementById('divSignin');

	        divSignup.style.display = 'none';
	        divSignin.style.display = 'block';
	    }


	    // Show Registration Form
	    document.getElementById('Registration').onclick = function () {
	        var divSignup = document.getElementById('divSignup');
	        var divSignin = document.getElementById('divSignin');

	        divSignin.style.display = 'none';
	        divSignup.style.display = 'block';
	    }


	    document.querySelector('#btnAttach').onchange = function (e) {
	        files = this.files;

	        for (var a = 0; a < files.length; a++) {
	            if (files[a].type == 'text/plain')
	            {
	                if(files[a].size < 100001)
	                {
                        // load bar
	                    var reader = new FileReader();
	                    reader.readAsDataURL(files[a]);
	                    reader.onload = function (e) {
	                        $('#loading').remove();
	                        var template = "<p id='loading'>Loading...</p>";
	                        $('#chat').append(template);
	                    }
	                    reader.onloadend = function (e) {
	                        $('#loading').remove();
	                        var template = "<p id='loading'>Loaded</p>";
	                        $('#chat').append(template);
	                    }
	                    // Позволить выполнять
	                    fileCollection.push(files[a]);
	                }
	                else {
	                    //Выход
	                    alert('file size > 100kb');
	                }
	            } else {
	                //Выход
	                alert('file type isn\'t text/plain');
	            }
	        }
	    }

        // Start Pop Up Window

        // Click to X
	    document.getElementById('closePopUp').onclick = function () {
	        document.getElementById('popUp').style.display = "none";
	    }
        

        // End Pop Up Window


        // Send Message
	    document.getElementById('btnSend').onclick = function (e) {
	        if (window.localStorage.name != "" && window.localStorage.password != "")
	        {
	            var message = document.getElementById('txtMessage').value;
	            var name = window.localStorage.name;

	            e.preventDefault();
	            e.stopPropagation();

                // Stop function ShowMessage
	            if (ajaxMessage != null) {
	                ajaxMessage.abort();
	                can = true;
	            }

                
	            console.log(fileCollection);
	            var form = document.forms.sendForm; // You need to use standart javascript object here
	            var formdate = new FormData(form);
                
	            console.log(formdate);

	            formdate.append('files', fileCollection[0]);
	            formdate.append('name', name);
	            formdate.append('message', message);

	            console.log(formdate);

	            var request = new XMLHttpRequest();
	            request.open('post', 'sendMessage.php', true);

	            request.onreadystatechange = function (msg) {
	                document.getElementById('txtMessage').value = ""; // Clear textarea
	                fileCollection = new Array(); // Clear file collection
                    // Clear choosed file

	                runShowMessage();
	                return true;
	            }

	            request.onerror = function () {
	                alert('error');
	                return false;
	            }

	            request.send(formdate);

	            //$.ajax({
	            //    url: 'sendMessage.php',
	            //    type: "POST",
	            //    data: ({ name: name, message: message}),
	            //    success: function (msg) {
	            //        console.log(msg);
	            //        document.getElementById('txtMessage').value = "";

	            //        runShowMessage();
	            //        return true;
	            //    },
	            //    error: function () {
	            //        alert('error');
	            //        return false;
	            //    }
	            //});
	        }
	    }

	    // Sing In
	    document.getElementById('signin').onclick = function () {
	        var userName = document.getElementById('userNameIn');
	        var userPassword = document.getElementById('userPasswordIn');

	        var auth = document.getElementById('auth');
	        var chat = document.getElementById('chat');

	        var divError = document.getElementById('errorsSignin');
	        var errors = [];
	        event.preventDefault();


	        // Validate User Name
	        valideteUserName(userName, errors);

	        // Validate User Password
	        validateUserPassword(userPassword, errors);

	        // Show Errors
	        if (errors.length !== 0) {
	            removeChildren(divError);
	            for (var i = 0; i < errors.length; i++) {
	                var el = document.createElement('span');
	                el.innerHTML = "- " + errors[i] + "<br>";
	                divError.appendChild(el);
	            }
	            return false;
	        }
            
	        var name = document.getElementById('userNameIn').value;
	        var password = document.getElementById('userPasswordIn').value;
	        $.ajax({
	            url: 'signin.php',
	            type: "POST",
	            data: ({ name: name, password: password}),
	            success: function (msg) {
                    
	                if (msg == 1) {
	                    auth.style.display = "none";  // Hide Auth
	                    chat.style.display = "block"; // Show Chat
	                    //set Session
	                    window.localStorage.name = name;
	                    window.localStorage.password = password;

	                    runShowMessage();
	                } else if (msg == 2) {
	                    var el = document.createElement('span');
	                    el.innerHTML = "- " + "Name and password do not match.<br>";
	                    divError.appendChild(el);
	                    return false;
	                }
	            },
	            error: function () {
	                return false;
	            }
	        });
	        return true;
	    }
	    // Sing up
		document.getElementById('signup').onclick = function () {
			var userName = document.getElementById('userNameUp');
			var userEmail = document.getElementById('userEmailUp');
			var userHomepage = document.getElementById('userHomepageUp');
			var userPassword = document.getElementById('userPasswordUp');

			var auth = document.getElementById('auth');
			var chat = document.getElementById('chat');

			var divError = document.getElementById('errorsSignup');
			var errors = [];
		    event.preventDefault();

			
	        // Validate User Name
			valideteUserName(userName, errors);

		    // Validate User Email
			validateUserEmail(userEmail, errors);

		    // Validate User Password
			validateUserPassword(userPassword, errors);
		
	        // Show Errors
			if (errors.length !== 0) {
			    removeChildren(divError);
			    for (var i = 0; i < errors.length; i++)
			    {
			        var el = document.createElement('span');
			        el.innerHTML = "- " + errors[i] + "<br>";
			        divError.appendChild(el);
			    }
			    return false;
			}
			var name = document.getElementById('userNameUp').value;
			var email = document.getElementById('userEmailUp').value;
			var homepage = document.getElementById('userHomepageUp').value;
			var password = document.getElementById('userPasswordUp').value;

			$.ajax({
			    url: 'signup.php',
			    type: "POST",
			    data: ({ name: name, password: password, email: email, homepage: homepage }),
			    success: function (msg) {
			        if (msg == 1) {
			            auth.style.display = "none";  // Hide Auth
			            chat.style.display = "block"; // Show Chat
			            //set Cookie
			            window.localStorage.name = name;
			            window.localStorage.password = password;

			            clearInterval(showMess);
			            setInterval(showMess, 1000);
			        } else if (msg == 3) {
			            var el = document.createElement('span');
			            el.innerHTML = "- " + "User exist.<br>";
			            divError.appendChild(el);
			            return false;
			        } else if (msg == 4) {
			            var el = document.createElement('span');
			            el.innerHTML = "- " + "Email exist.<br>";
			            divError.appendChild(el);
			            return false;
			        } else if (msg == 2) {
			            var el = document.createElement('span');
			            el.innerHTML = "- " + "Server error.<br>";
			            divError.appendChild(el);
			            return false;
			        }
			    },
			    error: function () {
			        return false;
			    }
			});
			return true;
		 }

		function runShowMessage()
		{
		    clearInterval(showMess);
		    setInterval(showMess, 1000);
		}

	     // Delete Child elements
		 function removeChildren(elem) {
		     while (elem.lastChild) {
		         elem.removeChild(elem.lastChild);
		     }
		 }
	     // Validate Function of user name
		 function valideteUserName(userName, errors) {
		     if (!userName.value) {
		         userName.style.border = "2px solid red";
		         errors.push('Name is empty.');
		     } else if (userName.value.length < 2 || userName.value.length > 25) {
		         userName.style.border = "2px solid red";
		         errors.push('Name must be at least 2 chars and not more 25 chars.');
		     } else {
		         userName.style.border = "2px solid green";
		     }
		 }

	     // Validate Function of user Email
		 function validateUserEmail(userEmail, errors) {
		     if (!userEmail.value) {
		         userEmail.style.border = "2px solid red";
		         errors.push('Email is empty.');
		     } else if(!userEmail.value.match(/\b[a-z0-9._]+@[a-z0-9.-]+\.[a-z]{2,4}\b/i))
		     {
		     	 userEmail.style.border = "2px solid red";
		         errors.push('Email isn\'t correct.')
		     } else {
		         userEmail.style.border = "2px solid green";
		     }
		 }
        // Validate Function of user Password
		 function validateUserPassword(userPassword, errors) {
		     if (!userPassword.value) {
		         userPassword.style.border = "2px solid red";
		         errors.push('Password is empty.');
		     } else if (userPassword.value.length < 6 || userPassword.value.length > 16) {
		         userPassword.style.border = "2px solid red";
		         errors.push('Password must be at least 6 chars and not more 16 chars.');
		     } else {
		         userPassword.style.border = "2px solid green";
		     }
		 }
	     
	    // Checking User Name to Exist
	    // Checking User Email to Exist
	    // Check User Name
	    // Check User Password

		 function showMess() {
		     if (can) {
		         can = false;
		         ajaxMessage = $.ajax({
		             type: "POST",
		             url: "showMessage.php",
		             success: function (html) {
		                 $('#messages').html(html);
		                 can = true;
		             }
		         });
                 
		     }
		 }
    }
    
})();