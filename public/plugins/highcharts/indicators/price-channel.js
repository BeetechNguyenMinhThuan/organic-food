/**
 * Highstock JS v11.2.0 (2023-10-30)
 *
 * Indicator series type for Highcharts Stock
 *
 * (c) 2010-2021 Daniel Studencki
 *
 * License: www.highcharts.com/license
 */!function(t){"object"==typeof module&&module.exports?(t.default=t,module.exports=t):"function"==typeof define&&define.amd?define("highcharts/indicators/price-channel",["highcharts","highcharts/modules/stock"],function(e){return t(e),t.Highcharts=e,t}):t("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(t){"use strict";var e=t?t._modules:{};function i(t,e,i,o){t.hasOwnProperty(e)||(t[e]=o.apply(null,i),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:e,module:t[e]}})))}i(e,"Stock/Indicators/ArrayUtilities.js",[],function(){return{getArrayExtremes:function(t,e,i){return t.reduce((t,o)=>[Math.min(t[0],o[e]),Math.max(t[1],o[i])],[Number.MAX_VALUE,-Number.MAX_VALUE])}}}),i(e,"Stock/Indicators/MultipleLinesComposition.js",[e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e){var i;let{sma:{prototype:o}}=t.seriesTypes,{defined:s,error:n,merge:r}=e;return function(t){let i=[],a=["bottomLine"],l=["top","bottom"],p=["top"];function h(t){return"plot"+t.charAt(0).toUpperCase()+t.slice(1)}function c(t,e){let i=[];return(t.pointArrayMap||[]).forEach(t=>{t!==e&&i.push(h(t))}),i}function u(){let t=this,e=t.pointValKey,i=t.linesApiNames,a=t.areaLinesNames,l=t.points,p=t.options,u=t.graph,d={options:{gapSize:p.gapSize}},f=[],m=c(t,e),y=l.length,g;if(m.forEach((t,e)=>{for(f[e]=[];y--;)g=l[y],f[e].push({x:g.x,plotX:g.plotX,plotY:g[t],isNull:!s(g[t])});y=l.length}),t.userOptions.fillColor&&a.length){let e=m.indexOf(h(a[0])),i=f[e],s=1===a.length?l:f[m.indexOf(h(a[1]))],n=t.color;t.points=s,t.nextPoints=i,t.color=t.userOptions.fillColor,t.options=r(l,d),t.graph=t.area,t.fillGraph=!0,o.drawGraph.call(t),t.area=t.graph,delete t.nextPoints,delete t.fillGraph,t.color=n}i.forEach((e,i)=>{f[i]?(t.points=f[i],p[e]?t.options=r(p[e].styles,d):n('Error: "There is no '+e+' in DOCS options declared. Check if linesApiNames are consistent with your DOCS line names."'),t.graph=t["graph"+e],o.drawGraph.call(t),t["graph"+e]=t.graph):n('Error: "'+e+" doesn't have equivalent in pointArrayMap. To many elements in linesApiNames relative to pointArrayMap.\"")}),t.points=l,t.options=p,t.graph=u,o.drawGraph.call(t)}function d(t){let e,i=[],s=[];if(t=t||this.points,this.fillGraph&&this.nextPoints){if((e=o.getGraphPath.call(this,this.nextPoints))&&e.length){e[0][0]="L",i=o.getGraphPath.call(this,t),s=e.slice(0,i.length);for(let t=s.length-1;t>=0;t--)i.push(s[t])}}else i=o.getGraphPath.apply(this,arguments);return i}function f(t){let e=[];return(this.pointArrayMap||[]).forEach(i=>{e.push(t[i])}),e}function m(){let t=this.pointArrayMap,e=[],i;e=c(this),o.translate.apply(this,arguments),this.points.forEach(o=>{t.forEach((t,s)=>{i=o[t],this.dataModify&&(i=this.dataModify.modifyValue(i)),null!==i&&(o[e[s]]=this.yAxis.toPixels(i,!0))})})}t.compose=function(t){if(e.pushUnique(i,t)){let e=t.prototype;e.linesApiNames=e.linesApiNames||a.slice(),e.pointArrayMap=e.pointArrayMap||l.slice(),e.pointValKey=e.pointValKey||"top",e.areaLinesNames=e.areaLinesNames||p.slice(),e.drawGraph=u,e.getGraphPath=d,e.toYData=f,e.translate=m}return t}}(i||(i={})),i}),i(e,"Stock/Indicators/PC/PCIndicator.js",[e["Stock/Indicators/ArrayUtilities.js"],e["Stock/Indicators/MultipleLinesComposition.js"],e["Core/Color/Palettes.js"],e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e,i,o,s){let{sma:n}=o.seriesTypes,{merge:r,extend:a}=s;class l extends n{constructor(){super(...arguments),this.data=void 0,this.options=void 0,this.points=void 0}getValues(e,i){let o,s,n,r,a,l,p;let h=i.period,c=e.xData,u=e.yData,d=u?u.length:0,f=[],m=[],y=[];if(!(d<h)){for(p=h;p<=d;p++)r=c[p-1],a=u.slice(p-h,p),o=((s=(l=t.getArrayExtremes(a,2,1))[1])+(n=l[0]))/2,f.push([r,s,o,n]),m.push(r),y.push([s,o,n]);return{values:f,xData:m,yData:y}}}}return l.defaultOptions=r(n.defaultOptions,{params:{index:void 0,period:20},lineWidth:1,topLine:{styles:{lineColor:i.colors[2],lineWidth:1}},bottomLine:{styles:{lineColor:i.colors[8],lineWidth:1}},dataGrouping:{approximation:"averages"}}),a(l.prototype,{areaLinesNames:["top","bottom"],nameBase:"Price Channel",nameComponents:["period"],linesApiNames:["topLine","bottomLine"],pointArrayMap:["top","middle","bottom"],pointValKey:"middle"}),e.compose(l),o.registerSeriesType("pc",l),l}),i(e,"masters/indicators/price-channel.src.js",[],function(){})});//# sourceMappingURL=price-channel.js.map