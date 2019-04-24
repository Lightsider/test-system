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


/********************work with forms***************************/

$("#addUser").submit(function (e) {
    e.preventDefault();

    $.ajax({
        url: '/addOrUpdateUser',
        data: $(this).serialize(),
        method: 'post',
        success: function (data) {
            data = $.parseJSON(data);
            var message = data["message"];
            $("#newUserMessage").css("display", "block");
            $("#newUserMessage").removeClass("alert-danger");
            $("#newUserMessage").addClass("alert-success");
            $("#newUserMessage strong").text(message);
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
});
// TO DO  work with data

/********************work with forms***************************/

