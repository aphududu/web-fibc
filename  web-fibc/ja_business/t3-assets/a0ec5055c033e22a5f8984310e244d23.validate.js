
var JFormValidator=new Class({initialize:function()
{this.handlers=Object();this.custom=Object();this.setHandler('username',function(value){regex=new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]","i");return!regex.test(value);});this.setHandler('password',function(value){regex=/^\S[\S ]{2,98}\S$/;return regex.test(value);});this.setHandler('numeric',function(value){regex=/^(\d|-)?(\d|,)*\.?\d*$/;return regex.test(value);});this.setHandler('email',function(value){regex=/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;return regex.test(value);});var forms=$$('form.form-validate');forms.each(function(form){this.attachToForm(form);},this);},setHandler:function(name,fn,en)
{en=(en=='')?true:en;this.handlers[name]={enabled:en,exec:fn};},attachToForm:function(form)
{$A(form.elements).each(function(el){el=$(el);if((el.getTag()=='input'||el.getTag()=='button')&&el.getProperty('type')=='submit'){if(el.hasClass('validate')){el.onclick=function(){return document.formvalidator.isValid(this.form);};}}else{el.addEvent('blur',function(){return document.formvalidator.validate(this);});}});},validate:function(el)
{if($(el).hasClass('required')){if(!($(el).getValue())){this.handleResponse(false,el);return false;}}
var handler=(el.className&&el.className.search(/validate-([a-zA-Z0-9\_\-]+)/)!=-1)?el.className.match(/validate-([a-zA-Z0-9\_\-]+)/)[1]:"";if(handler==''){this.handleResponse(true,el);return true;}
if((handler)&&(handler!='none')&&(this.handlers[handler])&&$(el).getValue()){if(this.handlers[handler].exec($(el).getValue())!=true){this.handleResponse(false,el);return false;}}
this.handleResponse(true,el);return true;},isValid:function(form)
{var valid=true;for(var i=0;i<form.elements.length;i++){if(this.validate(form.elements[i])==false){valid=false;}}
$A(this.custom).each(function(validator){if(validator.exec()!=true){valid=false;}});return valid;},handleResponse:function(state,el)
{if(!(el.labelref)){var labels=$$('label');labels.each(function(label){if(label.getProperty('for')==el.getProperty('id')){el.labelref=label;}});}
if(state==false){el.addClass('invalid');if(el.labelref){$(el.labelref).addClass('invalid');}}else{el.removeClass('invalid');if(el.labelref){$(el.labelref).removeClass('invalid');}}}});document.formvalidator=null;Window.onDomReady(function(){document.formvalidator=new JFormValidator();});