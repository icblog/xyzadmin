/*! For license information please see 952.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[952],{8585:(t,e,n)=>{n.d(e,{Z:()=>a});var r=n(9669),o=n.n(r),i="http://127.0.0.1:8000";"remote"===appDataObj.appEnv&&(i="https://xyzadmin.icblog.uk");const a=o().create({baseURL:i,withCredentials:!0,headers:{"Content-Type":"application/json"}})},1694:(t,e,n)=>{n.d(e,{$w:()=>d,Ae:()=>u,Ec:()=>a,Nb:()=>s,TJ:()=>c,de:()=>r,dq:()=>p,eY:()=>l,ef:()=>i,kc:()=>o});var r=function(){return"Sorry system error, your request can not be processed please see a member of the security team thank you!"};function o(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";return"arr"==r?e.filter((function(e){return e!==t})):e.filter((function(e){return e[n]!==t}))}function i(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=new Date(t).toLocaleDateString();return e&&(n=n+" "+new Date(t).toLocaleTimeString("en-GB").slice(0,5)),n}function a(t){var e=new Date(t);return new Date(e.getTime()-6e4*e.getTimezoneOffset()).toISOString().slice(0,19).replace("T"," ")}function l(t){t.value.focus()}function u(t,e,n){return t.length?e.filter((function(e){return e[n].toLowerCase().includes(t.toLowerCase())})):e}function s(){return(new Date).toDateString()}function c(){return(new Date).toLocaleTimeString("en-GB").slice(0,5)}function d(t,e,n,r,o){var i=arguments.length>5&&void 0!==arguments[5]?arguments[5]:"Records",a=arguments.length>6&&void 0!==arguments[6]&&arguments[6],l=new t("l","pt"),u=[],d="Date: "+s()+" Time: "+c(),p="  |  ("+o.length+") "+i;o.forEach((function(t,e){for(var n=[],o=0;o<r.length;o++)n.push(t[r[o]]);u.push(n)})),l.autoTable({columns:n,body:u,margin:{horizontal:10},styles:{overflow:"linebreak"},bodyStyles:{valign:"top"},columnStyles:{email:{cellWidth:"wrap"}},theme:"striped",showHead:"everyPage",didDrawPage:function(t){l.setFontSize(14),l.setTextColor(40),l.text(d+p,10,20,{baseline:"top"});var e="Page "+l.internal.getCurrentPageInfo().pageNumber+" of "+l.internal.getNumberOfPages();l.setFontSize(10);var n=l.internal.pageSize,r=n.height?n.height:n.getHeight();l.text(e,t.settings.margin.left,r-10)}}),a&&l.autoPrint(),l.output("dataurlnewwindow")}function p(){return[{name:"Latest"},{name:"A-Z"},{name:"Z-A"},{name:"Date ascending"},{name:"Date descending"}]}},8952:(t,e,n)=>{n.r(e),n.d(e,{default:()=>ut});var r=n(821),o=n(4707),i=n(4730),a=n(8159),l=n.n(a),u=n(1682),s=n(2306),c=n(4041),d=n(7916),p=n(1293),f=n(1694),v=n(8585);function m(t){return m="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},m(t)}function y(){y=function(){return t};var t={},e=Object.prototype,n=e.hasOwnProperty,r=Object.defineProperty||function(t,e,n){t[e]=n.value},o="function"==typeof Symbol?Symbol:{},i=o.iterator||"@@iterator",a=o.asyncIterator||"@@asyncIterator",l=o.toStringTag||"@@toStringTag";function u(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{u({},"")}catch(t){u=function(t,e,n){return t[e]=n}}function s(t,e,n,o){var i=e&&e.prototype instanceof p?e:p,a=Object.create(i.prototype),l=new F(o||[]);return r(a,"_invoke",{value:x(t,n,l)}),a}function c(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=s;var d={};function p(){}function f(){}function v(){}var h={};u(h,i,(function(){return this}));var g=Object.getPrototypeOf,b=g&&g(g(j([])));b&&b!==e&&n.call(b,i)&&(h=b);var w=v.prototype=p.prototype=Object.create(h);function S(t){["next","throw","return"].forEach((function(e){u(t,e,(function(t){return this._invoke(e,t)}))}))}function _(t,e){function o(r,i,a,l){var u=c(t[r],t,i);if("throw"!==u.type){var s=u.arg,d=s.value;return d&&"object"==m(d)&&n.call(d,"__await")?e.resolve(d.__await).then((function(t){o("next",t,a,l)}),(function(t){o("throw",t,a,l)})):e.resolve(d).then((function(t){s.value=t,a(s)}),(function(t){return o("throw",t,a,l)}))}l(u.arg)}var i;r(this,"_invoke",{value:function(t,n){function r(){return new e((function(e,r){o(t,n,e,r)}))}return i=i?i.then(r,r):r()}})}function x(t,e,n){var r="suspendedStart";return function(o,i){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===o)throw i;return D()}for(n.method=o,n.arg=i;;){var a=n.delegate;if(a){var l=O(a,n);if(l){if(l===d)continue;return l}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var u=c(t,e,n);if("normal"===u.type){if(r=n.done?"completed":"suspendedYield",u.arg===d)continue;return{value:u.arg,done:n.done}}"throw"===u.type&&(r="completed",n.method="throw",n.arg=u.arg)}}}function O(t,e){var n=e.method,r=t.iterator[n];if(void 0===r)return e.delegate=null,"throw"===n&&t.iterator.return&&(e.method="return",e.arg=void 0,O(t,e),"throw"===e.method)||"return"!==n&&(e.method="throw",e.arg=new TypeError("The iterator does not provide a '"+n+"' method")),d;var o=c(r,t.iterator,e.arg);if("throw"===o.type)return e.method="throw",e.arg=o.arg,e.delegate=null,d;var i=o.arg;return i?i.done?(e[t.resultName]=i.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,d):i:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,d)}function k(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function C(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function F(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(k,this),this.reset(!0)}function j(t){if(t){var e=t[i];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){for(;++r<t.length;)if(n.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=void 0,e.done=!0,e};return o.next=o}}return{next:D}}function D(){return{value:void 0,done:!0}}return f.prototype=v,r(w,"constructor",{value:v,configurable:!0}),r(v,"constructor",{value:f,configurable:!0}),f.displayName=u(v,l,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===f||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,v):(t.__proto__=v,u(t,l,"GeneratorFunction")),t.prototype=Object.create(w),t},t.awrap=function(t){return{__await:t}},S(_.prototype),u(_.prototype,a,(function(){return this})),t.AsyncIterator=_,t.async=function(e,n,r,o,i){void 0===i&&(i=Promise);var a=new _(s(e,n,r,o),i);return t.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},S(w),u(w,l,"Generator"),u(w,i,(function(){return this})),u(w,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=Object(t),n=[];for(var r in e)n.push(r);return n.reverse(),function t(){for(;n.length;){var r=n.pop();if(r in e)return t.value=r,t.done=!1,t}return t.done=!0,t}},t.values=j,F.prototype={constructor:F,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(C),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(n,r){return a.type="throw",a.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var o=this.tryEntries.length-1;o>=0;--o){var i=this.tryEntries[o],a=i.completion;if("root"===i.tryLoc)return r("end");if(i.tryLoc<=this.prev){var l=n.call(i,"catchLoc"),u=n.call(i,"finallyLoc");if(l&&u){if(this.prev<i.catchLoc)return r(i.catchLoc,!0);if(this.prev<i.finallyLoc)return r(i.finallyLoc)}else if(l){if(this.prev<i.catchLoc)return r(i.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return r(i.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=e,i?(this.method="next",this.next=i.finallyLoc,d):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),d},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),C(n),d}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var o=r.arg;C(n)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:j(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),d}},t}function h(t,e,n,r,o,i,a){try{var l=t[i](a),u=l.value}catch(t){return void n(t)}l.done?e(u):Promise.resolve(u).then(r,o)}function g(t){return function(){var e=this,n=arguments;return new Promise((function(r,o){var i=t.apply(e,n);function a(t){h(i,r,o,a,l,"next",t)}function l(t){h(i,r,o,a,l,"throw",t)}a(void 0)}))}}function b(t){return function(t){if(Array.isArray(t))return w(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return w(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return w(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function w(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,r=new Array(e);n<e;n++)r[n]=t[n];return r}var S={key:0},_={class:"row"},x={class:"col-md-12"},O={key:1},k={class:"row"},C={class:"col-md-6 mobile-margin-bottom ml-0"},F={class:"btn-group"},j={key:0},D=[(0,r._)("i",{class:"fas fa-times"},null,-1)],L={key:1},I=[(0,r._)("i",{class:"fas fa-search"},null,-1)],P=(0,r.Uk)(" Convert to PDF "),E=(0,r.Uk)(" Print all "),U={class:"col-md-6"},T={class:"input-group current-visitor-sort-option-wrapper"},H=(0,r._)("div",{class:"input-group-prepend"},[(0,r._)("label",{class:"form-label",for:"reason"},"Sort:")],-1),V={class:"current-visitor-sort-option-selected form-control"},R={class:"input-group-append"},N={class:"row viewallvisitors-search-wrapper"},W={class:"col-md-12 text-center"},Z=[(0,r._)("p",{class:"text-danger small"}," Please select date range or enter co-worker/visitor first name. ",-1)],B={class:"col-md-6 mb-3"},z=(0,r._)("span",{class:"small bolded"},"Start date:",-1),A={class:"col-md-6 mb-3"},q=(0,r._)("span",{class:"small bolded"},"End date:",-1),G={class:"col-md-12"},M=(0,r._)("span",{class:"small bolded"},"First name: ",-1),Y=(0,r._)("span",{class:"small"},"(optional)",-1),$={class:"input-group"},K={class:"col-md-6 mx-auto"},J=(0,r.Uk)(" Search "),Q={class:"viewallvistors-result-wrapper"},X={class:"row"},tt={class:"col-md-12"},et={class:"row"},nt={class:"col-md-12 pt-0 pb-0"},rt={class:"small"},ot={class:"row pt-3"},it={class:"col-md-12"},at={class:"pt-3 text-center"},lt={class:"text-center pt-4 pb-4"};const ut={name:"ViewAllVisitors",props:{menuItemClicked:{type:String,default:""}},setup:function(t){var e=t,n=new Date,a=(0,r.iH)(n),m=(0,r.iH)(new Date(n.getFullYear()+"-1-1")),h=(0,r.iH)(n),w=(0,r.iH)(n),ut=(0,r.iH)(null),st=(0,f.dq)(),ct="/view-all-visitor",dt=(0,r.qj)({currentVisitorsRes:[],currentlyActiveIndex:null,dataLength:0,customErr:"",isSortOptionDivOpened:!1,isSortOptionSeletd:!1,optionSelected:"Latest",isFetchingDataComplete:!1,showSearchWrapperDiv:!1,coworkerOrVisitorFname:"",searchFormError:!1,isSearching:!1,isPaginating:!1,initialPageLoad:"yes",totalRecords:0,pageNumber:1,lastPageNumber:0}),pt=function(){dt.isSortOptionDivOpened=!dt.isSortOptionDivOpened},ft=function(){dt.showSearchWrapperDiv=!dt.showSearchWrapperDiv},vt=function(){var t=!1;return h.value==n&&w.value==n||(t=!0),{selectedSortOption:dt.optionSelected,coworkerOrVisitorFname:dt.coworkerOrVisitorFname,startDate:(0,f.Ec)(h.value),endDate:(0,f.Ec)(w.value),isDateChanged:t,initialPageLoad:dt.initialPageLoad,totalRecords:dt.totalRecords,pageNumber:dt.pageNumber}},mt=function(t){var e,n,r,o,i,a,l,u=arguments.length>1&&void 0!==arguments[1]&&arguments[1];(dt.dataLength=null==t||null===(e=t.data)||void 0===e?void 0:e.viewAllVisitorsResult.length,dt.initialPageLoad=null==t||null===(n=t.data)||void 0===n?void 0:n.initialPageLoad,dt.totalRecords=null==t||null===(r=t.data)||void 0===r?void 0:r.totalRecords,dt.pageNumber=null==t||null===(o=t.data)||void 0===o?void 0:o.pageNumber,dt.lastPageNumber=null==t||null===(i=t.data)||void 0===i?void 0:i.lastPageNumber,u)?dt.currentVisitorsRes=[].concat(b(dt.currentVisitorsRes),b(null==t||null===(a=t.data)||void 0===a?void 0:a.viewAllVisitorsResult)):dt.currentVisitorsRes=null==t||null===(l=t.data)||void 0===l?void 0:l.viewAllVisitorsResult},yt=function(){var t=g(y().mark((function t(){var e,n,r;return y().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return dt.isFetchingDataComplete=!1,dt.showSearchWrapperDiv&&(dt.showSearchWrapperDiv=!1),t.prev=2,t.next=5,v.Z.post(ct,vt());case 5:""!=(null==(n=t.sent)||null===(e=n.data)||void 0===e?void 0:e.error)?dt.customErr=null===(r=n.data)||void 0===r?void 0:r.error:mt(n),t.next=12;break;case 9:t.prev=9,t.t0=t.catch(2),dt.customErr=(0,f.de)();case 12:return t.prev=12,dt.isFetchingDataComplete=!0,dt.isSearching&&(dt.isSearching=!1),t.finish(12);case 16:case"end":return t.stop()}}),t,null,[[2,9,12,16]])})));return function(){return t.apply(this,arguments)}}(),ht=function(){dt.searchFormError&&(dt.searchFormError=!1)},gt=function(){h.value!=n||w.value!=n||""!=dt.coworkerOrVisitorFname?(dt.isSearching=!0,dt.pageNumber=1,ht(),yt()):dt.searchFormError=!0},bt=function(){var t=g(y().mark((function t(e){return y().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:dt.isSortOptionDivOpened=!1,dt.isSortOptionSeletd=!0,dt.optionSelected=e,dt.pageNumber=1,yt();case 5:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}(),wt=function(t){var e=!1;"print"==t&&(e=!0),(0,f.$w)(i.default,l(),["First name","Last name","Signed in","Signed out","Badge","Company","Phone","Reason"],["fname","lname","sign_in","sign_out","badge","company","phone","reason"],dt.currentVisitorsRes,"Records",e)},St=function(){var t=g(y().mark((function t(){var e,n,r;return y().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!(dt.pageNumber>dt.lastPageNumber)){t.next=2;break}return t.abrupt("return");case 2:if(dt.isSearching){t.next=17;break}return dt.isPaginating=!0,t.prev=4,t.next=7,v.Z.post(ct,vt());case 7:""!=(null==(n=t.sent)||null===(e=n.data)||void 0===e?void 0:e.error)?dt.customErr=null===(r=n.data)||void 0===r?void 0:r.error:mt(n,!0),t.next=14;break;case 11:t.prev=11,t.t0=t.catch(4),dt.customErr=(0,f.de)();case 14:return t.prev=14,dt.isPaginating=!1,t.finish(14);case 17:case"end":return t.stop()}}),t,null,[[4,11,14,17]])})));return function(){return t.apply(this,arguments)}}();return(0,r.bv)((function(){"view all visitors"==e.menuItemClicked&&(yt(),new IntersectionObserver((function(t){return t.forEach((function(t){return t.isIntersecting&&St()}),{rootMargin:"-150px 0px 0px 0px"})})).observe(ut.value))})),function(t,e){return""!=dt.customErr?((0,r.wg)(),(0,r.iD)("section",S,[(0,r._)("div",_,[(0,r._)("div",x,[(0,r.Wm)((0,r.SU)(c.Z),{infotype:"error",customClass:"no-border text-center",msg:dt.customErr},null,8,["msg"])])])])):((0,r.wg)(),(0,r.iD)("section",O,[(0,r._)("div",k,[(0,r._)("div",C,[(0,r._)("div",F,[(0,r.Wm)((0,r.SU)(u.Z),{btnType:"button",customClass:"primary-btn",btnFunc:ft},{default:(0,r.w5)((function(){return[dt.showSearchWrapperDiv?((0,r.wg)(),(0,r.iD)("span",j,D)):((0,r.wg)(),(0,r.iD)("span",L,I))]})),_:1}),(0,r.wy)((0,r._)("span",null,[(0,r.Wm)((0,r.SU)(u.Z),{btnType:"button",customClass:"primary-btn ml-3",btnFunc:function(){return wt("pdf")}},{default:(0,r.w5)((function(){return[P]})),_:1},8,["btnFunc"]),(0,r.Wm)((0,r.SU)(u.Z),{btnType:"button",customClass:"primary-btn ml-3",btnFunc:function(){return wt("print")}},{default:(0,r.w5)((function(){return[E]})),_:1},8,["btnFunc"])],512),[[r.F8,!dt.isSearching&&dt.dataLength>0]])])]),(0,r._)("div",U,[(0,r.wy)((0,r._)("div",T,[H,(0,r._)("div",V,[(0,r._)("div",null,(0,r.zw)(dt.optionSelected),1),(0,r.wy)((0,r._)("div",null,[(0,r.Wm)((0,r.SU)(s.Z),{customWrapperClass:"current-visitor-sort-option-select-wrapper",resultObj:(0,r.SU)(st),allowSearch:!1,optionSelected:dt.optionSelected,onUpdateSelectedOptionInput:bt},null,8,["resultObj","optionSelected"])],512),[[r.F8,dt.isSortOptionDivOpened]])]),(0,r._)("div",R,[(0,r.Wm)((0,r.SU)(u.Z),{btnType:"button",customClass:"option-toggle-btn",btnFunc:pt},{default:(0,r.w5)((function(){return[(0,r._)("i",{class:(0,r.C_)(dt.isSortOptionDivOpened?"fas fa-arrow-up":"fas fa-arrow-down")},null,2)]})),_:1})])],512),[[r.F8,!dt.isSearching&&dt.dataLength>0]])])]),(0,r.wy)((0,r._)("div",N,[(0,r.wy)((0,r._)("div",W,Z,512),[[r.F8,dt.searchFormError]]),(0,r._)("div",B,[z,(0,r._)("span",{class:"form-control",onClick:ht},[(0,r.Wm)((0,r.SU)(o.Z),{modelValue:h.value,"onUpdate:modelValue":e[0]||(e[0]=function(t){return h.value=t}),"partial-range":!1,"lower-limit":m.value,"upper-limit":a.value,weekStartsOn:0,inputFormat:"yyyy-MM-dd"},null,8,["modelValue","lower-limit","upper-limit"])])]),(0,r._)("div",A,[q,(0,r._)("span",{class:"form-control",onClick:ht},[(0,r.Wm)((0,r.SU)(o.Z),{modelValue:w.value,"onUpdate:modelValue":e[1]||(e[1]=function(t){return w.value=t}),"partial-range":!1,"lower-limit":m.value,"upper-limit":a.value,weekStartsOn:0,inputFormat:"yyyy-MM-dd"},null,8,["modelValue","lower-limit","upper-limit"])])]),(0,r._)("div",G,[M,Y,(0,r._)("div",$,[(0,r.wy)((0,r._)("input",{"onUpdate:modelValue":e[2]||(e[2]=function(t){return dt.coworkerOrVisitorFname=t}),type:"text",class:"form-control",placeholder:"First name of co-worker or visitor ....",onFocus:ht},null,544),[[r.nr,dt.coworkerOrVisitorFname]])])]),(0,r._)("div",K,[(0,r.Wm)((0,r.SU)(u.Z),{btnType:"button",fullBtn:!0,customClass:"primary-btn mt-3",btnFunc:gt},{default:(0,r.w5)((function(){return[J]})),_:1})])],512),[[r.F8,dt.showSearchWrapperDiv]]),(0,r._)("div",Q,[(0,r.wy)((0,r._)("div",X,[(0,r._)("div",tt,[(0,r.Wm)((0,r.SU)(p.Z))])],512),[[r.F8,dt.isSearching]]),(0,r.wy)((0,r._)("div",null,[(0,r._)("div",et,[(0,r._)("div",nt,[(0,r._)("span",rt,"Total records: "+(0,r.zw)(dt.totalRecords),1)])]),((0,r.wg)(!0),(0,r.iD)(r.HY,null,(0,r.Ko)(dt.currentVisitorsRes,(function(t,e){return(0,r.wg)(),(0,r.iD)("div",ot,[(0,r._)("div",it,[(0,r.Wm)((0,r.SU)(d.Z),{showBtn:!1,visitor:t},null,8,["visitor"])])])})),256))],512),[[r.F8,!dt.isSearching&&dt.dataLength>0]]),(0,r.wy)((0,r._)("div",at,[(0,r.Wm)((0,r.SU)(c.Z),{infotype:"info",msg:"Sorry no records found",customClass:"no-border"})],512),[[r.F8,dt.dataLength<=0&&dt.isFetchingDataComplete]])]),(0,r._)("span",{ref_key:"loadMoreIntersect",ref:ut},null,512),(0,r.wy)((0,r._)("div",lt,[(0,r.Wm)((0,r.SU)(p.Z))],512),[[r.F8,dt.isPaginating]])]))}}}},5027:(t,e,n)=>{n.d(e,{Z:()=>p});var r=n(821),o={class:"accordion-wrapper"},i={class:"float-left"},a={class:"collapsed-heading"},l={class:"float-right pr-3 pt-1"},u={class:"collapsed-icon"},s={class:"accordion-content-wrapper"},c={class:"accordion-content",ref:"content"};const d={components:{Transition:r.uT},data:function(){return{height:0}},props:{activeIndex:{type:Number,default:null},itemIndex:{type:Number,default:null}},methods:{updateIndex:function(){this.activeIndex===this.itemIndex?this.$emit("update:itemIndex",null):this.$emit("update:itemIndex",this.itemIndex)}}};const p=(0,n(3744).Z)(d,[["render",function(t,e,n,d,p,f){return(0,r.wg)(),(0,r.iD)("div",o,[(0,r._)("div",{onClick:e[0]||(e[0]=function(){return f.updateIndex&&f.updateIndex.apply(f,arguments)}),class:"accordion-trigger cf"},[(0,r._)("div",i,[(0,r._)("span",a,[(0,r.WI)(t.$slots,"accordion-trigger")])]),(0,r._)("div",l,[(0,r._)("span",u,[(0,r._)("i",{class:(0,r.C_)({"fa fa-chevron-up":n.activeIndex===n.itemIndex,"fa fa-chevron-down":n.activeIndex!=n.itemIndex})},null,2)])])]),(0,r.Wm)(r.uT,{name:"expand"},{default:(0,r.w5)((function(){return[(0,r._)("div",s,[(0,r.wy)((0,r._)("div",c,[(0,r.WI)(t.$slots,"accordion-content")],512),[[r.F8,n.activeIndex===n.itemIndex]])])]})),_:3})])}]])},1682:(t,e,n)=>{n.d(e,{Z:()=>l});var r=n(821);function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function i(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==o(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!==o(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===o(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var a=["title","type"];const l={name:"AppButton",props:{noBtnStyle:{type:Boolean,default:!1},btnStyle:{type:String,default:"default"},btnType:{type:String,default:"button"},btnTitle:{type:String,default:""},btnFunc:{type:Function,default:null},fullBtn:{type:Boolean,default:!1},hideBtn:{type:Boolean,default:!1},customClass:{type:String,default:""},customClassObj:{type:Object,default:null}},setup:function(t){var e=t,n=(0,r.qj)({defaultClassName:"no-border-radius btn shadow-none "+e.customClass});return function(e,o){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("button",{title:t.btnTitle,type:t.btnType,class:(0,r.C_)(i({"hide-on-all-screen":t.hideBtn,"btn-full":t.fullBtn,"btn-muted":"muted"===t.btnStyle,"primary-btn":"primary"===t.btnStyle,"btn-primary":"primary2"===t.btnStyle,"btn-danger":"danger"===t.btnStyle,"btn-default":"default"===t.btnStyle,"btn-secondary":"secondary"===t.btnStyle,"btn-success":"success"===t.btnStyle,"btn-warning":"warn"===t.btnStyle},n.defaultClassName,!0)),onClick:o[0]||(o[0]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)})},[(0,r.WI)(e.$slots,"default")],10,a),[[r.F8,!t.noBtnStyle]]),(0,r.wy)((0,r._)("button",{class:(0,r.C_)(null!=t.customClassObj?t.customClassObj:t.customClass),onClick:o[1]||(o[1]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)})},[(0,r.WI)(e.$slots,"default")],2),[[r.F8,t.noBtnStyle]])],64)}}}},4041:(t,e,n)=>{n.d(e,{Z:()=>a});var r=n(821),o=(0,r._)("br",null,null,-1),i=["innerHTML"];const a={name:"HandleMsg",props:{infotype:{type:String,requred:!0},msg:{type:String,requred:!0},customClass:{type:String,default:""},showHeading:{type:Boolean,default:!0},customHeading:{type:String,default:""}},setup:function(t){var e=t,n=(0,r.iH)("no-border-radius alert"),a=(0,r.iH)("");return"success"==e.infotype&&(n.value="".concat(n.value," alert-success text-success"),a.value=""==e.customHeading?"Success!":e.customHeading),"error"==e.infotype&&(n.value="".concat(n.value," alert-danger text-danger"),a.value=""==e.customHeading?"Error!":e.customHeading),"info"==e.infotype&&(n.value="".concat(n.value," alert-secondary"),a.value=""==e.customHeading?"Info!":e.customHeading),function(l,u){return(0,r.wg)(),(0,r.iD)("div",{class:(0,r.C_)((0,r.SU)(n)+" "+t.customClass),"aria-live":"assertive"},[(0,r.wy)((0,r._)("span",null,[(0,r._)("strong",null,(0,r.zw)((0,r.SU)(a)),1),o],512),[[r.F8,t.showHeading]]),(0,r._)("span",{innerHTML:e.msg},null,8,i)],2)}}}},1293:(t,e,n)=>{n.d(e,{Z:()=>i});var r=n(821),o=[(0,r._)("i",{class:"fas fa-spinner fa-spin"},null,-1)];const i={name:"LoadingIndicator",props:{position:{type:String,default:null},dot:{type:Boolean,default:!1},loaderSize:{type:String,default:"large"},centerLoader:{type:Boolean,default:!0},loaderPSizeClassName:{type:String,default:""}},setup:function(t){var e=t,n=(0,r.iH)(""),i=(0,r.iH)("");return(0,r.bv)((function(){"large"==e.loaderSize&&(i.value="fa-3x"),"med"==e.loaderSize&&(i.value="fa-2x"),"small"==e.loaderSize&&(i.value="fa-1x"),e.centerLoader&&(n.value="loader"),null!==e.position&&"full-page"===e.position&&(n.value="".concat(n.value," full-page-loader")),e.dot&&(n.value="".concat(n.value," loader-dot"))})),function(e,a){return(0,r.wg)(),(0,r.iD)(r.HY,null,[t.dot?((0,r.wg)(),(0,r.iD)("div",{key:0,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(i))},"..........",2)],2)):(0,r.kq)("",!0),t.dot?(0,r.kq)("",!0):((0,r.wg)(),(0,r.iD)("div",{key:1,class:(0,r.C_)((0,r.SU)(n))},[(0,r._)("div",{class:(0,r.C_)((0,r.SU)(i))},o,2),(0,r._)("p",{class:(0,r.C_)(t.loaderPSizeClassName)},"Please wait...",2)],2))],64)}}}},1912:(t,e,n)=>{n.d(e,{Z:()=>d});var r=n(821),o=n(1694);function i(t){return i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},i(t)}function a(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==i(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!==i(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===i(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var l={class:"input-group local-search-wrapper"},u=(0,r._)("span",{class:"local-search-icon"},[(0,r._)("i",{class:"fas fa-search"})],-1),s=["placeholder"],c=[(0,r._)("i",{class:"fas fa-times"},null,-1)];const d={name:"LocalSearch",props:{oldResultObj:{type:Object,default:{}},whatToCheck:{type:String,default:"name"},inputPlaceHolderValue:{type:String,default:"Search ...."},inputClass:{type:String,default:""}},emits:["updateResultObj"],setup:function(t,e){var n=e.emit,i=t,d=(0,r.iH)(""),p=function(){d.value=""};return(0,r.YP)(d,(function(t){var e=[];e=""==t?i.oldResultObj:(0,o.Ae)(t,i.oldResultObj,i.whatToCheck),n("updateResultObj",{arrObj:e,newValue:t})})),function(e,n){var o;return(0,r.wg)(),(0,r.iD)("div",l,[u,(0,r.wy)((0,r._)("input",{type:"text",class:(0,r.C_)((o={},a(o,t.inputClass,!0),a(o,"form-control",!0),a(o,"local-search-input",!0),o)),placeholder:t.inputPlaceHolderValue,"onUpdate:modelValue":n[0]||(n[0]=function(t){return(0,r.dq)(d)?d.value=t:d=t})},null,10,s),[[r.nr,(0,r.SU)(d)]]),(0,r.SU)(d).length>0?((0,r.wg)(),(0,r.iD)("span",{key:0,class:"local-search-icon-times",onClick:p},c)):(0,r.kq)("",!0)])}}}},2306:(t,e,n)=>{n.d(e,{Z:()=>a});var r=n(821),o=n(1912),i=["onClick"];const a={name:"OptionElement",props:{resultObj:{type:Object,default:{}},optionSelected:{type:String,default:""},placeHolderText:{type:String,default:"Search ...."},allowSearch:{type:Boolean,default:!0},customWrapperClass:{type:String,default:""}},emits:["updateSelectedOptionInput"],setup:function(t,e){var n=e.emit,a=t,l=(0,r.qj)({filteredResultObject:a.resultObj}),u=function(t){l.filteredResultObject=t.arrObj};return function(e,s){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("div",null,[(0,r.Wm)(o.Z,{oldResultObj:t.resultObj,whatToCheck:"name",inputPlaceHolderValue:t.placeHolderText,inputClass:"custom-search-input",onUpdateResultObj:u},null,8,["oldResultObj","inputPlaceHolderValue"])],512),[[r.F8,t.allowSearch]]),(0,r._)("div",{class:(0,r.C_)("option-element-wrapper "+t.customWrapperClass)},[(0,r._)("ul",null,[l.filteredResultObject.length>0?((0,r.wg)(!0),(0,r.iD)(r.HY,{key:0},(0,r.Ko)(l.filteredResultObject,(function(e,o){return(0,r.wg)(),(0,r.iD)("li",{key:o,class:(0,r.C_)(e.name==t.optionSelected?"option-selected":""),onClick:function(){var t;(t=e.name)!=a.optionSelected&&n("updateSelectedOptionInput",t)}},(0,r.zw)(e.name),11,i)})),128)):(0,r.kq)("",!0)])],2)],64)}}}},7916:(t,e,n)=>{n.d(e,{Z:()=>w});var r=n(821),o=n(1682),i=n(5027),a=n(1694),l={class:"visitors-card-wrapper box-shadow"},u={class:"row"},s={class:"col-md-5 detail-col1"},c=(0,r.Uk)(" Signed in: "),d=(0,r.Uk)(" Signed out: "),p=(0,r.Uk)(" Company: "),f=(0,r.Uk)(" Visiting: "),v={class:"col-md-5 detail-col2"},m=(0,r.Uk)(" Reason: "),y=(0,r.Uk)(" Badge: "),h=(0,r.Uk)(" Phone: "),g={class:"col-md-2 detail-col3"},b=(0,r.Uk)(" Sign Out ");const w={name:"VisitorsDetailsCard",props:{visitor:{type:Object,default:{}},handleSignOutVisitor:{type:Function,default:null},showBtn:{type:Boolean,default:!0}},setup:function(t){var e=(0,r.qj)({currentlyActiveIndex:null});return function(n,w){return(0,r.wg)(),(0,r.iD)("div",l,[((0,r.wg)(),(0,r.j4)((0,r.SU)(i.Z),{key:t.visitor.id,activeIndex:e.currentlyActiveIndex,itemIndex:t.visitor.id,"onUpdate:itemIndex":w[0]||(w[0]=function(t){return e.currentlyActiveIndex=t})},{"accordion-trigger":(0,r.w5)((function(){return[(0,r._)("span",null,(0,r.zw)(t.visitor.fname+" "+t.visitor.lname),1)]})),"accordion-content":(0,r.w5)((function(){return[(0,r._)("div",u,[(0,r._)("div",s,[(0,r._)("ul",null,[(0,r._)("li",null,[c,(0,r._)("span",null,(0,r.zw)((0,r.SU)(a.ef)(t.visitor.sign_in,!0)),1)]),(0,r.wy)((0,r._)("li",null,[d,(0,r._)("span",null,(0,r.zw)(null==t.visitor.sign_out?"...............":(0,r.SU)(a.ef)(t.visitor.sign_in,!0)),1)],512),[[r.F8,!t.showBtn]]),(0,r._)("li",null,[p,(0,r._)("span",null,(0,r.zw)(t.visitor.company),1)]),(0,r._)("li",null,[f,(0,r._)("span",null,(0,r.zw)(t.visitor.visiting),1)])])]),(0,r._)("div",v,[(0,r._)("ul",null,[(0,r._)("li",null,[m,(0,r._)("span",null,(0,r.zw)(t.visitor.reason),1)]),(0,r._)("li",null,[y,(0,r._)("span",null,(0,r.zw)(t.visitor.badge),1)]),(0,r._)("li",null,[h,(0,r._)("span",null,(0,r.zw)(t.visitor.phone),1)])])]),(0,r._)("div",g,[(0,r.wy)((0,r._)("span",null,[(0,r.Wm)((0,r.SU)(o.Z),{customClass:"primary-btn",btnFunc:function(){return t.handleSignOutVisitor(t.visitor.id)}},{default:(0,r.w5)((function(){return[b]})),_:1},8,["btnFunc"])],512),[[r.F8,t.showBtn]])])])]})),_:1},8,["activeIndex","itemIndex"]))])}}}}}]);