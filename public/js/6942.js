"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[6942],{1694:(t,e,n)=>{n.d(e,{$w:()=>v,Ae:()=>f,Ec:()=>c,Ir:()=>y,JO:()=>p,LE:()=>S,MM:()=>m,Nb:()=>_,TJ:()=>g,U0:()=>a,YZ:()=>h,de:()=>l,dq:()=>k,eY:()=>d,ef:()=>s,ic:()=>w,kc:()=>u,mV:()=>i,oH:()=>b,z6:()=>o});var l=function(){return"Sorry system error, your request can not be processed please see a member of the security team thank you!"};function r(t,e){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2];return e.length>t?n?e.slice(0,t)+"...":e.slice(0,t):e}function o(t,e){var n;return n=r(1,t)+r(1,e)+"-"+function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6,e=Math.random().toString().replace("0.","");return e.length>t?e.slice(0,t):e}(3),n}function i(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"top";"top"==t?window.scrollTo({top:0,behavior:"smooth"}):window.scrollTo({top:document.body.scrollHeight,left:0,behavior:"smooth"})}function a(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",l=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj",r=!1;return"arr"==l?e.some((function(e){return e===t}))&&(r=!0):e.some((function(e){return e[n]===t}))&&(r=!0),r}function u(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",l=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";return"arr"==l?e.filter((function(e){return e!==t})):e.filter((function(e){return e[n]!==t}))}function s(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],l=new Date(t).toLocaleDateString();return e&&(l=l+" "+new Date(t).toLocaleTimeString("en-GB").slice(0,5)),n&&(l=t.substr(11,5)),l}function c(t){var e=new Date(t);return new Date(e.getTime()-6e4*e.getTimezoneOffset()).toISOString().slice(0,19).replace("T"," ")}function d(t){t.value.focus()}function f(t,e,n){var l=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";if(!t.length)return e;var r=[];return"obj"==l?e.forEach((function(e){isNaN(e[n])?e[n].toLowerCase().indexOf(t.toLowerCase())>-1&&r.push(e):e[n].toString().toLowerCase().indexOf(t.toLowerCase())>-1&&r.push(e)})):"arr"==l&&e.forEach((function(e){isNaN(e)?e.toLowerCase().indexOf(t.toLowerCase())>-1&&r.push(e):e.toString().toLowerCase().indexOf(t.toLowerCase())>-1&&r.push(e)})),r}function m(t){return/^(((\+44)? ?(\(0\))? ?)|(0))( ?[0-9]{3,4}){3}$/.test(t)}function b(t){return!!t.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)}function p(t,e){return(null==t?"Leaver":t)+" "+(null==e?"":e)}function _(){var t=!(arguments.length>0&&void 0!==arguments[0])||arguments[0],e=new Date;return t?e.toDateString():e}function g(){return _(!1).toLocaleTimeString("en-GB").slice(0,5)}function w(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0;return t.split(e)[n]}function y(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ";return t.slice(t.indexOf(e)+1)}function h(){var t=_(!1),e=t.getMonth()+1,n=t.getDate(),l=t.getFullYear();return e<10&&(e="0"+e.toString()),n<10&&(n="0"+n.toString()),l+"-"+e+"-"+n}function v(t,e,n,l,r){var o=arguments.length>5&&void 0!==arguments[5]?arguments[5]:"Records",i=arguments.length>6&&void 0!==arguments[6]&&arguments[6],a=arguments.length>7&&void 0!==arguments[7]?arguments[7]:[],u=new t("l","pt"),c=[],d="Date: "+_()+" Time: "+g(),f="  |  ("+r.length+") "+o;r.forEach((function(t,e){for(var n=[],r=0;r<l.length;r++)a.length>0&&a.includes(l[r])&&null!=t[l[r]]?n.push(s(t[l[r]],!0)):n.push(t[l[r]]);c.push(n)})),u.autoTable({columns:n,body:c,margin:{horizontal:10},styles:{overflow:"linebreak"},bodyStyles:{valign:"top"},columnStyles:{email:{cellWidth:"wrap"}},theme:"striped",showHead:"everyPage",didDrawPage:function(t){u.setFontSize(14),u.setTextColor(40),u.text(d+f,10,20,{baseline:"top"});var e="Page "+u.internal.getCurrentPageInfo().pageNumber+" of "+u.internal.getNumberOfPages();u.setFontSize(10);var n=u.internal.pageSize,l=n.height?n.height:n.getHeight();u.text(e,t.settings.margin.left,l-10)}}),i&&u.autoPrint(),u.output("dataurlnewwindow")}function k(){return[{name:"Latest"},{name:"A-Z"},{name:"Z-A"},{name:"Date ascending"},{name:"Date descending"}]}function S(t,e){var n=new Date(t),l=new Date;return Math.ceil((l.getTime()-n.getTime())/864e5)>=e}},6942:(t,e,n)=>{n.r(e),n.d(e,{default:()=>F});var l=n(821),r=n(1682),o=n(1694),i={key:0},a=(0,l._)("hr",null,null,-1),u={class:"col-md-4 pt-0 mt-0 pb-0 mb-0"},s={class:"result-detail-ul cf"},c=(0,l.Uk)(" Key name: "),d=(0,l.Uk)(" Co-worker name out: "),f=(0,l.Uk)(" Co-worker department out: "),m=(0,l.Uk)(" Date out: "),b=(0,l.Uk)(" Time out: "),p=(0,l.Uk)(" Gave it out by: "),_={class:"col-md-8 pb-0 mb-0"},g={class:"row"},w={class:"col-8"},y={class:"result-detail-ul cf"},h=(0,l.Uk)(" Coworker authorized: "),v=(0,l.Uk)(" Co-worker name in: "),k=(0,l.Uk)(" Co-worker department in: "),S=(0,l.Uk)(" Date in: "),C=(0,l.Uk)(" Time in: "),D=(0,l.Uk)(" Received it in by: "),z=(0,l.Uk)(" comment: "),T={class:"col-4"},U={class:"mt-0 mb-0 pt-0 pb-0 text-right"},L=(0,l.Uk)("Key in "),B=(0,l._)("i",{class:"fas fa-arrow-down"},null,-1);const F={name:"KeyLogDetailsCard",props:{key_log_result_details:{}},emits:["handleKeyInModal"],setup:function(t,e){var n=e.emit;(0,l.qj)({current_active_accordion_index:null});return function(e,F){return t.key_log_result_details.length>0?((0,l.wg)(),(0,l.iD)("div",i,[a,((0,l.wg)(!0),(0,l.iD)(l.HY,null,(0,l.Ko)(t.key_log_result_details,(function(t,e){return(0,l.wg)(),(0,l.iD)("div",{key:e,class:(0,l.C_)({"row box-shadow mb-4":!0,"key-out-highliter":null==t.in_at})},[(0,l._)("div",u,[(0,l._)("ul",s,[(0,l._)("li",null,[c,(0,l._)("span",null,(0,l.zw)(t.key_name),1)]),(0,l._)("li",null,[d,(0,l._)("span",null,(0,l.zw)(t.coworker_name_out),1)]),(0,l._)("li",null,[f,(0,l._)("span",null,(0,l.zw)(t.coworker_department_out),1)]),(0,l._)("li",null,[m,(0,l._)("span",null,(0,l.zw)((0,l.SU)(o.ef)(t.out_at)),1)]),(0,l._)("li",null,[b,(0,l._)("span",null,(0,l.zw)((0,l.SU)(o.ef)(t.out_at,!1,!0)),1)]),(0,l._)("li",null,[p,(0,l._)("span",null,(0,l.zw)(t.risk_coworker_name_out),1)])])]),(0,l._)("div",_,[(0,l._)("div",g,[(0,l._)("div",w,[(0,l._)("ul",y,[(0,l._)("li",null,[h,(0,l._)("span",null,(0,l.zw)(0==t.is_coworker_authorized?"No":"Yes"),1)]),(0,l._)("li",null,[v,(0,l._)("span",null,(0,l.zw)(null==t.coworker_name_in?"---":t.coworker_name_in),1)]),(0,l._)("li",null,[k,(0,l._)("span",null,(0,l.zw)(null==t.coworker_department_in?"---":t.coworker_department_in),1)]),(0,l._)("li",null,[S,(0,l._)("span",null,(0,l.zw)(null===t.in_at?"---":(0,l.SU)(o.ef)(t.in_at)),1)]),(0,l._)("li",null,[C,(0,l._)("span",null,(0,l.zw)(null===t.in_at?"---":(0,l.SU)(o.ef)(t.in_at,!1,!0)),1)]),(0,l._)("li",null,[D,(0,l._)("span",null,(0,l.zw)(null===t.risk_coworker_name_in?"---":t.risk_coworker_name_in),1)]),(0,l._)("li",null,[z,(0,l._)("span",null,(0,l.zw)(null==t.comment?"---":t.comment),1)])])]),(0,l._)("div",T,[(0,l.wy)((0,l._)("div",U,[(0,l.Wm)((0,l.SU)(r.Z),{customClass:"mr-3 pt-1 pb-1 mt-3",btnStyle:"primary2",btnFunc:function(){n("handleKeyInModal",t)}},{default:(0,l.w5)((function(){return[L,B]})),_:2},1032,["btnFunc"])],512),[[l.F8,null==t.in_at]])])])])],2)})),128))])):(0,l.kq)("",!0)}}}},1682:(t,e,n)=>{n.d(e,{Z:()=>u});var l=n(821);function r(t){return r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},r(t)}function o(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==r(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var l=n.call(t,e||"default");if("object"!==r(l))return l;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===r(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var i=["title","type","disabled"],a=["disabled"];const u={name:"AppButton",props:{noBtnStyle:{type:Boolean,default:!1},btnStyle:{type:String,default:"default"},btnType:{type:String,default:"button"},btnTitle:{type:String,default:""},btnFunc:{type:Function,default:null},fullBtn:{type:Boolean,default:!1},btnDisabled:{type:Boolean,default:!1},hideBtn:{type:Boolean,default:!1},customClass:{type:String,default:""},customClassObj:{type:Object,default:null}},setup:function(t){var e=t,n=(0,l.qj)({defaultClassName:"no-border-radius btn shadow-none "+e.customClass});return function(e,r){return(0,l.wg)(),(0,l.iD)(l.HY,null,[(0,l.wy)((0,l._)("button",{title:t.btnTitle,type:t.btnType,class:(0,l.C_)(o({"hide-on-all-screen":t.hideBtn,"btn-full":t.fullBtn,"btn-muted":"muted"===t.btnStyle,"primary-btn":"primary"===t.btnStyle,"btn-primary":"primary2"===t.btnStyle,"btn-danger":"danger"===t.btnStyle,"btn-default":"default"===t.btnStyle,"btn-secondary":"secondary"===t.btnStyle,"btn-success":"success"===t.btnStyle,"btn-warning":"warn"===t.btnStyle},n.defaultClassName,!0)),onClick:r[0]||(r[0]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)}),disabled:t.btnDisabled},[(0,l.WI)(e.$slots,"default")],10,i),[[l.F8,!t.noBtnStyle]]),(0,l.wy)((0,l._)("button",{class:(0,l.C_)(null!=t.customClassObj?t.customClassObj:t.customClass),onClick:r[1]||(r[1]=function(){return t.btnFunc&&t.btnFunc.apply(t,arguments)}),disabled:t.btnDisabled},[(0,l.WI)(e.$slots,"default")],10,a),[[l.F8,t.noBtnStyle]])],64)}}}}}]);