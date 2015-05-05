function GetXmlHttpObject()
{
    var xmlhttp = false;
    /*@cc_on @*/
    /*@if (@_jscript_version >= 5)
     // JScript gives us Conditional compilatiolistdropdownChangedn, we can cope with old IE versions.
     // and security blocked creation of the objects.
     try {addFilterConditions
     xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
     } catch (e) {
     try {toEnableSkill
     xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
     } catch (E) {
     xmlhttp = false;
     }verifySIPtgSettingsmanagerRoleMenuVaalidations
     }
     @end @*/
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
    {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;

}

function delTeam(team_id, p_name) {
    var URL = "ajaxHandle.php"
    var xmlhttp = false;
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp)
    {
        xmlhttp.open('POST', URL, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xmlhttp.send("team_id=" + team_id + "&act=delTeam");
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                if (xmlhttp.responseText) {
                    window.location = "home.php?p_name=" + p_name;
                }
                else {
                    alert('Failed to Delete Teams');
                }
            }
        }
        delete xmlhttp;
    }
}

function changeTeam() {
    var arg = document.getElementById('select1').value;
    var URL = "ajaxHandle.php"
    var xmlhttp = false;
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp)
    {
        xmlhttp.open('POST', URL, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xmlhttp.send("t_name=" + arg + "&act=changeTeam");
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById('assigned').value = xmlhttp.responseText;
            }
        }
        delete xmlhttp;
    }
}

function validateTaskAdd(event, p_name) {
    if (event == 'cancel') {
        document.forms[0].submit();
    }
    else {
        var flag = 1;
        var flag2 = 1;
        var msg = '<i>Fill Necessary Details</i>';
        var strtDate = document.getElementById('datepicker1');
        var relDate = document.getElementById('datepicker2');
        var tskName = document.getElementById('task_name');
        strtDate.style.border = '';
        relDate.style.border = '';
        tskName.style.border = '';
        document.getElementById('select1').style.border = '';
        if (tskName.value == '') {
            tskName.style.border = '1px solid red';
            flag = 0;
        }
        if (relDate.value == '') {
            relDate.style.border = '1px solid red';
            flag = 0;
        }
        if (strtDate.value == '') {
            strtDate.style.border = '1px solid red';
            flag = 0;
        }
        if (document.getElementById('select1').value == '') {
            document.getElementById('select1').style.border = '1px solid red';
            flag = 0;
        }
        if (flag) {
            var date1 = new Date(document.getElementById('datepicker1').value);
            var date2 = new Date(document.getElementById('datepicker2').value);
            var diffDays = date2.getTime() - date1.getTime();
            flag2 = 0;
            if (isNaN(diffDays)) {
                msg = 'NaN Error : Incosistent Data.';
            }
            else if (diffDays < 1) {
                strtDate.style.border = '1px solid red';
                relDate.style.border = '1px solid red';
                msg = '<i> Start Date can not be Greater than Release Date.';
            }
            else
                flag2 = 1;
        }
        if (flag && flag2) {
            document.forms[0].action = "addTask.php?p_name=" + p_name;
            document.getElementById('task_type').disabled = false;
            document.forms[0].submit();
        }
        else {
            document.getElementById('msgdiv').innerHTML = msg;
        }
    }
}

function validateTskUpdate(param) {
    var flag = 1;
    var flag2 = 1;
    var msg = '<i>Fill Necessary Details</i>';
    var strtDate = document.getElementById('datepicker1');
    var relDate = document.getElementById('datepicker2');
    strtDate.style.border = '';
    relDate.style.border = '';
    if (relDate.value == '') {
        relDate.style.border = '1px solid red';
        flag = 0;
    }
    if (strtDate.value == '') {
        strtDate.style.border = '1px solid red';
        flag = 0;
    }
    if (flag) {
        var date1 = new Date(document.getElementById('datepicker1').value);
        var date2 = new Date(document.getElementById('datepicker2').value);
        var diffDays = date2.getTime() - date1.getTime();
        flag2 = 0;
        if (isNaN(diffDays)) {
            msg = 'NaN Error : Incosistent Data.';
        }
        else if (diffDays < 1) {
            strtDate.style.border = '1px solid red';
            relDate.style.border = '1px solid red';
            msg = '<i> Start Date can not be Greater than Release Date.';
        }
        else
            flag2 = 1;
    }
    if (flag && flag2) {
        document.forms[0].action = "taskUpdate.php?task_name=" + param;
        document.forms[0].submit();
    }
    else {
        document.getElementById('msgdiv').innerHTML = msg;
    }

}

function checkDup(event) {
    arg = "p_name="
    if (event != '') {
        arg += event + "&task_name="
        arg += encodeURI(document.getElementById('task_name').value);
    } else {
        arg += encodeURI(document.getElementById('project_name').value);
    }
    arg += "&act=checkDup"
    var URL = "ajaxHandle.php"
    var xmlhttp = false;
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp)
    {
        xmlhttp.open('POST', URL, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xmlhttp.send(arg);
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                if (xmlhttp.responseText) {
                    if (event != '') {
                        arg = "A Task already exist with this name. Choose a different name.";
                        document.getElementById('task_name').style.border = '1px solid red';
                    }
                    else {
                        arg = "A Project already exist with this name. Choose a different name.";
                        document.getElementById('project_name').style.border = '1px solid red';
                    }
                }
                else {
                    arg = '';
                    if (event != '')
                        document.getElementById('task_name').style.border = '';
                    else
                        document.getElementById('project_name').style.border = '';
                }
                document.getElementById('msgdiv').innerHTML = arg;
            }
        }
        delete xmlhttp;
    }
}

function validatepro(p_name) {
    if (document.getElementById('cancel').value == 'clicked') {
        document.forms[0].submit();
    }
    var strtDate = document.getElementById('datepicker1');
    var relDate = document.getElementById('datepicker2');
    var desc = document.getElementById('location2');
    var flag = 1;
    var flag2 = 1;
    var msg = '<i>Fill Necessary Details</i>';
    if (p_name == '') {
        document.getElementById('project_name').style.border = '';
        if (document.getElementById('project_name').value == '') {
            document.getElementById('project_name').style.border = '1px solid red';
            flag = 0;
        }
    }
    strtDate.style.border = ''
    if (strtDate.value == '') {
        strtDate.style.border = '1px solid red';
        flag = 0;
    }
    relDate.style.border = '';
    if (relDate.value == '') {
        relDate.style.border = '1px solid red';
        flag = 0;
    }
    desc.style.border = '';
    if (desc.value == '') {
        desc.style.border = '1px solid red';
        flag = 0;
    }
    if (flag) {
        var date1 = new Date(document.getElementById('datepicker1').value);
        var date2 = new Date(document.getElementById('datepicker2').value);
        var diffDays = date2.getTime() - date1.getTime();
        flag2 = 0;
        if (isNaN(diffDays)) {
            msg = 'NaN Error : Incosistent Data.';
        }
        else if (diffDays < 1) {
            strtDate.style.border = '1px solid red';
            relDate.style.border = '1px solid red';
            msg = '<i> Start Date can not be Greater than Release Date.';
        }
        else
            flag2 = 1;
    }
    if (flag && flag2) {
        if (p_name == '')
            document.forms[0].action = "addProject.php";
        else
            document.forms[0].action = "editProject.php?p_name=" + p_name;
        return true;
    }
    else {
        document.getElementById('msgdiv').innerHTML = msg;
    }
    return false;
}

//function submitform() {
//    if (document.getElementById('update').value == 'EDIT') {
//        document.getElementById('update').value = 'UPDATE';
//        document.getElementById('select1').disabled = false;
//        document.getElementById('datepicker1').readOnly = false;
//        document.getElementById('langs').readOnly = false;
//        document.getElementById('efforts').readOnly = false;
//        document.getElementById('link').readOnly = false;
//        document.getElementById('notes').readOnly = false;
//        document.getElementById('bugs').readOnly = false;
//    }
//    else if (document.getElementById('update').value == 'UPDATE') {
//        document.forms[0].submit();
//    }
//    else {
//        alert('JAVA SCRIPT ERROR!!!');
//    }
//
//}

var wnd = null;
var teamWnd = null;

function popup(url, name, width, height, options)
{
    var x = (screen.width - width) / 2,
            y = (screen.height - height) / 2
            ;

    options += ', left=' + x +
            ', top=' + y +
            ', width=' + width +
            ', height=' + height +
            ', titlebar=no' +
            ', toolbar=no' +
            ', menubar=no' +
            ', status=no' +
            ', channelmode=yes' +
            ', location=no'
            ;
    options = options.replace(/^,/, '');
    wnd = window.open(url, name, options);
    wnd.focus();
    return wnd;
}

function par_disable() {
    if (wnd && !wnd.closed) {
        wnd.close();
        wnd = null;
    }
    if (teamWnd && !teamWnd.closed) {
        teamWnd.close();
        teamWnd = null;
    }
}

function passChecklist() {
    wnd = popup('selectPro.php?bulkedit=true', 'proWindow', 500, 500, 'scrollbars=1');
}

function addTeam(p_name) {
    teamWnd = popup('addTeam.php?addteam=true&p_name=' + p_name, 'teamWindow', 550, 200, '');
}

function addTeamValidation() {
    document.getElementById('team_name').style.border = '';
    document.getElementById('team_name').style.border = '';
    if (document.getElementById('team_name').value == '') {
        document.getElementById('team_name').style.border = '1px solid red';
        document.getElementById('msgdiv').innerHTML = "<h5><i style='color : red'>Fill Details</i></h5>";
    } else if (document.getElementById('iqe').value == '') {
        document.getElementById('iqe').style.border = '1px solid red';
        document.getElementById('msgdiv').innerHTML = "<h5><i style='color : red'>Fill Details</i></h5>";
    }
    else {
        var arg = document.getElementById('team_name').value;
        var arg1 = document.getElementById('p_name').value;
        var arg2 = document.getElementById('iqe').value;
        var URL = "ajaxHandle.php"
        var xmlhttp = false;
        xmlhttp = GetXmlHttpObject();
        if (xmlhttp)
        {
            xmlhttp.open('POST', URL, true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xmlhttp.send("t_name=" + arg + "&p_name=" + arg1 + "&iqe=" + arg2 + "&act=TeamAdd");
            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    if (xmlhttp.responseText) {
                        document.getElementById('team_name').style.border = '1px solid red';
                        document.getElementById('msgdiv').innerHTML = "<h5><i style='color : red'>Team Already Exists</i></h5>";
                    } else {
                        self.close();
                        window.opener.location.href = "home.php?p_name=" + arg1;
                    }
                }
            }
        }
    }
}

function getPro() {
    var field = document.proPopUP.check_list;
    var pro = '';
    var len = field.length;
    if (len == undefined) {
        if (field.checked == true) {
            pro = "'" + field.value + "'";
        }
    }
    else {
        for (i = 0; i < len; i++) {
            if (field[i].checked == true)
                pro += "'" + field[i].value + "',";
        }
        pro = pro.substr(0, pro.length - 1);
    }
    var URL = "ajaxHandle.php"
    var xmlhttp = false;
    xmlhttp = GetXmlHttpObject();
    if (xmlhttp)
    {
        xmlhttp.open('POST', URL, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xmlhttp.send("proList=" + encodeURI(pro) + "&act=addtoSession");
        xmlhttp.onreadystatechange = function ()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                if (xmlhttp.responseText) {
//                    document.getElementById('TaskTeam').innerHTML = xmlhttp.responseText;
                    self.close();
                    window.opener.location.href = "home.php?bulkedit=true";
                }
            }
        }
        delete xmlhttp;
    }
}

function getTaskTeam() {
    if (document.getElementById('project').value == '')
        document.getElementById('TaskTeam').innerHTML = 'Team : <input type=\"text\" name=\"team\"> Task : <input type=\"text\" name=\"task\">';
    else {
        var arg = document.getElementById('project').value;
        var URL = "ajaxHandle.php"
        var xmlhttp = false;
        xmlhttp = GetXmlHttpObject();
        if (xmlhttp)
        {
            xmlhttp.open('POST', URL, true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xmlhttp.send("projectname=" + arg + "&act=getTaskTeam");
            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    if (xmlhttp.responseText) {
                        document.getElementById('TaskTeam').innerHTML = xmlhttp.responseText;
                    }
                }
            }
            delete xmlhttp;
        }
    }
}

function checkUncheck(obj) {
    var field = document.proPopUP.check_list;
    var put;
    if (obj.checked == true)
        put = true;
    else
        put = false;
    for (i = 0; i < field.length; i++) {
        field[i].checked = put;
    }
}

function changeTask() {
    if (document.getElementById('task_type').value == 'Linguistic') {
        document.getElementById('link').innerHTML = 'Link To Screenshots';
    }
    else if (document.getElementById('task_type').value == 'Functional') {
        document.getElementById('link').innerHTML = 'Link To Test Cases';
    }
}

function clicked() {
    document.getElementById('cancel').value = 'clicked';
}