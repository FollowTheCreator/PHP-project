function deleteCookie() {
    document.cookie = "hash=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "login=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "type=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.location = "http://findtofind/main.php";
}
function setCookie(cookievalue){
    var date = new Date(new Date().getTime() + 10 * 1000);
    document.cookie = "currid="+cookievalue+"; path=/; expires=" + date.toUTCString();
}

function setCenter(X,Y){
    mX = X;
    mY = Y;
    fzoom = 16;
    init();
}

function checkloc(){
    loc = document.location.href;
    loc = loc.substr(0, 33);
}

function checkloc1(){
    loc1 = document.location.href;
    loc1 = loc1.substr(0, 35);
}

var currsel = "search.php?now=vac";
function chng(el)
{
    var form1 = document.getElementById("form1");
    currsel = el.options[el.selectedIndex].className;
    form1.action = el.options[el.selectedIndex].value;
}

function locat(el)
{
    document.location = currsel;
}

function link(address)
{
    document.location = address;
}

function addkey(){
    $(".contkey").append("<div class = 'inp'><input class = 'forkey' type = 'text' name = 'keyskill[]' onblur = 'addkey1(this)' maxlength='32'></input><text onclick = 'del(this)' class = 'hand'>X</text></div>");
    $(".inp").last().find(".forkey").focus();
}
function addkey1(el){
    if ($(el).val() == ""){
        $(el).parent().remove();
    }
}
function del(el){
    $(el).parent().remove();
}

function addedu(){
    if($(".inp1").last().find(".eduprof").val() != "" && $(".inp1").last().find(".eduinst").val() != "" && $(".inp1").last().find(".eduend").val() != "")
    {
        $(".edu").append("<div class = 'inp1'><input class = 'eduprof' type = 'text' name = 'educprof[]' placeholder = 'Профессия по диплому' onblur = 'addedu1(this)' required maxlength='100'></input><br><input class = 'eduinst' type = 'text' name = 'educinst[]' placeholder = 'Учебное заведение' onblur = 'addedu1(this)' required maxlength='100'></input><br><input class = 'eduend' type = 'text' name = 'educend[]' onblur = 'addedu1(this)' placeholder = 'Год окончания' required></input><br><text onclick = 'deledu(this)' class = 'hand'>X</text></div>");
        $(".inp1").last().find(".eduprof").focus();
    }
}
function addedu1(el){
    if($(el).parent().find(".eduprof").val() == "" && $(el).parent().find(".eduinst").val() == "" && $(el).parent().find(".eduend").val() == "")
    {
        $(el).parent().remove();
    }
}
function deledu(el){
    $(el).parent().remove();
}

function addcurs(){
    if($(".inp2").last().find(".cursprof").val() != "" && $(".inp2").last().find(".cursinst").val() != "" && $(".inp2").last().find(".cursend").val() != "")
    {
        $(".curs").append("<div class = 'inp2'><input class = 'cursprof' type = 'text' name = 'cursprof[]' placeholder = 'Название курса' onblur = 'addcurs1(this)' required maxlength='100'></input><br><input class = 'cursinst' type = 'text' name = 'cursinst[]' placeholder = 'Учебное заведение' onblur = 'addcurs1(this)' required maxlength='100'></input><br><input class = 'cursend' type = 'text' name = 'cursend[]' onblur = 'addcurs1(this)' placeholder = 'Год окончания' required></input><br><text onclick = 'delcurs(this)' class = 'hand'>X</text></div>");
        $(".inp2").last().find(".cursprof").focus();
    }
}
function addcurs1(el){
    if($(el).parent().find(".cursprof").val() == "" && $(el).parent().find(".cursinst").val() == "" && $(el).parent().find(".cursend").val() == "")
    {
        $(el).parent().remove();
    }
}
function delcurs(el){
    $(el).parent().remove();
}

function addjob(){
    if($(".inp3").last().find(".jobcom").val() != "" && $(".inp3").last().find(".jobpost").val() != "" && $(".inp3").last().find(".jobabo").val() != "" && $(".inp3").last().find(".jobtime").val() != "" && $(".inp3").last().find(".jobend").val() != "")
    {
        $(".job").append("<div class = 'inp3'><input class = 'jobcom' type = 'text' name = 'jobcom[]' placeholder = 'Компания' onblur = 'addjob1(this)' maxlength='100' required></input><br><input class = 'jobpost' type = 'text' name = 'jobpost[]' placeholder = 'Должность' onblur = 'addjob1(this)' maxlength='100' required></input><br><input class = 'jobabo' type = 'text' name = 'jobabo[]' placeholder = 'Описание работы' onblur = 'addjob1(this)' maxlength='500'></input><br><text class = 'jobtimetext'>Дата начала работы:</text><input class = 'jobtime' type = 'date' name = 'jobtime[]' onfocus = 'setmax(this)' onblur = 'addjob1(this)' required></input><br><text class = 'jobendtext'>Дата окончания работы:</text><input class = 'jobend' type = 'date' name = 'jobend[]' onfocus = 'setmin(this)' onblur = 'addjob1(this)' required></input><br><text onclick = 'deljob(this)' class = 'hand'>X</text></div>");
        $(".inp3").last().find(".jobcom").focus();
    }
}
function addjob1(el){
    if($(el).parent().find(".jobcom").val() == "" && $(el).parent().find(".jobpost").val() == "" && $(el).parent().find(".jobtime").val() == "" && $(el).parent().find(".jobend").val() == "")
    {
        $(el).parent().remove();
    }
}

function setmax(el){
    $(el).attr("max", $(el).next().next().next().val());
}
function setmin(el){
    $(el).attr("min", $(el).prev().prev().prev().val());
}
function deljob(el){
    $(el).parent().remove();
}

$(document).ready(function(){
    var requiredCheckboxes = $('.prof1 :checkbox[required]');
    if(requiredCheckboxes.is(':checked')) {
        requiredCheckboxes.removeAttr('required');
    } 
    requiredCheckboxes.change(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});

$(document).ready(function(){
    var schet = 0;
    $(".prof3").not("[checked]").parent().parent().find(".prof1").hide();
    $(".prof2").each(function(){
        if($(this).prop("checked") == true){
            schet++;
        }
    });
    $("text.prof").click(function(){
        if($(this).parent().next().css("display") == "none")
        {
            $("ul.prof1").hide(300);
            $(this).parent().next().show(300);
        }
        else
        {
            $(this).parent().next().hide(300);
        }
    });
    $("text.searchprof").parent().find(".searchprof1").hide();
    $("text.searchprof").click(function(){
        if($(this).parent().find(".searchprof1").css("display") == "none")
        {
            $(this).parent().find(".searchprof1").show(300);
        }
        else
        {
            $(this).parent().find(".searchprof1").hide(300);
        }
    });
    $("input.prof3").click(function(){
        schet = 0;
        $(".prof2").prop("checked", false);
    });
    $(".prof2").click(function(){
        if($(this).prop("checked") == false){
            schet--;
        }
        if($(this).prop("checked") == true){
            schet++;
        }
        if(schet > 3){
            $(this).prop("checked", false);
            schet--;
        }
    });
}); 

$(document).ready(function(){
    $("ul.prof1s").hide();
    $("text.profs").click(function(){
        if($(this).next().css("display") == "none")
        {
            $(this).next().show(300);
        }
        else
        {
            $(this).next().hide(300);
        }
    });
    $("input.prof3s").click(function(){
        if($(this).prop("checked") == true){
            $(this).next().next().find(".prof2s").prop("checked", true);
        }
        else {
            $(this).next().next().find(".prof2s").prop("checked", false);
        }   
    });
    $("input.searchprof3").click(function(){
        if($(this).prop("checked") == true){
            $(this).next().next().find(".searchprof2").prop("checked", true);
        }
        else {
            $(this).next().next().find(".searchprof2").prop("checked", false);
        }   
    });
}); 

$(document).ready(function(){
    $("[name='addvacan']").click(function() {
        var isFormValidCheck = false;
        var isFormValidText = true;
        $(this).parent().find("[required]").each(function(){
            if($(this).attr('type') == 'text' && $(this).val() == "")
            {
                isFormValidText = false;
            }
            if($(this).attr('type') == 'mail' && $(this).val() == "")
            {
                isFormValidText = false;
            }
            if($(this).is('textarea') && $(this).val() == "")
            {
                isFormValidText = false;
            }
        });
        $(this).parent().find(".prof2").each(function(){
            if($(this).prop("checked")) 
            {
                isFormValidCheck = true;
            }
        });
        if(!isFormValidCheck || !isFormValidText) alert('Необходимо заполнить все обязательные поля');
    });
});

$(document).ready(function(){
    $("[name='addresum']").click(function() {
        var isFormValidCheck = false;
        var isFormValidText = true;
        $(this).parent().find("[required]").each(function(){
            if($(this).attr('type') == 'text' && $(this).val() == "")
            {
                isFormValidText = false;
            }
            if($(this).attr('type') == 'mail' && $(this).val() == "")
            {
                isFormValidText = false;
            }
            if($(this).is('textarea') && $(this).val() == "")
            {
                isFormValidText = false;
            }
        });
        $(this).parent().find(".prof2").each(function(){
            if($(this).prop("checked")) 
            {
                isFormValidCheck = true;
            }
        });
        if(!isFormValidCheck || !isFormValidText) {alert('Необходимо заполнить все обязательные поля');}
    });
});

function updateinp(el){
    $(el).css("display", "none");
    $(el).prev().attr("readonly", false).focus();
    $(el).prev().css("border-bottom", "solid #555555 2px");
    $(el).parent().find("[name='save']").css("display", "inline");
}
function updatepas(el){
    $(el).next().css("display", "block");
    $(el).parent().find("[name='save']").css("display", "inline");
}

$(document).ready(function(){
    $(".forupdate").click(function(e){
        e.stopPropagation();
    });
    $(".fordelete").click(function(e){
        e.stopPropagation();
    });
});

function reload(){
    if (window.location.href.substr(-6) !== '?saved') {
        window.location = window.location.href + '?saved';
    }
    window.location.href = window.location.href;
}







$(document).ready(function(){
    var slides = document.querySelectorAll('#slides .slide');
    var currentSlide = 0;
    var slideInterval = setInterval(nextSlide,20000);
    
    function nextSlide(){
        goToSlide(currentSlide+1);
    }
    
    function previousSlide(){
        goToSlide(currentSlide-1);
    }
    
    function goToSlide(n){
        slides[currentSlide].className = 'slide';
        currentSlide = (n+slides.length)%slides.length;
        slides[currentSlide].className = 'slide showing';
    }
});

$(document).ready(function(){
    $(".mainfield").mouseenter(function(){
        $(this).css("filter", "blur(5px) grayscale(100%)");
        $(this).next().css("opacity", "1");
    }).mouseleave(function(){
        $(this).css("filter", "none");
        $(this).next().css("opacity", "0");
    });
    $(".center").mouseenter(function(){
        $(this).css("opacity", "1");
        $(this).prev().css("filter", "blur(5px) grayscale(100%)");
    }).mouseleave(function(){
        $(this).css("opacity", "0");
        $(this).prev().css("filter", "none");
    });
});

function slidelogin(el){
    if($(el).parent().css('top') == '300px')
    {
        $(el).parent().css('top', '0px');
        $(el).html('АВТОРИЗАЦИЯ');
        $(el).parent().parent().find(".formlogin").css('top', '80px');
        $(el).parent().parent().find(".formreguser").css('top', '430px');
        $(el).parent().parent().find(".formregcom").css('top', '420px');
    }
    else if($(el).parent().css('top') == '0px')
    {
        $(el).parent().css('top', '300px');
        $(el).html('РЕГИСТРАЦИЯ');
        $(el).parent().parent().find(".formlogin").css('top', '30px');
        $(el).parent().parent().find(".formreguser").css('top', '390px');
        $(el).parent().parent().find(".formregcom").css('top', '380px');
    }
}
