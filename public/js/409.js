/*! For license information please see 409.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[409],{1694:(t,e,n)=>{n.d(e,{Ae:()=>u,Ec:()=>a,Nb:()=>s,TJ:()=>c,de:()=>r,eY:()=>l,ef:()=>i,kc:()=>o});var r=function(){return"Sorry system error, your request can not be processed please see a member of the security team thank you!"};function o(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";return"arr"==r?e.filter((function(e){return e!==t})):e.filter((function(e){return e[n]!==t}))}function i(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=new Date(t).toLocaleDateString();return e&&(n=n+" "+new Date(t).toLocaleTimeString("en-GB").slice(0,5)),n}function a(t){var e=new Date(t);return new Date(e.getTime()-6e4*e.getTimezoneOffset()).toISOString().slice(0,19).replace("T"," ")}function l(t){t.value.focus()}function u(t,e,n){return t.length?e.filter((function(e){return e[n].toLowerCase().includes(t.toLowerCase())})):e}function s(){return(new Date).toDateString()}function c(){return(new Date).toLocaleTimeString("en-GB").slice(0,5)}},5409:(t,e,n)=>{n.r(e),n.d(e,{default:()=>at});var r=n(821),o=n(4730),i=(n(8159),n(1682)),a=n(1694);function l(t){return l="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},l(t)}function u(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==l(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!==l(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===l(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var s={class:"input-group local-search-wrapper"},c=(0,r._)("span",{class:"local-search-icon"},[(0,r._)("i",{class:"fas fa-search"})],-1),d=["placeholder"],p=[(0,r._)("i",{class:"fas fa-times"},null,-1)];const f={name:"LocalSearch",props:{oldResultObj:{type:Object,default:{}},whatToCheck:{type:String,default:"name"},inputPlaceHolderValue:{type:String,default:"Search ...."},inputClass:{type:String,default:""}},emits:["updateResultObj"],setup:function(t,e){var n=e.emit,o=t,i=(0,r.iH)(""),l=function(){i.value=""};return(0,r.YP)(i,(function(t){var e=[];e=""==t?o.oldResultObj:(0,a.Ae)(t,o.oldResultObj,o.whatToCheck),n("updateResultObj",{arrObj:e,newValue:t})})),function(e,n){var o;return(0,r.wg)(),(0,r.iD)("div",s,[c,(0,r.wy)((0,r._)("input",{type:"text",class:(0,r.C_)((o={},u(o,t.inputClass,!0),u(o,"form-control",!0),u(o,"local-search-input",!0),o)),placeholder:t.inputPlaceHolderValue,"onUpdate:modelValue":n[0]||(n[0]=function(t){return(0,r.dq)(i)?i.value=t:i=t})},null,10,d),[[r.nr,(0,r.SU)(i)]]),(0,r.SU)(i).length>0?((0,r.wg)(),(0,r.iD)("span",{key:0,class:"local-search-icon-times",onClick:l},p)):(0,r.kq)("",!0)])}}};var v=["onClick"];const h={name:"OptionElement",props:{resultObj:{type:Object,default:{}},optionSelected:{type:String,default:""},placeHolderText:{type:String,default:"Search ...."},allowSearch:{type:Boolean,default:!0},customWrapperClass:{type:String,default:""}},emits:["updateSelectedOptionInput"],setup:function(t,e){var n=e.emit,o=t,i=(0,r.qj)({filteredResultObject:o.resultObj}),a=function(t){i.filteredResultObject=t.arrObj};return function(e,l){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("div",null,[(0,r.Wm)(f,{oldResultObj:t.resultObj,whatToCheck:"name",inputPlaceHolderValue:t.placeHolderText,inputClass:"custom-search-input",onUpdateResultObj:a},null,8,["oldResultObj","inputPlaceHolderValue"])],512),[[r.F8,t.allowSearch]]),(0,r._)("div",{class:(0,r.C_)("option-element-wrapper "+t.customWrapperClass)},[(0,r._)("ul",null,[i.filteredResultObject.length>0?((0,r.wg)(!0),(0,r.iD)(r.HY,{key:0},(0,r.Ko)(i.filteredResultObject,(function(e,i){return(0,r.wg)(),(0,r.iD)("li",{key:i,class:(0,r.C_)(e.name==t.optionSelected?"option-selected":""),onClick:function(){var t;(t=e.name)!=o.optionSelected&&n("updateSelectedOptionInput",t)}},(0,r.zw)(e.name),11,v)})),128)):(0,r.kq)("",!0)])],2)],64)}}};var m=n(4041),y=n(5027),g={class:"col-md-12 visitors-card-wrapper"},b={class:"row"},w={class:"col-md-5 detail-col1"},S=(0,r.Uk)(" Signed in: "),_=(0,r.Uk)(" Signed out: "),x=(0,r.Uk)(" Company: "),O=(0,r.Uk)(" Visiting: "),C={class:"col-md-5 detail-col2"},k=(0,r.Uk)(" Reason: "),j=(0,r.Uk)(" Badge: "),L=(0,r.Uk)(" Phone: "),D={class:"col-md-2 detail-col3"},E=(0,r.Uk)(" Sign Out ");const I={name:"VisitorsDetailsCard",props:{visitor:{type:Object,default:{}},handleSignOutVisitor:{type:Function,default:null},showBtn:{type:Boolean,default:!0}},setup:function(t){var e=(0,r.qj)({currentlyActiveIndex:null});return function(n,o){return(0,r.wg)(),(0,r.iD)("div",g,[((0,r.wg)(),(0,r.j4)((0,r.SU)(y.Z),{key:t.visitor.id,activeIndex:e.currentlyActiveIndex,itemIndex:t.visitor.id,"onUpdate:itemIndex":o[0]||(o[0]=function(t){return e.currentlyActiveIndex=t})},{"accordion-trigger":(0,r.w5)((function(){return[(0,r._)("span",null,(0,r.zw)(t.visitor.fname+" "+t.visitor.lname),1)]})),"accordion-content":(0,r.w5)((function(){return[(0,r._)("div",b,[(0,r._)("div",w,[(0,r._)("ul",null,[(0,r._)("li",null,[S,(0,r._)("span",null,(0,r.zw)((0,r.SU)(a.ef)(t.visitor.sign_in,!0)),1)]),(0,r.wy)((0,r._)("li",null,[_,(0,r._)("span",null,(0,r.zw)(null==t.visitor.sign_out?"...............":(0,r.SU)(a.ef)(t.visitor.sign_in,!0)),1)],512),[[r.F8,!t.showBtn]]),(0,r._)("li",null,[x,(0,r._)("span",null,(0,r.zw)(t.visitor.company),1)]),(0,r._)("li",null,[O,(0,r._)("span",null,(0,r.zw)(t.visitor.visiting),1)])])]),(0,r._)("div",C,[(0,r._)("ul",null,[(0,r._)("li",null,[k,(0,r._)("span",null,(0,r.zw)(t.visitor.reason),1)]),(0,r._)("li",null,[j,(0,r._)("span",null,(0,r.zw)(t.visitor.badge),1)]),(0,r._)("li",null,[L,(0,r._)("span",null,(0,r.zw)(t.visitor.phone),1)])])]),(0,r._)("div",D,[(0,r.wy)((0,r._)("span",null,[(0,r.Wm)((0,r.SU)(i.Z),{customClass:"primary-btn",btnFunc:function(){return t.handleSignOutVisitor(t.visitor.id)}},{default:(0,r.w5)((function(){return[E]})),_:1},8,["btnFunc"])],512),[[r.F8,t.showBtn]])])])]})),_:1},8,["activeIndex","itemIndex"]))])}}};var R=n(1293),P=n(9669),T=n.n(P),U="http://127.0.0.1:8000";"remote"===appDataObj.appEnv&&(U="https://xyzadmin.icblog.uk");const F=T().create({baseURL:U,withCredentials:!0,headers:{"Content-Type":"application/json"}});function V(t){return V="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},V(t)}function H(){H=function(){return t};var t={},e=Object.prototype,n=e.hasOwnProperty,r=Object.defineProperty||function(t,e,n){t[e]=n.value},o="function"==typeof Symbol?Symbol:{},i=o.iterator||"@@iterator",a=o.asyncIterator||"@@asyncIterator",l=o.toStringTag||"@@toStringTag";function u(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{u({},"")}catch(t){u=function(t,e,n){return t[e]=n}}function s(t,e,n,o){var i=e&&e.prototype instanceof p?e:p,a=Object.create(i.prototype),l=new C(o||[]);return r(a,"_invoke",{value:S(t,n,l)}),a}function c(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=s;var d={};function p(){}function f(){}function v(){}var h={};u(h,i,(function(){return this}));var m=Object.getPrototypeOf,y=m&&m(m(k([])));y&&y!==e&&n.call(y,i)&&(h=y);var g=v.prototype=p.prototype=Object.create(h);function b(t){["next","throw","return"].forEach((function(e){u(t,e,(function(t){return this._invoke(e,t)}))}))}function w(t,e){function o(r,i,a,l){var u=c(t[r],t,i);if("throw"!==u.type){var s=u.arg,d=s.value;return d&&"object"==V(d)&&n.call(d,"__await")?e.resolve(d.__await).then((function(t){o("next",t,a,l)}),(function(t){o("throw",t,a,l)})):e.resolve(d).then((function(t){s.value=t,a(s)}),(function(t){return o("throw",t,a,l)}))}l(u.arg)}var i;r(this,"_invoke",{value:function(t,n){function r(){return new e((function(e,r){o(t,n,e,r)}))}return i=i?i.then(r,r):r()}})}function S(t,e,n){var r="suspendedStart";return function(o,i){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===o)throw i;return j()}for(n.method=o,n.arg=i;;){var a=n.delegate;if(a){var l=_(a,n);if(l){if(l===d)continue;return l}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var u=c(t,e,n);if("normal"===u.type){if(r=n.done?"completed":"suspendedYield",u.arg===d)continue;return{value:u.arg,done:n.done}}"throw"===u.type&&(r="completed",n.method="throw",n.arg=u.arg)}}}function _(t,e){var n=e.method,r=t.iterator[n];if(void 0===r)return e.delegate=null,"throw"===n&&t.iterator.return&&(e.method="return",e.arg=void 0,_(t,e),"throw"===e.method)||"return"!==n&&(e.method="throw",e.arg=new TypeError("The iterator does not provide a '"+n+"' method")),d;var o=c(r,t.iterator,e.arg);if("throw"===o.type)return e.method="throw",e.arg=o.arg,e.delegate=null,d;var i=o.arg;return i?i.done?(e[t.resultName]=i.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,d):i:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,d)}function x(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function O(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function C(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(x,this),this.reset(!0)}function k(t){if(t){var e=t[i];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){for(;++r<t.length;)if(n.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=void 0,e.done=!0,e};return o.next=o}}return{next:j}}function j(){return{value:void 0,done:!0}}return f.prototype=v,r(g,"constructor",{value:v,configurable:!0}),r(v,"constructor",{value:f,configurable:!0}),f.displayName=u(v,l,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===f||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,v):(t.__proto__=v,u(t,l,"GeneratorFunction")),t.prototype=Object.create(g),t},t.awrap=function(t){return{__await:t}},b(w.prototype),u(w.prototype,a,(function(){return this})),t.AsyncIterator=w,t.async=function(e,n,r,o,i){void 0===i&&(i=Promise);var a=new w(s(e,n,r,o),i);return t.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},b(g),u(g,l,"Generator"),u(g,i,(function(){return this})),u(g,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=Object(t),n=[];for(var r in e)n.push(r);return n.reverse(),function t(){for(;n.length;){var r=n.pop();if(r in e)return t.value=r,t.done=!1,t}return t.done=!0,t}},t.values=k,C.prototype={constructor:C,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(O),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(n,r){return a.type="throw",a.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var o=this.tryEntries.length-1;o>=0;--o){var i=this.tryEntries[o],a=i.completion;if("root"===i.tryLoc)return r("end");if(i.tryLoc<=this.prev){var l=n.call(i,"catchLoc"),u=n.call(i,"finallyLoc");if(l&&u){if(this.prev<i.catchLoc)return r(i.catchLoc,!0);if(this.prev<i.finallyLoc)return r(i.finallyLoc)}else if(l){if(this.prev<i.catchLoc)return r(i.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return r(i.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=e,i?(this.method="next",this.next=i.finallyLoc,d):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),d},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),O(n),d}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var o=r.arg;O(n)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:k(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),d}},t}function z(t,e,n,r,o,i,a){try{var l=t[i](a),u=l.value}catch(t){return void n(t)}l.done?e(u):Promise.resolve(u).then(r,o)}function B(t){return function(){var e=this,n=arguments;return new Promise((function(r,o){var i=t.apply(e,n);function a(t){z(i,r,o,a,l,"next",t)}function l(t){z(i,r,o,a,l,"throw",t)}a(void 0)}))}}var N={class:"row"},W={class:"col"},Z={class:"pt-3"},A={class:"col text-right"},q=(0,r.Uk)(" Print all"),G={class:"row"},Y={class:"col-md-6"},$={class:"input-group current-visitor-sort-option-wrapper"},M=(0,r._)("div",{class:"input-group-prepend"},[(0,r._)("label",{class:"form-label",for:"reason"},"Sort:")],-1),J={class:"current-visitor-sort-option-selected form-control"},K={class:"input-group-append"},Q={class:"col-md-6"},X={class:"current-visitors-search-wrapper"},tt={class:"row pt-3"},et={class:"row"},nt={class:"col-md-12 text-center"},rt={key:0},ot={key:1},it=(0,r.Uk)(" Reset Data ");const at={name:"CurrentVisitors",props:{errors:Object,vistorsResultSet:{type:Array,default:[]}},setup:function(t){var e=[{name:"Latest"},{name:"A-Z"},{name:"Z-A"},{name:"Date ascending"},{name:"Date descending"}],n=(0,r.qj)({oldVisitorsRes:[],currentVisitorsRes:[],currentlyActiveIndex:null,dataLength:0,customErr:"",isSortOptionDivOpened:!1,optionSelected:"Latest",isFetchingDataComplete:!1,isPageResting:!1}),l=function(){n.isSortOptionDivOpened=!n.isSortOptionDivOpened},u=function(){var t=B(H().mark((function t(e){var r,o,i,l,u;return H().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return n.isFetchingDataComplete=!1,t.prev=1,t.next=4,F.post("/sort-current-visitor",{selectedSortOption:e});case 4:""!=(null==(o=t.sent)||null===(r=o.data)||void 0===r?void 0:r.error)?n.customErr=o.data.error:(n.optionSelected=e,n.currentVisitorsRes=null==o||null===(i=o.data)||void 0===i?void 0:i.currentVisitorsResult,n.oldVisitorsRes=null==o||null===(l=o.data)||void 0===l?void 0:l.currentVisitorsResult,n.dataLength=null==o||null===(u=o.data)||void 0===u?void 0:u.currentVisitorsResult.length),t.next=11;break;case 8:t.prev=8,t.t0=t.catch(1),n.customErr=(0,a.de)();case 11:return t.prev=11,n.isFetchingDataComplete=!0,t.finish(11);case 14:case"end":return t.stop()}}),t,null,[[1,8,11,14]])})));return function(e){return t.apply(this,arguments)}}(),s=function(){var t=B(H().mark((function t(e){return H().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:n.isSortOptionDivOpened=!1,u(e);case 2:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),c=function(t){n.currentVisitorsRes=t.arrObj},d=function(){var t=B(H().mark((function t(e){var r,o;return H().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,F.post("/signout-visitor",{signedInId:e,currentDataTime:(0,a.Ec)(new Date)});case 3:""!=(null==(o=t.sent)||null===(r=o.data)||void 0===r?void 0:r.error)?n.customErr=o.data.error:(n.currentVisitorsRes=(0,a.kc)(e,n.currentVisitorsRes,"id"),n.dataLength=n.dataLength-1),t.next=10;break;case 7:t.prev=7,t.t0=t.catch(0),n.customErr=(0,a.de)();case 10:case"end":return t.stop()}}),t,null,[[0,7]])})));return function(e){return t.apply(this,arguments)}}(),p=function(){u("A-Z"),setTimeout((function(){var t=new o.default("l","pt"),e=[],r="Date: "+(0,a.Nb)()+" Time: "+(0,a.TJ)(),i="  |  ("+n.oldVisitorsRes.length+") Current visitors or contractors on site";n.oldVisitorsRes.forEach((function(t,n){var r=[];r.push(t.fname+" "+t.lname),r.push(t.sign_in),r.push(t.badge),r.push(t.company),r.push(t.phone),r.push(t.reason),e.push(r)})),t.autoTable({columns:["Name","Signed in","Badge","Company","Phone","Reason"],body:e,margin:{horizontal:10},styles:{overflow:"linebreak"},bodyStyles:{valign:"top"},columnStyles:{email:{cellWidth:"wrap"}},theme:"striped",showHead:"everyPage",didDrawPage:function(e){t.setFontSize(14),t.setTextColor(40),t.text(r+i,10,20,{baseline:"top"});var n="Page "+t.internal.getCurrentPageInfo().pageNumber+" of "+t.internal.getNumberOfPages();t.setFontSize(10);var o=t.internal.pageSize,a=o.height?o.height:o.getHeight();t.text(n,e.settings.margin.left,a-10)}}),t.autoPrint(),t.output("dataurlnewwindow")}),1e3)},v=function(){var t=B(H().mark((function t(){var e,r,o,i,l;return H().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return n.isPageResting=!0,t.prev=1,t.next=4,F.post("/reset-current-visitor");case 4:""!=(null==(r=t.sent)||null===(e=r.data)||void 0===e?void 0:e.error)?n.customErr=r.data.error:(n.currentVisitorsRes=null==r||null===(o=r.data)||void 0===o?void 0:o.currentVisitorsResult,n.oldVisitorsRes=null==r||null===(i=r.data)||void 0===i?void 0:i.currentVisitorsResult,n.dataLength=null==r||null===(l=r.data)||void 0===l?void 0:l.currentVisitorsResult.length),t.next=11;break;case 8:t.prev=8,t.t0=t.catch(1),n.customErr=(0,a.de)();case 11:return t.prev=11,n.isPageResting=!1,t.finish(11);case 14:case"end":return t.stop()}}),t,null,[[1,8,11,14]])})));return function(){return t.apply(this,arguments)}}();return(0,r.bv)((function(){u(n.optionSelected),function(){var t;function e(){u(n.optionSelected)}function r(){clearInterval(t),t=setInterval(e,6e4)}["click","mousedown","mousemove","keypress","scroll","touchstart"].forEach((function(t){document.addEventListener(t,r,!0)}))}()})),function(t,o){return(0,r.wg)(),(0,r.iD)("div",null,[(0,r.wy)((0,r._)("section",null,[(0,r.Wm)((0,r.SU)(m.Z),{infotype:"error",customClass:"no-border text-center",msg:n.customErr},null,8,["msg"])],512),[[r.F8,""!=n.customErr&&n.dataLength<=0&&n.isFetchingDataComplete]]),(0,r.wy)((0,r._)("section",null,[(0,r._)("div",N,[(0,r._)("div",W,[(0,r._)("p",Z,(0,r.zw)(n.dataLength>0?"("+n.dataLength+") visitors on site":"("+n.dataLength+") visitor on site"),1)]),(0,r._)("div",A,[(0,r.Wm)((0,r.SU)(i.Z),{noBtnStyle:!0,customClass:"ml-2 primary-btn",btnFunc:p},{default:(0,r.w5)((function(){return[q]})),_:1})])]),(0,r._)("div",G,[(0,r._)("div",Y,[(0,r._)("div",$,[M,(0,r._)("div",J,[(0,r._)("div",null,(0,r.zw)(n.optionSelected),1),(0,r.wy)((0,r._)("div",null,[(0,r.Wm)((0,r.SU)(h),{customWrapperClass:"current-visitor-sort-option-select-wrapper",resultObj:e,allowSearch:!1,optionSelected:n.optionSelected,onUpdateSelectedOptionInput:s},null,8,["optionSelected"])],512),[[r.F8,n.isSortOptionDivOpened]])]),(0,r._)("div",K,[(0,r.Wm)((0,r.SU)(i.Z),{btnType:"button",customClass:"option-toggle-btn",btnFunc:l},{default:(0,r.w5)((function(){return[(0,r._)("i",{class:(0,r.C_)(n.isSortOptionDivOpened?"fas fa-arrow-up":"fas fa-arrow-down")},null,2)]})),_:1})])])]),(0,r._)("div",Q,[(0,r._)("div",X,[(0,r.Wm)((0,r.SU)(f),{oldResultObj:n.oldVisitorsRes,whatToCheck:"fname",inputPlaceHolderValue:"Visitor first name....",onUpdateResultObj:c},null,8,["oldResultObj"])])])]),((0,r.wg)(!0),(0,r.iD)(r.HY,null,(0,r.Ko)(n.currentVisitorsRes,(function(t,e){return(0,r.wg)(),(0,r.iD)("div",tt,[(0,r.Wm)((0,r.SU)(I),{visitor:t,handleSignOutVisitor:d},null,8,["visitor"])])})),256))],512),[[r.F8,""==n.customErr&&n.dataLength>0]]),(0,r.wy)((0,r._)("section",null,[(0,r._)("div",et,[(0,r._)("div",nt,[n.isPageResting?((0,r.wg)(),(0,r.iD)("section",rt,[(0,r.Wm)((0,r.SU)(R.Z))])):((0,r.wg)(),(0,r.iD)("section",ot,[(0,r.Wm)((0,r.SU)(m.Z),{infotype:"info",msg:"No visitors on site",customClass:"no-border"}),(0,r.Wm)((0,r.SU)(i.Z),{btnType:"button",customClass:"primary-btn",btnFunc:v},{default:(0,r.w5)((function(){return[it]})),_:1})]))])])],512),[[r.F8,""==n.customErr&&n.dataLength<=0&&n.isFetchingDataComplete]])])}}}},5027:(t,e,n)=>{n.d(e,{Z:()=>p});var r=n(821),o={class:"accordion-wrapper"},i={class:"float-left"},a={class:"collapsed-heading"},l={class:"float-right pr-3 pt-1"},u={class:"collapsed-icon"},s={class:"accordion-content-wrapper"},c={class:"accordion-content",ref:"content"};const d={components:{Transition:r.uT},data:function(){return{height:0}},props:{activeIndex:{type:Number,default:null},itemIndex:{type:Number,default:null}},methods:{updateIndex:function(){this.activeIndex===this.itemIndex?this.$emit("update:itemIndex",null):this.$emit("update:itemIndex",this.itemIndex)}}};const p=(0,n(3744).Z)(d,[["render",function(t,e,n,d,p,f){return(0,r.wg)(),(0,r.iD)("div",o,[(0,r._)("div",{onClick:e[0]||(e[0]=function(){return f.updateIndex&&f.updateIndex.apply(f,arguments)}),class:"accordion-trigger cf"},[(0,r._)("div",i,[(0,r._)("span",a,[(0,r.WI)(t.$slots,"accordion-trigger")])]),(0,r._)("div",l,[(0,r._)("span",u,[(0,r._)("i",{class:(0,r.C_)({"fa fa-chevron-up":n.activeIndex===n.itemIndex,"fa fa-chevron-down":n.activeIndex!=n.itemIndex})},null,2)])])]),(0,r.Wm)(r.uT,{name:"expand"},{default:(0,r.w5)((function(){return[(0,r._)("div",s,[(0,r.wy)((0,r._)("div",c,[(0,r.WI)(t.$slots,"accordion-content")],512),[[r.F8,n.activeIndex===n.itemIndex]])])]})),_:3})])}]])},1682:(t,e,n)=>{n.d(e,{Z:()=>l});var r=n(821);function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function i(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==o(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!==o(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===o(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var a=["title","type"];const l={name:"AppButton",props:{noBtnStyle:{type:Boolean,default:!1},btnStyle:{type:String,default:"default"},btnType:{type:String,default:"button"},btnTitle:{type:String,default:""},btnFunc:{type:Function,default:null},fullBtn:{type:Boolean,default:!1},hideBtn:{type:Boolean,default:!1},customClass:{type:String,default:""},customClassObj:{type:Object,default:null}},setup:function(t){var e=t,n=(0,r.qj)({defaultClassName:"no-border-radius btn shadow-none "+e.customClass});return function(e,o){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("button",{title:t.btnTitle,type:t.btnType,class:(0,r.C_)(i({"hide-on-all-screen":t.hideBtn,"btn-full":t.fullBtn,"btn-muted":"muted"===t.btnStyle,"primary-btn":"primary"===t.btnStyle,"btn-primary":"primary2"===t.btnStyle,"btn-danger":"danger"===t.btnStyle,"btn-default":"default"===t.btnStyle,"btn-secondary":"secondary"===t.btnStyle,"btn-success":"success"===t.btnStyle,"btn-warning":"warn"===t.btnStyle},n.defaultClassName,!0)),onClick:o[0]||(o[0]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)})},[(0,r.WI)(e.$slots,"default")],10,a),[[r.F8,!t.noBtnStyle]]),(0,r.wy)((0,r._)("button",{class:(0,r.C_)(null!=t.customClassObj?t.customClassObj:t.customClass),onClick:o[1]||(o[1]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)})},[(0,r.WI)(e.$slots,"default")],2),[[r.F8,t.noBtnStyle]])],64)}}}},4041:(t,e,n)=>{n.d(e,{Z:()=>a});var r=n(821),o=(0,r._)("br",null,null,-1),i=["innerHTML"];const a={name:"HandleMsg",props:{infotype:{type:String,requred:!0},msg:{type:String,requred:!0},customClass:{type:String,default:""},showHeading:{type:Boolean,default:!0},customHeading:{type:String,default:""}},setup:function(t){var e=t,n=(0,r.iH)("no-border-radius alert"),a=(0,r.iH)("");return"success"==e.infotype&&(n.value="".concat(n.value," alert-success text-success"),a.value=""==e.customHeading?"Success!":e.customHeading),"error"==e.infotype&&(n.value="".concat(n.value," alert-danger text-danger"),a.value=""==e.customHeading?"Error!":e.customHeading),"info"==e.infotype&&(n.value="".concat(n.value," alert-secondary"),a.value=""==e.customHeading?"Info!":e.customHeading),function(l,u){return(0,r.wg)(),(0,r.iD)("div",{class:(0,r.C_)((0,r.SU)(n)+" "+t.customClass),"aria-live":"assertive"},[(0,r.wy)((0,r._)("span",null,[(0,r._)("strong",null,(0,r.zw)((0,r.SU)(a)),1),o],512),[[r.F8,t.showHeading]]),(0,r._)("span",{innerHTML:e.msg},null,8,i)],2)}}}},1293:(t,e,n)=>{n.d(e,{Z:()=>i});var r=n(821),o=[(0,r._)("i",{class:"fas fa-spinner fa-spin"},null,-1)];const i={name:"LoadingIndicator",props:{position:{type:String,default:null},dot:{type:Boolean,default:!1},loaderSize:{type:String,default:"large"},centerLoader:{type:Boolean,default:!0},loaderPSizeClassName:{type:String,default:""}},setup:function(t){var e=t,n=(0,r.iH)(""),i=(0,r.iH)("");return(0,r.bv)((function(){"large"==e.loaderSize&&(i.value="fa-3x"),"med"==e.loaderSize&&(i.value="fa-2x"),"small"==e.loaderSize&&(i.value="fa-1x"),e.centerLoader&&(n.value="loader"),null!==e.position&&"full-page"===e.position&&(n.value="".concat(n.value," full-page-loader")),e.dot&&(n.value="".concat(n.value," loader-dot"))})),function(e,a){return(0,r.wg)(),(0,r.iD)(r.HY,null,[t.dot?((0,r.wg)(),(0,r.iD)("div",{key:0,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(i))},"..........",2)],2)):(0,r.kq)("",!0),t.dot?(0,r.kq)("",!0):((0,r.wg)(),(0,r.iD)("div",{key:1,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(i))},o,2),(0,r._)("p",{class:(0,r.C_)(t.loaderPSizeClassName)},"Please wait...",2)],2))],64)}}}}}]);