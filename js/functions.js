

// This file is part of iAdLearning Moodle Plugin - http://www.iadlearning.com/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


var api = '/api/v2';


/*
 *  Main Interface Functions
*/

function iad_get_course_list(url, platform, email, password, loginFailedMessage) {

	var reqUrl = url + api + '/platforms/url/' + platform;
	$.ajax({
		type: 'GET',
		url: reqUrl,

		success:
			function(response) {
				var platformId = response._id;
				iad_login_request(url, platformId, email, password, loginFailedMessage);
			},

		contentType: "application/json"
	});

}




function iad_get_last_access(url, platform, email, password, loginFailedMessage) {

	var reqUrl = url + api + '/platforms/url/' + platform;
	$.ajax({
		type: 'GET',
		url: reqUrl,

		success:
			function(response) {
				var platformId = response._id;
				alert('Response:' + platformId.toString());
				$(this).html(platformId);
			},

		contentType: "application/json"
	});

}


/*
 *  Support Functions
*/

function iad_login_request(url, platformId, email, password, loginFailedMessage) {

	var reqUrl = url + api + '/platforms/' + platformId + '/login';
	var reqData = JSON.stringify({'email': email, 'password': password});
	$.ajax({
		type: 'PUT',
		url: reqUrl,
		data: reqData,

		success:
				function(response, status) {
					iad_course_list_request(url, platformId, response.token, 1);
				},

		error:
				function(xhr, status, error) {
					if(xhr.status == 404) {
						alert(loginFailedMessage);
					}
				},

		contentType: "application/json"
	});
}



function iad_course_list_request(url, platformId, token, number) {

	var reqUrl = url + api + '/platforms/' + platformId + '/courses/branch-name-list';
	$.ajax({
		type: 'GET',
		url: reqUrl,

		beforeSend:
				function(http) {
					http.setRequestHeader('Authorization', token);
				},

		success:
				function(response) {
					var select = document.getElementById('id_select_course');
					var length, i;

					select.disabled = false;
					length = select.options.length;

					// Removes the previous data
					for( i = 0; i < length; i++) {
						select.remove(1);
					}

					response.forEach(
						function(course) {
							var opt = document.createElement('option');
							opt.value = course._id;
							opt.innerHTML = course.name;
							select.appendChild(opt);
						}
					);
				},

		contentType: "application/json"
	});
}



function iad_open_course(openUrl) {

	var queryString = openUrl.split("?")[1];
	var logUrl = 'iad_log_course_opened.php?' + queryString;

	console.log(openUrl);

	$.ajax({
		type: 'POST',
		url: logUrl,

		success:
			function(response) {
				alert(response);
				window.open(openUrl , '_blank', 'location=no,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,width=1500,height=1000');
			},

		contentType: "application/json"
	});


}


function setIadFields() {

	var iadCourse = document.getElementById('id_iad_course');
	var iadCourseName = document.getElementById('id_iad_course_name');
	var selectCourse = document.getElementById('id_select_course');

	iadCourse.value = selectCourse.value;
	iadCourseName.value = selectCourse.options[ selectCourse.selectedIndex ].text;
}


/******************************************************************************************************/


function iad_open_activity_login(url, query, platform, platformId, accessFailedMessage) {

	var reqUrl = url + api + '/platforms/' + platformId + '/external/login?' + query;
	$.ajax({
		type: 'GET',
		url: reqUrl,

		success:
			function(response) {
				alert("SUCCESS TRIGGERED");
				console.log('success');
				var platformId = response.token;
				iad_open_window(platform, token);
			},
		error:
			
			function(xhr, status, error) {
				alert("ERROR TRIGGERED");
				console.log('failure');
				if(xhr.status == 404) {
					alert(accessFailedMessage);
				}
			},

		contentType: "application/json"
		});

}

function iad_open_window(platform, token) {

	reqUrl = platform + api + '/external/open?token=' + token
	window.open(reqUrl , '_blank', 'location=no,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,width=1500,height=1000');


}


function iad_open_activity(url, query, platform, accessFailedMessage) {


	var reqUrl = url + api + '/platforms/url/' + platform;
	$.ajax({
		type: 'GET',
		url: reqUrl,

		success:
			function(response) {
				var platformId = response._id;
				iad_open_activity_login(url, query, platform, platformId, accessFailedMessage);
			},

		contentType: "application/json"
	});


}

function iad_number_courses_request(url, platformId, token) {

	var reqUrl = url + api + '/platforms/' + platformId + '/courses/branches?search_value=&order_field=name&order_asc=true&page_size=1&page_number=0';
	$.ajax({
		type: 'GET',
		url: reqUrl,
		beforeSend:
			function(http) {
				http.setRequestHeader('Authorization', token);
			},

		success:
			function(response) {
				iad_course_list_request(url, platformId, token, response.max_pages);
			},

		contentType: "application/json"
	});
}







/******************************************************************************************************/


