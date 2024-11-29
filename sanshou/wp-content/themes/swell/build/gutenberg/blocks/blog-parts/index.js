!function(){"use strict";var e={n:function(t){var l=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(l,{a:l}),l},d:function(t,l){for(var a in l)e.o(l,a)&&!e.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:l[a]})},o:function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}},t=window.wp.i18n,l=window.wp.blocks,a=window.wp.element,c=window.wp.components,s=window.wp.blockEditor,r=window.wp.serverSideRender,n=e.n(r),o=function(e){let{icon:t,size:l=24,...c}=e;return(0,a.cloneElement)(t,{width:l,height:l,...c})},i=window.wp.primitives,u=(0,a.createElement)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,a.createElement)(i.Path,{d:"M20.1 5.1L16.9 2 6.2 12.7l-1.3 4.4 4.5-1.3L20.1 5.1zM4 20.8h8v-1.5H4v1.5z"})),p=window.wp.url,d=JSON.parse('{"u2":"loos/blog-parts"}'),m=[{attributes:{partsTitle:{type:"string",default:""},partsID:{type:"string",default:""}},save:({attributes:e})=>React.createElement("div",null,'[blog_parts id="'+e.partsID+'"]')}],w=React.createElement("svg",{viewBox:"0 0 56 56"},React.createElement("g",null,React.createElement("path",{d:"M15.4,41.9c0,0.6,0.4,1,1,1h9.2c0.6,0,1-0.4,1-1v-0.8c0-0.6-0.4-1-1-1h-9.2c-0.6,0-1,0.4-1,1V41.9z"}),React.createElement("path",{d:"M11.2,42.9c0.8,0,1.4-0.6,1.4-1.4s-0.6-1.4-1.4-1.4s-1.4,0.6-1.4,1.4S10.4,42.9,11.2,42.9z"}),React.createElement("path",{d:"M45.2,42.9c0.6,0,1-0.4,1-1v-12c0-0.6-0.4-1-1-1h-12c-0.6,0-1,0.4-1,1v12c0,0.6,0.4,1,1,1H45.2z"}),React.createElement("path",{d:"M15.4,36.3c0,0.6,0.4,1,1,1h9.2c0.6,0,1-0.4,1-1v-0.8c0-0.6-0.4-1-1-1h-9.2c-0.6,0-1,0.4-1,1V36.3z"}),React.createElement("path",{d:"M16.4,31.7h9.2c0.6,0,1-0.4,1-1v-0.8c0-0.6-0.4-1-1-1h-9.2c-0.6,0-1,0.4-1,1v0.8C15.4,31.3,15.8,31.7,16.4,31.7z"}),React.createElement("path",{d:"M11.2,37.3c0.8,0,1.4-0.6,1.4-1.4c0-0.8-0.6-1.4-1.4-1.4s-1.4,0.6-1.4,1.4C9.8,36.7,10.4,37.3,11.2,37.3z"}),React.createElement("path",{d:"M45.2,13.1H10.8c-0.6,0-1,0.4-1,1v9.2c0,0.6,0.4,1,1,1h34.4c0.6,0,1-0.4,1-1v-9.2C46.2,13.5,45.8,13.1,45.2,13.1z M21,21.6 h-8.4v-5.9H21V21.6z M32.2,21.6h-8.4v-5.9h8.4V21.6z M43.4,21.6H35v-5.9h8.4V21.6z"}),React.createElement("path",{d:"M11.2,31.7c0.8,0,1.4-0.6,1.4-1.4s-0.6-1.4-1.4-1.4s-1.4,0.6-1.4,1.4S10.4,31.7,11.2,31.7z"})),React.createElement("path",{d:"M50.5,46.8h-45c-0.3,0-0.5-0.2-0.5-0.5V9.7c0-0.3,0.2-0.5,0.5-0.5h45c0.3,0,0.5,0.2,0.5,0.5v36.7 C51,46.6,50.8,46.8,50.5,46.8z M53,6.2H3c-0.6,0-1,0.4-1,1v41.7c0,0.6,0.4,1,1,1h50c0.6,0,1-0.4,1-1V7.2C54,6.6,53.6,6.2,53,6.2 L53,6.2z"}));const h=window.swellBlogParts||{},v=window.swellPartsUses||{},b=[{value:"all",label:"--- "+(0,t.__)("用途で絞り込む","swell")+" ---"}];b.push({value:"id-0",label:(0,t.__)("通常パーツ（用途の設定なし）","swell")});const E={"id-0":[],all:[]};Object.keys(v).forEach((e=>{const t=v[e];b.push({value:"id-"+e,label:t}),E["id-"+e]=[]})),Object.keys(h).forEach((e=>{const t=h[e],l=t.term_id||"0";E["id-"+l].push({value:e,label:t.title||""}),E.all.push({value:e,label:t.title||""})}));const R=(0,a.memo)((({partsID:e,setAttributes:l,selectedTerm:a,setSelectedTerm:s})=>React.createElement("div",{className:"swl-block-selectArea"},React.createElement(c.SelectControl,{value:e,className:"-partlist",options:[{value:"",label:(0,t.__)("-- ブログパーツを選択 --","swell")},...E[a]],onChange:e=>{l({partsID:e})}}),React.createElement(c.SelectControl,{value:a,options:b,onChange:e=>{s(e),l({partsID:""})}})))),_=({isSelected:e,attributes:l,setAttributes:s,setSelectedTerm:r})=>{const[n,o]=(0,a.useState)(""),[i,u]=(0,a.useState)(E.all),p=(0,a.useRef)(),d=(0,a.useRef)(),m=n&&n.length>=2&&i.length>0;return(0,a.useEffect)((()=>{u(E.all),o("")}),[l,e]),React.createElement("div",{className:"swl-block-searchArea"},React.createElement(c.TextControl,{placeholder:(0,t.__)("タイトルで検索…","swell"),value:n,onChange:e=>{o(e),u(E.all.filter((({label:t})=>t.toLowerCase().includes(e))))},onKeyDown:e=>{m&&null!=p&&p.current&&"Tab"===e.key&&(e.preventDefault(),p.current.querySelector("button").focus())},ref:d}),m&&React.createElement(c.Popover,{ref:p,className:"swl-pop--search",position:"bottom",focusOnMount:!1,onClose:()=>d.current.focus()},React.createElement("div",{className:"swl-pop--search__content"},React.createElement("ul",{className:"swl-pop--search__results"},i.map((({value:e,label:t})=>React.createElement("li",{key:e},React.createElement(c.Button,{className:"block-editor-url-input__suggestion",isLink:!0,onClick:()=>{u(E.all),o(""),s({partsID:e}),r("all")}},t))))))))};(0,l.registerBlockType)(d.u2,{title:(0,t.__)("ブログパーツ","swell"),description:(0,t.__)("登録済みのブログパーツを呼び出すことができます。","swell"),icon:w,edit:({attributes:e,setAttributes:l,isSelected:c})=>{const{partsID:r}=e,i=h[r]||null,d=i?"id-"+(i.term_id||0):"all",[m,w]=(0,a.useState)(d),v=(0,s.useBlockProps)({className:"swell-block-blog-parts swl-block-hasPreview"});return React.createElement("div",v,React.createElement(R,{partsID:r,setAttributes:l,selectedTerm:m,setSelectedTerm:w}),React.createElement(_,{isSelected:c,attributes:e,setAttributes:l,setSelectedTerm:w}),React.createElement("div",{className:"swl-block-previewLabel"},React.createElement("span",null,"Preview"),r&&React.createElement("a",{href:(0,p.addQueryArgs)("post.php",{post:r,action:"edit"}),className:"__editLink",target:"_blank",rel:"noopener noreferrer"},React.createElement(o,{icon:u}),React.createElement("span",null,(0,t.__)("このブログパーツを編集する","swell")))),React.createElement("div",{className:"swl-block-previewArea"},r?React.createElement(n(),{block:"loos/blog-parts",attributes:e}):React.createElement("p",null,(0,t.__)("ブログパーツを選択してください。","swell"))))},save:()=>null,deprecated:m})}();