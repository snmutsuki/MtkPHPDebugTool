(this.webpackJsonpmtk_debug_setting=this.webpackJsonpmtk_debug_setting||[]).push([[0],{117:function(e,t,n){},153:function(e,t,n){e.exports=n(303)},158:function(e,t,n){e.exports=n.p+"static/media/logo.25bf045c.svg"},213:function(e,t,n){},303:function(e,t,n){"use strict";n.r(t);var a=n(0),r=n.n(a),c=n(4),o=n.n(c),l=(n(117),n(28)),s=n(29),i=n(31),u=n(30),p=n(32),m=(n(158),n(304)),h=n(113),f=n(7),d=n(77),b=h.a.SubMenu,E=m.a.Sider,g=function(e){function t(e){var n;return Object(l.a)(this,t),(n=Object(i.a)(this,Object(u.a)(t).call(this,e))).onCollapse=function(e){console.log(e),n.setState({collapsed:e})},n.onItemClick=function(e){n.props.handleItemClick(e.key)},n.state={collapsed:!1,menuContent:[]},n}return Object(p.a)(t,e),Object(s.a)(t,[{key:"componentDidMount",value:function(){var e=this,t=[];fetch(this.props.fetchUrl).then((function(e){return e.text()})).then((function(n){t=JSON.parse(n).data,e.setState((function(){return{menuContent:t}}))})).catch((function(t){console.log(t),e.setState((function(){return{menuContent:[]}}))}))}},{key:"parseMenuContent",value:function(e){var t=this,n=[];return e.forEach((function(e){if(e.subMenu){var a=t.parseMenuContent(e.subMenu);n.push(r.a.createElement(b,{key:e.key,title:r.a.createElement("span",null,!!e.icon&&r.a.createElement(f.a,{type:e.icon}),r.a.createElement("span",null,e.name)),disabled:e.disabled},a))}else n.push(r.a.createElement(h.a.Item,{key:e.key,onClick:t.onItemClick,disabled:e.disabled},r.a.createElement(d.b,{to:t.props.baseUrl+e.path},!!e.icon&&r.a.createElement(f.a,{type:e.icon}),r.a.createElement("span",null,e.name))))})),n}},{key:"render",value:function(){var e=this.parseMenuContent(this.state.menuContent).map((function(e){return e}));return r.a.createElement(E,{collapsible:!0,collapsed:this.state.collapsed,onCollapse:this.onCollapse},r.a.createElement("div",{className:"logo-collapsed-"+this.state.collapsed}),r.a.createElement(h.a,{theme:"dark",defaultSelectedKeys:["1"],mode:"inline"},e))}}]),t}(r.a.Component),y=(n(213),n(133),n(40)),v=n(308),k=n(305),O=n(306),C=n(150),j=n(115),M=function(e){function t(e){var n;return Object(l.a)(this,t),(n=Object(i.a)(this,Object(u.a)(t).call(this,e))).handleSubmit=function(e){e.preventDefault(),n.props.form.validateFieldsAndScroll((function(e,t){e||fetch(n.props.path,{method:"POST",headers:{Accept:"application/json","Content-Type":"application/json","X-Requested-With":"XMLHttpRequest"},body:JSON.stringify(t)}).catch((function(e){return console.log(e)}))}))},n.state={confirmDirty:!1,autoCompleteResult:[]},n}return Object(p.a)(t,e),Object(s.a)(t,[{key:"getInputType",value:function(e){return"password"==e?r.a.createElement(v.a.Password,null):"switch"==e?r.a.createElement(k.a,null):r.a.createElement(v.a,null)}},{key:"parseFormContent",value:function(e){var t=this,n=[];console.log(e);var a=this.props.form.getFieldDecorator;return e.forEach((function(e){n.push(r.a.createElement(O.a.Item,{label:r.a.createElement("span",null,e.helpMessage?r.a.createElement("span",null,e.labelName,"\xa0",r.a.createElement(C.a,{title:e.helpMessage},r.a.createElement(f.a,{type:"question-circle-o"}))):e.labelName)},a(e.name,{rules:[{required:e.required,message:"\u8fd9\u4e2a\u503c\u5fc5\u987b\u7ed9\u5b9a\uff01"}],initialValue:e.value})(t.getInputType(e.type))))})),n}},{key:"render",value:function(){var e=this.parseFormContent(this.props.content).map((function(e){return e}));return r.a.createElement(O.a,Object.assign({},{labelCol:{xs:{span:24},sm:{span:8}},wrapperCol:{xs:{span:24},sm:{span:10}}},{onSubmit:this.handleSubmit,className:this.props.className}),e,r.a.createElement(O.a.Item,{wrapperCol:{xs:{span:24,offset:0},sm:{span:16,offset:8}}},r.a.createElement(j.a,{type:"primary",htmlType:"submit"},"\u786e\u5b9a")))}}]),t}(r.a.Component),S=O.a.create({name:"register"})(M),w=n(307),N=function(e){function t(){return Object(l.a)(this,t),Object(i.a)(this,Object(u.a)(t).apply(this,arguments))}return Object(p.a)(t,e),Object(s.a)(t,[{key:"parsePath",value:function(e){for(var t=[],n=0,a=0;-1!=(n=e.indexOf("/",a));)0!=n&&t.push(r.a.createElement(w.a.Item,null,e.substring(a,n))),a=++n;return t.push(r.a.createElement(w.a.Item,null,e.substring(a))),t}},{key:"render",value:function(){var e=this.parsePath(this.props.path).map((function(e){return e}));return r.a.createElement(w.a,{style:this.props.style},e)}}]),t}(r.a.Component),I=function(e){function t(){return Object(l.a)(this,t),Object(i.a)(this,Object(u.a)(t).apply(this,arguments))}return Object(p.a)(t,e),Object(s.a)(t,[{key:"render",value:function(){return r.a.createElement("div",{className:this.props.className},this.props.content)}}]),t}(r.a.Component),x=m.a.Header,T=m.a.Content,D=m.a.Footer,q="/mtkDebug/mtkManager",F="http://localhost:8088/mtkDebug/mtk.php",J=function(e){function t(e){var n;return Object(l.a)(this,t),(n=Object(i.a)(this,Object(u.a)(t).call(this,e))).changeContent=function(e){var t=[];fetch(F+"/MtkManager"+e).then((function(e){return e.text()})).then((function(a){t=JSON.parse(a).data,n.setState((function(){return{path:e,content:t}}))})).catch((function(t){console.log(t),n.setState((function(){return{path:e,content:[]}}))}))},n.state={content:[],path:"/welcome"},n}return Object(p.a)(t,e),Object(s.a)(t,[{key:"render",value:function(){var e=this;return r.a.createElement(m.a,{style:{minHeight:"100vh"}},r.a.createElement(g,{baseUrl:q,handleItemClick:this.changeContent,fetchUrl:F+"/MtkManager/menu"}),r.a.createElement(m.a,null,r.a.createElement(x,{style:{background:"#fff"}},r.a.createElement("span",null,"MTK")),r.a.createElement(T,{style:{margin:"0 16px"}},r.a.createElement(N,{style:{margin:"16px 0"},path:this.state.path}),r.a.createElement(y.c,null,r.a.createElement(y.a,{path:q+"/setting",render:function(){return r.a.createElement(S,{path:F+"/Setting"+e.state.path,content:e.state.content,className:"content-border"})}}),r.a.createElement(y.a,{path:q+"/debug",render:function(){return r.a.createElement(I,{className:"content-border",content:e.state.content})}}),r.a.createElement(y.a,{path:"*",render:function(){return r.a.createElement(I,{className:"content-border",content:"Welcome to MTK"})}}))),r.a.createElement(D,{style:{textAlign:"center"}},"Made by mutsuki")))}}]),t}(r.a.Component);var P=function(){return r.a.createElement(d.a,null,r.a.createElement(J,null))};Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));o.a.render(r.a.createElement(P,null),document.getElementById("root")),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()}))}},[[153,1,2]]]);
//# sourceMappingURL=main.6bde4ee9.chunk.js.map