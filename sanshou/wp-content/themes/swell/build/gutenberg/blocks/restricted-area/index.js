!function(){"use strict";var e=window.wp.i18n,t=window.wp.blocks,a=window.wp.blockEditor,l=window.wp.components,c="function"==typeof a.useInnerBlocksProps?a.useInnerBlocksProps:a.__experimentalUseInnerBlocksProps,n=JSON.parse('{"u2":"loos/restricted-area"}'),r=React.createElement("svg",{viewBox:"0 0 56 56"},React.createElement("g",null,React.createElement("polygon",{points:"50.1,50.1 47.1,50.1 47.1,53 53,53 53,47.1 50.1,47.1 \t"}),React.createElement("rect",{x:"15.7",y:"50.1",width:"8.8",height:"2.9"}),React.createElement("rect",{x:"31.4",y:"50.1",width:"8.8",height:"2.9"}),React.createElement("polygon",{points:"5.9,47.1 3,47.1 3,53 8.9,53 8.9,50.1 5.9,50.1 \t"}),React.createElement("rect",{x:"3",y:"31.4",width:"2.9",height:"8.8"}),React.createElement("rect",{x:"3",y:"15.7",width:"2.9",height:"8.8"}),React.createElement("polygon",{points:"3,8.9 5.9,8.9 5.9,5.9 8.9,5.9 8.9,3 3,3 \t"}),React.createElement("rect",{x:"15.7",y:"3",width:"8.8",height:"2.9"}),React.createElement("rect",{x:"31.4",y:"3",width:"8.8",height:"2.9"}),React.createElement("polygon",{points:"47.1,3 47.1,5.9 50.1,5.9 50.1,8.9 53,8.9 53,3 \t"}),React.createElement("rect",{x:"50.1",y:"15.7",width:"2.9",height:"8.8"}),React.createElement("rect",{x:"50.1",y:"31.4",width:"2.9",height:"8.8"})),React.createElement("rect",{x:"14",y:"20.5",width:"28",height:"3"}),React.createElement("rect",{x:"14",y:"32.5",width:"28",height:"3"}),React.createElement("path",{d:"M20.2,25.5h-1.4c-0.6,0-1-0.4-1-1.1v-4.8c0-0.7,0.4-1.1,1-1.1h1.4c0.6,0,1,0.4,1,1.1v4.8C21.2,25.1,20.8,25.5,20.2,25.5z"}),React.createElement("path",{d:"M37.2,37.5h-1.4c-0.6,0-1-0.4-1-1.1v-4.8c0-0.7,0.4-1.1,1-1.1h1.4c0.6,0,1,0.4,1,1.1v4.8C38.2,37.1,37.8,37.5,37.2,37.5z"})),s=window.wp.date,o=window.wp.element,m=window.wp.primitives,i=(0,o.createElement)(m.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,o.createElement)(m.Path,{d:"M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm.5 16c0 .3-.2.5-.5.5H5c-.3 0-.5-.2-.5-.5V7h15v12zM9 10H7v2h2v-2zm0 4H7v2h2v-2zm4-4h-2v2h2v-2zm4 0h-2v2h2v-2zm-4 4h-2v2h2v-2zm4 0h-2v2h2v-2z"})),u=(0,o.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,o.createElement)(m.Path,{d:"M7 13.8h6v-1.5H7v1.5zM18 16V4c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2zM5.5 16V4c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v12c0 .3-.2.5-.5.5H6c-.3 0-.5-.2-.5-.5zM7 10.5h8V9H7v1.5zm0-3.3h8V5.8H7v1.4zM20.2 6v13c0 .7-.6 1.2-1.2 1.2H8v1.5h11c1.5 0 2.7-1.2 2.7-2.8V6h-1.5z"})),p=(0,o.createElement)(m.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,o.createElement)(m.Path,{d:"M19 6.2h-5.9l-.6-1.1c-.3-.7-1-1.1-1.8-1.1H5c-1.1 0-2 .9-2 2v11.8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8.2c0-1.1-.9-2-2-2zm.5 11.6c0 .3-.2.5-.5.5H5c-.3 0-.5-.2-.5-.5V6c0-.3.2-.5.5-.5h5.8c.2 0 .4.1.4.3l1 2H19c.3 0 .5.2.5.5v9.5z"})),R="undefined"!=typeof GetSettings?s.getSettings:s.__experimentalGetSettings,g=window.wp.data,h=function(e){let{icon:t,size:a=24,...l}=e;return(0,o.cloneElement)(t,{width:a,height:a,...l})},w=(0,o.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,o.createElement)(m.Path,{d:"M12 4.75a7.25 7.25 0 100 14.5 7.25 7.25 0 000-14.5zM3.25 12a8.75 8.75 0 1117.5 0 8.75 8.75 0 01-17.5 0zM12 8.75a1.5 1.5 0 01.167 2.99c-.465.052-.917.44-.917 1.01V14h1.5v-.845A3 3 0 109 10.25h1.5a1.5 1.5 0 011.5-1.5zM11.25 15v1.5h1.5V15h-1.5z"}));const E=(0,o.createInterpolateElement)((0,e.sprintf)((0,e.__)("Macなら%1$sキー、Windowsなら%2$sキーを押しながらクリックすると複数選択できます。","swell"),"<code>command</code>","<code>ctrl</code>"),{code:React.createElement("code",null)});var _=({type:t="",label:a="",text:l="",tag:c="div"})=>{let n="",r="";"multiple-select"===t?(n=(0,e.__)("複数選択できます","swell"),r=E):(n=a,r=l);const s=c;return React.createElement(s,{className:"swl-helpPopover"},n&&React.createElement("span",{className:"swl-helpPopover__label"},n),React.createElement(h,{icon:w,size:"20",className:"swl-helpPopover__icon"}),React.createElement("span",{className:"swl-helpPopover__desc"},r))},d=(0,o.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,o.createElement)(m.Path,{d:"M20.1 11.2l-6.7-6.7c-.1-.1-.3-.2-.5-.2H5c-.4-.1-.8.3-.8.7v7.8c0 .2.1.4.2.5l6.7 6.7c.2.2.5.4.7.5s.6.2.9.2c.3 0 .6-.1.9-.2.3-.1.5-.3.8-.5l5.6-5.6c.4-.4.7-1 .7-1.6.1-.6-.2-1.2-.6-1.6zM19 13.4L13.4 19c-.1.1-.2.1-.3.2-.2.1-.4.1-.6 0-.1 0-.2-.1-.3-.2l-6.5-6.5V5.8h6.8l6.5 6.5c.2.2.2.4.2.6 0 .1 0 .3-.2.5zM9 8c-.6 0-1 .4-1 1s.4 1 1 1 1-.4 1-1-.4-1-1-1z"})),v=(0,o.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,o.createElement)(m.Path,{fillRule:"evenodd",d:"M5 5.5h14a.5.5 0 01.5.5v1.5a.5.5 0 01-.5.5H5a.5.5 0 01-.5-.5V6a.5.5 0 01.5-.5zM4 9.232A2 2 0 013 7.5V6a2 2 0 012-2h14a2 2 0 012 2v1.5a2 2 0 01-1 1.732V18a2 2 0 01-2 2H6a2 2 0 01-2-2V9.232zm1.5.268V18a.5.5 0 00.5.5h12a.5.5 0 00.5-.5V9.5h-13z",clipRule:"evenodd"}));function b(e){if(!e)return[];const t=e.map((e=>({children:[],parent:null,...e}))),a=t.reduce(((e,t)=>(e[t.parent]||(e[t.parent]=[]),e[t.parent].push(t),e)),{});if(a.null&&a.null.length)return t;const l=e=>e.map((e=>{const t=a[e.id]||[];return{...e,children:t.length?l(t):[]}}));return l(a[0]||[])}const y=({ids:t,relation:a,attr:c,setOptions:n,forArchive:r=!1})=>{const s=!r&&1<t.length;return(0,o.useEffect)((()=>{s||"AND"!==a||n({[c]:"IN"})}),[s,a]),React.createElement(React.Fragment,null,React.createElement(l.ButtonGroup,{className:"swl-btns--logicalRelation"},s?React.createElement(React.Fragment,null,React.createElement(l.Button,{text:React.createElement(React.Fragment,null,"IN",React.createElement("span",null,(0,e.__)("一つでも該当する","swell"))),isPrimary:"IN"===a,onClick:()=>{n({[c]:"IN"})}}),React.createElement(l.Button,{text:React.createElement(React.Fragment,null,"AND",React.createElement("span",null,(0,e.__)("全てに該当する","swell"))),isPrimary:"AND"===a,onClick:()=>{n({[c]:"AND"})}}),React.createElement(l.Button,{text:React.createElement(React.Fragment,null,"NOT IN",React.createElement("span",null,(0,e.__)("該当しない","swell"))),isPrimary:"NOT IN"===a,onClick:()=>{n({[c]:"NOT IN"})}})):React.createElement(React.Fragment,null,React.createElement(l.Button,{text:React.createElement(React.Fragment,null,"IN",React.createElement("span",null,(0,e.__)("該当する","swell"))),isPrimary:"NOT IN"!==a,onClick:()=>{n({[c]:"IN"})}}),React.createElement(l.Button,{text:React.createElement(React.Fragment,null,"NOT IN",React.createElement("span",null,(0,e.__)("該当しない","swell"))),isPrimary:"NOT IN"===a,onClick:()=>{n({[c]:"NOT IN"})}}))))};var C=({setOptions:t,attrs:a,type:c=""})=>{const{catID:n,tagID:r,taxName:s,termID:o,catRelation:m,tagRelation:i,termRelation:u,queryRelation:R,exCatChildren:w}=a,E="archive"===c,C=(0,g.useSelect)((e=>{const t=e("core").getTaxonomies({per_page:-1,context:"view"}),a=[];if(null!==t)for(const e of t)-1===["category","post_tag","nav_menu","wp_pattern_category","parts_use"].indexOf(e.slug)&&a.push({label:e.name,value:e.slug});return a}),[])||[],x=(0,g.useSelect)((e=>e("core").getEntityRecords("taxonomy","category",{per_page:-1}))),N=(0,g.useSelect)((e=>e("core").getEntityRecords("taxonomy","post_tag",{per_page:-1}))),k=(0,g.useSelect)((e=>e("core").getEntityRecords("taxonomy",s,{per_page:-1})),[s]);let B="category";!n&&r&&(B="tag"),n||r||!o||(B="taxonomy");const T=n.split(","),P=r.split(","),I=o.split(","),f=React.createElement(React.Fragment,null,React.createElement(l.TreeSelect,{className:"swl-tree-select -category",noOptionLabel:"----",onChange:e=>{const a=e.join(",");t({catID:a.replace(/^,/,"")})},selectedId:T,tree:b(x),multiple:!0}),React.createElement(_,{type:"multiple-select"}),"query"===c&&React.createElement(l.CheckboxControl,{className:"__exCatChildren",label:(0,e.__)("子カテゴリのみの記事を除外","swell"),checked:w,onChange:e=>{t({exCatChildren:e})}}),React.createElement("div",{"data-swl-disable":!n||null},React.createElement(l.BaseControl,{className:"__termRelation"},React.createElement(l.BaseControl.VisualLabel,null,(0,e.__)("選択したタームの論理関係","swell")),React.createElement(y,{ids:T,attr:"catRelation",relation:m,setOptions:t,forArchive:E})))),z=React.createElement(React.Fragment,null,React.createElement(l.TreeSelect,{className:"swl-tree-select -tag",noOptionLabel:"----",onChange:e=>{const a=e.join(",");t({tagID:a.replace(/^,/,"")})},selectedId:P,tree:b(N),multiple:!0}),React.createElement(_,{type:"multiple-select"}),React.createElement("div",{"data-swl-disable":!r||null},React.createElement(l.BaseControl,{className:"__termRelation"},React.createElement(l.BaseControl.VisualLabel,null,(0,e.__)("選択したタームの論理関係","swell")),React.createElement(y,{ids:P,attr:"tagRelation",relation:i,setOptions:t,forArchive:E})))),V=0<C.length?React.createElement(React.Fragment,null,React.createElement(l.SelectControl,{label:"タクソノミーを選択",value:s,options:[{label:"---",value:""},...C],onChange:e=>{t({taxName:e})}}),s&&React.createElement(React.Fragment,null,React.createElement(l.TreeSelect,{label:(0,e.__)("ターム","swell"),className:"swl-tree-select -term",noOptionLabel:"----",onChange:e=>{const a=e.join(",");t({termID:a.replace(/^,/,"")})},selectedId:I,tree:b(k),multiple:!0}),React.createElement(_,{type:"multiple-select"}),React.createElement("div",{"data-swl-disable":!o||null},React.createElement(l.BaseControl,{className:"__termRelation"},React.createElement(l.BaseControl.VisualLabel,null,(0,e.__)("選択したタームの論理関係","swell")),React.createElement(y,{ids:I,attr:"termRelation",relation:u,setOptions:t,forArchive:E}))))):React.createElement("p",null,(0,e.__)("選択可能なタクソノミーがありません。","swell"));return React.createElement(React.Fragment,null,React.createElement(l.TabPanel,{className:"swl-tabPanel -terms",activeClass:"is-active",tabs:[{name:"category",title:React.createElement(React.Fragment,null,React.createElement(h,{icon:p}),React.createElement("span",null,(0,e.__)("カテゴリー","swell"))),className:"swl-tabPanel__menu--v -category"},{name:"tag",title:React.createElement(React.Fragment,null,React.createElement(h,{icon:d}),React.createElement("span",null,(0,e.__)("タグ","swell"))),className:"swl-tabPanel__menu--v -tag"},{name:"taxonomy",title:React.createElement(React.Fragment,null,React.createElement(h,{icon:v}),React.createElement("span",null,(0,e.__)("タクソノミー","swell"))),className:"swl-tabPanel__menu--v -taxonomy"}],initialTabName:B},(e=>"category"===e.name?f:"tag"===e.name?z:"taxonomy"===e.name?V:void 0)),React.createElement("hr",{style:{borderBottomStyle:"dashed"}}),React.createElement("div",{"data-swl-disable":E||null},React.createElement(l.SelectControl,{label:(0,e.__)("各タクソノミー条件の関係","swell"),value:R,options:[{label:(0,e.__)("どれか1つでも条件に合うかどうか","swell"),value:"OR"},{label:(0,e.__)("全ての条件に合うかどうか","swell"),value:"AND"}],onChange:e=>{t({queryRelation:e})},help:E?(0,e.__)("個別ページでの判定時のみ有効です","swell"):null})))};const x=[{label:(0,e.__)("非ログインユーザー","swell"),value:"noLoggedIn"},{label:(0,e.__)("ログインユーザー","swell"),value:"loggedIn"}],N=[{label:(0,e.__)("管理者","swell"),value:"administrator"},{label:(0,e.__)("編集者","swell"),value:"editor"},{label:(0,e.__)("投稿者","swell"),value:"author"},{label:(0,e.__)("寄稿者","swell"),value:"contributor"},{label:(0,e.__)("購読者","swell"),value:"subscriber"}],k=[{label:(0,e._x)("フロントページ","page-type","swell"),value:"front"},{label:(0,e._x)("ホーム（投稿一覧）","page-type","swell"),value:"home"},{label:(0,e._x)("アーカイブ","page-type","swell"),value:"archive"},{label:(0,e._x)("検索結果ページ","page-type","swell"),value:"search"},{label:(0,e._x)("404ページ","page-type","swell"),value:"404"},{label:(0,e._x)("個別ページ","page-type","swell"),value:"singular"}];var B=({attributes:t,setAttributes:a})=>{const{roles:c,isRole:n,isLoggedIn:r,isDateTime:m,startDateTime:h,endDateTime:w,isPage:E,pageLimitType:d,pageTypes:v,allowedPostTypes:b,terms:y}=t,[B,T]=(0,o.useState)(!1),[P,I]=(0,o.useState)(!1),f=R(),z=/a(?!\\)/i.test(f.formats.time.toLowerCase().replace(/\\\\/g,"").split("").reverse().join("")),V=h?(0,s.dateI18n)(`${f.formats.date} ${f.formats.time}`,h):(0,e.__)("未設定","swell"),S=w?(0,s.dateI18n)(`${f.formats.date} ${f.formats.time}`,w):(0,e.__)("未設定","swell"),F=((e={})=>{const t=e.ignoreTypes||["attachment"];return(0,g.useSelect)((e=>{const a=e("core").getPostTypes({per_page:-1});if(null===a)return[];const l=[];for(const e of a)e.viewable&&-1===t.indexOf(e.slug)&&l.push({label:e.name,value:e.slug});return l}),[])})()||[],D=(0,o.useCallback)((e=>{a({terms:{...y,...e}})}),[a,y]);return React.createElement(React.Fragment,null,React.createElement(l.PanelBody,{title:(0,e.__)("制限設定","swell"),initialOpen:!0},React.createElement(l.ToggleControl,{label:(0,e.__)("ログイン状態で制限する","swell"),checked:n,onChange:e=>{a({isRole:e})}}),n&&React.createElement(React.Fragment,null,React.createElement(l.RadioControl,{label:(0,e.__)("コンテンツを閲覧できるユーザー","swell"),selected:r?"loggedIn":"noLoggedIn",options:x,onChange:e=>{a({isLoggedIn:"loggedIn"===e})}}),r&&React.createElement(l.BaseControl,{className:"swl-checkboxGroup"},N.map((e=>React.createElement(l.CheckboxControl,{label:e.label,key:`key_${e.value}`,checked:c[e.value],onChange:t=>{a({roles:{...c,[e.value]:t}})}}))))),React.createElement("hr",null),React.createElement(l.ToggleControl,{label:(0,e.__)("表示期間を制限する","swell"),checked:m,onChange:e=>{a({isDateTime:e})}}),m&&React.createElement(React.Fragment,null,React.createElement(l.BaseControl,{className:"swl-dateTimePicker"},React.createElement(l.BaseControl.VisualLabel,null,(0,e.__)("開始","swell")),React.createElement(l.Button,{icon:i,isTertiary:!0,onClick:()=>{T(!0)}},V),B&&React.createElement(l.Popover,{className:"swl-pop--datetime",onClose:()=>{T(!1)}},React.createElement(l.DateTimePicker,{__nextRemoveResetButton:!0,__nextRemoveHelpButton:!0,currentDate:h,is12Hour:z,onChange:e=>{a({startDateTime:e}),e||T(!1)}}))),React.createElement("div",{className:"swl-dash"},(0,e.__)("〜","swell")),React.createElement(l.BaseControl,{className:"swl-dateTimePicker"},React.createElement(l.BaseControl.VisualLabel,null,(0,e.__)("終了","swell")),React.createElement(l.Button,{icon:i,isTertiary:!0,onClick:()=>{I(!0)}},S),P&&React.createElement(l.Popover,{className:"swl-pop--datetime",onClose:()=>{I(!1)}},React.createElement(l.DateTimePicker,{__nextRemoveResetButton:!0,__nextRemoveHelpButton:!0,currentDate:w,is12Hour:z,onChange:e=>{a({endDateTime:e}),e||I(!1)}})))),React.createElement("hr",null),React.createElement(l.ToggleControl,{label:(0,e.__)("ページで制限する","swell"),checked:E,onChange:e=>{a({isPage:e})}}),E&&React.createElement(React.Fragment,null,React.createElement(l.BaseControl,{className:"swl-checkboxGroup"},React.createElement(l.BaseControl.VisualLabel,null,(0,e.__)("制限方法","swell")),React.createElement(l.ButtonGroup,{className:"swl-btns--limtPageType"},React.createElement(l.Button,{text:(0,e.__)("ページ種別","swell"),icon:u,isPrimary:"page_type"===d,onClick:()=>{"page_type"!==d&&a({pageLimitType:"page_type"})}}),React.createElement(l.Button,{text:(0,e.__)("ターム","swell"),icon:p,isPrimary:"terms"===d,onClick:()=>{"terms"!==d&&a({pageLimitType:"terms"})}}))),"page_type"===d&&React.createElement(React.Fragment,null,React.createElement(l.BaseControl,{className:"swl-checkboxGroup"},k.map((e=>React.createElement(l.CheckboxControl,{label:e.label,key:`key_${e.value}`,checked:v[e.value],onChange:t=>{a({pageTypes:{...v,[e.value]:t}})}})))),React.createElement("div",{"data-swl-disable":!v.singular||null,style:{marginTop:"-8px"}},React.createElement(l.SelectControl,{label:(0,e.__)("個別ページの種類","swell"),value:b.split(","),options:[{label:(0,e.__)("全ての投稿タイプ","swell"),value:""},...F],multiple:!0,onChange:e=>{const t=e.join(",");a({allowedPostTypes:t.replace(/^,/,"")})}}),React.createElement(_,{type:"multiple-select"}))),"terms"===d&&React.createElement(React.Fragment,null,React.createElement(l.BaseControl,{className:"swl-checkboxGroup"},React.createElement(l.CheckboxControl,{label:React.createElement(React.Fragment,null,(0,e.__)("アーカイブページを対象にする","swell")),checked:y.isArchive,onChange:e=>{D({isArchive:e})},className:"has-helptip",help:React.createElement(_,{tag:"span",text:(0,e.__)("指定した条件に合致するタームアーカイブページでコンテンツを表示します。","swell")})}),React.createElement(l.CheckboxControl,{label:(0,e.__)("個別ページを対象にする","swell"),checked:y.isSingular,onChange:e=>{D({isSingular:e})},className:"has-helptip",help:React.createElement(_,{tag:"span",text:(0,e.__)("指定した条件に合致するタームを持つ個別ページでコンテンツを表示します。","swell")})})),React.createElement("div",{"data-swl-disable":!y.isArchive&&!y.isSingular||null},React.createElement("hr",{style:{borderBottomStyle:"dashed"}}),React.createElement(C,{attrs:y,setOptions:D,type:y.isArchive?"archive":""}))))))};const T=[["core/paragraph"]];(0,t.registerBlockType)(n.u2,{title:(0,e.__)("制限エリア","swell"),icon:r,edit:({attributes:e,setAttributes:t})=>{const n=(0,a.useBlockProps)({className:"swell-block-restrictedArea swl-inner-blocks"}),s=c(n,{template:T,templateLock:!1}),{children:o,...m}=s;return React.createElement(React.Fragment,null,React.createElement(a.InspectorControls,null,React.createElement(B,{attributes:e,setAttributes:t})),React.createElement("div",m,React.createElement("div",{className:"swl-parentSelector"},React.createElement(l.Icon,{icon:r})),o))},save:()=>React.createElement(a.InnerBlocks.Content,null)})}();