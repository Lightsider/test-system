$("#question-type").change(function (event) {
    $('#question-type').parent(".form-group").nextAll().css("display","none");
    $("#" + $(this).val()).css('display',"block");
});

//choose
$("button[name='add-ans-ch']").click(function (event) {
    event.preventDefault();
    var n1 = $(this).parent(".col-10").find("input").last().attr("name").substr(4,1);
    n1 = +n1 + 1;
    var block;

    block = $(this).parent(".col-10").find("input").last();
    $("<input type='text' name='ans-"+ n1 + "-ch' class='form-control' placeholder='Ответ'>").insertAfter(block);

    block = $(this).parent(".col-10").parent(".row").find(".col-2 div").last();
    $("<div class=\"radio-label-div\"><label for='ans-" + n1 +"-ch' class=\"radio-label\"><input type='radio' name='ans-right-ch' value='" + n1 +"'></label></div>").insertAfter(block);
});

//multi-choose
$("button[name='add-ans-mch']").click(function (event) {
    event.preventDefault();
    var n1 = $(this).parent(".col-10").find("input").last().attr("name").substr(4,1);
    n1 = +n1 + 1;
    var block;

    block = $(this).parent(".col-10").find("input").last();
    $("<input type='text' name='ans-"+ n1 + "-mch' class='form-control' placeholder='Ответ'>").insertAfter(block);

    block = $(this).parent(".col-10").parent(".row").find(".col-2 div").last();
    $("<div class=\"radio-label-div\"><label for='ans-" + n1 +"-mch' class=\"radio-label\"><input type='checkbox' name='ans-right-mch-" + n1 + "' value='" + n1 +"'></label></div>").insertAfter(block);
});

//docker
$("button[name='add-ans-doc']").click(function (event) {
    event.preventDefault();
    var n1 = $(this).parent(".col-12").find("input").last().attr("name").substr(4,1);
    n1 = +n1 + 1;
    var block;

    block = $(this).parent(".col-12").find("input").last();
    $("<input type='text' name='ans-"+ n1 + "-doc' class='form-control' placeholder='Ответ'>").insertAfter(block);
});
