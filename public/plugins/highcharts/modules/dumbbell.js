/**
 * Highcharts JS v11.2.0 (2023-10-30)
 *
 * (c) 2009-2021 Sebastian Bochan, Rafal Sebestjanski
 *
 * License: www.highcharts.com/license
 */!function(t){"object"==typeof module&&module.exports?(t.default=t,module.exports=t):"function"==typeof define&&define.amd?define("highcharts/modules/dumbbell",["highcharts"],function(o){return t(o),t.Highcharts=o,t}):t("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(t){"use strict";var o=t?t._modules:{};function e(t,o,e,i){t.hasOwnProperty(o)||(t[o]=i.apply(null,e),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:o,module:t[o]}})))}e(o,"Series/AreaRange/AreaRangePoint.js",[o["Core/Series/SeriesRegistry.js"],o["Core/Utilities.js"]],function(t,o){let{area:{prototype:{pointClass:e,pointClass:{prototype:i}}}}=t.seriesTypes,{defined:s,isNumber:r,merge:l}=o;return class extends e{constructor(){super(...arguments),this.high=void 0,this.low=void 0,this.options=void 0,this.plotX=void 0,this.series=void 0}setState(){let t=this.state,o=this.series,e=o.chart.polar;o.options.marker,o.symbol,s(this.plotHigh)||(this.plotHigh=o.yAxis.toPixels(this.high,!0)),s(this.plotLow)||(this.plotLow=this.plotY=o.yAxis.toPixels(this.low,!0)),o.lowerStateMarkerGraphic=o.stateMarkerGraphic,o.stateMarkerGraphic=o.upperStateMarkerGraphic,this.graphic=this.graphics&&this.graphics[1],this.plotY=this.plotHigh,e&&r(this.plotHighX)&&(this.plotX=this.plotHighX),i.setState.apply(this,arguments),this.state=t,this.plotY=this.plotLow,this.graphic=this.graphics&&this.graphics[0],e&&r(this.plotLowX)&&(this.plotX=this.plotLowX),o.upperStateMarkerGraphic=o.stateMarkerGraphic,o.stateMarkerGraphic=o.lowerStateMarkerGraphic,o.lowerStateMarkerGraphic=void 0;let l=o.modifyMarkerSettings();i.setState.apply(this,arguments),o.restoreMarkerSettings(l)}haloPath(){let t=this.series.chart.polar,o=[];return this.plotY=this.plotLow,t&&r(this.plotLowX)&&(this.plotX=this.plotLowX),this.isInside&&(o=i.haloPath.apply(this,arguments)),this.plotY=this.plotHigh,t&&r(this.plotHighX)&&(this.plotX=this.plotHighX),this.isTopInside&&(o=o.concat(i.haloPath.apply(this,arguments))),o}isValid(){return r(this.low)&&r(this.high)}}}),e(o,"Series/Dumbbell/DumbbellPoint.js",[o["Series/AreaRange/AreaRangePoint.js"],o["Core/Utilities.js"]],function(t,o){let{extend:e,pick:i}=o;class s extends t{constructor(){super(...arguments),this.series=void 0,this.options=void 0,this.pointWidth=void 0}setState(){let t=this.series,o=t.chart,s=t.options.lowColor,r=t.options.marker,l=t.options.lowMarker,h=this.options,n=h.lowColor,a=this.zone&&this.zone.color,p=i(n,l?.fillColor,s,h.color,a,this.color,t.color),c="attr",d,u;if(this.pointSetState.apply(this,arguments),!this.state){c="animate";let[t,s]=this.graphics||[];t&&!o.styledMode&&(t.attr({fill:p}),s&&(u={y:this.y,zone:this.zone},this.y=this.high,this.zone=this.zone?this.getZone():void 0,d=i(this.marker?this.marker.fillColor:void 0,r?r.fillColor:void 0,h.color,this.zone?this.zone.color:void 0,this.color),s.attr({fill:d}),e(this,u)))}this.connector?.[c](t.getConnectorAttribs(this))}destroy(){return this.graphic||(this.graphic=this.connector,this.connector=void 0),super.destroy()}}return e(s.prototype,{pointSetState:t.prototype.setState}),s}),e(o,"Series/Dumbbell/DumbbellSeriesDefaults.js",[],function(){return{trackByArea:!1,fillColor:"none",lineWidth:0,pointRange:1,connectorWidth:1,stickyTracking:!1,groupPadding:.2,crisp:!1,pointPadding:.1,lowColor:"#333333",states:{hover:{lineWidthPlus:0,connectorWidthPlus:1,halo:!1}}}}),e(o,"Series/Dumbbell/DumbbellSeries.js",[o["Series/Dumbbell/DumbbellPoint.js"],o["Series/Dumbbell/DumbbellSeriesDefaults.js"],o["Core/Globals.js"],o["Core/Series/SeriesRegistry.js"],o["Core/Renderer/SVG/SVGRenderer.js"],o["Core/Utilities.js"]],function(t,o,e,i,s,r){let{noop:l}=e,{arearange:h,column:n,columnrange:a}=i.seriesTypes,{extend:p,merge:c,pick:d}=r;class u extends h{constructor(){super(...arguments),this.data=void 0,this.options=void 0,this.points=void 0,this.columnMetrics=void 0}getConnectorAttribs(t){let o=this.chart,e=t.options,i=this.options,r=this.xAxis,l=this.yAxis,h=d(i.states&&i.states.hover&&i.states.hover.connectorWidthPlus,1),n=d(e.dashStyle,i.dashStyle),a=l.toPixels(i.threshold||0,!0),c=o.inverted?l.len-a:a,u=d(e.connectorWidth,i.connectorWidth),g=d(e.connectorColor,i.connectorColor,e.color,t.zone?t.zone.color:void 0,t.color),y=d(t.plotLow,t.plotY),m=d(t.plotHigh,c),f;if("number"!=typeof y)return{};t.state&&(u+=h),y<0?y=0:y>=l.len&&(y=l.len),m<0?m=0:m>=l.len&&(m=l.len),(t.plotX<0||t.plotX>r.len)&&(u=0),t.graphics&&t.graphics[1]&&(f={y:t.y,zone:t.zone},t.y=t.high,t.zone=t.zone?t.getZone():void 0,g=d(e.connectorColor,i.connectorColor,e.color,t.zone?t.zone.color:void 0,t.color),p(t,f));let C={d:s.prototype.crispLine([["M",t.plotX,y],["L",t.plotX,m]],u,"ceil")};return!o.styledMode&&(C.stroke=g,C["stroke-width"]=u,n&&(C.dashstyle=n)),C}drawConnector(t){let o=d(this.options.animationLimit,250),e=t.connector&&this.chart.pointCount<o?"animate":"attr";t.connector||(t.connector=this.chart.renderer.path().addClass("highcharts-lollipop-stem").attr({zIndex:-1}).add(this.group)),t.connector[e](this.getConnectorAttribs(t))}getColumnMetrics(){let t=n.prototype.getColumnMetrics.apply(this,arguments);return t.offset+=t.width/2,t}translate(){let t=this.chart.inverted;for(let o of(this.setShapeArgs.apply(this),this.translatePoint.apply(this,arguments),this.points)){let{pointWidth:e,shapeArgs:i={},tooltipPos:s}=o;o.plotX=i.x||0,i.x=o.plotX-e/2,s&&(t?s[1]=this.xAxis.len-o.plotX:s[0]=o.plotX)}this.columnMetrics.offset-=this.columnMetrics.width/2}drawPoints(){let t=this.chart,o=this.points.length,e=this.lowColor=this.options.lowColor,i=this.options.lowMarker,s=0,r,l,h;for(this.seriesDrawPoints.apply(this,arguments);s<o;){l=this.points[s];let[o,n]=l.graphics||[];this.drawConnector(l),n&&(n.element.point=l,n.addClass("highcharts-lollipop-high")),(l.connector?.element).point=l,o&&(h=l.zone&&l.zone.color,r=d(l.options.lowColor,i?.fillColor,e,l.options.color,h,l.color,this.color),t.styledMode||o.attr({fill:r}),o.addClass("highcharts-lollipop-low")),s++}}markerAttribs(){let t=super.markerAttribs.apply(this,arguments);return t.x=Math.floor(t.x||0),t.y=Math.floor(t.y||0),t}pointAttribs(t,o){let e=super.pointAttribs.apply(this,arguments);return"hover"===o&&delete e.fill,e}setShapeArgs(){n.prototype.translate.apply(this),a.prototype.afterColumnTranslate.apply(this)}}return u.defaultOptions=c(h.defaultOptions,o),p(u.prototype,{crispCol:n.prototype.crispCol,drawGraph:l,drawTracker:n.prototype.drawTracker,pointClass:t,seriesDrawPoints:h.prototype.drawPoints,trackerGroups:["group","markerGroup","dataLabelsGroup"],translatePoint:h.prototype.translate}),i.registerSeriesType("dumbbell",u),u}),e(o,"masters/modules/dumbbell.src.js",[],function(){})});//# sourceMappingURL=dumbbell.js.map