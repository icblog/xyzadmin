/*! For license information please see 7079.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[7079],{8585:(t,e,n)=>{n.d(e,{Z:()=>o});var r=n(9669);const o=n.n(r)().create({baseURL:appDataObj.appBaseUrl,withCredentials:!0,headers:{"Content-Type":"application/json"}})},1694:(t,e,n)=>{n.d(e,{$w:()=>S,Ae:()=>d,Ec:()=>c,Ir:()=>b,JO:()=>y,LE:()=>x,MM:()=>p,Nb:()=>v,TJ:()=>g,U0:()=>u,YZ:()=>w,de:()=>r,dq:()=>_,eY:()=>f,ef:()=>s,ic:()=>m,kc:()=>l,mV:()=>i,oH:()=>h,z6:()=>a});var r=function(){return"Sorry system error, your request can not be processed please see a member of the security team thank you!"};function o(t,e){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2];return e.length>t?n?e.slice(0,t)+"...":e.slice(0,t):e}function a(t,e){var n;return n=o(1,t)+o(1,e)+"-"+function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6,e=Math.random().toString().replace("0.","");return e.length>t?e.slice(0,t):e}(3),n}function i(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"top";"top"==t?window.scrollTo({top:0,behavior:"smooth"}):window.scrollTo({top:document.body.scrollHeight,left:0,behavior:"smooth"})}function u(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj",o=!1;return"arr"==r?e.some((function(e){return e===t}))&&(o=!0):e.some((function(e){return e[n]===t}))&&(o=!0),o}function l(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";return"arr"==r?e.filter((function(e){return e!==t})):e.filter((function(e){return e[n]!==t}))}function s(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=new Date(t).toLocaleDateString();return e&&(r=r+" "+new Date(t).toLocaleTimeString("en-GB").slice(0,5)),n&&(r=t.substr(11,5)),r}function c(t){var e=new Date(t);return new Date(e.getTime()-6e4*e.getTimezoneOffset()).toISOString().slice(0,19).replace("T"," ")}function f(t){t.value.focus()}function d(t,e,n){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";if(!t.length)return e;var o=[];return"obj"==r?e.forEach((function(e){isNaN(e[n])?e[n].toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e):e[n].toString().toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e)})):"arr"==r&&e.forEach((function(e){isNaN(e)?e.toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e):e.toString().toLowerCase().indexOf(t.toLowerCase())>-1&&o.push(e)})),o}function p(t){return/^(((\+44)? ?(\(0\))? ?)|(0))( ?[0-9]{3,4}){3}$/.test(t)}function h(t){return!!t.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)}function y(t,e){return(null==t?"Leaver":t)+" "+(null==e?"":e)}function v(){var t=!(arguments.length>0&&void 0!==arguments[0])||arguments[0],e=new Date;return t?e.toDateString():e}function g(){return v(!1).toLocaleTimeString("en-GB").slice(0,5)}function m(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0;return t.split(e)[n]}function b(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ";return t.slice(t.indexOf(e)+1)}function w(){var t=v(!1),e=t.getMonth()+1,n=t.getDate(),r=t.getFullYear();return e<10&&(e="0"+e.toString()),n<10&&(n="0"+n.toString()),r+"-"+e+"-"+n}function S(t,e,n,r,o){var a=arguments.length>5&&void 0!==arguments[5]?arguments[5]:"Records",i=arguments.length>6&&void 0!==arguments[6]&&arguments[6],u=arguments.length>7&&void 0!==arguments[7]?arguments[7]:[],l=new t("l","pt"),c=[],f="Date: "+v()+" Time: "+g(),d="  |  ("+o.length+") "+a;o.forEach((function(t,e){for(var n=[],o=0;o<r.length;o++)u.length>0&&u.includes(r[o])&&null!=t[r[o]]?n.push(s(t[r[o]],!0)):n.push(t[r[o]]);c.push(n)})),l.autoTable({columns:n,body:c,margin:{horizontal:10},styles:{overflow:"linebreak"},bodyStyles:{valign:"top"},columnStyles:{email:{cellWidth:"wrap"}},theme:"striped",showHead:"everyPage",didDrawPage:function(t){l.setFontSize(14),l.setTextColor(40),l.text(f+d,10,20,{baseline:"top"});var e="Page "+l.internal.getCurrentPageInfo().pageNumber+" of "+l.internal.getNumberOfPages();l.setFontSize(10);var n=l.internal.pageSize,r=n.height?n.height:n.getHeight();l.text(e,t.settings.margin.left,r-10)}}),i&&l.autoPrint(),l.output("dataurlnewwindow")}function _(){return[{name:"Latest"},{name:"A-Z"},{name:"Z-A"},{name:"Date ascending"},{name:"Date descending"}]}function x(t,e){var n=new Date(t),r=new Date;return Math.ceil((r.getTime()-n.getTime())/864e5)>=e}},7079:(t,e,n)=>{n.r(e),n.d(e,{default:()=>O});var r=n(821),o=n(9285),a=n(1682),i=n(1293),u=n(8585),l=n(1694);function s(t){return s="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},s(t)}function c(){c=function(){return t};var t={},e=Object.prototype,n=e.hasOwnProperty,r=Object.defineProperty||function(t,e,n){t[e]=n.value},o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",i=o.asyncIterator||"@@asyncIterator",u=o.toStringTag||"@@toStringTag";function l(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,n){return t[e]=n}}function f(t,e,n,o){var a=e&&e.prototype instanceof h?e:h,i=Object.create(a.prototype),u=new O(o||[]);return r(i,"_invoke",{value:x(t,n,u)}),i}function d(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=f;var p={};function h(){}function y(){}function v(){}var g={};l(g,a,(function(){return this}));var m=Object.getPrototypeOf,b=m&&m(m(T([])));b&&b!==e&&n.call(b,a)&&(g=b);var w=v.prototype=h.prototype=Object.create(g);function S(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function _(t,e){function o(r,a,i,u){var l=d(t[r],t,a);if("throw"!==l.type){var c=l.arg,f=c.value;return f&&"object"==s(f)&&n.call(f,"__await")?e.resolve(f.__await).then((function(t){o("next",t,i,u)}),(function(t){o("throw",t,i,u)})):e.resolve(f).then((function(t){c.value=t,i(c)}),(function(t){return o("throw",t,i,u)}))}u(l.arg)}var a;r(this,"_invoke",{value:function(t,n){function r(){return new e((function(e,r){o(t,n,e,r)}))}return a=a?a.then(r,r):r()}})}function x(t,e,n){var r="suspendedStart";return function(o,a){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===o)throw a;return j()}for(n.method=o,n.arg=a;;){var i=n.delegate;if(i){var u=L(i,n);if(u){if(u===p)continue;return u}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var l=d(t,e,n);if("normal"===l.type){if(r=n.done?"completed":"suspendedYield",l.arg===p)continue;return{value:l.arg,done:n.done}}"throw"===l.type&&(r="completed",n.method="throw",n.arg=l.arg)}}}function L(t,e){var n=e.method,r=t.iterator[n];if(void 0===r)return e.delegate=null,"throw"===n&&t.iterator.return&&(e.method="return",e.arg=void 0,L(t,e),"throw"===e.method)||"return"!==n&&(e.method="throw",e.arg=new TypeError("The iterator does not provide a '"+n+"' method")),p;var o=d(r,t.iterator,e.arg);if("throw"===o.type)return e.method="throw",e.arg=o.arg,e.delegate=null,p;var a=o.arg;return a?a.done?(e[t.resultName]=a.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,p):a:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,p)}function C(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function k(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function O(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(C,this),this.reset(!0)}function T(t){if(t){var e=t[a];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){for(;++r<t.length;)if(n.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=void 0,e.done=!0,e};return o.next=o}}return{next:j}}function j(){return{value:void 0,done:!0}}return y.prototype=v,r(w,"constructor",{value:v,configurable:!0}),r(v,"constructor",{value:y,configurable:!0}),y.displayName=l(v,u,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===y||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,v):(t.__proto__=v,l(t,u,"GeneratorFunction")),t.prototype=Object.create(w),t},t.awrap=function(t){return{__await:t}},S(_.prototype),l(_.prototype,i,(function(){return this})),t.AsyncIterator=_,t.async=function(e,n,r,o,a){void 0===a&&(a=Promise);var i=new _(f(e,n,r,o),a);return t.isGeneratorFunction(n)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},S(w),l(w,u,"Generator"),l(w,a,(function(){return this})),l(w,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=Object(t),n=[];for(var r in e)n.push(r);return n.reverse(),function t(){for(;n.length;){var r=n.pop();if(r in e)return t.value=r,t.done=!1,t}return t.done=!0,t}},t.values=T,O.prototype={constructor:O,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(k),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(n,r){return i.type="throw",i.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],i=a.completion;if("root"===a.tryLoc)return r("end");if(a.tryLoc<=this.prev){var u=n.call(a,"catchLoc"),l=n.call(a,"finallyLoc");if(u&&l){if(this.prev<a.catchLoc)return r(a.catchLoc,!0);if(this.prev<a.finallyLoc)return r(a.finallyLoc)}else if(u){if(this.prev<a.catchLoc)return r(a.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return r(a.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=e&&e<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=t,i.arg=e,a?(this.method="next",this.next=a.finallyLoc,p):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),k(n),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var o=r.arg;k(n)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:T(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),p}},t}function f(t,e,n,r,o,a,i){try{var u=t[a](i),l=u.value}catch(t){return void n(t)}u.done?e(l):Promise.resolve(l).then(r,o)}function d(t){return function(){var e=this,n=arguments;return new Promise((function(r,o){var a=t.apply(e,n);function i(t){f(a,r,o,i,u,"next",t)}function u(t){f(a,r,o,i,u,"throw",t)}i(void 0)}))}}var p={class:"form-wrapper"},h={key:0},y={key:1},v=["onSubmit"],g={class:"form-label"},m=(0,r._)("br",null,null,-1),b=(0,r._)("br",null,null,-1),w={key:0,class:"text-danger bolded small"},S={key:1,class:"text-success bolded"},_={key:2},x={class:"input-group mb-3"},L={class:"input-group-append"},C=(0,r.Uk)("Save"),k={class:"small"};const O={name:"CommonAbsenceReasonsForm",setup:function(t){var e=(0,r.qj)({reason:"",is_processing:!1,err_msg:"",success_msg:""}),n=function(){e.err_msg=""},s=function(){var t=!1;""==e.reason&&(t=!0,e.err_msg="*Please enter absence reason before saving thanks"),t||(e.is_processing=!0,setTimeout(d(c().mark((function t(){var n,r,a;return c().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,u.Z.post("/absence/add-reasons",{reason:e.reason});case 3:""!=(null==(r=t.sent)||null===(n=r.data)||void 0===n?void 0:n.error)?e.err_msg=null==r||null===(a=r.data)||void 0===a?void 0:a.error:(e.success_msg="Reason added successfully",e.reason="",setTimeout((function(){o.Nd.get("/absence/reasons")}),500)),t.next=10;break;case 7:t.prev=7,t.t0=t.catch(0),e.err_msg=(0,l.de)();case 10:return t.prev=10,e.is_processing=!1,t.finish(10);case 13:case"end":return t.stop()}}),t,null,[[0,7,10,13]])}))),1e3))};return function(t,o){return(0,r.wg)(),(0,r.iD)("div",p,[e.is_processing?((0,r.wg)(),(0,r.iD)("section",h,[(0,r.Wm)(i.Z)])):(0,r.kq)("",!0),e.is_processing?(0,r.kq)("",!0):((0,r.wg)(),(0,r.iD)("section",y,[(0,r._)("form",{onSubmit:(0,r.iM)(s,["prevent"])},[(0,r._)("label",g,[(0,r.wy)((0,r._)("span",null," Add new absence reason",512),[[r.F8,""==e.success_msg]]),m,b,""!=e.err_msg?((0,r.wg)(),(0,r.iD)("span",w,(0,r.zw)(e.err_msg),1)):""!=e.success_msg?((0,r.wg)(),(0,r.iD)("span",S,(0,r.zw)(e.success_msg),1)):((0,r.wg)(),(0,r.iD)("span",_,"Reason*"))]),(0,r.wy)((0,r._)("div",x,[(0,r.wy)((0,r._)("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=function(t){return e.reason=t}),class:"form-control",onFocus:n},null,544),[[r.nr,e.reason]]),(0,r._)("div",L,[(0,r.Wm)(a.Z,{btnType:"submit",customClass:"btn-primary"},{default:(0,r.w5)((function(){return[C]})),_:1})])],512),[[r.F8,""==e.success_msg]]),(0,r.wy)((0,r._)("p",k," All fields marked with a * are mandatory ",512),[[r.F8,""==e.success_msg]])],40,v)]))])}}}},1682:(t,e,n)=>{n.d(e,{Z:()=>l});var r=n(821);function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function a(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==o(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!==o(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===o(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var i=["title","type","disabled"],u=["disabled"];const l={name:"AppButton",props:{noBtnStyle:{type:Boolean,default:!1},btnStyle:{type:String,default:"default"},btnType:{type:String,default:"button"},btnTitle:{type:String,default:""},btnFunc:{type:Function,default:null},fullBtn:{type:Boolean,default:!1},btnDisabled:{type:Boolean,default:!1},hideBtn:{type:Boolean,default:!1},customClass:{type:String,default:""},customClassObj:{type:Object,default:null}},setup:function(t){var e=t,n=(0,r.qj)({defaultClassName:"no-border-radius btn shadow-none "+e.customClass});return function(e,o){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("button",{title:t.btnTitle,type:t.btnType,class:(0,r.C_)(a({"hide-on-all-screen":t.hideBtn,"btn-full":t.fullBtn,"btn-muted":"muted"===t.btnStyle,"primary-btn":"primary"===t.btnStyle,"btn-primary":"primary2"===t.btnStyle,"btn-danger":"danger"===t.btnStyle,"btn-default":"default"===t.btnStyle,"btn-secondary":"secondary"===t.btnStyle,"btn-success":"success"===t.btnStyle,"btn-warning":"warn"===t.btnStyle},n.defaultClassName,!0)),onClick:o[0]||(o[0]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)}),disabled:t.btnDisabled},[(0,r.WI)(e.$slots,"default")],10,i),[[r.F8,!t.noBtnStyle]]),(0,r.wy)((0,r._)("button",{class:(0,r.C_)(null!=t.customClassObj?t.customClassObj:t.customClass),onClick:o[1]||(o[1]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)}),disabled:t.btnDisabled},[(0,r.WI)(e.$slots,"default")],10,u),[[r.F8,t.noBtnStyle]])],64)}}}},1293:(t,e,n)=>{n.d(e,{Z:()=>a});var r=n(821),o=[(0,r._)("i",{class:"fas fa-spinner fa-spin"},null,-1)];const a={name:"LoadingIndicator",props:{position:{type:String,default:null},dot:{type:Boolean,default:!1},loaderSize:{type:String,default:"large"},centerLoader:{type:Boolean,default:!0},loaderPSizeClassName:{type:String,default:""},showBelowText:{type:Boolean,default:!0}},setup:function(t){var e=t,n=(0,r.iH)(""),a=(0,r.iH)("");return(0,r.bv)((function(){"large"==e.loaderSize&&(a.value="fa-3x"),"med"==e.loaderSize&&(a.value="fa-2x"),"small"==e.loaderSize&&(a.value="fa-1x"),e.centerLoader&&(n.value="loader"),null!==e.position&&"full-page"===e.position&&(n.value="".concat(n.value," full-page-loader")),e.dot&&(n.value="".concat(n.value," loader-dot"))})),function(e,i){return(0,r.wg)(),(0,r.iD)(r.HY,null,[t.dot?((0,r.wg)(),(0,r.iD)("div",{key:0,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(a))},"..........",2)],2)):(0,r.kq)("",!0),t.dot?(0,r.kq)("",!0):((0,r.wg)(),(0,r.iD)("div",{key:1,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(a))},o,2),(0,r.wy)((0,r._)("p",{class:(0,r.C_)(t.loaderPSizeClassName)},"Please wait...",2),[[r.F8,t.showBelowText]])],2))],64)}}}}}]);