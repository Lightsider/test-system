$("#question-type").change(function (event) {
    $('#question-type').parent(".form-group").nextAll().css("display", "none");
    $("#" + $(this).val()).css('display', "block");
});

//choose
$("button[name='add-ans-ch']").click(function (event) {
    event.preventDefault();
    var n1 = $(this).parent(".col-10").find("input").last().attr("name").substr(4, 1);
    n1 = +n1 + 1;
    var block;

    block = $(this).parent(".col-10").find("input").last();
    $("<input type='text' name='ans-" + n1 + "-ch' class='form-control' placeholder='Ответ'>").insertAfter(block);

    block = $(this).parent(".col-10").parent(".row").find(".col-2 div").last();
    $("<div class=\"radio-label-div\"><label for='ans-" + n1 + "-ch' class=\"radio-label\"><input type='radio' name='ans-right-ch' value='" + n1 + "'></label></div>").insertAfter(block);
});

//multi-choose
$("button[name='add-ans-mch']").click(function (event) {
    event.preventDefault();
    var n1 = $(this).parent(".col-10").find("input").last().attr("name").substr(4, 1);
    n1 = +n1 + 1;
    var block;

    block = $(this).parent(".col-10").find("input").last();
    $("<input type='text' name='ans-" + n1 + "-mch' class='form-control' placeholder='Ответ'>").insertAfter(block);

    block = $(this).parent(".col-10").parent(".row").find(".col-2 div").last();
    $("<div class=\"radio-label-div\"><label for='ans-" + n1 + "-mch' class=\"radio-label\"><input type='checkbox' name='ans-right-mch-" + n1 + "' value='" + n1 + "'></label></div>").insertAfter(block);
});

//docker
$("button[name='add-ans-doc']").click(function (event) {
    event.preventDefault();
    var n1 = $(this).parent(".col-12").find("input").last().attr("name").substr(4, 1);
    n1 = +n1 + 1;
    var block;

    block = $(this).parent(".col-12").find("input").last();
    $("<input type='text' name='ans-" + n1 + "-doc' class='form-control' placeholder='Ответ'>").insertAfter(block);
});


$(document).ready(function (e) {
   showUsersList();
});


/********************work with forms***************************/

$("#addUser").submit(function (e) {
    e.preventDefault();

    //add user
    $.ajax({
        url: '/api/addUser',
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            var message = data["message"];
            $("#newUserMessage").css("display", "block");
            $("#newUserMessage").removeClass("alert-danger");
            $("#newUserMessage").addClass("alert-success");
            $("#newUserMessage strong").text(message);
            $("#addUser")[0].reset();
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#newUserMessage").css("display", "block");
            $("#newUserMessage").removeClass("alert-success");
            $("#newUserMessage").addClass("alert-danger");
            $("#newUserMessage strong").html(message);
        }
    });

    // get userlist
    showUsersList();
});

$("#contacts-list").on("click",".btn-success",function (e) {
    e.preventDefault();
    var user_id = $(this).parent(".contact-item-actions").parent(".user-card").find("input[name=user-id]").val();
    getUserInfoInUpdateForm(user_id)
});

function getUserInfoInUpdateForm(user_id)
{
    var modal = $("#editUser");
    modal.find(".btn-success").attr("disabled","true");
    modal.modal('show');
    $("#updateUserMessage").css("display", "none");
    $("#updateUserMessage strong").text("");
    $.ajax({
        url: '/api/user/' + user_id,
        method: 'get',
        success: function (data) {
            modal.find(".modal-content input[name=user-id]").val(data["id"]);
            modal.find(".modal-content input[name=login]").val(data["login"]);
            modal.find(".modal-content input[name=fullname]").val(data["fullname"]);
            modal.find(".modal-content input[name=group]").val(data["group"]);
            modal.find(".modal-content input[name=status][value="+data["users_status"]["value"]+"]").attr("checked",true);
            modal.find(".btn-success").removeAttr("disabled");
        },
        error: function (data) {
            alert("Пользователь не найден");
        }
    });
}

$("#updateUser").submit(function (e) {
    e.preventDefault();
    var user_id = $(this).find("input[name=user-id]").val();
    //update user
    $.ajax({
        url: '/api/updateUser/' + user_id,
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            var message = data["message"];
            $("#updateUserMessage").css("display", "block");
            $("#updateUserMessage").removeClass("alert-danger");
            $("#updateUserMessage").addClass("alert-success");
            $("#updateUserMessage strong").text(message);
            $("#updateUser input[type=password]").val("");
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#updateUserMessage").css("display", "block");
            $("#updateUserMessage").removeClass("alert-success");
            $("#updateUserMessage").addClass("alert-danger");
            $("#updateUserMessage strong").html(message);
        }
    });

    // get userlist
    showUsersList();
});

function showUsersList() {
    if($("div").is("#contacts-list"))
    {
        $("#contacts-list").html("");
        $.ajax({
            url: '/api/users',
            method: 'get',
            success: function (data) {
                $.each(data, function (index, value) {
                    var html = "<div class=\"col-sm-6\">\n" +
                        "                                    <div class=\"card user-card contact-item p-md\" id=\"user-" + value["id"] + "\">\n" +
                        "<input type=\"hidden\" value=\"" + value["id"] + "\" name=\"user-id\">                                        " +
                        "<div class=\"media\">\n" +
                        "                                            <div class=\"media-left\">\n" +
                        "                                                <div class=\"avatar avatar-xl avatar-circle\">\n";
                    if (value["users_status"]["value"] === "admin") {
                        html += "<a href=\"/users/"+value["login"]+"\"><img src=\"/img/admin.png\" alt=\"admin image\"></a>";
                    }
                    else {
                        html += "<a href=\"/users/"+value["login"]+"\"><img src=\"/img/stud.png\" alt=\"user image\"></a>";
                    }
                    html += "</div>\n" +
                        "                                            </div>\n" +
                        "                                            <div class=\"media-body\">\n" +
                        "                                                <a href=\"/users/"+value["login"]+"\"><h5 class=\"media-heading title-color\">" + value["fullname"] + "</h5></a>\n" +
                        "                                                <small class=\"media-meta\">" + value["users_status"]["value"] + "</small><br>\n" +
                        "                                                <small class=\"media-meta\">" + value["group"] + "</small>\n" +
                        "                                            </div>\n" +
                        "                                        </div>\n" +
                        "                                        <div class=\"contact-item-actions\">\n" +
                        "                                            <a href=\"javascript:void(0)\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#contactModal\"><i class=\"fa fa-edit\"></i></a>\n" +
                        "                                            <a href=\"javascript:void(0)\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteItemModal\"><i class=\"fa fa-trash\"></i></a>\n" +
                        "                                        </div><!-- .contact-item-actions -->\n" +
                        "                                    </div><!-- card user-card -->\n" +
                        "                                </div><!-- END column -->";

                    $("#contacts-list").append(html);
                });
            }
        });
    }
    else if($("div").is("#Profile"))
    {
        $(".profile-cover").html("");
        var user_id = $("input[name=user-id]").val();
        $.ajax({
            url: '/api/user/' + user_id,
            method: 'get',
            success: function (data) {
                var html = " <div class=\"cover-user m-b-lg\">                    <div>\n" +
                    "                                <a href=\"javascript:void(0)\" onclick=\"getUserInfoInUpdateForm("+data["id"]+")\"\n" +
                    "                                   data-toggle=\"modal\" data-target=\"#editUser\"><span\n" +
                    "                                            class=\"cover-icon\"><i class=\"fa fa-edit\"></i></span></a>\n" +
                    "                            </div>\n" +
                    "                            <div>\n" +
                    "                                <div class=\"avatar avatar-xl avatar-circle\">\n" +
                    "                                    <a href=\"javascript:void(0)\">\n";
                if (data["users_status"]["value"] === "admin") {
                    html += "<img class=\"img-responsive\" src=\"/img/admin.png\" alt=\"admin image\">\n";
                }
                else {
                    html += "<img class=\"img-responsive\" src=\"/img/stud.png\" alt=\"user image\">\n";
                }
                html+=
                    "                                    </a>\n" +
                    "                                </div><!-- .avatar -->\n" +
                    "                            </div>\n" +
                    "                            <div>\n" +
                    "                                <a href=\"javascript:void(0)\" onclick=\"getUserInfoInDeleteForm("+data["id"]+")\"\n" +
                    "                                   data-toggle=\"modal\" data-target=\"#deleteUser\"><span\n" +
                    "                                            class=\"cover-icon\"><i class=\"fa fa-window-close\"></i></span></a>\n" +
                    "                            </div>\n" +
                    "                        </div>\n" +
                    "                        <div class=\"text-center\">\n" +
                    "                            <h4 class=\"profile-info-name m-b-lg\">\n" +
                    "                                "+data["fullname"]+"\n" +
                    "                                <a href=\"javascript:void(0)\" class=\"title-color\">\n" +
                    "                                    aka "+data["login"]+"\n" +
                    "                                </a>\n" +
                    "                            </h4>\n" +
                    "                            <div>\n" +
                    "                                <a href=\"javascript:void(0)\" class=\"m-r-xl theme-color\"><i\n" +
                    "                                            class=\"fa fa-bolt m-r-xs\"></i> "+data["users_status"]["value"]+"</a>\n" +
                    "                                <a href=\"javascript:void(0)\" class=\"theme-color\"><i\n" +
                    "                                            class=\"fa fa-map-marker m-r-xs\"></i>"+data["group"]+"</a>\n" +
                    "                            </div>\n" +
                    "                        </div>"
                $(".profile-cover").append(html);
            }
        });
    }

}

$("#contacts-list").on("click",".btn-danger",function (e) {
    e.preventDefault();
    var user_id = $(this).parent(".contact-item-actions").parent(".user-card").find("input[name=user-id]").val();
    getUserInfoInDeleteForm(user_id);
});

function getUserInfoInDeleteForm(user_id)
{
    var modal = $("#deleteUser");
    modal.find(".btn-danger").attr("disabled","true");
    modal.modal('show');
    $("#deleteUserMessage").css("display", "none");
    $("#deleteUserMessage strong").text("");
    $.ajax({
        url: '/api/user/' + user_id,
        method: 'get',
        success: function (data) {
            modal.find(".modal-body p strong").text(data["login"]);
            modal.find(".modal-content input[name=user-id]").val(data["id"]);
            modal.find(".btn-danger").removeAttr("disabled");
        },
        error: function (data) {
            alert("Пользователь не найден");
        }
    });
}

$("#deleteUser .btn-danger").click(function (e) {
    e.preventDefault();
    var modal = $("#deleteUser");
    var user_id = modal.find("input[name=user-id]").val();
    $.ajax({
        url: '/api/deleteUser/' + user_id,
        method: 'delete',
        success: function (data) {
            var message = data["message"];
            $("#deleteUserMessage").css("display", "block");
            $("#deleteUserMessage").removeClass("alert-danger");
            $("#deleteUserMessage").addClass("alert-success");
            $("#deleteUserMessage strong").text(message);
        },
        error: function (data) {
            alert("Пользователь не найден");
        }
    });
    showUsersList();
    if($("div").is("#Profile")) $(location).attr('href',"/users");
});




/********************work with forms***************************/

