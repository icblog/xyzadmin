"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[2169],{1694:(e,n,t)=>{t.d(n,{$w:()=>k,Ae:()=>p,Ec:()=>c,Ir:()=>v,JO:()=>_,LE:()=>S,MM:()=>m,Nb:()=>g,TJ:()=>y,U0:()=>l,YZ:()=>w,de:()=>r,dq:()=>h,eY:()=>d,ef:()=>u,ic:()=>b,kc:()=>s,mV:()=>o,oH:()=>f,z6:()=>a});var r=function(){return"Sorry system error, your request can not be processed please see a member of the security team thank you!"};function i(e,n){var t=arguments.length>2&&void 0!==arguments[2]&&arguments[2];return n.length>e?t?n.slice(0,e)+"...":n.slice(0,e):n}function a(e,n){var t;return t=i(1,e)+i(1,n)+"-"+function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:6,n=Math.random().toString().replace("0.","");return n.length>e?n.slice(0,e):n}(3),t}function o(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"top";"top"==e?window.scrollTo({top:0,behavior:"smooth"}):window.scrollTo({top:document.body.scrollHeight,left:0,behavior:"smooth"})}function l(e,n){var t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj",i=!1;return"arr"==r?n.some((function(n){return n===e}))&&(i=!0):n.some((function(n){return n[t]===e}))&&(i=!0),i}function s(e,n){var t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";return"arr"==r?n.filter((function(n){return n!==e})):n.filter((function(n){return n[t]!==e}))}function u(e){var n=arguments.length>1&&void 0!==arguments[1]&&arguments[1],t=arguments.length>2&&void 0!==arguments[2]&&arguments[2],r=new Date(e).toLocaleDateString();return n&&(r=r+" "+new Date(e).toLocaleTimeString("en-GB").slice(0,5)),t&&(r=e.substr(11,5)),r}function c(e){var n=new Date(e);return new Date(n.getTime()-6e4*n.getTimezoneOffset()).toISOString().slice(0,19).replace("T"," ")}function d(e){e.value.focus()}function p(e,n,t){var r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"obj";if(!e.length)return n;var i=[];return"obj"==r?n.forEach((function(n){isNaN(n[t])?n[t].toLowerCase().indexOf(e.toLowerCase())>-1&&i.push(n):n[t].toString().toLowerCase().indexOf(e.toLowerCase())>-1&&i.push(n)})):"arr"==r&&n.forEach((function(n){isNaN(n)?n.toLowerCase().indexOf(e.toLowerCase())>-1&&i.push(n):n.toString().toLowerCase().indexOf(e.toLowerCase())>-1&&i.push(n)})),i}function m(e){return/^(((\+44)? ?(\(0\))? ?)|(0))( ?[0-9]{3,4}){3}$/.test(e)}function f(e){return!!e.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)}function _(e,n){return(null==e?"Leaver":e)+" "+(null==n?"":n)}function g(){var e=!(arguments.length>0&&void 0!==arguments[0])||arguments[0],n=new Date;return e?n.toDateString():n}function y(){return g(!1).toLocaleTimeString("en-GB").slice(0,5)}function b(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ",t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0;return e.split(n)[t]}function v(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:" ";return e.slice(e.indexOf(n)+1)}function w(){var e=g(!1),n=e.getMonth()+1,t=e.getDate(),r=e.getFullYear();return n<10&&(n="0"+n.toString()),t<10&&(t="0"+t.toString()),r+"-"+n+"-"+t}function k(e,n,t,r,i){var a=arguments.length>5&&void 0!==arguments[5]?arguments[5]:"Records",o=arguments.length>6&&void 0!==arguments[6]&&arguments[6],l=arguments.length>7&&void 0!==arguments[7]?arguments[7]:[],s=new e("l","pt"),c=[],d="Date: "+g()+" Time: "+y(),p="  |  ("+i.length+") "+a;i.forEach((function(e,n){for(var t=[],i=0;i<r.length;i++)l.length>0&&l.includes(r[i])&&null!=e[r[i]]?t.push(u(e[r[i]],!0)):t.push(e[r[i]]);c.push(t)})),s.autoTable({columns:t,body:c,margin:{horizontal:10},styles:{overflow:"linebreak"},bodyStyles:{valign:"top"},columnStyles:{email:{cellWidth:"wrap"}},theme:"striped",showHead:"everyPage",didDrawPage:function(e){s.setFontSize(14),s.setTextColor(40),s.text(d+p,10,20,{baseline:"top"});var n="Page "+s.internal.getCurrentPageInfo().pageNumber+" of "+s.internal.getNumberOfPages();s.setFontSize(10);var t=s.internal.pageSize,r=t.height?t.height:t.getHeight();s.text(n,e.settings.margin.left,r-10)}}),o&&s.autoPrint(),s.output("dataurlnewwindow")}function h(){return[{name:"Latest"},{name:"A-Z"},{name:"Z-A"},{name:"Date ascending"},{name:"Date descending"}]}function S(e,n){var t=new Date(e),r=new Date;return Math.ceil((r.getTime()-t.getTime())/864e5)>=n}},2169:(e,n,t)=>{t.r(n),t.d(n,{default:()=>b});var r=t(821),i=t(9285),a=t(8500),o=t(2770),l=t(1682),s={class:"container-wrapper"},u={class:"container-fluid"},c={class:"row"},d={class:"col-xs-12 col-sm-12 col-md-12 col-lg-3"},p={class:"col-xs-12 col-sm-12 col-md-12 col-lg-9"},m={class:"row pt-5"},f={class:"col text-right pt-2"},_=(0,r.Uk)(" Add co-worker "),g={class:"col pt-2"},y=(0,r.Uk)(" Add contrator ");const b={name:"AddUser",setup:function(e){return function(e,n){return(0,r.wg)(),(0,r.j4)((0,r.SU)(o.Z),{pageTitle:"add-user",pageIntro:"Add user"},{default:(0,r.w5)((function(){return[(0,r._)("div",s,[(0,r._)("div",u,[(0,r._)("div",c,[(0,r._)("div",d,[(0,r.Wm)((0,r.SU)(a.Z),{currentlyActiveIndex:0})]),(0,r._)("div",p,[(0,r._)("div",m,[(0,r._)("div",f,[(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:function(){i.Nd.visit("/user/add-coworker")},btnStyle:"warn",customClass:"sign-in-out-btn mr-4 pt-3 pb-3"},{default:(0,r.w5)((function(){return[_]})),_:1},8,["btnFunc"])]),(0,r._)("div",g,[(0,r.Wm)((0,r.SU)(l.Z),{btnFunc:function(){i.Nd.visit("/user/add-contractor")},btnStyle:"primary2",customClass:"sign-in-out-btn ml-4 pt-3 pb-3"},{default:(0,r.w5)((function(){return[y]})),_:1},8,["btnFunc"])])])])])])])]})),_:1})}}}},8346:(e,n,t)=>{t.d(n,{Z:()=>p});var r=t(821),i={class:"accordion-wrapper"},a={class:"accordion-trigger-left"},o={class:"collapsed-heading"},l={class:"accordion-trigger-right"},s={class:"collapsed-icon"},u={class:"accordion-content-wrapper"},c={class:"accordion-content",ref:"content"};const d={components:{Transition:r.uT},data:function(){return{height:0}},props:{activeIndex:{type:Number,default:null},itemIndex:{type:Number,default:null},extraTriggerFunc:{type:Function,default:function(){}}},methods:{updateIndex:function(){this.activeIndex===this.itemIndex?this.$emit("update:itemIndex",null):this.$emit("update:itemIndex",this.itemIndex)}}};const p=(0,t(3744).Z)(d,[["render",function(e,n,t,d,p,m){return(0,r.wg)(),(0,r.iD)("div",i,[(0,r._)("div",{onClick:n[0]||(n[0]=function(){m.updateIndex(),t.extraTriggerFunc()}),class:"accordion-trigger"},[(0,r._)("div",a,[(0,r._)("span",o,[(0,r.WI)(e.$slots,"accordion-trigger")])]),(0,r._)("div",l,[(0,r._)("span",s,[(0,r._)("i",{class:(0,r.C_)({"fa fa-chevron-up":t.activeIndex===t.itemIndex,"fa fa-chevron-down":t.activeIndex!=t.itemIndex})},null,2)])])]),(0,r.Wm)(r.uT,{name:"expand"},{default:(0,r.w5)((function(){return[(0,r._)("div",u,[(0,r.wy)((0,r._)("div",c,[(0,r.WI)(e.$slots,"accordion-content")],512),[[r.F8,t.activeIndex===t.itemIndex]])])]})),_:3})])}]])},1682:(e,n,t)=>{t.d(n,{Z:()=>s});var r=t(821);function i(e){return i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},i(e)}function a(e,n,t){return(n=function(e){var n=function(e,n){if("object"!==i(e)||null===e)return e;var t=e[Symbol.toPrimitive];if(void 0!==t){var r=t.call(e,n||"default");if("object"!==i(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===n?String:Number)(e)}(e,"string");return"symbol"===i(n)?n:String(n)}(n))in e?Object.defineProperty(e,n,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[n]=t,e}var o=["title","type","disabled"],l=["disabled"];const s={name:"AppButton",props:{noBtnStyle:{type:Boolean,default:!1},btnStyle:{type:String,default:"default"},btnType:{type:String,default:"button"},btnTitle:{type:String,default:""},btnFunc:{type:Function,default:null},fullBtn:{type:Boolean,default:!1},btnDisabled:{type:Boolean,default:!1},hideBtn:{type:Boolean,default:!1},customClass:{type:String,default:""},customClassObj:{type:Object,default:null}},setup:function(e){var n=e,t=(0,r.qj)({defaultClassName:"no-border-radius btn shadow-none "+n.customClass});return function(n,i){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("button",{title:e.btnTitle,type:e.btnType,class:(0,r.C_)(a({"hide-on-all-screen":e.hideBtn,"btn-full":e.fullBtn,"btn-muted":"muted"===e.btnStyle,"primary-btn":"primary"===e.btnStyle,"btn-primary":"primary2"===e.btnStyle,"btn-danger":"danger"===e.btnStyle,"btn-default":"default"===e.btnStyle,"btn-secondary":"secondary"===e.btnStyle,"btn-success":"success"===e.btnStyle,"btn-warning":"warn"===e.btnStyle},t.defaultClassName,!0)),onClick:i[0]||(i[0]=function(){return e.btnFunc&&e.btnFunc.apply(e,arguments)}),disabled:e.btnDisabled},[(0,r.WI)(n.$slots,"default")],10,o),[[r.F8,!e.noBtnStyle]]),(0,r.wy)((0,r._)("button",{class:(0,r.C_)(null!=e.customClassObj?e.customClassObj:e.customClass),onClick:i[1]||(i[1]=function(){return e.btnFunc&&e.btnFunc.apply(e,arguments)}),disabled:e.btnDisabled},[(0,r.WI)(n.$slots,"default")],10,l),[[r.F8,e.noBtnStyle]])],64)}}}},9323:(e,n,t)=>{t.d(n,{Z:()=>o});var r=t(821),i=t(9285),a=["href"];const o={name:"AppLink",props:{linkType:{type:String,default:"int"},className:{type:String,default:""},linkUrl:{type:String,default:"",requred:!0}},setup:function(e){return function(n,t){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.wy)((0,r._)("a",{class:(0,r.C_)(e.className),href:e.linkUrl,target:"_blank"},[(0,r.WI)(n.$slots,"default")],10,a),[[r.F8,"ext"===e.linkType]]),(0,r.wy)((0,r.Wm)((0,r.SU)(i.rU),{class:(0,r.C_)(e.className),href:e.linkUrl},{default:(0,r.w5)((function(){return[(0,r.WI)(n.$slots,"default")]})),_:3},8,["class","href"]),[[r.F8,"int"===e.linkType]])],64)}}}},2770:(e,n,t)=>{t.d(n,{Z:()=>S});var r=t(821),i=t(1601),a=t(1694),o={class:"container"},l={class:"row"},s={class:"col"},u={class:"col"},c={class:"date-time"},d={class:"col"},p={class:"date-time"},m={class:"container pt-1"},f={class:"row justify-content-end pt-5 pb-3 text-center"},_={class:"col-9"};const g={name:"Header",props:{backUrl:{type:String,default:""},pageIntro:{type:String,default:""}},setup:function(e){var n=(0,r.qj)({currentDate:"",currentTime:"",interval:0}),t=function(){n.currentDate=(0,a.Nb)(),n.currentTime=(0,a.TJ)()};return(0,r.bv)((function(){setTimeout((function(){t()}),50),setInterval((function(){t()}),1e3)})),function(t,a){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r._)("header",null,[(0,r._)("div",o,[(0,r._)("div",l,[(0,r._)("div",s,[(0,r.Wm)(i.Z)]),(0,r._)("div",u,[(0,r._)("h5",c,"Date: "+(0,r.zw)(n.currentDate),1)]),(0,r._)("div",d,[(0,r._)("h5",p,"Time: "+(0,r.zw)(n.currentTime),1)])])])]),(0,r._)("div",m,[(0,r._)("div",f,[(0,r._)("div",_,[(0,r._)("h5",null,(0,r.zw)(e.pageIntro),1)])])])],64)}}};var y={className:"footer-wrapper"},b=(0,r._)("i",{class:"fa fa-copyright","aria-hidden":"true"},null,-1);const v={name:"Footer",setup:function(e){var n="".concat((new Date).getFullYear()," ic-admin.icblog.uk");return function(e,t){return(0,r.wg)(),(0,r.iD)("footer",y,[(0,r._)("div",{class:"container"},[(0,r._)("div",{class:"row"},[(0,r._)("div",{class:"col-md-10 mx-auto"},[(0,r._)("p",{class:"text-center"},[b,(0,r.Uk)(" "+(0,r.zw)(n))])])])])])}}};var w=t(9285),k={class:"content-wrapper"},h=appDataObj.appName;const S={name:"Layout",props:{pageTitle:{type:String,default:""},pageIntro:{type:String,default:""},backUrl:{type:String,default:""}},setup:function(e){return function(n,t){return(0,r.wg)(),(0,r.iD)(r.HY,null,[(0,r.Wm)((0,r.SU)(w.Fb),null,{default:(0,r.w5)((function(){return[(0,r._)("title",null,"\r\n      "+(0,r.zw)((0,r.SU)(h)+" | "+e.pageTitle)+"\r\n    ",1)]})),_:1}),(0,r.Wm)((0,r.SU)(g),{backUrl:e.backUrl,pageIntro:e.pageIntro},null,8,["backUrl","pageIntro"]),(0,r._)("div",k,[(0,r.WI)(n.$slots,"default")]),(0,r.Wm)((0,r.SU)(v))],64)}}}},1912:(e,n,t)=>{t.d(n,{Z:()=>d});var r=t(821),i=t(1694);function a(e){return a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a(e)}function o(e,n,t){return(n=function(e){var n=function(e,n){if("object"!==a(e)||null===e)return e;var t=e[Symbol.toPrimitive];if(void 0!==t){var r=t.call(e,n||"default");if("object"!==a(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===n?String:Number)(e)}(e,"string");return"symbol"===a(n)?n:String(n)}(n))in e?Object.defineProperty(e,n,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[n]=t,e}var l={class:"input-group local-search-wrapper"},s=(0,r._)("span",{class:"local-search-icon"},[(0,r._)("i",{class:"fas fa-search"})],-1),u=["placeholder"],c=[(0,r._)("i",{class:"fas fa-times"},null,-1)];const d={name:"LocalSearch",props:{oldResultObj:{type:Object,default:{}},arrType:{type:String,default:"obj"},whatToCheck:{type:String,default:"name"},inputPlaceHolderValue:{type:String,default:"Search ...."},inputClass:{type:String,default:""},elementName:{type:String,default:""}},emits:["updateResultObj"],setup:function(e,n){var t=n.emit,a=e,d=(0,r.iH)(""),p=function(){d.value=""};return(0,r.YP)(d,(function(e){var n=[];n=""==e?a.oldResultObj:"sidebar"==a.elementName?function(e){for(var n=[],t=0;t<a.oldResultObj.length;t++)a.oldResultObj[t].name.toLowerCase().indexOf(e.toLowerCase())>-1&&n.push(a.oldResultObj[t]);return n}(e):(0,i.Ae)(e,a.oldResultObj,a.whatToCheck,a.arrType),t("updateResultObj",{arrObj:n,newValue:e})})),function(n,t){var i;return(0,r.wg)(),(0,r.iD)("div",l,[s,(0,r.wy)((0,r._)("input",{type:"text",class:(0,r.C_)((i={},o(i,e.inputClass,!0),o(i,"local-search-input form-control",!0),i)),placeholder:e.inputPlaceHolderValue,"onUpdate:modelValue":t[0]||(t[0]=function(e){return(0,r.dq)(d)?d.value=e:d=e})},null,10,u),[[r.nr,(0,r.SU)(d)]]),(0,r.SU)(d).length>0?((0,r.wg)(),(0,r.iD)("span",{key:0,class:"local-search-icon-times",onClick:p},c)):(0,r.kq)("",!0)])}}}},1601:(e,n,t)=>{t.d(n,{Z:()=>u});var r=t(821),i=t(9323),a={class:"logo-wrapper"},o={class:"xyz-logo"},l=(0,r._)("span",{class:"logo-span"},"ic",-1),s=(0,r.Uk)("-admin");const u={name:"Logo",setup:function(e){return function(e,n){return(0,r.wg)(),(0,r.iD)("div",a,[(0,r._)("h1",o,[(0,r.Wm)(i.Z,{linkUrl:"/"},{default:(0,r.w5)((function(){return[l,s]})),_:1})])])}}}},8500:(e,n,t)=>{t.d(n,{Z:()=>x});var r=t(821),i=t(8346),a=t(9323),o=t(1682),l=t(1912);var s={class:"side-bar-wrapper"},u={class:"menu-toggle-btn-wrapper"},c={class:"side-bar-inner-wrapper"},d={class:"mb-3"},p={class:"pt-2"},m=(0,r._)("i",{class:"fa fa-user","aria-hidden":"true"},null,-1),f={class:"section-wrapper cf"},_=(0,r.Uk)("Logout"),g=(0,r.Uk)("Login"),y={class:"side-bar-menu-search-warpper"},b={class:"side-bar-inner-wrapper side-bar-inner-wrapper2"},v={class:"pt-2"},w={class:"cf"},k={key:0,class:"menu-link-wrapper"},h={key:0,class:"menu-active"},S={key:1};const x={name:"SideBar",props:{currentlyActiveIndex:{type:Number,default:null}},setup:function(e){var n=e,t=[{name:"Users",links:[{link_name:"Add user",link_url:"/add-user",component_name:"user/adduser",is_ext:!1,restricted_type:"admin"},{link_name:"Edit user",link_url:"/edit-user",component_name:"user/edituser",is_ext:!1,restricted_type:"admin"},{link_name:"View users",link_url:"/view-users",component_name:"user/viewusers",is_ext:!1,restricted_type:"user"}]},{name:"Visitors",links:[{link_name:"Current visitors",link_url:"/current-visitor",component_name:"visitors/currentvisitors",is_ext:!1,restricted_type:"user"},{link_name:"View visitors",link_url:"/view-all-visitor",component_name:"visitors/viewallvisitors",is_ext:!1,restricted_type:"user"},{link_name:"Visitors sign in/out",link_url:"https://iv.icblog.uk/",component_name:"",is_ext:!0,restricted_type:"user"},{link_name:"Visiting reasons",link_url:"/visiting-reasons",component_name:"visitors/visitingreasons",is_ext:!1,restricted_type:"user"}]},{name:"Absence",links:[{link_name:"Add absence",link_url:"/absence/add",component_name:"absence/addabsence",is_ext:!1,restricted_type:"user"},{link_name:"View absence",link_url:"/absence",component_name:"absence/absencehome",is_ext:!1,restricted_type:"user"},{link_name:"Absence reasons",link_url:"/absence/reasons",component_name:"absence/commonabsencereasons",is_ext:!1,restricted_type:"user"}]},{name:"Phones",links:[{link_name:"Add phones",link_url:"/phones/add",component_name:"phone/addphone",is_ext:!1,restricted_type:"user"},{link_name:"Edit phones",link_url:"/phones/edit",component_name:"phone/editphone",is_ext:!1,restricted_type:"user"},{link_name:"View phones",link_url:"/phones",component_name:"phone/phonehome",is_ext:!1,restricted_type:"user"}]},{name:"Department/Company",links:[{link_name:"Add new depart/comp",link_url:"/departcomp/add",component_name:"departcomp/adddepartmentorcompany",is_ext:!1,restricted_type:"user"},{link_name:"Manage depart/comp",link_url:"/view-all-depart-comp",component_name:"departcomp/viewdepartmentorcompany",is_ext:!1,restricted_type:"user"}]},{name:"Lockers",links:[{link_name:"Add new locker",link_url:"/lockers/add",component_name:"locker/addlocker",is_ext:!1,restricted_type:"user"},{link_name:"Manage locker",link_url:"/lockers",component_name:"locker/viewlockers",is_ext:!1,restricted_type:"user"}]},{name:"Keys",links:[{link_name:"Key log",link_url:"/keys/log",component_name:"key/keylog",is_ext:!1,restricted_type:"user"},{link_name:"Add new key",link_url:"/keys/add",component_name:"key/addkey",is_ext:!1,restricted_type:"user"},{link_name:"View all keys",link_url:"/view-keys",component_name:"key/viewkeys",is_ext:!1,restricted_type:"user"},{link_name:"Manage key storage",link_url:"/keys/storage",component_name:"key/storage",is_ext:!1,restricted_type:"user"}]},{name:"Temp offsite",links:[{link_name:"Current temp offsite",link_url:"/tempoffsite/current",component_name:"tempoffsite/currenttempoffsite",is_ext:!1,restricted_type:"user"},{link_name:"View temp offsite",link_url:"/tempoffsite/view",component_name:"tempoffsite/viewtempoffsite",is_ext:!1,restricted_type:"user"},{link_name:"Temp offsite in/out",link_url:"https://iv.icblog.uk/temp-in-out",component_name:"",is_ext:!0,restricted_type:"user"}]}],x=(0,r.qj)({currentlyActiveIndex:n.currentlyActiveIndex,is_menu_on:!1,default_menu_data:t,menu_data:t}),I=function(e){x.menu_data=e.arrObj},C=function(){x.is_menu_on=!x.is_menu_on};return(0,r.bv)((function(){})),function(e,n){return(0,r.wg)(),(0,r.iD)("div",s,[(0,r._)("div",u,[(0,r.Wm)((0,r.SU)(o.Z),{btnTitle:x.is_menu_on?"Close menu":"Open menu",btnStyle:"primary",btnFunc:C},{default:(0,r.w5)((function(){return[(0,r._)("span",null,[(0,r._)("i",{class:(0,r.C_)(x.is_menu_on?"fas fa-times":"fa fa-bars")},null,2)])]})),_:1},8,["btnTitle"])]),(0,r._)("div",{class:(0,r.C_)({"side-bar-menu-wrapper":!0,"menu-on":!!x.is_menu_on,"menu-off":!x.is_menu_on})},[(0,r._)("div",c,[(0,r._)("section",d,[((0,r.wg)(),(0,r.j4)((0,r.SU)(i.Z),{key:1e3,activeIndex:x.currentlyActiveIndex,itemIndex:1e3,"onUpdate:itemIndex":n[0]||(n[0]=function(e){return x.currentlyActiveIndex=e})},{"accordion-trigger":(0,r.w5)((function(){return[(0,r._)("h6",p,[m,(0,r.Uk)(" "+(0,r.zw)(" "+e.$page.props.username),1)])]})),"accordion-content":(0,r.w5)((function(){return[(0,r._)("ul",f,[e.$page.props.isLoggedIn?((0,r.wg)(),(0,r.iD)("li",{key:0,onClick:C},[(0,r.Wm)((0,r.SU)(a.Z),{linkUrl:"/logout"},{default:(0,r.w5)((function(){return[_]})),_:1})])):((0,r.wg)(),(0,r.iD)("li",{key:1,onClick:C},[(0,r.Wm)((0,r.SU)(a.Z),{linkUrl:"/login"},{default:(0,r.w5)((function(){return[g]})),_:1})]))])]})),_:1},8,["activeIndex"]))])]),(0,r.wy)((0,r._)("div",y,[(0,r.Wm)((0,r.SU)(l.Z),{oldResultObj:x.default_menu_data,elementName:"sidebar",inputPlaceHolderValue:"Search menu...",onUpdateResultObj:I},null,8,["oldResultObj"])],512),[[r.F8,e.$page.props.isLoggedIn]]),(0,r.wy)((0,r._)("div",b,[((0,r.wg)(!0),(0,r.iD)(r.HY,null,(0,r.Ko)(x.menu_data,(function(t,o){return(0,r.wg)(),(0,r.iD)("section",{class:"mb-3",key:o},[((0,r.wg)(),(0,r.j4)((0,r.SU)(i.Z),{key:o,activeIndex:x.currentlyActiveIndex,itemIndex:o,"onUpdate:itemIndex":n[1]||(n[1]=function(e){return x.currentlyActiveIndex=e})},{"accordion-trigger":(0,r.w5)((function(){return[(0,r._)("h6",v,(0,r.zw)(t.name),1)]})),"accordion-content":(0,r.w5)((function(){return[(0,r._)("ul",w,[((0,r.wg)(!0),(0,r.iD)(r.HY,null,(0,r.Ko)(t.links,(function(n,t){return(0,r.wg)(),(0,r.iD)("li",{key:t,onClick:C},["admin"==n.restricted_type&&e.$page.props.isAdmin||"user"==n.restricted_type&&e.$page.props.isLoggedIn?((0,r.wg)(),(0,r.iD)("div",k,[e.$page.component.toLowerCase()==n.component_name?((0,r.wg)(),(0,r.iD)("span",h,(0,r.zw)(n.link_name),1)):((0,r.wg)(),(0,r.iD)("span",S,[(0,r.Wm)((0,r.SU)(a.Z),{linkType:n.is_ext?"ext":"int",linkUrl:n.link_url},{default:(0,r.w5)((function(){return[(0,r.Uk)((0,r.zw)(n.link_name),1)]})),_:2},1032,["linkType","linkUrl"])]))])):(0,r.kq)("",!0)])})),128))])]})),_:2},1032,["activeIndex","itemIndex"]))])})),128))],512),[[r.F8,e.$page.props.isLoggedIn]])],2)])}}}}}]);