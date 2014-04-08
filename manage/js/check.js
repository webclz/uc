// JavaScript Document
/*
 *author@Juren
 */

$(document).ready(function (e) {
    //点击修改按钮
    $("#change").click(function () {
        $("#mobile").removeClass("border_none");
        $("#mobile").attr("readonly", false);
        $("#mail").removeClass("border_none");
        $("#mail").attr("readonly", false);
        $("#address").removeClass("border_none");
        $("#address").attr("readonly", false);
        $("#locate5").removeClass("hidden");
        $("#locate6").removeClass("hidden");
        $("#locate7").removeClass("hidden");
        $("#change").addClass("hidden");
        $("#sub").removeClass("hidden");
        $("#cancel").removeClass("hidden");
    });
    //点击取消按钮
    $("#cancel").click(function () {
        $("#mobile").addClass("border_none");
        $("#mobile").attr("readonly", true);
        $("#mail").addClass("border_none");
        $("#mail").attr("readonly", true);
        $("#address").addClass("border_none");
        $("#address").attr("readonly", true);
        $("#locate5").addClass("hidden");
        $("#locate6").addClass("hidden");
        $("#locate7").addClass("hidden");
        $("#change").removeClass("hidden");
        $("#sub").addClass("hidden");
        $("#cancel").addClass("hidden");
    });
    //点击提交按钮
    $("#sub").click(function () {
        if (check_address('address', 'locate7') && check_mail('mail', 'locate6') && check_mobile('mobile', 'locate5')) {
            $("#mobile").addClass("border_none");
            $("#mobile").attr("readonly", true);
            $("#mail").addClass("border_none");
            $("#mail").attr("readonly", true);
            $("#address").addClass("border_none");
            $("#address").attr("readonly", true);
            $("#locate5").addClass("hidden");
            $("#locate6").addClass("hidden");
            $("#locate7").addClass("hidden");
            $("#change").removeClass("hidden");
            $("#sub").addClass("hidden");
            $("#cancel").addClass("hidden");
            return true;
        } else {
            return false;
        }
    });

    //修改密码
    $("#pwChange").click(function () {
        $("#pwCancel").removeClass("hidden");
        $("#pwSubmit").removeClass("hidden");
        $("#pwChange").addClass("hidden");
        $("#inputPw1").removeClass("hidden");
        $("#inputPw2").removeClass("hidden");
        $("#accountPassword").attr("readonly", false);
        $("#accountPassword").removeClass("border_none");
        $("#accountPassword").val("");
        $("#oldPwRemind").removeClass("hidden");
        $("#oldPasswordText").text("旧密码：");
    });
    //取消修改密码
    $("#pwCancel").click(function () {
        $("#pwCancel").addClass("hidden");
        $("#pwSubmit").addClass("hidden");
        $("#pwChange").removeClass("hidden");
        $("#inputPw1").addClass("hidden");
        $("#inputPw2").addClass("hidden");
        $("#accountPassword").attr("readonly", true);
        $("#accountPassword").addClass("border_none");
        $("#accountPassword").val("******");
        $("#oldPwRemind").addClass("hidden");
        $("#oldPasswordText").text("密码：");
    });
    //保存修改密码
    $("#pwSubmit").click(function () {
        if (check_accountPassword('accountPassword', 'oldPwRemind') && check_newAccountPassword('newAccountPassword', 'locate1') && check_newAccountPasswordRe('newAccountPasswordRe', 'locate2', 'newAccountPassword')) {
            alert('修改密码成功');
            $("#pwCancel").addClass("hidden");
            $("#pwSubmit").addClass("hidden");
            $("#pwChange").removeClass("hidden");
            $("#inputPw1").addClass("hidden");
            $("#inputPw2").addClass("hidden");
            $("#accountPassword").attr("readonly", true);
            $("#accountPassword").addClass("border_none");
            $("#accountPassword").val("******");
            $("#oldPwRemind").addClass("hidden");
            $("#oldPasswordText").text("密码：");
            return true;
        } else {
            alert("填写信息有误，请确认");
            return false;
        }
    });
});

//显示错误警告信息
/*
 *PARAM:	e_warning		警告提示元素ID或CLASS
 *		e_success		正确成功提示元素ID或CLASS
 *		e_normal		正常提示信息元素ID或CLASS
 *		str_info		提示的文字信息
 */
function show_warning(e_warning, e_success, e_normal, str_info) {
    e_warning.text(str_info);
    e_warning.removeClass("hidden");
    e_normal.addClass("hidden");
    e_success.addClass("hidden");
}
//显示正确信息
function show_success(e_warning, e_success, e_normal, str_info) {
    e_success.text(str_info);
    e_success.removeClass("hidden");
    e_warning.addClass("hidden");
    e_normal.addClass("hidden");
}
//显示正常
function show_normal(e_warning, e_success, e_normal, str_info) {
    e_normal.text(str_info);
    e_normal.removeClass("hidden");
    e_warning.addClass("hidden");
    e_success.addClass("hidden");
}

//用户名验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_userName(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0) {
        show_warning(e_warning, e_success, e_normal, "用户名不能为空");
    }
    if (e_value.length < 4 && e_value.length > 0) {
        show_warning(e_warning, e_success, e_normal, "用户名不能少于4个字符");
    }
    if (e_value.length >= 4) {
        show_success(e_warning, e_success, e_normal, "正确");
    }
}
//真实姓名验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_realName(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0) {
        show_warning(e_warning, e_success, e_normal, "真实姓名不能为空");
        return false;
    }
    if (e_value.length >= 2) {
        if (check_letter(e_value)) {
            show_success(e_warning, e_success, e_normal, "正确")
            return true;
        } else {
            show_warning(e_warning, e_success, e_normal, "真实姓名为汉子或英文字母");
            return false;
        }
    }
    function check_letter(e_value) {
        for (var i = 0; i < e_value.length; i++) {
            if (e_value.charAt(i) > '0' && e_value.charAt(i) < '9') {
                return false;
                break;
            }
        }
        return true;
    }
}
//身份证验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_idCard(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0) {
        //如果身份证号码为空
        show_warning(e_warning, e_success, e_normal, "身份证号码不能为空");
        return false;
    } else if (e_value.length < 18 || e_value.length > 18) {
        //如果身份证号码小于18位或者大于18位
        show_warning(e_warning, e_success, e_normal, "身份证号码为18位");
        return false;
    } else if (e_value.length == 18) {
        if (check_idCardLetter(e_value)) {
            //检查身份证字符是否合法
            if (getCheckCode(getPowerSum(e_value)) == e_value.substring(17, e_value.length)) {
                //对输入的身份证号码进行“身份证验证码”核对
                show_success(e_warning, e_success, e_normal, "正确");
                return true;
            } else {
                show_warning(e_warning, e_success, e_normal, "您输入的身份证信息有误，请核对后再输");
                return false;
            }
        } else {
            show_warning(e_warning, e_success, e_normal, "身份证号码格式不正确");
            return false;
        }
    }
}
//检查身份证字符的正确性
/*
 *PARAM:	cardNum		身份证号码
 */
function check_idCardLetter(cardNum) {
    for (var i = 0; i < cardNum.length - 1; i++) {
        if (cardNum.substring(i, i + 1) < '0' || cardNum.substring(i, i + 1) > '9') {
            break;
            return false;
        }
    }
    if ((cardNum.substring(17, cardNum.length) < '0' || cardNum.substring(17, cardNum.length) > '9') && cardNum.substring(17, cardNum.length) != 'x') {
        return false;
    }
    return true;
}

//身份证地址验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 *		idCardId	身份证号输入的ID
 */
function check_idCardAddress(tagId, locate, idCardId) {
    var e_value = $("#" + tagId).val();
    var str_idCard = $("#" + idCardId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    //省份编码
    var provinceCode = new Array(
        {provinceId: "11", provinceName: "北京"},
        {provinceId: "12", provinceName: "天津"},
        {provinceId: "13", provinceName: "河北"},
        {provinceId: "14", provinceName: "山西"},
        {provinceId: "15", provinceName: "内蒙古"},
        {provinceId: "21", provinceName: "辽宁"},
        {provinceId: "22", provinceName: "吉林"},
        {provinceId: "23", provinceName: "黑龙江"},
        {provinceId: "31", provinceName: "上海"},
        {provinceId: "32", provinceName: "江苏"},
        {provinceId: "33", provinceName: "浙江"},
        {provinceId: "34", provinceName: "安徽"},
        {provinceId: "35", provinceName: "福建"},
        {provinceId: "36", provinceName: "江西"},
        {provinceId: "37", provinceName: "山东"},
        {provinceId: "41", provinceName: "河南"},
        {provinceId: "42", provinceName: "湖北"},
        {provinceId: "43", provinceName: "湖南"},
        {provinceId: "44", provinceName: "广东"},
        {provinceId: "45", provinceName: "广西"},
        {provinceId: "46", provinceName: "海南"},
        {provinceId: "50", provinceName: "重庆"},
        {provinceId: "51", provinceName: "四川"},
        {provinceId: "52", provinceName: "贵州"},
        {provinceId: "53", provinceName: "云南"},
        {provinceId: "54", provinceName: "西藏"},
        {provinceId: "61", provinceName: "陕西"},
        {provinceId: "62", provinceName: "甘肃"},
        {provinceId: "63", provinceName: "青海"},
        {provinceId: "64", provinceName: "宁夏"},
        {provinceId: "65", provinceName: "新疆"},
        {provinceId: "71", provinceName: "台湾"},
        {provinceId: "81", provinceName: "香港"},
        {provinceId: "82", provinceName: "澳门"},
        {provinceId: "91", provinceName: "国外"}
    );
    //alert(provinceCode[5].provinceId);
    if (e_value.length == 0) {
        show_warning(e_warning, e_success, e_normal, "身份证地址不能为空");
        return false;
    } else {
        if (str_idCard.length == 0) {
            show_warning(e_warning, e_success, e_normal, "请先输入身份证号码，再输入地址信息");
            return false;
        } else {
            var str_pCode = str_idCard.substr(0, 2);
            var str_pName = '';
            for (var i = 0; i < provinceCode.length; i++) {
                if (str_pCode == provinceCode[i].provinceId) {
                    str_pName = provinceCode[i].provinceName;
                    break;
                }
            }
            if (str_pName == '') {
                show_warning(e_warning, e_success, e_normal, "您输入的身份证号码有误，请检查身份证号码后重新输入身份证号码");
                return false;
            } else if (e_value.match(str_pName)) {
                show_success(e_warning, e_success, e_normal, "正确");
                return true;
            } else {
                show_warning(e_warning, e_success, e_normal, "您输入的地址与身份证不符，请核对后重新输入");
                return false;
            }
        }
    }

}

//手机号验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_mobile(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == '') {
        show_warning(e_warning, e_success, e_normal, "手机号不能为空");
        return false;
    } else if (e_value.length != 11) {
        show_warning(e_warning, e_success, e_normal, "手机号码位数为11位");
        return false;
    } else {
        if (check_letter(e_value)) {
            show_success(e_warning, e_success, e_normal, "正确");
            return true;
        } else {
            show_warning(e_warning, e_success, e_normal, "手机号必须全为数字");
            return false;
        }
    }
    function check_letter(phoneNum) {
        for (var i = 0; i < phoneNum.length; i++) {
            if (phoneNum.charAt(i) < '0' || phoneNum.charAt(i) > '9') {
                return false;
            }
        }
        return true;
    }
}

//电子邮箱验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_mail(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length < 0 || e_value == '') {
        show_warning(e_warning, e_success, e_normal, "电子邮箱不能为空");
        return false;
    } else if (e_value.match("@")) {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    } else {
        show_warning(e_warning, e_success, e_normal, "电子邮箱格式不正确");
        return false;
    }
}
//联系地址验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_address(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length < 0 || e_value == '') {
        show_warning(e_warning, e_success, e_normal, "地址不能为空");
        return false;
    } else if (e_value.length < 4) {
        show_warning(e_warning, e_success, e_normal, "请填写详细地址，以方便与您的沟通");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}
//原密码验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_accountPassword(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length < 6) {
        show_warning(e_warning, e_success, e_normal, "原密码不正确");
        return false;
    } else {
        /*ajax异步验证*/
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}
//新密码验证
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_newAccountPassword(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0) {
        show_warning(e_warning, e_success, e_normal, "密码不能为空");
        return false;
    } else if (e_value.length < 6) {
        show_warning(e_warning, e_success, e_normal, "密码不能少于6位");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}
//新密码重复验证
/*
 *PARAM:	tagId		重复密码输入框ID
 *		locate		显示提示位置ID
 *		tagId2		新密码输入框ID
 */
function check_newAccountPasswordRe(tagId, locate, tagId2) {
    var e_value = $("#" + tagId).val();
    var e_value2 = $("#" + tagId2).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length >= 6) {
        if (e_value == e_value2) {
            show_success(e_warning, e_success, e_normal, "正确");
            return true;
        } else {
            show_warning(e_warning, e_success, e_normal, "密码不一致");
            return false;
        }
    } else {
        show_warning(e_warning, e_success, e_normal, "密码不一致");
        return false;
    }
}

//交易ID检验
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_tradingId(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "交易号码不能为空");
        return false;
    } else if (e_value.length < 15 || e_value.length > 15) {
        show_warning(e_warning, e_success, e_normal, "交易号码为15位，请核对");
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}
//会员ID检验
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_memberId(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "会员账号不能为空");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}

//订单号ID检验
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_orderId(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "订单号不能为空");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}
//快递单号ID检验
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_expressId(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "快递单号不能为空");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}

//快递公司检验
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 *		tagId		其他快递公司输入ID
 */
function check_expressCompany(tagId, locate, tagId2) {
    var e_value = $("#" + tagId).find("option:selected").val();
    var e_value2 = $("#" + tagId2).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value != 'empty') {
        show_success(e_warning, e_success, e_normal, "正确");
        $("#" + tagId2).addClass("hidden");
        return true;
    } else if (e_value2.length == 0) {
        $("#" + tagId2).removeClass("hidden");
        show_warning(e_warning, e_success, e_normal, "请选择或输入一个快递公司");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}

/***商品录入**/
//商品名称
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_commodityName(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "商品名称不能为空");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}

//商品分类
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 *		tagId		其他商品分类输入ID
 */
function cehck_commodityType(tagId, locate, tagId2, tagId3) {
    var e_value = $("#" + tagId).find("option:selected").val();
    var e_value2 = $("#" + tagId2).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value != 'empty') {
        show_success(e_warning, e_success, e_normal, "正确");
        $("#" + tagId2).addClass("hidden");
        $("#" + tagId3).addClass("hidden");
        return true;
    } else if (e_value2.length == 0) {
        $("#" + tagId2).removeClass("hidden");
        $("#" + tagId3).addClass("hidden");
        show_warning(e_warning, e_success, e_normal, "请选择或输入一个商品分类");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}

//兑换商品所需积分
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_commodityPointer(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "积分不能为空");
        return false;
    } else {
        if (check_letter(e_value)) {
            show_success(e_warning, e_success, e_normal, "正确");
            return true;
        } else {
            show_warning(e_warning, e_success, e_normal, "积分只能为数字");
            return false;
        }
    }
    function check_letter(str) {
        for (var i = 0; i < str.length; i++) {
            if (str.charAt(i) < '0' || str.charAt(i) > '9') {
                return false;
            }
        }
        return true;
    }
}

//商品网络链接地址
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_commodityLink(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "商品网络链接不能为空");
        return false;
    } else if (e_value.match("http://") || e_value.match("https://")) {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    } else {
        show_warning(e_warning, e_success, e_normal, "商品网络链接为http://或https://开头。");
        return false;
    }
}
//商品图片
/*
 *PARAM:	tagId		输入框ID
 *		locate		显示提示位置ID
 */
function check_commodityImage(tagId, locate) {
    var e_value = $("#" + tagId).val();
    var e_normal = $("#" + locate).children(".normal");
    var e_warning = $("#" + locate).children(".warning");
    var e_success = $("#" + locate).children(".success");
    if (e_value.length == 0 || e_value == "") {
        show_warning(e_warning, e_success, e_normal, "商品图片不能为空");
        return false;
    } else {
        show_success(e_warning, e_success, e_normal, "正确");
        return true;
    }
}
