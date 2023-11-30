/**
 * Highstock JS v11.2.0 (2023-10-30)
 *
 * Slow Stochastic series type for Highcharts Stock
 *
 * (c) 2010-2021 Pawel Fus
 *
 * License: www.highcharts.com/license
 */!function(t){"object"==typeof module&&module.exports?(t.default=t,module.exports=t):"function"==typeof define&&define.amd?define("highcharts/indicators/indicators",["highcharts","highcharts/modules/stock"],function(e){return t(e),t.Highcharts=e,t}):t("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(t){"use strict";var e=t?t._modules:{};function s(t,e,s,a){t.hasOwnProperty(e)||(t[e]=a.apply(null,s),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:e,module:t[e]}})))}s(e,"Stock/Indicators/SlowStochastic/SlowStochasticIndicator.js",[e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e){let{sma:s,stochastic:a}=t.seriesTypes,{extend:i,merge:o}=e;class n extends a{constructor(){super(...arguments),this.data=void 0,this.options=void 0,this.points=void 0}getValues(t,e){let a=e.periods,i=super.getValues.call(this,t,e),o={values:[],xData:[],yData:[]};if(!i)return;o.xData=i.xData.slice(a[1]-1);let n=i.yData.slice(a[1]-1),r=s.prototype.getValues.call(this,{xData:o.xData,yData:n},{index:1,period:a[2]});if(r){for(let t=0,e=o.xData.length;t<e;t++)o.yData[t]=[n[t][1],r.yData[t-a[2]+1]||null],o.values[t]=[o.xData[t],n[t][1],r.yData[t-a[2]+1]||null];return o}}}return n.defaultOptions=o(a.defaultOptions,{params:{periods:[14,3,3]}}),i(n.prototype,{nameBase:"Slow Stochastic"}),t.registerSeriesType("slowstochastic",n),n}),s(e,"masters/indicators/slow-stochastic.src.js",[],function(){})});//# sourceMappingURL=slow-stochastic.js.map