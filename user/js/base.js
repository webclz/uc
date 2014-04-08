// JavaScript Document
/*
 *author@Juren
 */
$(document).ready(function (e) {
    //左侧导航鼠标经过效果
    $(".nav li a").mouseover(function () {
        var oldClass = $(this).children("span").attr("class");
        if (oldClass.match("_")) {
        } else {
            var newClass = oldClass + "_";
            $(this).children("span").attr("class", newClass);
            $(this).mouseout(function () {
                $(this).children("span").attr("class", oldClass);
            });
        }
    });
    //登录用户选择
    $("#ib_enter").click(function () {
        $("#ib_enter").addClass("enter_active");
        $("#user_enter").removeClass("enter_active");
        $("#table_ib").removeClass("hidden");
        $("#table_user").addClass("hidden");
    });
    $("#user_enter").click(function () {
        $("#ib_enter").removeClass("enter_active");
        $("#user_enter").addClass("enter_active");
        $("#table_ib").addClass("hidden");
        $("#table_user").removeClass("hidden");
    });
	
});