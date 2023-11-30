/**
 * Highstock JS v11.2.0 (2023-10-30)
 *
 * Indicator series type for Highcharts Stock
 *
 * (c) 2010-2021 Rafal Sebestjanski
 *
 * License: www.highcharts.com/license
 */!function(t){"object"==typeof module&&module.exports?(t.default=t,module.exports=t):"function"==typeof define&&define.amd?define("highcharts/indicators/dmi",["highcharts","highcharts/modules/stock"],function(e){return t(e),t.Highcharts=e,t}):t("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(t){"use strict";var e=t?t._modules:{};function i(t,e,i,s){t.hasOwnProperty(e)||(t[e]=s.apply(null,i),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:e,module:t[e]}})))}i(e,"Stock/Indicators/MultipleLinesComposition.js",[e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e){var i;let{sma:{prototype:s}}=t.seriesTypes,{defined:a,error:o,merge:n}=e;return function(t){let i=[],r=["bottomLine"],l=["top","bottom"],p=["top"];function h(t){return"plot"+t.charAt(0).toUpperCase()+t.slice(1)}function u(t,e){let i=[];return(t.pointArrayMap||[]).forEach(t=>{t!==e&&i.push(h(t))}),i}function c(){let t=this,e=t.pointValKey,i=t.linesApiNames,r=t.areaLinesNames,l=t.points,p=t.options,c=t.graph,d={options:{gapSize:p.gapSize}},f=[],m=u(t,e),y=l.length,g;if(m.forEach((t,e)=>{for(f[e]=[];y--;)g=l[y],f[e].push({x:g.x,plotX:g.plotX,plotY:g[t],isNull:!a(g[t])});y=l.length}),t.userOptions.fillColor&&r.length){let e=m.indexOf(h(r[0])),i=f[e],a=1===r.length?l:f[m.indexOf(h(r[1]))],o=t.color;t.points=a,t.nextPoints=i,t.color=t.userOptions.fillColor,t.options=n(l,d),t.graph=t.area,t.fillGraph=!0,s.drawGraph.call(t),t.area=t.graph,delete t.nextPoints,delete t.fillGraph,t.color=o}i.forEach((e,i)=>{f[i]?(t.points=f[i],p[e]?t.options=n(p[e].styles,d):o('Error: "There is no '+e+' in DOCS options declared. Check if linesApiNames are consistent with your DOCS line names."'),t.graph=t["graph"+e],s.drawGraph.call(t),t["graph"+e]=t.graph):o('Error: "'+e+" doesn't have equivalent in pointArrayMap. To many elements in linesApiNames relative to pointArrayMap.\"")}),t.points=l,t.options=p,t.graph=c,s.drawGraph.call(t)}function d(t){let e,i=[],a=[];if(t=t||this.points,this.fillGraph&&this.nextPoints){if((e=s.getGraphPath.call(this,this.nextPoints))&&e.length){e[0][0]="L",i=s.getGraphPath.call(this,t),a=e.slice(0,i.length);for(let t=a.length-1;t>=0;t--)i.push(a[t])}}else i=s.getGraphPath.apply(this,arguments);return i}function f(t){let e=[];return(this.pointArrayMap||[]).forEach(i=>{e.push(t[i])}),e}function m(){let t=this.pointArrayMap,e=[],i;e=u(this),s.translate.apply(this,arguments),this.points.forEach(s=>{t.forEach((t,a)=>{i=s[t],this.dataModify&&(i=this.dataModify.modifyValue(i)),null!==i&&(s[e[a]]=this.yAxis.toPixels(i,!0))})})}t.compose=function(t){if(e.pushUnique(i,t)){let e=t.prototype;e.linesApiNames=e.linesApiNames||r.slice(),e.pointArrayMap=e.pointArrayMap||l.slice(),e.pointValKey=e.pointValKey||"top",e.areaLinesNames=e.areaLinesNames||p.slice(),e.drawGraph=c,e.getGraphPath=d,e.toYData=f,e.translate=m}return t}}(i||(i={})),i}),i(e,"Stock/Indicators/DMI/DMIIndicator.js",[e["Stock/Indicators/MultipleLinesComposition.js"],e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e,i){let{sma:s}=e.seriesTypes,{correctFloat:a,extend:o,isArray:n,merge:r}=i;class l extends s{constructor(){super(...arguments),this.options=void 0}calculateDM(t,e,i){let s=t[e][1],o=t[e][2],n=t[e-1][1],r=t[e-1][2];return a(s-n>r-o?i?Math.max(s-n,0):0:i?0:Math.max(r-o,0))}calculateDI(t,e){return t/e*100}calculateDX(t,e){return a(Math.abs(t-e)/Math.abs(t+e)*100)}smoothValues(t,e,i){return a(t-t/i+e)}getTR(t,e){return a(Math.max(t[1]-t[2],e?Math.abs(t[1]-e[3]):0,e?Math.abs(t[2]-e[3]):0))}getValues(t,e){let i=e.period,s=t.xData,a=t.yData,o=a?a.length:0,r=[],l=[],p=[];if(s.length<=i||!n(a[0])||4!==a[0].length)return;let h=0,u=0,c=0,d;for(d=1;d<o;d++){let t,e,o,n,f,m,y,g,D;d<=i?(n=this.calculateDM(a,d,!0),f=this.calculateDM(a,d),m=this.getTR(a[d],a[d-1]),h+=n,u+=f,c+=m,d===i&&(y=this.calculateDI(h,c),g=this.calculateDI(u,c),D=this.calculateDX(h,u),r.push([s[d],D,y,g]),l.push(s[d]),p.push([D,y,g]))):(n=this.calculateDM(a,d,!0),f=this.calculateDM(a,d),m=this.getTR(a[d],a[d-1]),t=this.smoothValues(h,n,i),e=this.smoothValues(u,f,i),o=this.smoothValues(c,m,i),h=t,u=e,c=o,y=this.calculateDI(h,c),g=this.calculateDI(u,c),D=this.calculateDX(h,u),r.push([s[d],D,y,g]),l.push(s[d]),p.push([D,y,g]))}return{values:r,xData:l,yData:p}}}return l.defaultOptions=r(s.defaultOptions,{params:{index:void 0},marker:{enabled:!1},tooltip:{pointFormat:'<span style="color: {point.color}">●</span><b> {series.name}</b><br/><span style="color: {point.color}">DX</span>: {point.y}<br/><span style="color: {point.series.options.plusDILine.styles.lineColor}">+DI</span>: {point.plusDI}<br/><span style="color: {point.series.options.minusDILine.styles.lineColor}">-DI</span>: {point.minusDI}<br/>'},plusDILine:{styles:{lineWidth:1,lineColor:"#06b535"}},minusDILine:{styles:{lineWidth:1,lineColor:"#f21313"}},dataGrouping:{approximation:"averages"}}),o(l.prototype,{areaLinesNames:[],nameBase:"DMI",linesApiNames:["plusDILine","minusDILine"],pointArrayMap:["y","plusDI","minusDI"],parallelArrays:["x","y","plusDI","minusDI"],pointValKey:"y"}),t.compose(l),e.registerSeriesType("dmi",l),l}),i(e,"masters/indicators/dmi.src.js",[],function(){})});//# sourceMappingURL=dmi.js.map