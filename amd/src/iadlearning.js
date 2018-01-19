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


define(['jquery'], function($) {

    var api = '/api/v2';

    return {
        init: function(url, platformId) {
            $("#id_check_auth").click(function() {
                var email = $("#id_email").val();
                var password = $("#id_password").val();
                var reqUrl = url + api + '/platforms/' + platformId + '/login';
                var reqData = JSON.stringify({'email': email, 'password': password});
                $.ajax({
                    type: 'PUT',
                    url: reqUrl,
                    data: reqData,
                    success:
                        function(response) {
                            var reqUrl = url + api + '/platforms/' + platformId + '/courses/branch-name-list';
                            $.ajax({
                                type: 'GET',
                                url: reqUrl,

                                beforeSend:
                                    function(http) {
                                        http.setRequestHeader('Authorization', response.token);
                                    },

                                success:
                                    function(response) {
                                        var select = document.getElementById('id_select_course');
                                        var length, i;

                                        select.disabled = false;
                                        length = select.options.length;

                                        // Removes the previous data.
                                        for (i = 0; i < length; i++) {
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
                        },

                    contentType: "application/json"
                });
            });
            $("#id_select_course").change(function() {
                var courseId = $("#id_select_course").val();
                var courseName = $("#id_select_course :selected").text();
                $("#id_iad_course").val(courseId);
                $("#id_iad_course_name").val(courseName);
            });

        }
    };

});