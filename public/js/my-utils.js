function fbPrintReport(href)
{
    $.fancybox({
        "width"			: "100%",
        "height"		: "100%",
        "autoScale"    	: false,
        "href"			: href,
        "type"			: "iframe",
        "transitionIn"	: "elastic",
        "transitionOut"	: "elastic",
        "speedIn"       : 600,
        "speedOut"      : 200,
        "overlayShow"   : true,
        "overlayColor"  : "#000",
        "titlePosition" : "over"
    });
}

function deleteSelected(tableObj, descriptionColumnIdx, actionUrl, buttonCancelFunction)
{
    actionSelected(
        tableObj,
        descriptionColumnIdx,
        actionUrl,
        buttonCancelFunction,
        "Tem certeza que deseja excluir estes itens?",
        "Excluir selecionados",
        "Cancelar"
    );
}

function deleteRow(row, tableObj, descriptionColumnIdx, actionUrl)
{
    //Desmarca tudo primeiro
    $(tableObj).find('tr').find(':checkbox:first').attr('checked', false);
    // Marca a checkbox
    $(row).closest("tr").find(":checkbox:first").attr("checked", true);
    deleteSelected(
        tableObj,
        descriptionColumnIdx,
        actionUrl,
        function() {
            $(row).closest("tr").find(":checkbox:first").attr("checked", false);
            retornoConfirm = false;
        }
    );
}

function actionRow(row, tableObj, descriptionColumnIdx, actionUrl, title, buttonOk, buttonCancel)
{
    //Desmarca tudo primeiro
    $(tableObj).find('tr').find(':checkbox:first').attr('checked', false);
    // Marca a checkbox
    $(row).closest("tr").find(":checkbox:first").attr("checked", true);
    actionSelected(
        tableObj,
        descriptionColumnIdx,
        actionUrl,
        function() {
            $(row).closest("tr").find(":checkbox:first").attr("checked", false);
            retornoConfirm = false;
        },
        title,
        buttonOk,
        buttonCancel
    );
}

function actionSelected(tableObj, descriptionColumnIdx, actionUrl, buttonCancelFunction, title, buttonOk, buttonCancel)
{
    var selecteds = $(tableObj).find(":checkbox:checked").not(".checkall").closest("tr");

    if(selecteds.exists())
    {
        var description = "";
        $.each(selecteds, function(idx, item) {
            if(description.length > 0) description += "<br/>";
            description += tableObj.fnGetData(item)[descriptionColumnIdx];
        });

        confirmDialog(
            title,
            description,
            buttonOk,
            buttonCancel,
            function() {
                $(tableObj).wrap("<form method='post' id='confirm_form' action='"+actionUrl+"'>"); $("#confirm_form").submit();
            },
            buttonCancelFunction
        );
    }
}


function confirmDialog(title, html, buttonOk, buttonCancel, buttonOkFunction, buttonCancelFunction, width, height, iconType)
{
    var retornoConfirm = false;

    title = typeof title !== 'undefined' ? title : "Você tem certeza?";
    html = typeof html !== 'undefined' ? html : "Você tem certeza?";
    buttonOk = typeof buttonOk !== 'undefined' ? buttonOk : "Sim";
    buttonCancel = typeof buttonCancel !== 'undefined' ? buttonCancel : "Não";
    buttonOkFunction = typeof buttonOkFunction !== 'undefined' ? buttonOkFunction : function() { retornoConfirm = true; };
    buttonCancelFunction = typeof buttonCancelFunction !== 'undefined' ? buttonCancelFunction : function() { retornoConfirm = false; };
    width = typeof width !== 'undefined' ? width : 400;
    height = typeof height !== 'undefined' ? height : "auto";
    iconType = typeof iconType !== 'undefined' ? iconType : "ui-icon-alert";

    var buttons = { };
    buttons[buttonCancel] = function() {
        buttonCancelFunction();
        $( this ).dialog( "close" );
    };

    buttons[buttonOk] = function() {
        buttonOkFunction();
        $( this ).dialog( "close" );
    };

    //$("#dialog-confirm").attr("title", title);
    $("#dialog-confirm-text").html(html);
    $("#dialog-confirm-icon").addClass(iconType);

    $("#dialog-confirm").dialog({
        title: title,
        autoOpen: true,
        closeText: '',
        resizable: false,
        minWidth: 400,
        minHeight: 150,
        width: width,
        height: height,
        modal: true,
        buttons: buttons
    });

    return retornoConfirm;
}


function dumpElement( jqueryElement ) {

    var element = jqueryElement.get(0);
    var elementDump;

    // dump element attributes
    var attrDump = '';

    var attribute;
    var dumpedAttribute;
    for( var i = 0; i < element.attributes.length; i++) {

        attribute = element.attributes[i];

        // skip every not specified attribute (useful for example in IE)
        if ( attribute.specified == false ) continue;

        // value correction
        if( (attribute.name == "value") && (attribute.value == "") && (element.value != "") )
            attribute.value = element.value;

        // current attribute dump
        dumpedAttribute = attribute.name + '="' + attribute.value + '"';

        // add current attribute to dump, separating attributes with whitespace
        attrDump += ((attrDump != '')?' ':'') + dumpedAttribute;
    }

    if(element.checked) {
        dumpedAttribute = 'checked="checked"';
        attrDump += ((attrDump != '')?' ':'') + dumpedAttribute;
    }

    var tagName = element.tagName.toLowerCase();

    // note: innerHTML does not preserve code formatting
    // note: innerHTML on IE sets the tags names to uppercase (e.g. not W3C Valid)
    if( element.innerHTML == '' ) {

        // self closing tag syntax
        elementDump = '<' + tagName + ((attrDump != '')? ' '+attrDump : '') + '/>';

    } else {

        elementDump = '<' + tagName + ((attrDump != '')? ' '+attrDump : '') + '>' +
            element.innerHTML +
            '</' + tagName + '>';
    }

    return elementDump;
}

// Funcao .exists() para jQuery
jQuery.fn.exists = function(){return this.length>0;}

// Funcao para centralizar uma DIV na tela
jQuery.fn.center = function () {
    this.css("position", "absolute");
    this.css("top", ($(window).height() - this.height())/ 2 + $(window).scrollTop() + "px");
    this.css("left", ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + "px");
    return this;
}


/*
    Pega o parametro passado via GET de nome NAME
*/
function get_parameter( name )
{
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( window.location.href );
    if( results == null )
        return "";
    else
        return results[1];
}

/*
Abrir tela de EXCLUIR via FancyBox, utilizando parametro via GET
*/
function fbConfirmDelete(href)
{
	$.fancybox({
        "width"         : 480,
        "height"        : 200,
	    "href"			: href,
        "autoScale"    	: true,
		"type"			: "iframe",
		"transitionIn"	: "elastic",
		"transitionOut"	: "elastic",
        "scrolling"     : "no",
        "modal"         : true,
        "speedIn"       : 600,
        "speedOut"      : 200,
        "overlayShow"   : true,
        "overlayColor"  : "#000"
	});
}

/*
Abrir tela de EXCLUIR via FancyBox, utilizando parametro via POST
*/
function fbConfirmDeletePost(href)
{
    var arr = new Array();
    $("input[name=check]:checked").each(function() {
        arr[arr.length] = $(this).val(); 
    }) // adiciona tudo no array
    
    if(arr.length > 0)
    {
        $.ajax({
            type     : "POST",
            cache    : false,
            url      : href,
            data     : {ids : arr},
            success  : function(data2) {
                $.fancybox({
                    "scrolling" : "no",
                    "modal"     : true,
                    "content"   : data2
                });
            }
        });
    } else {
        alert("Selecione ao menos 1 registro!");
    }
}


$(document).ready(function() {
    $("#messages:not(:has(.red))").hide().fadeIn("slow").delay(5000).fadeOut("slow");
});

/*
 Devido ao LAYOUT comprado,
 se for necessário mudar o valor selecionado numa COMBO será necessário utilizar esta função
 */
function atualizaSelect(id, valor)
{
    $("#" + id).selectmenu('value', $("#" + id + " > option[value='"+valor+"']").index());
}

/*
    Devido ao LAYOUT comprado,
    se for necessário CHECKAR uma checkbox via javascript é necessário utilizar esta função.
 */
function atualizaCheckbox(id, checked)
{
    $("#" + id).attr("checked", checked);
    $("#" + id).trigger('updateState');
}

/*
    Devido ao LAYOUT comprado,
    esta função é mais garantida de retornar um valor correto
 */
function isChecked(id)
{
    return $("#" + id).is(":checked");
}

function getValueFromInput(obj, checkedValue, uncheckedValue)
{
    checkedValue = typeof checkedValue !== 'undefined' ? checkedValue : true;
    uncheckedValue = typeof uncheckedValue !== 'undefined' ? uncheckedValue : false;

    var value;

    switch(obj.get(0).type)
    {
        case 'password':
        case 'text':
        case 'textarea':
            value = obj.val();
            break;
        case 'select-multiple':
        case 'select-one':
            value = obj.val()
            break;
        case 'checkbox':
        case 'radio':
            if(obj.get(0).checked)
                value = checkedValue;
            else
                value = uncheckedValue;
    }

    return value;
}

/*
    Limpa os itens de FORMULARIO filhos do ID passado no parâmetro
 */
function limparForm(id) {

    $("#"+id).find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'select-multiple':
            case 'select-one':
                $(this).val('');
                $(this).selectmenu('value',0);
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
                $(this).trigger('updateState');
        }
    });

}

function adicionarErroAoElementoDoForm(id, msgErro)
{
    if($("#" + id).parent().find(".errors").exists()) // valida se já existe a UL errors
    {
        $("#" + id).parent().find(".errors").append('<li>' + msgErro + '</li>');
    }
    else
    {
        $("#" + id).parent().append('<ul class="errors"><li>' + msgErro + '</li></ul>');
    }
}

function limparErrosDosForms()
{
    $("ul.errors").remove();
}

function isEmptyValue(obj, optionalCheckbox)
{
    optionalCheckbox = typeof optionalCheckbox !== 'undefined' ? optionalCheckbox : false;

    switch(obj.get(0).type) {
        case undefined:
        case 'password':
        case 'text':
        case 'textarea':
        case 'select-multiple':
        case 'select-one':
            if(obj.val() == "")
                return true;
            break;
        case 'checkbox':
        case 'radio':
            if(!obj.get(0).checked && !optionalCheckbox)
                return true;
    }

    return false;
}

function validarObrigatorios(arrayDeIds)
{
    $("ul.errors").remove();

    var houveErro = false;
    for (var i = 0; i < arrayDeIds.length; i++)
    {
        var id = arrayDeIds[i];
        var obj = $("#" + id );

        var exibeErro = false;
        exibeErro = isEmptyValue(obj);

        if(exibeErro)
        {
            adicionarErroAoElementoDoForm(id, "Campo obrigatório.");
            if(!houveErro)
            {
                $.scrollTo('#' + id, 0,  {offset:-50});
                houveErro = true;
            }
        }
    }

    return !houveErro;
}
/*
    Valida se o valor do form é inteiro;
 */
function form_input_is_int(input){
    return !isNaN(input)&&parseInt(input)==input;
}


ValidateAjax = {
    initialize: function(formid, url) {
        this.error = true;
        this.parentId = "";
        this.end_url = url;
        this.form_id = '#'+formid;
        $(this.form_id).submit(function(event) {
            if(ValidateAjax.error)
            {
                var valid = ValidateAjax.doValidate();
                if(!valid) {
                    event.preventDefault();
                }
                return valid;
            } else {
                return true;
            }
        });
    },
    doValidate: function() {
        var url = this.end_url;
        var data = $(this.form_id).serializeArray();
        $.ajax({
            type: "POST",
            url: url,
            async: false,
            data: data,
            success: function(response) {
                ValidateAjax.error = false;

                $(ValidateAjax.form_id).find('.errors').remove();

                $.each(response, function(id, value) {
                    this.parentId = "";
                    ValidateAjax.eachFunction(id, value, "");
                });

                if(ValidateAjax.error)
                    $.scrollTo($(".list.errors:first").parent(), 100, {offset:-50});
            }
        });

        return !ValidateAjax.error;
    },
    getHTML: function(errArray) {
        var o = '<ul class="list errors">';
        $.each(errArray,function(key,value){
            o += '<li>'+ value+'</li>';
        });
        o += '</ul>';

        return o;
    },
    eachFunction: function(id, value, parentId) {
        var finalId = id;
        if(parentId.length > 0) {
            finalId = parentId + '_' + id;
        }

        if($('#' + finalId).exists()) {
            $('#' + finalId).parent().append(ValidateAjax.getHTML(value));
            ValidateAjax.error = true;
        } else {
            if(typeof(value) == "object") {

                if(parentId.length > 0) {
                    parentId = parentId + '_' + id;
                } else {
                    parentId = id;
                }

                //this.parentId += '_' + id;
                $.each(value, function(id, value) {
                    if(typeof(value) == "object") {
                        ValidateAjax.eachFunction(id, value, parentId);
                    }
                });
            }
        }
    }
}


function decoraSelects(selector)
{
    if($(selector + ' select').exists()) {

        $(selector + ' select').not('table select').each(function(idx, select) {
            if ($(select).multiselect("widget").get(0).type !== undefined)
            {
                var multiple = ($(select).attr("multiple") != undefined);
                var required = ($(select).attr("required") != undefined);
                var filter = !$(select).hasClass("select_nofilter");
                var openUp = $(select).hasClass("select_openup");

                var open = {};
                if (openUp) {
                    open = {
                        my: 'left bottom',
                        at: 'left top'
                    };
                }
                var classes = "";
                if (required) {
                    classes = "required";
                }

                if (multiple && filter) {
                    $(select).multiselect({ minWidth: 140, classes: classes, position: open }).multiselectfilter({ classes: classes });
                } else if(multiple) {
                    $(select).multiselect({ minWidth: 140, classes: classes, position: open });
                } else if(filter) {
                    $(select).multiselect({
                        multiple: false,
                        selectedList: 1,
                        minWidth: 140,
                        classes: classes,
                        position: open
                    }).multiselectfilter({ classes: classes });
                } else {
                    $(select).multiselect({
                        multiple: false,
                        selectedList: 1,
                        minWidth: 140,
                        classes: classes,
                        position: open
                    });
                }
            } else {
                $(select).multiselect("refresh");
            }
        });


        /*
        $(selector + ' select[multiple][required]').not('table select').not('.select_nofilter').multiselect({ minWidth: 140, classes:"required" }).multiselectfilter({ classes:"required" });

        $(selector + ' select[multiple]').not('table select').not('.select_nofilter').multiselect({ minWidth: 140 }).multiselectfilter({ });

        $(selector + ' select[required]').not('select[multiple]').not('table select').not('.select_nofilter').multiselect({
            multiple: false,
            selectedList: 1,
            minWidth: 140,
            classes:"required",
            position: open
        }).multiselectfilter({ classes:"required" });

        $(selector + ' select').not('select[multiple]').not('table select').not('.select_nofilter').multiselect({
            multiple: false,
            selectedList: 1,
            minWidth: 140,
            position: open
        }).multiselectfilter({  });

        $(selector + ' select.select_nofilter').not('select[multiple]').not('table select').multiselect({
            multiple: false,
            selectedList: 1,
            minWidth: 140,
            position: open
        });
        */

        /*
        $(selector + ' select').multiselect({
            multiple: false,
            selectedList: 1
        });
        */

    } else if($(selector).exists()) {
        if( ($(selector).get(0).type == "select-one") || ($(selector).get(0).type == "select-multiple")) {
            $(selector).multiselect("refresh");
        }
    }

    /*
    $(function() {

        var selector = '#' + id + ' select';

        if($('#' + id).exists())
            if( ($('#' + id).get(0).type === "select-one")
                || ($('#' + id).get(0).type === "select-multiple") )
                selector = '#' + id;

        if($(selector).exists())
        {
            $(selector).not("select.multi").selectmenu({
                style: 'dropdown',
                transferClasses: true,
                width: null
            });
        }
    });*/
}

function boxHide(obj)
{
    $(obj).parent().next('.content').fadeToggle(600);
    if($(obj).hasClass("hide")) {
        $(obj).removeClass("hide");
        $(obj).addClass("unhide");
    } else {
        $(obj).removeClass("unhide");
        $(obj).addClass("hide");
    }
}

function decoraAButtons(id)
{
    $("#" + id + " a.button").wrapInner("<span></span>");
    $("#" + id + " a.button, #" + id + " button, #" + id + "  .pager img").hover(

        function() {
            $(this).stop().fadeTo(200, 0.7);
        }, function() {
            $(this).stop().fadeTo(200, 1.0);
        });
}

function decoraChecks(selector)
{
    if($(selector + " > input[type=radio], " + selector + " input[type=checkbox]").exists()) {
        $(selector + " > input[type=radio], " + selector + " input[type=checkbox]").each(function() {
            if ($(this).parents("table").length === 0) {
                $(this).customInput();
            }
        });
    }
}

function getdigits (s) {
    return s.replace (/[^\d]/g, '');
}

function gettingAnHtmlByJson(formId, actionPath, idOfFieldToBeFilled) {

    var form = $('#' + formId).serialize();

    $.ajax
        ({
            type: "POST",
            url: actionPath,
            data: form,
            cache: false,
            success: function(html)
            {
                $("#" + idOfFieldToBeFilled).html(html);
                $("#" + idOfFieldToBeFilled).show();
            }
        });
}

function BuscaTudo(obj, id, url, idCombo, selected, tipo, firsttext, combosToClear, collectionsToClear)
{
    if((collectionsToClear != undefined) && (collectionsToClear != null) && (collectionsToClear.length > 0))
    {
        var newVal = $(obj).val();
        var oldVal = $.data(obj, 'val');

        if(oldVal == undefined) {
            var defaultValue;
            $(obj).find('option').each(function (i, o) {
                if (o.defaultSelected) {
                    defaultValue = o.value;
                    return;
                }
            });
            oldVal = defaultValue;
        }

        if((oldVal != undefined) && (oldVal != null) && (oldVal != "") && (oldVal != newVal)) {
            if (!confirm("Ao trocar este valor você irá perder informações previamente selecionadas de outros campos?")) {
                $(obj).val(oldVal);
                $(obj).multiselect("refresh");
                return;
            }
        }
        $.data(obj, 'val', newVal);        //store new value for next time

        $.each(collectionsToClear, function(index, idCollectionToClear) {
            var fn = window[idCollectionToClear + "_collectionDelAll"]; // pega o clear
            if(typeof fn === 'function') {
                fn();
            }
        });
    }

    if( (combosToClear != undefined) && (combosToClear != null) && (combosToClear.length > 0) )
    {
        $.each(combosToClear, function(index, idComboToClear) {
            var firstTextComboToClear = $('#'+idComboToClear+' option:first').text();

            $('#'+idComboToClear).empty();

            if($('#' + idComboToClear).attr("multiple") == null) //quando não for multiple
                $('#'+idComboToClear).append('<option value="">'+firstTextComboToClear+'</option>');

            $('#'+idComboToClear).multiselect("refresh");
        });
    }

    if((idCombo != undefined) && (idCombo != null))
    {
        $('#'+idCombo).empty();
        if(firsttext != null) {
            $('#'+idCombo).append('<option value="">'+firsttext+'</option>');
        }
        $('#'+idCombo).multiselect("refresh");

        $.getJSON(url + '?id='+id+'&selected='+selected+'&tipo='+tipo, function(data) {

            var item = data[0];

            $.each(data, function(i, item) {
                var selected = "";
                if(item.selected == item.chave) {
                    selected = 'selected="selected"';
                }

                $('#'+idCombo).append('<option value="'+item.chave+'" '+selected+'>'+item.descricao+'</option>');
            });

            $('#'+idCombo).multiselect("refresh");
        }).error(function() { decoraSelects('#'+idCombo); });

    }
}

function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
        && (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop) );
}

//------------------------------CONFIGURA O AJAX PADRAO---------------------------//
$.ajaxPool = [];
$.ajaxPool.abortAll = function() {
    $(this).each(function(idx, jqXHR) {
        jqXHR.abort();
    });
    $.ajaxPool.length = 0
};
////////////////////////////////////////////////////////////////////////////////////
// Configura o AJAX do jQuery para aparecer a DIV Carregando enquanto está
// processando
////////////////////////////////////////////////////////////////////////////////////
$.ajaxSetup({
    beforeSend : function(jqXHR) {
        $.ajaxPool.push(jqXHR);
        $('#divCarregando').center(); $("#divCarregando").show();
    },
    complete : function(jqXHR) {
        var index = $.inArray(jqXHR, $.ajaxPool);
        if (index > -1) {
            $.ajaxPool.splice(index, 1);
        }

        if($.ajaxPool.length == 0) {
            $("#divCarregando").hide();
        }
    },
    error : function(jqXHR) {
        var index = $.inArray(jqXHR, $.ajaxPool);
        if (index > -1) {
            $.ajaxPool.splice(index, 1);
        }

        if($.ajaxPool.length == 0) {
            $("#divCarregando").hide();
        }
    }
});