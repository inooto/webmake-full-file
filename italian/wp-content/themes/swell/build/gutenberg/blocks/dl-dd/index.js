!function(){"use strict";var e=window.wp.i18n,t=window.wp.blocks,s=window.wp.blockEditor,c="function"==typeof s.useInnerBlocksProps?s.useInnerBlocksProps:s.__experimentalUseInnerBlocksProps,l=[{attributes:{dtWidth:{type:"number"}},supports:{reusable:!1,className:!1},save:({attributes:e})=>{const t=(e=>{const t={};return e&&(t.width=`calc(100% - ${e+2.5}em)`),t})(e.dtWidth),c=s.useBlockProps.save({className:"swell-block-dl__dd",style:t||null});return React.createElement("dd",c,React.createElement(s.InnerBlocks.Content,null))}}];const n=[["core/paragraph"]],r="swell-block-dl";(0,t.registerBlockType)("loos/dd",{title:(0,e.__)("項目の説明(DD)","swell"),icon:React.createElement("svg",{viewBox:"0 0 56 56"},React.createElement("path",{d:"M47.5,24.5v7h-32v-7H47.5 M49,22H14c-0.6,0-1,0.4-1,1v10c0,0.6,0.4,1,1,1h35c0.6,0,1-0.4,1-1V23C50,22.4,49.6,22,49,22 L49,22z"})),edit:()=>{const e=(0,s.useBlockProps)({className:`${r}__dd swl-inner-blocks swl-has-margin--s`}),t=c(e,{template:n});return React.createElement("div",t)},save:()=>{const e=s.useBlockProps.save({className:`${r}__dd`});return React.createElement("dd",e,React.createElement(s.InnerBlocks.Content,null))},deprecated:l})}();