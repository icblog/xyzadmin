"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[282],{7282:(e,n,a)=>{a.r(n),a.d(n,{default:()=>m});var t=a(821),s=a(9285),l=a(1293),r=a(1601),o=a(4041),i={class:"container pb-5"},u={class:"row"},c={class:"col-md-7 mx-auto"},d={class:"text-center pt-5 pb-3"},p={class:"form-wrapper"},f={key:0},g={key:1},v=appDataObj.appName;const m={name:"Verify",props:{errors:Object,respondsMsg:{type:String,default:""}},setup:function(e){var n=e,a=(0,t.iH)(!1);return(0,t.bv)((function(){""==n.respondsMsg&&(a.value=!0,setTimeout((function(){s.Nd.post("/verify-link",{},{onFinish:function(){a.value=!1,setTimeout((function(){"code000"==n.respondsMsg&&s.Nd.get("/forgotten-password")}),8e3)}})}),1e3))})),function(n,s){return(0,t.wg)(),(0,t.iD)(t.HY,null,[(0,t._)("title",null,"\r\n    "+(0,t.zw)((0,t.SU)(v)+" | verify-link")+"\r\n  ",1),(0,t._)("div",i,[(0,t._)("div",u,[(0,t._)("div",c,[(0,t._)("div",d,[(0,t.Wm)((0,t.SU)(r.Z))]),(0,t._)("div",p,[(0,t.SU)(a)?((0,t.wg)(),(0,t.iD)("section",f,[(0,t.Wm)((0,t.SU)(l.Z))])):(0,t.kq)("",!0),(0,t.SU)(a)||"code000"!=e.respondsMsg?(0,t.kq)("",!0):((0,t.wg)(),(0,t.iD)("section",g,[(0,t.Wm)((0,t.SU)(o.Z),{infotype:"error",msg:"Sorry the link has expired or Invalid,  you will be redirected to create a new one thank you.",customClass:"form-responds-msg"})]))])])])])],64)}}}},9323:(e,n,a)=>{a.d(n,{Z:()=>r});var t=a(821),s=a(9285),l=["href"];const r={name:"AppLink",props:{linkType:{type:String,default:"int"},className:{type:String,default:""},linkUrl:{type:String,default:"",requred:!0}},setup:function(e){return function(n,a){return(0,t.wg)(),(0,t.iD)(t.HY,null,[(0,t.wy)((0,t._)("a",{class:(0,t.C_)(e.className),href:e.linkUrl,target:"_blank"},[(0,t.WI)(n.$slots,"default")],10,l),[[t.F8,"ext"===e.linkType]]),(0,t.wy)((0,t.Wm)((0,t.SU)(s.rU),{class:(0,t.C_)(e.className),href:e.linkUrl},{default:(0,t.w5)((function(){return[(0,t.WI)(n.$slots,"default")]})),_:3},8,["class","href"]),[[t.F8,"int"===e.linkType]])],64)}}}},4041:(e,n,a)=>{a.d(n,{Z:()=>r});var t=a(821),s=(0,t._)("br",null,null,-1),l=["innerHTML"];const r={name:"HandleMsg",props:{infotype:{type:String,requred:!0},msg:{type:String,requred:!0},customClass:{type:String,default:""},showHeading:{type:Boolean,default:!0},customHeading:{type:String,default:""}},setup:function(e){var n=e,a=(0,t.iH)("no-border-radius alert"),r=(0,t.iH)("");return"success"==n.infotype&&(a.value="".concat(a.value," alert-success text-success"),r.value=""==n.customHeading?"Success!":n.customHeading),"error"==n.infotype&&(a.value="".concat(a.value," alert-danger text-danger"),r.value=""==n.customHeading?"Error!":n.customHeading),"info"==n.infotype&&(a.value="".concat(a.value," alert-secondary"),r.value=""==n.customHeading?"Info!":n.customHeading),function(o,i){return(0,t.wg)(),(0,t.iD)("div",{class:(0,t.C_)((0,t.SU)(a)+" "+e.customClass),"aria-live":"assertive"},[(0,t.wy)((0,t._)("span",null,[(0,t._)("strong",null,(0,t.zw)((0,t.SU)(r)),1),s],512),[[t.F8,e.showHeading]]),(0,t._)("span",{innerHTML:n.msg},null,8,l)],2)}}}},1293:(e,n,a)=>{a.d(n,{Z:()=>l});var t=a(821),s=[(0,t._)("i",{class:"fas fa-spinner fa-spin"},null,-1)];const l={name:"LoadingIndicator",props:{position:{type:String,default:null},dot:{type:Boolean,default:!1},loaderSize:{type:String,default:"large"},centerLoader:{type:Boolean,default:!0},loaderPSizeClassName:{type:String,default:""},showBelowText:{type:Boolean,default:!0}},setup:function(e){var n=e,a=(0,t.iH)(""),l=(0,t.iH)("");return(0,t.bv)((function(){"large"==n.loaderSize&&(l.value="fa-3x"),"med"==n.loaderSize&&(l.value="fa-2x"),"small"==n.loaderSize&&(l.value="fa-1x"),n.centerLoader&&(a.value="loader"),null!==n.position&&"full-page"===n.position&&(a.value="".concat(a.value," full-page-loader")),n.dot&&(a.value="".concat(a.value," loader-dot"))})),function(n,r){return(0,t.wg)(),(0,t.iD)(t.HY,null,[e.dot?((0,t.wg)(),(0,t.iD)("div",{key:0,class:(0,t.C_)((0,t.SU)(a))},[(0,t._)("div",{class:(0,t.C_)((0,t.SU)(l))},"..........",2)],2)):(0,t.kq)("",!0),e.dot?(0,t.kq)("",!0):((0,t.wg)(),(0,t.iD)("div",{key:1,class:(0,t.C_)((0,t.SU)(a))},[(0,t._)("div",{class:(0,t.C_)((0,t.SU)(l))},s,2),(0,t.wy)((0,t._)("p",{class:(0,t.C_)(e.loaderPSizeClassName)},"Please wait...",2),[[t.F8,e.showBelowText]])],2))],64)}}}},1601:(e,n,a)=>{a.d(n,{Z:()=>u});var t=a(821),s=a(9323),l={class:"logo-wrapper"},r={class:"xyz-logo"},o=(0,t._)("span",{class:"logo-span"},"ic",-1),i=(0,t.Uk)("-admin");const u={name:"Logo",setup:function(e){return function(e,n){return(0,t.wg)(),(0,t.iD)("div",l,[(0,t._)("h1",r,[(0,t.Wm)(s.Z,{linkUrl:"/"},{default:(0,t.w5)((function(){return[o,i]})),_:1})])])}}}}}]);