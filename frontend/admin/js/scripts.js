$("form select[name=type]").change(function (event) {
    $('form select[name=type]').parent(".form-group").nextAll().css("display", "none");
    $("#" + $(this).val()).css('display', "block");
    $("#u" + $(this).val()).css('display', "block");
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
    showTestsList();
    showQuestList();
    showQuestsByCategory("all");
});


/********************work with forms***************************/
//users
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

$("#contacts-list").on("click", ".btn-success", function (e) {
    e.preventDefault();
    var user_id = $(this).parent(".contact-item-actions").parent(".user-card").find("input[name=user-id]").val();
    getUserInfoInUpdateForm(user_id)
});

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


$("#contacts-list").on("click", ".btn-danger", function (e) {
    e.preventDefault();
    var user_id = $(this).parent(".contact-item-actions").parent(".user-card").find("input[name=user-id]").val();
    getUserInfoInDeleteForm(user_id);
});


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
    if ($("div").is("#Profile")) $(location).attr('href', "/users");
});

//tests
$("#addTest").submit(function (e) {
    e.preventDefault();

    //add user
    $.ajax({
        url: '/api/addTest',
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            var message = data["message"];
            $("#newTestMessage").css("display", "block");
            $("#newTestMessage").removeClass("alert-danger");
            $("#newTestMessage").addClass("alert-success");
            $("#newTestMessage strong").text(message);
            $("#addTest")[0].reset();
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#newTestMessage").css("display", "block");
            $("#newTestMessage").removeClass("alert-success");
            $("#newTestMessage").addClass("alert-danger");
            $("#newTestMessage strong").html(message);
        }
    });

    // get testlist
    showTestsList();
});

$("#editTest").submit(function (e) {
    e.preventDefault();
    var test_id = $("#editTest").find("input[name=id]").val();
    //update user
    $.ajax({
        url: '/api/updateTest/' + test_id,
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            var message = data["message"];
            $("#updateTestMessage").css("display", "block");
            $("#updateTestMessage").removeClass("alert-danger");
            $("#updateTestMessage").addClass("alert-success");
            $("#updateTestMessage strong").text(message);
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#updateTestMessage").css("display", "block");
            $("#updateTestMessage").removeClass("alert-success");
            $("#updateTestMessage").addClass("alert-danger");
            $("#updateTestMessage strong").html(message);
        }
    });

    // get testlist
    showTestsList();
});


$("#modalUpdateTest").click(function () {
    var test_id = $("#editTest").find("input[name=id]").val();
    getTestInfoInUpdateForm(test_id);
});

$("#deleteTest .btn-danger").click(function (e) {
    e.preventDefault();
    var modal = $("#deleteTest");
    var user_id = modal.find("input[name=test_id]").val();
    $.ajax({
        url: '/api/deleteTest/' + user_id,
        method: 'delete',
        success: function (data) {

        },
        error: function (data) {
            alert("Тест не найден");
        }
    });
    if ($("div").is("#deleteTest")) $(location).attr('href', "/tests");
});

$("#editQuestInTestForm").submit(function (e) {
    e.preventDefault();
    //update quests in test
    $.ajax({
        url: '/api/addQuestToTest/',
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            var message = data["message"];
            $("#updateQuestInTestMessage").css("display", "block");
            $("#updateQuestInTestMessage").removeClass("alert-danger");
            $("#updateQuestInTestMessage").addClass("alert-success");
            $("#updateQuestInTestMessage strong").text(message);
            showTestsList();
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#updateQuestInTestMessage").css("display", "block");
            $("#updateQuestInTestMessage").removeClass("alert-success");
            $("#updateQuestInTestMessage").addClass("alert-danger");
            $("#updateQuestInTestMessage strong").html(message);
        }
    });

    // get questlist
    showQuestList();
});

$("#questModal").on("hidden.bs.modal", function () {
    $("#updateQuestInTestMessage").css("display", "none");
});

$("#questList").on("click", ".btn-danger", function (e) {
    e.preventDefault();
    var quest_id = $(this).parent(".contact-item-actions").parent(".contact-item").find("input[name=quest_id]").val();
    getQuestInfoInDeleteForm(quest_id);
});


$("#deleteQuestInTest .btn-danger").click(function (e) {
    e.preventDefault();
    var modal = $("#deleteQuestInTest");
    var quest_id = modal.find("input[name=quest_id]").val();
    var test_id = modal.find("input[name=test_id]").val();
    $.ajax({
        url: '/api/deleteQuestInTest/' + test_id + "/" + quest_id,
        method: 'delete',
        success: function (data) {
            var message = data["message"];
            $("#deleteQuestInTestMessage").css("display", "block");
            $("#deleteQuestInTestMessage").removeClass("alert-danger");
            $("#deleteQuestInTestMessage").addClass("alert-success");
            $("#deleteQuestInTestMessage strong").text(message);
            $("#quests option[value=" + quest_id + "]").removeAttr("selected");
        },
        error: function (data) {
            alert("Этот вопрос в этом тесте не найден");
        }
    });
    showQuestList();
});

//categories

$("#addCategory").submit(function (e) {
    e.preventDefault();

    //add category
    $.ajax({
        url: '/api/addCategory',
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            var message = data["message"];
            $("#addCategoryMessage").css("display", "block");
            $("#addCategoryMessage").removeClass("alert-danger");
            $("#addCategoryMessage").addClass("alert-success");
            $("#addCategoryMessage strong").text(message);
            $("#addCategory")[0].reset();
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#addCategoryMessage").css("display", "block");
            $("#addCategoryMessage").removeClass("alert-success");
            $("#addCategoryMessage").addClass("alert-danger");
            $("#addCategoryMessage strong").html(message);
        }
    });

    // get categorylist
    showCategoriesList();
});

$("#cat-list").on("click", ".fa-edit", function (e) {
    e.preventDefault();
    var cat_id = $(this).parent(".item-actions").parent(".list-group-item").find("input[name=cat_id]").val();
    getCategoryInfoInUpdateForm(cat_id)
});

$("#updateCategory").submit(function (e) {
    e.preventDefault();

    var modal = $("#editCategory");
    var cat_id = modal.find("input[name=cat_id]").val();
    //update category
    $.ajax({
        url: '/api/updateCategory/' + cat_id,
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            var message = data["message"];
            $("#updateCategoryMessage").css("display", "block");
            $("#updateCategoryMessage").removeClass("alert-danger");
            $("#updateCategoryMessage").addClass("alert-success");
            $("#updateCategoryMessage strong").text(message);
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#updateCategoryMessage").css("display", "block");
            $("#updateCategoryMessage").removeClass("alert-success");
            $("#updateCategoryMessage").addClass("alert-danger");
            $("#updateCategoryMessage strong").html(message);
        }
    });

    // get questlist
    showCategoriesList();
});

$("#cat-list").on("click", ".fa-trash", function (e) {
    e.preventDefault();
    var cat_id = $(this).parent(".item-actions").parent(".list-group-item").find("input[name=cat_id]").val();
    getCategoryInfoInDeleteForm(cat_id)
});


$("#deleteCategory .btn-danger").click(function (e) {
    e.preventDefault();
    var modal = $("#deleteCategory");
    var cat_id = modal.find("input[name=cat_id]").val();
    $.ajax({
        url: '/api/deleteCategory/' + cat_id,
        method: 'delete',
        success: function (data) {
            var message = data["message"];
            $("#deleteCategoryMessage").css("display", "block");
            $("#deleteCategoryMessage").removeClass("alert-danger");
            $("#deleteCategoryMessage").addClass("alert-success");
            $("#deleteCategoryMessage strong").text(message);
        },
        error: function (data) {
            alert("Категория не найдена");
        }
    });
    showCategoriesList();
});

$("#categories-list").on("click", ".list-group-item:not(.text-color)", function (e) {
    e.preventDefault();
    var cat_id = $(this).find("input[name=cat_id]").val();
    showQuestsByCategory(cat_id);
});


//quests
$("#addQuestion").submit(function (e) {
    e.preventDefault();

    //add quest
    $.ajax({
        url: '/api/addQuest',
        data: new FormData($("#addQuestion")[0]),
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            var message = data["message"];
            $("#newQuestMessage").css("display", "block");
            $("#newQuestMessage").removeClass("alert-danger");
            $("#newQuestMessage").addClass("alert-success");
            $("#newQuestMessage strong").text(message);
            $("#addQuestion")[0].reset();
            // update page
            showCategoriesList();
            showQuestsByCategory("all");
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#newQuestMessage").css("display", "block");
            $("#newQuestMessage").removeClass("alert-success");
            $("#newQuestMessage").addClass("alert-danger");
            $("#newQuestMessage strong").html(message);
        }
    });
});

$("#deleteQuest .btn-danger").click(function (e) {
    $("#deleteQuest .btn-danger").attr("disabled", "true");
    e.preventDefault();
    var modal = $("#deleteQuest");
    var quest_id = modal.find("input[name=quest_id]").val();
    $.ajax({
        url: '/api/deleteQuest/' + quest_id,
        method: 'delete',
        success: function (data) {
            var message = data["message"];
            $("#deleteQuestMessage").css("display", "block");
            $("#deleteQuestMessage").removeClass("alert-danger");
            $("#deleteQuestMessage").addClass("alert-success");
            $("#deleteQuestMessage strong").text(message);
        },
        error: function (data) {
            alert("Вопрос не найден");
        }
    });
    if ($("div").is("#quest-info")) $(location).attr('href', "/quests");
    // update page
    showCategoriesList();
    showQuestsByCategory("all");
});

$("#quests-list").on("click", ".btn-danger", function (e) {
    e.preventDefault();
    var quest_id = $(this).parent(".contact-item-actions").parent(".user-card").find("input[name=quest_id]").val();
    $("#deleteQuest .btn-danger").removeAttr("disabled");
    getQuestInfoInDeleteForm(quest_id);
});

$("#deleteQuest").on("hidden.bs.modal", function () {
    $("#deleteQuestMessage").css("display", "none");
});

$("#updateQuest").on("hidden.bs.modal", function () {
    $("#updateQuestMessage").css("display", "none");
});

$("#newQuestion").on("hidden.bs.modal", function () {
    $("#newQuestMessage").css("display", "none");
});

$("#quests-list").on("click", ".btn-success", function (e) {
    e.preventDefault();
    var quest_id = $(this).parent(".contact-item-actions").parent(".user-card").find("input[name=quest_id]").val();
    $("#updateQuest .btn-success").removeAttr("disabled");
    getQuestInfoInUpdateForm(quest_id);
});

$("#updateQuestion").submit(function (e) {
    e.preventDefault();
    var id = $("#updateQuestion").find("input[name=id]").val();
    //update quest
    $.ajax({
        url: '/api/updateQuest/'+ id,
        data: new FormData($("#updateQuestion")[0]),
        method: 'post',
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            var message = data["message"];
            $("#updateQuestMessage").css("display", "block");
            $("#updateQuestMessage").removeClass("alert-danger");
            $("#updateQuestMessage").addClass("alert-success");
            $("#updateQuestMessage strong").text(message);
            // update page
            showCategoriesList();
            if ($("div").is("#quest-info")) {
                showQuestList();
            }
            else showQuestsByCategory("all");
        },
        error: function (data) {
            data = $.parseJSON(data.responseText);
            var message_arr = data["errors"], message = "";
            $.each(message_arr, function (index, value) {
                $.each(value, function (index, value2) {
                    message += value2 + "<br>";
                });
            });
            $("#updateQuestMessage").css("display", "block");
            $("#updateQuestMessage").removeClass("alert-success");
            $("#updateQuestMessage").addClass("alert-danger");
            $("#updateQuestMessage strong").html(message);
        }
    });
});

$("#modalUpdateQuest").click(function () {
    var quest_id = $("input[name=id]").val();
    getQuestInfoInUpdateForm(quest_id);
});

$(document).on("click","a[data-target=deleteFile]",function (e) {
    e.preventDefault();
    var id = $(this).data("value");
    $.ajax({
        url: '/api/deleteFile/' + id,
        method: 'delete',
        success: function (data) {
            alert("Файл успешно удален")
        },
        error: function (data) {
            alert("Ошибка при удалении файла");
        }
    });
    // update page
    showCategoriesList();
    showQuestsByCategory("all");
});

/********************work with forms***************************/


/********************functions***************************/
function getQuestInfoInUpdateForm(id) {
    var modal = $("#editQuestion");
    $("#updateQuestion")[0].reset();
    $("#updateQuestion input").removeAttr("checked");
    modal.find(".btn-success").attr("disabled", "true");
    modal.modal('show');
    $("#updateQuestMessage").css("display", "none");
    $("#updateQuestMessage strong").text("");
    $.ajax({
        url: '/api/quest/' + id,
        method: 'get',
        success: function (data) {
            modal.find(".modal-content input[name=id]").val(data["id"]);
            modal.find(".modal-content input[name=title]").val(data["title"]);
            modal.find(".modal-content textarea[name=description]").val(data["description"]);
            modal.find(".modal-content input[name=score]").val(data["score"]);
            modal.find(".modal-content textarea[name=hint]").val(data["hint"]);

            modal.find("#quest-files").html("");
            $.each(data["files"], function (index, value) {
                var html = "<p><a href=\"/" + value["path"] + "\" target='_blank'>" + value["path"].split("/")[1] + "</a> <a href=\"#\" class=\"text-danger\" data-target='deleteFile' data-value='" + value["id"] +"'> Удалить </a></p>"
                modal.find("#quest-files").append(html);
            });

            modal.find(".modal-content select[name='categories[]'] option").removeAttr("selected");
            $.each(data['category'], function (index, category) {
                modal.find(".modal-content select[name='categories[]'] option[value=" + category["id"] + "]").attr("selected", "true");
            });

            modal.find(".modal-content select[name='type'] option").removeAttr("selected");
            modal.find(".modal-content select[name='type'] option[value=" + data["type"] + "]").attr("selected", "true");
            modal.find(".modal-content select[name='type']").trigger("change");

            if (data["type"] === "ch") {
                var i = 1;
                $.each(data["answers"], function (index, answer) {
                    if (modal.find("input[name='ans-" + i + "-ch']").length > 0) {
                        modal.find("input[name='ans-" + i + "-ch']").val(answer["text"]);
                        if(answer["status"]=="1")
                        {
                            modal.find("input[name='ans-right-ch'][value="+i+"]").attr('checked', 'checked');
                        }
                    }
                    else
                    {
                        modal.find("button[name='add-ans-ch']").click();
                        modal.find("input[name='ans-" + i + "-ch']").val(answer["text"]);
                        if(answer["status"]=="1")
                        {
                            modal.find("input[name='ans-right-ch'][value="+i+"]").attr('checked', 'checked');
                        }
                    }
                    i++;
                });
            }
            else if (data["type"] === "wch") {
                modal.find(".modal-content textarea[name=ans-wch]").val(data["answers"][0]["text"]);
            }
            else if (data["type"] === "mch") {
                var i = 1;
                $.each(data["answers"], function (index, answer) {
                    if (modal.find("input[name='ans-" + i + "-mch']").length > 0) {
                        modal.find("input[name='ans-" + i + "-mch']").val(answer["text"]);
                        if(answer["status"]=="1")
                        {
                            modal.find("input[name='ans-right-mch-"+i+"']").attr('checked', 'checked');
                        }
                    }
                    else
                    {
                        modal.find("button[name='add-ans-mch']").click();
                        modal.find("input[name='ans-" + i + "-mch']").val(answer["text"]);
                        if(answer["status"]=="1")
                        {
                            modal.find("input[name='ans-right-mch-"+i+"']").attr('checked', 'checked');
                        }
                    }
                    i++;
                });
            }
            else if (data["type"] === "doc") {
                modal.find(".modal-content input[name=doc-name]").val(data["docker"]["name"]);
                modal.find(".modal-content textarea[name=ans-doc]").val(data["answers"][0]["text"]);
            }

            modal.find(".btn-success").removeAttr("disabled");
        },
        error: function (data) {
            alert("Вопрос не найден");
        }
    });
}

function showQuestsByCategory(cat_id) {
    var url = "";
    if (cat_id !== "all") {
        url = '/api/category/' + cat_id;
    }
    else url = '/api/quests';

    var listBlock = $("#quests-list");
    listBlock.text("Загрузка...");
    $.ajax({
        url: url,
        method: 'get',
        success: function (data) {
            listBlock.text("");
            var array;
            if (cat_id !== "all") {
                array = data["quests"]
            }
            else
                array = data;

            $.each(array, function (index, value) {
                var type = "";
                var html = "<div class=\"col-sm-3\">\n" +
                    "                                <div class=\"card user-card contact-item p-md\">\n" +
                    "                                    <div class=\"media\">\n" +
                    "                                        <div class=\"media-body\">" +
                    "<input type='hidden' name='quest_id' value='" + value["id"] + "'>" +
                    "                                            <a href=\"/quest/"+value["id"]+"\"><h5 class=\"media-heading title-color\">" + value["title"] + "</h5></a>\n";
                if (value["type"] == "wch") type = "С развернутым ответом";
                else if (value["type"] == "mch") type = "С множественным выбором";
                else if (value["type"] == "wch") type = "С виртуальным контейнером";
                else type = "С выбором ответа";
                html +=
                    "                                            <small class=\"media-meta\">" + type + "</small>\n" +
                    "<br><small class='media-meta'>";
                if (value["category"].length > 0) {
                    $.each(value["category"], function (index_cat, category) {
                        html += category["name"] + ",";
                    });
                    html = html.substr(0, html.length - 1)
                }
                else {
                    html += "Без категории";
                }
                html += "</small><p class=\"media-meta mb-0\">" + value["score"] + " баллов </p>" +
                    "                                        </div>\n" +
                    "                                    </div>\n" +
                    "                                    <div class=\"contact-item-actions\">\n" +
                    "                                        <a href=\"javascript:void(0)\" class=\"btn btn-success\" data-toggle=\"modal\"\n" +
                    "                                           data-target=\"#editQuest\"><i class=\"fa fa-edit\"></i></a>" +
                    "                                        <a href=\"javascript:void(0)\" class=\"btn btn-danger\" data-toggle=\"modal\"\n" +
                    "                                           data-target=\"#deleteQuest\"><i class=\"fa fa-trash\"></i></a>\n" +
                    "                                    </div><!-- .contact-item-actions -->\n" +
                    "                                </div><!-- card user-card -->\n" +
                    "                            </div><!-- END column -->"

                listBlock.append(html);
            });

            $(".list-group-item").removeClass("active");
            $(".list-group-item input[name=cat_id][value=" + cat_id + "]").parent(".list-group-item").addClass("active");

        },
        error: function (data) {
            alert("Категория не найдена");
        }
    });
}

function getCategoryInfoInDeleteForm(id) {
    var modal = $("#deleteCategory");
    modal.find(".btn-danger").attr("disabled", "true");
    modal.modal('show');
    $("#deleteCategoryMessage").css("display", "none");
    $("#deleteCategoryMessage strong").text("");
    $.ajax({
        url: '/api/category/' + id,
        method: 'get',
        success: function (data) {
            modal.find(".modal-content input[name=cat_id]").val(data["id"]);
            modal.find(".modal-content strong:first").text(data["name"]);
            modal.find(".btn-danger").removeAttr("disabled");
        },
        error: function (data) {
            alert("Категория не найдена");
        }
    });
}

function getCategoryInfoInUpdateForm(id) {
    var modal = $("#editCategory");
    modal.find(".btn-success").attr("disabled", "true");
    modal.modal('show');
    $("#updateCategoryMessage").css("display", "none");
    $("#updateCategoryMessage strong").text("");
    $.ajax({
        url: '/api/category/' + id,
        method: 'get',
        success: function (data) {
            modal.find(".modal-content input[name=cat_id]").val(data["id"]);
            modal.find(".modal-content input[name=name]").val(data["name"]);
            modal.find(".modal-content input[name=slug]").val(data["slug"]);
            modal.find(".btn-success").removeAttr("disabled");
        },
        error: function (data) {
            alert("Категория не найдена");
        }
    });
}

function getQuestInfoInDeleteForm(quest_id) {
    if ($("div").is("#deleteQuestInTest")) {
        var modal = $("#deleteQuestInTest");
        modal.find(".btn-danger").attr("disabled", "true");
        modal.modal('show');
        $("#deleteQuestInTestMessage").css("display", "none");
        $("#deleteQuestInTestMessage strong").text("");
        $.ajax({
            url: '/api/quest/' + quest_id,
            method: 'get',
            success: function (data) {
                modal.find(".modal-body p strong").text(data["title"]);
                modal.find(".modal-content input[name=quest_id]").val(data["id"]);
                modal.find(".btn-danger").removeAttr("disabled");
            },
            error: function (data) {
                alert("Этот вопрос в этом тесте не найден");
            }
        });
    }
    else if ($("div").is("#deleteQuest")) {
        var modal = $("#deleteQuest");
        modal.find(".btn-danger").attr("disabled", "true");
        modal.modal('show');
        $("#deleteQuest").css("display", "none");
        $("#deleteQuest strong:first").text("");
        $.ajax({
            url: '/api/quest/' + quest_id,
            method: 'get',
            success: function (data) {
                modal.find(".modal-body p strong:first").text(data["title"]);
                modal.find(".modal-content input[name=quest_id]").val(data["id"]);
                modal.find(".btn-danger").removeAttr("disabled");
            },
            error: function (data) {
                alert("Вопрос не найден");
            }
        });
    }
}

function showQuestList() {
    if ($("div").is("#questList")) {
        var test_id = $("#editTest").find("input[name=id]").val();
        $("#questList").html("Загрузка...");
        $.ajax({
            url: '/api/quests/' + test_id,
            method: 'get',
            success: function (data) {
                $("#questList").html("");
                $.each(data, function (index, value) {
                    var type = "";
                    var html = "<div class=\"col-sm-3\">\n" +
                        "                                <div class=\"card user-card contact-item p-md\">\n" +
                        "                                    <div class=\"media\">\n" +
                        "                                        <div class=\"media-body\">" +
                        "<input type='hidden' name='quest_id' value='" + value["id"] + "'>" +
                        "                                            <a href=\"/quest/"+value["id"]+"\"><h5 class=\"media-heading title-color\">" + value["title"] + "</h5></a>\n";
                    if (value["type"] == "wch") type = "С развернутым ответом";
                    else if (value["type"] == "mch") type = "С множественным выбором";
                    else if (value["type"] == "doc") type = "С виртуальным контейнером";
                    else type = "С выбором ответа";
                    html +=
                        "                                            <small class=\"media-meta\">" + type + "</small>\n" +
                        "<br><small class='media-meta'>";
                    if (value["category"].length > 0) {
                        $.each(value["category"], function (index_cat, category) {
                            html += category["name"] + ",";
                        });
                        html = html.substr(0, html.length - 1)
                    }
                    else {
                        html += "Без категории";
                    }
                    html += "</small><p class=\"media-meta mb-0\">" + value["score"] + " баллов </p>" +
                        "                                        </div>\n" +
                        "                                    </div>\n" +
                        "                                    <div class=\"contact-item-actions\">\n" +
                        "                                        <a href=\"javascript:void(0)\" class=\"btn btn-danger\" data-toggle=\"modal\"\n" +
                        "                                           data-target=\"#deleteQuestInTest\"><i class=\"fa fa-trash\"></i></a>\n" +
                        "                                    </div><!-- .contact-item-actions -->\n" +
                        "                                </div><!-- card user-card -->\n" +
                        "                            </div><!-- END column -->"

                    $("#questList").append(html);
                });
            }
        });
    }
    else if ($("div").is("#quest-info")) {
        $("#quest-info").html("Загрузка...");
        var quest_id = $("input[name=id]").val();
        $.ajax({
            url: '/api/quest/' + quest_id,
            method: 'get',
            success: function (data) {
                $("#quest-info").html("");
                var type = "";
                var html = "<h3 class=\"m-b-lg\">" + data["title"] + "</h3>\n" +
                    "                    <div class=\"row mt-3\">\n" +
                    "                        <div class=\"col-md-12\">\n" +
                    "                            <p>" + data["description"] + "</p>" +
                    "<p><strong>Баллы:</strong> " + data["score"] + "</p>" +
                    "<p><strong>Текст подсказки для обучающего теста:</strong><br>" + data["hint"] + "</p>" +
                    "<p><strong>Файлы:</strong><br>";
                if (data["files"].length > 0) {
                    $.each(data["files"], function (index, cat) {
                        html += "<a href='/" + cat["path"] + ">" + cat["path"] + "</a><br>";
                    });
                }
                else {
                    html += "Отсутствуют<br>";
                }
                html+="<p class=\"m-h-lg fz-md lh-lg\"><strong>Категории:</strong> ";
                if (data["category"].length > 0) {
                    $.each(data["category"], function (index, cat) {
                        html += cat["name"] + ","
                    });
                    html = html.substr(0, html.length - 1);
                }
                else {
                    html += "Без категории";
                }
                if (data["type"] == "wch") type = "С развернутым ответом";
                else if (data["type"] == "mch") type = "С множественным выбором";
                else if (data["type"] == "doc") type = "С виртуальным контейнером";
                else type = "С выбором ответа";
                html += "<p class=\"m-h-lg fz-md lh-lg\"><strong>Тип:</strong> " + type + " </p>\n";

                if(data["type"] == "doc")
                {
                    html+= "<p><strong>Название контейнера:</strong> "+data["docker"]["name"]+"</p>";
                }

                html+= "<p><strong>Ответы:</strong><br><ul>";

                $.each(data["answers"], function (index, answer) {
                    html += "<li>"+answer["text"];
                    if(answer["status"]==1) html+=" - верный";
                    html+="</li>";
                });

                html +=
                    "                       </ul> </div><!-- END column -->\n" +
                    "                    </div><!-- .row -->";

                $("#quest-info").append(html);
            }
        });
    }
}

function showCategoriesList() {
    if ($("div").is("#cat-list")) {
        $("#cat-list").html("Загрузка...");
        $.ajax({
            url: '/api/categories',
            method: 'get',
            success: function (data) {
                $("#cat-list").html("");
                $("select[name='categories[]']").html("");
                $.each(data, function (index, value) {
                    var count_quests = 0;
                    if (value["quests"] && value["quests"].length) count_quests = value["quests"].length;
                    var html = "<a href=\"#\" class=\"list-group-item\">\n" +
                        "                                            <input type=\"hidden\" name=\"cat_id\" value=\"" + value["id"] + "\">\n" +
                        "                                            <div class=\"item-data\">\n" +
                        "                                                <span class=\"label-text\">" + value["name"] + "</span>\n" +
                        "                                                <span class=\"pull-right hide-on-hover\">" + count_quests + "</span>\n" +
                        "                                            </div>\n" +
                        "                                            <div class=\"item-actions\">\n" +
                        "                                                <i class=\"item-action fa fa-edit\" data-toggle=\"modal\"\n" +
                        "                                                   data-target=\"#editCategory\"></i>\n" +
                        "                                                <i class=\"item-action fa fa-trash\" data-toggle=\"modal\"\n" +
                        "                                                   data-target=\"#deleteCategory\"></i>\n" +
                        "                                            </div>\n" +
                        "                                        </a><!-- .list-group-item -->";

                    $("#cat-list").append(html);
                    var option = "<option value=\"" + value["id"] + "\">" + value["name"] + "</option>"
                    $("select[name='categories[]']").append(option);
                });
            }
        });
    }
}

function getTestInfoInUpdateForm(id) {
    var modal = $("#updateTest");
    modal.find(".btn-success").attr("disabled", "true");
    modal.modal('show');
    $("#updateTestMessage").css("display", "none");
    $("#updateTestMessage strong").text("");
    $.ajax({
        url: '/api/test/' + id,
        method: 'get',
        success: function (data) {
            modal.find(".modal-content input[name=id]").val(data["test"]["id"]);
            modal.find(".modal-content input[name=title]").val(data["test"]["title"]);
            modal.find(".modal-content textarea[name=description]").val(data["test"]["description"]);
            modal.find(".modal-content input[name=time]").val(data["test"]["time"]);
            $.each(data["test"]["category"], function (index, cat) {
                modal.find(".modal-content select[name=status] option[value=" + cat["id"] + "]").attr("checked", true);
            });
            modal.find(".btn-success").removeAttr("disabled");
        },
        error: function (data) {
            alert("Тест не найден");
        }
    });
}

function showTestsList() {
    if ($("div").is("#testsList")) {
        $("#testsList").html("Загрузка...");
        $.ajax({
            url: '/api/tests',
            method: 'get',
            success: function (data) {
                $("#testsList").html("");
                $.each(data["tests"], function (index, value) {
                    var type = "";
                    var active = "card-muted";
                    if(value["active"]==1)
                        active = "";
                    var html = "<div class=\"col-sm-6 col-md-4\">\n" +
                        "                                        <a href=\"/test/" + value["id"] + "\">" +
                        "<div class=\"card\ " + getColorFromResults(data["average_values"][value["id"]], "card") + " "+active+"\">\n" +
                        "                                                <div class=\"card-header\">\n" +
                        "                                                    <h4 class=\"card-title text-normalsize\">" + value["title"] + "</h4>\n" +
                        "                                                </div>\n" +
                        "                                                <div class=\"card-block\">\n" +
                        "                                                    <p><strong>Всего\n" +
                        "                                                            вопросов:</strong> " + value["questions"].length + "\n" +
                        "                                                    </p>\n";
                    if (data["average_values"][value["id"]] !== null) {
                        html += "<p><strong>Средний балл:</strong> " + data["average_values"][value["id"]] + "</p>\n"
                    }
                    else {
                        html += "<p><strong>Средний балл:</strong> Нет данных </p>\n"
                    }
                    if (value["type"] == "learn") type = "Обучающий";
                    else type = "Контрольный";

                    html += "<p><strong>Тип:</strong> " + type + "\n" +
                        "                                                    </p>\n";
                    html += "                                             </div>\n" +
                        "                                                <div class=\"card-footer\">\n";
                    if (value["category"].length > 0) {
                        $.each(value["category"], function (index_cat, category) {
                            html += category["name"] + ",";
                        });
                        html = html.substr(0, html.length - 1)
                    }
                    else {
                        html += "Без категории";
                    }
                    html += "                                                </div>\n" +
                        "                                            </div>";

                    $("#testsList").append(html);
                });
            }
        });
    }
    else if ($("div").is("#updateTest")) {
        $("#test-info").html("Загрузка...");
        var test_id = $("input[name=id]").val();
        $.ajax({
            url: '/api/test/' + test_id,
            method: 'get',
            success: function (data) {
                $("#test-info").html("");
                var type = "";
                var html = "<h3 class=\"m-b-lg\">" + data["test"]["title"] + "</h3>\n" +
                    "                    <div class=\"row mt-3\">\n" +
                    "                        <div class=\"col-md-12\">\n" +
                    "                            <p> " + data["test"]["description"] + "</p>" +
                    "<p class=\"m-h-lg fz-md lh-lg\"><strong>Время:</strong> " + data["test"]["time"] + " </p>\n" +
                    "<p class=\"m-h-lg fz-md lh-lg\"><strong>Категории:</strong> ";
                if (data["test"]["category"].length > 0) {
                    $.each(data["test"]["category"], function (index, cat) {
                        html += cat["name"] + ","
                    });
                    html = html.substr(0, html.length - 1);
                }
                else {
                    html += "Без категории";
                }
                html +=
                    "                        </p><p class=\"m-h-lg fz-md lh-lg\"><strong>Всего вопросов:</strong> " + data["test"]["questions"].length + " </p>\n" +
                    "<p class=\"m-h-lg fz-md lh-lg\"><strong>Максимум баллов:</strong> ";
                if (data["test"]["questions"].length > 0) {
                    var max = 0;
                    $.each(data["test"]["questions"], function (index, quest) {
                        max+= +quest["score"];
                    });
                    html+= max;
                }
                else {
                    html += "Нет данных";
                }
                html+=
                    "                           </p> <p class=\"m-h-lg fz-md lh-lg\"><strong>Всего решали:</strong> " + data["test"]["results"].length + " </p>\n";
                if (data["average_value"] !== null) {
                    html += "<p class=\"m-h-lg fz-md lh-lg\"><strong>Средний балл:</strong> " + data["average_value"] + " </p>\n"
                }
                else {
                    html += "<p class=\"m-h-lg fz-md lh-lg\"><strong>Средний балл:</strong> Нет данных </p>\n"
                }
                if (data["test"]["type"] == "learn") type = "Обучающий";
                else type = "Контрольный";
                html += "<p class=\"m-h-lg fz-md lh-lg\"><strong>Тип:</strong> " + type + " </p>\n"
                html +=
                    "                        </div><!-- END column -->\n" +
                    "                    </div><!-- .row -->";

                $("#test-info").append(html);
            }
        });
    }
}


function getUserInfoInDeleteForm(user_id) {
    var modal = $("#deleteUser");
    modal.find(".btn-danger").attr("disabled", "true");
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

function showUsersList() {
    if ($("div").is("#newUser")) {
        $("#contacts-list").html("Загрузка...");
        $.ajax({
            url: '/api/users',
            method: 'get',
            success: function (data) {
                $("#contacts-list").html("");
                $.each(data, function (index, value) {
                    var html = "<div class=\"col-sm-6\">\n" +
                        "                                    <div class=\"card user-card contact-item p-md\" id=\"user-" + value["id"] + "\">\n" +
                        "<input type=\"hidden\" value=\"" + value["id"] + "\" name=\"user-id\">                                        " +
                        "<div class=\"media\">\n" +
                        "                                            <div class=\"media-left\">\n" +
                        "                                                <div class=\"avatar avatar-xl avatar-circle\">\n";
                    if (value["users_status"]["value"] === "admin") {
                        html += "<a href=\"/users/" + value["login"] + "\"><img src=\"/img/admin.png\" alt=\"admin image\"></a>";
                    }
                    else {
                        html += "<a href=\"/users/" + value["login"] + "\"><img src=\"/img/stud.png\" alt=\"user image\"></a>";
                    }
                    html += "</div>\n" +
                        "                                            </div>\n" +
                        "                                            <div class=\"media-body\">\n" +
                        "                                                <a href=\"/users/" + value["login"] + "\"><h5 class=\"media-heading title-color\">" + value["fullname"] + "</h5></a>\n" +
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
    else if ($("div").is("#Profile")) {
        $(".profile-cover").html("Загрузка...");
        var user_id = $("input[name=user-id]").val();
        $.ajax({
            url: '/api/user/' + user_id,
            method: 'get',
            success: function (data) {
                $(".profile-cover").html("");
                var html = " <div class=\"cover-user m-b-lg\">                    <div>\n" +
                    "                                <a href=\"javascript:void(0)\" onclick=\"getUserInfoInUpdateForm(" + data["id"] + ")\"\n" +
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
                html +=
                    "                                    </a>\n" +
                    "                                </div><!-- .avatar -->\n" +
                    "                            </div>\n" +
                    "                            <div>\n" +
                    "                                <a href=\"javascript:void(0)\" onclick=\"getUserInfoInDeleteForm(" + data["id"] + ")\"\n" +
                    "                                   data-toggle=\"modal\" data-target=\"#deleteUser\"><span\n" +
                    "                                            class=\"cover-icon\"><i class=\"fa fa-window-close\"></i></span></a>\n" +
                    "                            </div>\n" +
                    "                        </div>\n" +
                    "                        <div class=\"text-center\">\n" +
                    "                            <h4 class=\"profile-info-name m-b-lg\">\n" +
                    "                                " + data["fullname"] + "\n" +
                    "                                <a href=\"javascript:void(0)\" class=\"title-color\">\n" +
                    "                                    aka " + data["login"] + "\n" +
                    "                                </a>\n" +
                    "                            </h4>\n" +
                    "                            <div>\n" +
                    "                                <a href=\"javascript:void(0)\" class=\"m-r-xl theme-color\"><i\n" +
                    "                                            class=\"fa fa-bolt m-r-xs\"></i> " + data["users_status"]["value"] + "</a>\n" +
                    "                                <a href=\"javascript:void(0)\" class=\"theme-color\"><i\n" +
                    "                                            class=\"fa fa-map-marker m-r-xs\"></i>" + data["group"] + "</a>\n" +
                    "                            </div>\n" +
                    "                        </div>"
                $(".profile-cover").append(html);
            }
        });
    }

}


function getUserInfoInUpdateForm(user_id) {
    var modal = $("#editUser");
    modal.find(".btn-success").attr("disabled", "true");
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
            modal.find(".modal-content input[name=status][value=" + data["users_status"]["value"] + "]").attr("checked", true);
            modal.find(".btn-success").removeAttr("disabled");
        },
        error: function (data) {
            alert("Пользователь не найден");
        }
    });
}

function getColorFromResults(results, prefix) {
    prefix = prefix || "";
    if (typeof results === "string" || typeof results === "number") {
        if (results < 25)
            return prefix + "-" + "danger";
        else if (results < 50)
            return prefix + "-" + "warning";
        else if (results < 75)
            return prefix + "-" + "primary";
        else return prefix + "-" + "success";
    }
    else return prefix + "-" + "default";
}

/********************functions***************************/
