/*! For license information please see 6387.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[6387],{8585:(t,e,n)=>{n.d(e,{Z:()=>o});var r=n(9669);const o=n.n(r)().create({baseURL:appDataObj.appBaseUrl,withCredentials:!0,headers:{"Content-Type":"application/json"}})},1694:(t,e,n)=>{n.d(e,{$w:()=>b,Ae:()=>d,Ec:()=>s,Ir:()=>w,JO:()=>y,LE:()=>k,MM:()=>p,Nb:()=>m,TJ:()=>v,U0:()=>l,YZ:()=>_,de:()=>r,dq:()=>S,eY:()=>f,ef:()=>c,ic:()=>g,kc:()=>u,mV:()=>i,oH:()=>h,z6:()=>a});var r=function(){return"Sorry system error, your request can not be processed please see a member of the security team thank you!"};function o(t,e){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2];return e.length>t?n?e.slice(0,t)+"...":e.slice(0,t):e}function a(t,e){var n;return n=o(1,t)+o(1,e)+"-"+function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6,e=Math.random().toString().replace("0.","");return e.length>t?e.slice(0,t):e}(3),n}function i(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"top";"top"==t?window.scrollTo({top:0,behavior:"smooth"}):window.scrollTo({top:document.body.scrollHeight,left:0,behavior:"smooth"})}function l(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj",o=!1;return"arr"==r?e.some((function(e){return e===t}))&&(o=!0):e.some((function(e){return e[n]===t}))&&(o=!0),o}function u(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";return"arr"==r?e.filter((function(e){return e!==t})):e.filter((function(e){return e[n]!==t}))}function c(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=new Date(t).toLocaleDateString();return e&&(r=r+" "+new Date(t).toLocaleTimeString("en-GB").slice(0,5)),n&&(r=t.substr(11,5)),r}function s(t){var e=new Date(t);return new Date(e.getTime()-6e4*e.getTimezoneOffset()).toISOString().slice(0,19).replace("T"," ")}function f(t){t.value.focus()}function d(t,e,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";if(!t.length)return e;var o=[];return"obj"==r?e.forEach((function(e){isNaN(e[n])?e[n].toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e):e[n].toString().toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e)})):"arr"==r&&e.forEach((function(e){isNaN(e)?e.toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e):e.toString().toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e)})),o}function p(t){return/^(((\+44)? ?(\(0\))? ?)|(0))( ?[0-9]{3,4}){3}$/.test(t)}function h(t){return!!t.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)}function y(t,e){return(null==t?"Leaver":t)+" "+(null==e?"":e)}function m(){var t=!(arguments.length>0&&void 0!==arguments[0])||arguments[0],e=new Date;return t?e.toDateString():e}function v(){return m(!1).toLocaleTimeString("en-GB").slice(0,5)}function g(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0;return t.split(e)[n]}function w(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ";return t.slice(t.indexOf(e)+1)}function _(){var t=m(!1),e=t.getMonth()+1,n=t.getDate(),r=t.getFullYear();return e<10&&(e="0"+e.toString()),n<10&&(n="0"+n.toString()),r+"-"+e+"-"+n}function b(t,e,n,r,o){var a=arguments.length>5&&void 0!==arguments[5]?arguments[5]:"Records",i=arguments.length>6&&void 0!==arguments[6]&&arguments[6],l=arguments.length>7&&void 0!==arguments[7]?arguments[7]:[],u=new t("l","pt"),s=[],f="Date: "+m()+" Time: "+v(),d="  |  ("+o.length+") "+a;o.forEach((function(t,e){for(var n=[],o=0;o<r.length;o++)l.length>0&&l.includes(r[o])&&null!=t[r[o]]?n.push(c(t[r[o]],!0)):n.push(t[r[o]]);s.push(n)})),u.autoTable({columns:n,body:s,margin:{horizontal:10},styles:{overflow:"linebreak"},bodyStyles:{valign:"top"},columnStyles:{email:{cellWidth:"wrap"}},theme:"striped",showHead:"everyPage",didDrawPage:function(t){u.setFontSize(14),u.setTextColor(40),u.text(f+d,10,20,{baseline:"top"});var e="Page "+u.internal.getCurrentPageInfo().pageNumber+" of "+u.internal.getNumberOfPages();u.setFontSize(10);var n=u.internal.pageSize,r=n.height?n.height:n.getHeight();u.text(e,t.settings.margin.left,r-10)}}),i&&u.autoPrint(),u.output("dataurlnewwindow")}function S(){return[{name:"Latest"},{name:"A-Z"},{name:"Z-A"},{name:"Date ascending"},{name:"Date descending"}]}function k(t,e){var n=new Date(t),r=new Date;return Math.ceil((r.getTime()-n.getTime())/864e5)>=e}},6387:(t,e,n)=>{n.r(e),n.d(e,{default:()=>Q});var r=n(821),o=n(9285),a=n(1293),i=n(4041),l=n(1682),u=n(5979),c=n(1694),s=n(8585);function f(t){return f="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},f(t)}function d(){d=function(){return t};var t={},e=Object.prototype,n=e.hasOwnProperty,r=Object.defineProperty||function(t,e,n){t[e]=n.value},o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",i=o.asyncIterator||"@@asyncIterator",l=o.toStringTag||"@@toStringTag";function u(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{u({},"")}catch(t){u=function(t,e,n){return t[e]=n}}function c(t,e,n,o){var a=e&&e.prototype instanceof h?e:h,i=Object.create(a.prototype),l=new E(o||[]);return r(i,"_invoke",{value:k(t,n,l)}),i}function s(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=c;var p={};function h(){}function y(){}function m(){}var v={};u(v,a,(function(){return this}));var g=Object.getPrototypeOf,w=g&&g(g(j([])));w&&w!==e&&n.call(w,a)&&(v=w);var _=m.prototype=h.prototype=Object.create(v);function b(t){["next","throw","return"].forEach((function(e){u(t,e,(function(t){return this._invoke(e,t)}))}))}function S(t,e){function o(r,a,i,l){var u=s(t[r],t,a);if("throw"!==u.type){var c=u.arg,d=c.value;return d&&"object"==f(d)&&n.call(d,"__await")?e.resolve(d.__await).then((function(t){o("next",t,i,l)}),(function(t){o("throw",t,i,l)})):e.resolve(d).then((function(t){c.value=t,i(c)}),(function(t){return o("throw",t,i,l)}))}l(u.arg)}var a;r(this,"_invoke",{value:function(t,n){function r(){return new e((function(e,r){o(t,n,e,r)}))}return a=a?a.then(r,r):r()}})}function k(t,e,n){var r="suspendedStart";return function(o,a){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===o)throw a;return F()}for(n.method=o,n.arg=a;;){var i=n.delegate;if(i){var l=x(i,n);if(l){if(l===p)continue;return l}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var u=s(t,e,n);if("normal"===u.type){if(r=n.done?"completed":"suspendedYield",u.arg===p)continue;return{value:u.arg,done:n.done}}"throw"===u.type&&(r="completed",n.method="throw",n.arg=u.arg)}}}function x(t,e){var n=e.method,r=t.iterator[n];if(void 0===r)return e.delegate=null,"throw"===n&&t.iterator.return&&(e.method="return",e.arg=void 0,x(t,e),"throw"===e.method)||"return"!==n&&(e.method="throw",e.arg=new TypeError("The iterator does not provide a '"+n+"' method")),p;var o=s(r,t.iterator,e.arg);if("throw"===o.type)return e.method="throw",e.arg=o.arg,e.delegate=null,p;var a=o.arg;return a?a.done?(e[t.resultName]=a.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,p):a:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,p)}function L(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function C(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function E(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(L,this),this.reset(!0)}function j(t){if(t){var e=t[a];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){for(;++r<t.length;)if(n.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=void 0,e.done=!0,e};return o.next=o}}return{next:F}}function F(){return{value:void 0,done:!0}}return y.prototype=m,r(_,"constructor",{value:m,configurable:!0}),r(m,"constructor",{value:y,configurable:!0}),y.displayName=u(m,l,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===y||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,m):(t.__proto__=m,u(t,l,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},b(S.prototype),u(S.prototype,i,(function(){return this})),t.AsyncIterator=S,t.async=function(e,n,r,o,a){void 0===a&&(a=Promise);var i=new S(c(e,n,r,o),a);return t.isGeneratorFunction(n)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},b(_),u(_,l,"Generator"),u(_,a,(function(){return this})),u(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=Object(t),n=[];for(var r in e)n.push(r);return n.reverse(),function t(){for(;n.length;){var r=n.pop();if(r in e)return t.value=r,t.done=!1,t}return t.done=!0,t}},t.values=j,E.prototype={constructor:E,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(C),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(n,r){return i.type="throw",i.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],i=a.completion;if("root"===a.tryLoc)return r("end");if(a.tryLoc<=this.prev){var l=n.call(a,"catchLoc"),u=n.call(a,"finallyLoc");if(l&&u){if(this.prev<a.catchLoc)return r(a.catchLoc,!0);if(this.prev<a.finallyLoc)return r(a.finallyLoc)}else if(l){if(this.prev<a.catchLoc)return r(a.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return r(a.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=e&&e<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=t,i.arg=e,a?(this.method="next",this.next=a.finallyLoc,p):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),C(n),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var o=r.arg;C(n)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:j(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),p}},t}function p(t,e,n,r,o,a,i){try{var l=t[a](i),u=l.value}catch(t){return void n(t)}l.done?e(u):Promise.resolve(u).then(r,o)}function h(t){return function(){var e=this,n=arguments;return new Promise((function(r,o){var a=t.apply(e,n);function i(t){p(a,r,o,i,l,"next",t)}function l(t){p(a,r,o,i,l,"throw",t)}i(void 0)}))}}var y={class:"row"},m={class:"col-12"},v={class:"text-right pb-2"},g=(0,r.Uk)("X"),w={class:"text-center bolded"},_={class:"mt-0 mb-1 text-color-black"},b=(0,r.Uk)("Key: "),S={class:"text-danger bolded"},k={class:"form-wrapper"},x={key:2},L={class:"text-center"},C={class:"bolded"},E=(0,r.Uk)(" bringing back key "),j={class:"bolded"},F={class:"text-center"},O=(0,r.Uk)("No"),T=(0,r.Uk)("Yes "),D={class:"form-group"},U=(0,r._)("label",{class:"form-label"},[(0,r.Uk)("Comment: "),(0,r._)("span",{class:"optional"},"(Optional)")],-1),N={class:"text-center"},P=(0,r.Uk)("Cancel"),H=(0,r.Uk)("Log it "),B={class:"pt-3"},W={class:"mt-0 mb-0"},Z=(0,r._)("span",{class:"bolded"},"Coworker name:",-1),z={class:"text-color-black ml-1"},G=(0,r.Uk)(" Change "),I={class:"mt-1"},R=(0,r._)("span",{class:"bolded"},"Coworker department:",-1),Y={class:"text-color-black ml-1"},q={class:"text-center"},A=(0,r.Uk)("Cancel"),M=(0,r.Uk)("Continue ");const Q={name:"KeyLogInForm",props:{key_log_obj:{type:Object,default:{}}},emits:["handleModalClose"],setup:function(t,e){var n=e.emit,f=t,p=(0,r.qj)({next_step:!1,is_form_processing:!1,custom_err:"",custom_success:"",is_different_coworker_name:!1,different_coworker_name:"",different_coworker_department:"",form_data:{key_name:"",key_log_id:0,coworker_name:"",coworker_department:"",comment:"",action:"keyin"}}),Q=function(t){"Yes_Q1"==t?p.next_step=!0:"No_Q1"==t&&(p.is_different_coworker_name=!0)},V=function(){var t,e,n,r;(p.is_form_processing=!0,p.form_data.key_log_id=null===(t=f.key_log_obj)||void 0===t?void 0:t.id,p.form_data.key_name=null===(e=f.key_log_obj)||void 0===e?void 0:e.key_name,""!=p.different_coworker_name)?(p.form_data.coworker_name=p.different_coworker_name,p.form_data.coworker_department=p.different_coworker_department):(p.form_data.coworker_name=null===(n=f.key_log_obj)||void 0===n?void 0:n.coworker_name_out,p.form_data.coworker_department=null===(r=f.key_log_obj)||void 0===r?void 0:r.coworker_department_out);setTimeout(h(d().mark((function t(){var e,n,r;return d().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,s.Z.post("/keys/handle-log-key",p.form_data);case 3:""!=(null==(n=t.sent)||null===(e=n.data)||void 0===e?void 0:e.error)?p.custom_err=null==n||null===(r=n.data)||void 0===r?void 0:r.error:(p.custom_success="Thanks, key ".concat(p.form_data.key_name," has been successfully logged"),setTimeout((function(){o.Nd.get("/keys/log")}),1e3)),t.next=10;break;case 7:t.prev=7,t.t0=t.catch(0),p.custom_err=(0,c.de)();case 10:return t.prev=10,p.is_form_processing=!1,t.finish(10);case 13:case"end":return t.stop()}}),t,null,[[0,7,10,13]])}))),200)},$=function(){p.different_coworker_name=""},J=function(t){p.different_coworker_name=(0,c.JO)(t.fname,t.lname),p.different_coworker_department=t.department_name},K=function(){p.is_different_coworker_name=!1,p.different_coworker_name="",p.different_coworker_department="",p.next_step=!1,p.custom_err="",n("handleModalClose")};return function(e,n){var o,c,s;return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r._)("div",y,[(0,r._)("div",m,[(0,r._)("div",v,[(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:K,btnStyle:"primary"},{default:(0,r.w5)((function(){return[g]})),_:1})]),(0,r._)("div",w,[(0,r._)("label",_,[b,(0,r._)("span",S,(0,r.zw)("".concat(null===(o=t.key_log_obj)||void 0===o?void 0:o.key_name)),1)])])])]),(0,r._)("div",k,[(0,r.wy)((0,r._)("section",null,[(0,r.Wm)((0,r.SU)(a.Z))],512),[[r.F8,p.is_form_processing]]),(0,r.wy)((0,r._)("section",null,[""!=p.custom_err?((0,r.wg)(),(0,r.j4)((0,r.SU)(i.Z),{key:0,infotype:"error",msg:p.custom_err,customClass:"form-responds-msg"},null,8,["msg"])):""!=p.custom_success?((0,r.wg)(),(0,r.j4)((0,r.SU)(i.Z),{key:1,infotype:"success",msg:p.custom_success,customClass:"form-responds-msg"},null,8,["msg"])):((0,r.wg)(),(0,r.iD)("section",x,[(0,r.wy)((0,r._)("section",null,[(0,r._)("p",L,[(0,r._)("span",C,(0,r.zw)(null===(c=t.key_log_obj)||void 0===c?void 0:c.coworker_name_out),1),E,(0,r._)("span",j,(0,r.zw)(null===(s=t.key_log_obj)||void 0===s?void 0:s.key_name)+" ?",1)]),(0,r._)("div",F,[(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:function(){return Q("No_Q1")},btnStyle:"warn"},{default:(0,r.w5)((function(){return[O]})),_:1},8,["btnFunc"]),(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:function(){return Q("Yes_Q1")},customClass:"ml-5",btnStyle:"primary2"},{default:(0,r.w5)((function(){return[T]})),_:1},8,["btnFunc"])])],512),[[r.F8,!p.next_step&&!p.is_different_coworker_name]]),(0,r.wy)((0,r._)("section",null,[(0,r._)("div",D,[U,(0,r.wy)((0,r._)("textarea",{"onUpdate:modelValue":n[0]||(n[0]=function(t){return p.form_data.comment=t}),class:"form-control",rows:"1",cols:"10"},null,512),[[r.nr,p.form_data.comment]])]),(0,r._)("div",N,[(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:K,btnStyle:"warn"},{default:(0,r.w5)((function(){return[P]})),_:1}),(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:V,customClass:"ml-5",btnStyle:"primary2"},{default:(0,r.w5)((function(){return[H]})),_:1})])],512),[[r.F8,p.next_step]]),(0,r.wy)((0,r._)("section",B,[(0,r.wy)((0,r._)("div",null,[(0,r._)("p",W,[Z,(0,r._)("span",z,(0,r.zw)(""!=p.different_coworker_name?p.different_coworker_name:""),1),(0,r._)("span",null,[(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:$,customClass:"change-selected-btn ml-1"},{default:(0,r.w5)((function(){return[G]})),_:1})])]),(0,r._)("p",I,[R,(0,r._)("span",Y,(0,r.zw)(""!=p.different_coworker_department?p.different_coworker_department:""),1)]),(0,r._)("div",q,[(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:K,btnStyle:"warn"},{default:(0,r.w5)((function(){return[A]})),_:1}),(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:function(){return Q("Yes_Q1")},customClass:"ml-5",btnStyle:"primary2"},{default:(0,r.w5)((function(){return[M]})),_:1},8,["btnFunc"])])],512),[[r.F8,!p.next_step&&""!=p.different_coworker_name]]),(0,r.wy)((0,r._)("div",null,[(0,r.Wm)((0,r.SU)(u.Z),{end_point:"/keys/find-coworker",makeResultAlink:!1,focusOnSearchInput:!0,resultFoundTextSingular:"person",resultFoundTextplural:"people",noResultText:"Sorry no one found, try again thank you.",onUpdateSelected:J})],512),[[r.F8,""==p.different_coworker_name]])],512),[[r.F8,p.is_different_coworker_name]])]))],512),[[r.F8,!p.is_form_processing]])])],64)}}}},1682:(t,e,n)=>{n.d(e,{Z:()=>u});var r=n(821);function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function a(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==o(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!==o(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===o(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var i=["title","type","disabled"],l=["disabled"];const u={name:"AppButton",props:{noBtnStyle:{type:Boolean,default:!1},btnStyle:{type:String,default:"default"},btnType:{type:String,default:"button"},btnTitle:{type:String,default:""},btnFunc:{type:Function,default:null},fullBtn:{type:Boolean,default:!1},btnDisabled:{type:Boolean,default:!1},hideBtn:{type:Boolean,default:!1},customClass:{type:String,default:""},customClassObj:{type:Object,default:null}},setup:function(t){var e=t,n=(0,r.qj)({defaultClassName:"no-border-radius btn shadow-none "+e.customClass});return function(e,o){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("button",{title:t.btnTitle,type:t.btnType,class:(0,r.C_)(a({"hide-on-all-screen":t.hideBtn,"btn-full":t.fullBtn,"btn-muted":"muted"===t.btnStyle,"primary-btn":"primary"===t.btnStyle,"btn-primary":"primary2"===t.btnStyle,"btn-danger":"danger"===t.btnStyle,"btn-default":"default"===t.btnStyle,"btn-secondary":"secondary"===t.btnStyle,"btn-success":"success"===t.btnStyle,"btn-warning":"warn"===t.btnStyle},n.defaultClassName,!0)),onClick:o[0]||(o[0]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)}),disabled:t.btnDisabled},[(0,r.WI)(e.$slots,"default")],10,i),[[r.F8,!t.noBtnStyle]]),(0,r.wy)((0,r._)("button",{class:(0,r.C_)(null!=t.customClassObj?t.customClassObj:t.customClass),onClick:o[1]||(o[1]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)}),disabled:t.btnDisabled},[(0,r.WI)(e.$slots,"default")],10,l),[[r.F8,t.noBtnStyle]])],64)}}}},5979:(t,e,n)=>{n.d(e,{Z:()=>b});var r=n(821),o=n(1694),a=n(1293),i=n(8585),l=n(6486);function u(t){return u="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},u(t)}function c(){c=function(){return t};var t={},e=Object.prototype,n=e.hasOwnProperty,r=Object.defineProperty||function(t,e,n){t[e]=n.value},o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",i=o.asyncIterator||"@@asyncIterator",l=o.toStringTag||"@@toStringTag";function s(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{s({},"")}catch(t){s=function(t,e,n){return t[e]=n}}function f(t,e,n,o){var a=e&&e.prototype instanceof h?e:h,i=Object.create(a.prototype),l=new E(o||[]);return r(i,"_invoke",{value:k(t,n,l)}),i}function d(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=f;var p={};function h(){}function y(){}function m(){}var v={};s(v,a,(function(){return this}));var g=Object.getPrototypeOf,w=g&&g(g(j([])));w&&w!==e&&n.call(w,a)&&(v=w);var _=m.prototype=h.prototype=Object.create(v);function b(t){["next","throw","return"].forEach((function(e){s(t,e,(function(t){return this._invoke(e,t)}))}))}function S(t,e){function o(r,a,i,l){var c=d(t[r],t,a);if("throw"!==c.type){var s=c.arg,f=s.value;return f&&"object"==u(f)&&n.call(f,"__await")?e.resolve(f.__await).then((function(t){o("next",t,i,l)}),(function(t){o("throw",t,i,l)})):e.resolve(f).then((function(t){s.value=t,i(s)}),(function(t){return o("throw",t,i,l)}))}l(c.arg)}var a;r(this,"_invoke",{value:function(t,n){function r(){return new e((function(e,r){o(t,n,e,r)}))}return a=a?a.then(r,r):r()}})}function k(t,e,n){var r="suspendedStart";return function(o,a){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===o)throw a;return F()}for(n.method=o,n.arg=a;;){var i=n.delegate;if(i){var l=x(i,n);if(l){if(l===p)continue;return l}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var u=d(t,e,n);if("normal"===u.type){if(r=n.done?"completed":"suspendedYield",u.arg===p)continue;return{value:u.arg,done:n.done}}"throw"===u.type&&(r="completed",n.method="throw",n.arg=u.arg)}}}function x(t,e){var n=e.method,r=t.iterator[n];if(void 0===r)return e.delegate=null,"throw"===n&&t.iterator.return&&(e.method="return",e.arg=void 0,x(t,e),"throw"===e.method)||"return"!==n&&(e.method="throw",e.arg=new TypeError("The iterator does not provide a '"+n+"' method")),p;var o=d(r,t.iterator,e.arg);if("throw"===o.type)return e.method="throw",e.arg=o.arg,e.delegate=null,p;var a=o.arg;return a?a.done?(e[t.resultName]=a.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,p):a:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,p)}function L(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function C(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function E(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(L,this),this.reset(!0)}function j(t){if(t){var e=t[a];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){for(;++r<t.length;)if(n.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=void 0,e.done=!0,e};return o.next=o}}return{next:F}}function F(){return{value:void 0,done:!0}}return y.prototype=m,r(_,"constructor",{value:m,configurable:!0}),r(m,"constructor",{value:y,configurable:!0}),y.displayName=s(m,l,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===y||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,m):(t.__proto__=m,s(t,l,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},b(S.prototype),s(S.prototype,i,(function(){return this})),t.AsyncIterator=S,t.async=function(e,n,r,o,a){void 0===a&&(a=Promise);var i=new S(f(e,n,r,o),a);return t.isGeneratorFunction(n)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},b(_),s(_,l,"Generator"),s(_,a,(function(){return this})),s(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=Object(t),n=[];for(var r in e)n.push(r);return n.reverse(),function t(){for(;n.length;){var r=n.pop();if(r in e)return t.value=r,t.done=!1,t}return t.done=!0,t}},t.values=j,E.prototype={constructor:E,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(C),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(n,r){return i.type="throw",i.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],i=a.completion;if("root"===a.tryLoc)return r("end");if(a.tryLoc<=this.prev){var l=n.call(a,"catchLoc"),u=n.call(a,"finallyLoc");if(l&&u){if(this.prev<a.catchLoc)return r(a.catchLoc,!0);if(this.prev<a.finallyLoc)return r(a.finallyLoc)}else if(l){if(this.prev<a.catchLoc)return r(a.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return r(a.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=e&&e<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=t,i.arg=e,a?(this.method="next",this.next=a.finallyLoc,p):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),C(n),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var o=r.arg;C(n)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:j(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),p}},t}function s(t,e,n,r,o,a,i){try{var l=t[a](i),u=l.value}catch(t){return void n(t)}l.done?e(u):Promise.resolve(u).then(r,o)}var f={class:"coworker-search-wrapper"},d={class:"coworker-search-input-wrapper"},p=["placeholder"],h=[(0,r._)("i",{class:"fas fa-times"},null,-1)],y={class:"co-worker-search-result"},m={className:"text-center number-result-found-p"},v=["onClick"],g={class:"blog-search-result"},w={className:"text-center pt-3"},_={class:"text-center"};const b={name:"CoWorkerSearch",props:{focusOnSearchInput:{type:Boolean,default:!1},isSearchOn:{type:Boolean,default:!1},makeResultAlink:{type:Boolean,default:!0},resultFoundTextSingular:{type:String,default:"result"},resultFoundTextplural:{type:String,default:"results"},linkUrl:{type:String,default:""},placeholderText:{type:String,default:"Search co-worker ...."},end_point:{type:String,default:"/find-coworker"},noResultText:{type:String,default:"Sorry no result found, please try again thank you."},dataStringValue:{type:String,default:"name"},isGeneralData:{type:Boolean,default:!1}},emits:["updateSelected"],setup:function(t,e){var n=e.emit,u=t,b=(0,r.iH)(""),S=(0,r.iH)(null),k=function(){b.value=""},x=(0,r.qj)({isSearching:!1,isSearchComplete:!1,customErr:"",coWorkerResData:[]}),L=function(){var t,e=(t=c().mark((function t(e){var n,r,a;return c().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(""==e){t.next=17;break}return x.isSearching=!0,x.isSearchComplete&&(x.isSearchComplete=!1),t.prev=3,t.next=6,i.Z.post(u.end_point,{searchedword:e});case 6:""!=(null==(r=t.sent)||null===(n=r.data)||void 0===n?void 0:n.error)?x.customErr=r.data.error:x.coWorkerResData=null==r||null===(a=r.data)||void 0===a?void 0:a.coWorkerResData,t.next=13;break;case 10:t.prev=10,t.t0=t.catch(3),x.customErr=(0,o.de)();case 13:return t.prev=13,x.isSearching=!1,x.isSearchComplete=!0,t.finish(13);case 17:case"end":return t.stop()}}),t,null,[[3,10,13,17]])})),function(){var e=this,n=arguments;return new Promise((function(r,o){var a=t.apply(e,n);function i(t){s(a,r,o,i,l,"next",t)}function l(t){s(a,r,o,i,l,"throw",t)}i(void 0)}))});return function(t){return e.apply(this,arguments)}}();return(0,r.bv)((function(){u.focusOnSearchInput&&(0,o.eY)(S)})),(0,r.YP)(b,(0,l.debounce)((function(t){L(t)}),400)),function(e,i){return(0,r.wg)(),(0,r.iD)("div",f,[(0,r._)("div",d,[(0,r.wy)((0,r._)("input",{ref_key:"searchInput",ref:S,"onUpdate:modelValue":i[0]||(i[0]=function(t){return(0,r.dq)(b)?b.value=t:b=t}),type:"text",class:(0,r.C_)({"form-control pr-5":!0}),placeholder:t.placeholderText,maxlength:"255",autocomplete:"off",onKeypress:i[1]||(i[1]=(0,r.D2)((0,r.iM)((function(){}),["prevent"]),["enter"]))},null,40,p),[[r.nr,(0,r.SU)(b)]]),(0,r.SU)(b).length>0?((0,r.wg)(),(0,r.iD)("span",{key:0,class:"clear-search-icon-times",onClick:k},h)):(0,r.kq)("",!0)]),(0,r.wy)((0,r._)("div",y,[(0,r.wy)((0,r._)("section",null,[(0,r.Wm)(a.Z,{loaderSize:"small"})],512),[[r.F8,x.isSearching]]),(0,r.wy)((0,r._)("section",null,[(0,r._)("p",m,(0,r.zw)(x.coWorkerResData.length>1?"("+x.coWorkerResData.length+") "+t.resultFoundTextplural:"("+x.coWorkerResData.length+") "+t.resultFoundTextSingular)+" found ",1),((0,r.wg)(!0),(0,r.iD)(r.HY,null,(0,r.Ko)(x.coWorkerResData,(function(t,e){return(0,r.wg)(),(0,r.iD)("div",{key:e},[(0,r._)("p",{class:"result-entry-p",onClick:function(){return e=t,void(u.makeResultAlink||n("updateSelected",e));var e}},(0,r.zw)((a=t,u.isGeneralData?a[u.dataStringValue]:(0,o.JO)(a.fname,a.lname))),9,v)]);var a})),128))],512),[[r.F8,x.isSearchComplete&&!x.isSearching&&x.coWorkerResData.length>0]]),(0,r.wy)((0,r._)("section",g,[(0,r._)("div",w,[(0,r._)("p",_,(0,r.zw)(t.noResultText),1)])],512),[[r.F8,x.isSearchComplete&&!x.isSearching&&x.coWorkerResData.length<=0&&""!=(0,r.SU)(b)]])],512),[[r.F8,""!=(0,r.SU)(b)]])])}}}},4041:(t,e,n)=>{n.d(e,{Z:()=>i});var r=n(821),o=(0,r._)("br",null,null,-1),a=["innerHTML"];const i={name:"HandleMsg",props:{infotype:{type:String,requred:!0},msg:{type:String,requred:!0},customClass:{type:String,default:""},showHeading:{type:Boolean,default:!0},customHeading:{type:String,default:""}},setup:function(t){var e=t,n=(0,r.iH)("no-border-radius alert"),i=(0,r.iH)("");return"success"==e.infotype&&(n.value="".concat(n.value," alert-success text-success"),i.value=""==e.customHeading?"Success!":e.customHeading),"error"==e.infotype&&(n.value="".concat(n.value," alert-danger text-danger"),i.value=""==e.customHeading?"Error!":e.customHeading),"info"==e.infotype&&(n.value="".concat(n.value," alert-secondary"),i.value=""==e.customHeading?"Info!":e.customHeading),function(l,u){return(0,r.wg)(),(0,r.iD)("div",{class:(0,r.C_)((0,r.SU)(n)+" "+t.customClass),"aria-live":"assertive"},[(0,r.wy)((0,r._)("span",null,[(0,r._)("strong",null,(0,r.zw)((0,r.SU)(i)),1),o],512),[[r.F8,t.showHeading]]),(0,r._)("span",{innerHTML:e.msg},null,8,a)],2)}}}},1293:(t,e,n)=>{n.d(e,{Z:()=>a});var r=n(821),o=[(0,r._)("i",{class:"fas fa-spinner fa-spin"},null,-1)];const a={name:"LoadingIndicator",props:{position:{type:String,default:null},dot:{type:Boolean,default:!1},loaderSize:{type:String,default:"large"},centerLoader:{type:Boolean,default:!0},loaderPSizeClassName:{type:String,default:""},showBelowText:{type:Boolean,default:!0}},setup:function(t){var e=t,n=(0,r.iH)(""),a=(0,r.iH)("");return(0,r.bv)((function(){"large"==e.loaderSize&&(a.value="fa-3x"),"med"==e.loaderSize&&(a.value="fa-2x"),"small"==e.loaderSize&&(a.value="fa-1x"),e.centerLoader&&(n.value="loader"),null!==e.position&&"full-page"===e.position&&(n.value="".concat(n.value," full-page-loader")),e.dot&&(n.value="".concat(n.value," loader-dot"))})),function(e,i){return(0,r.wg)(),(0,r.iD)(r.HY,null,[t.dot?((0,r.wg)(),(0,r.iD)("div",{key:0,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(a))},"..........",2)],2)):(0,r.kq)("",!0),t.dot?(0,r.kq)("",!0):((0,r.wg)(),(0,r.iD)("div",{key:1,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(a))},o,2),(0,r.wy)((0,r._)("p",{class:(0,r.C_)(t.loaderPSizeClassName)},"Please wait...",2),[[r.F8,t.showBelowText]])],2))],64)}}}}}]);