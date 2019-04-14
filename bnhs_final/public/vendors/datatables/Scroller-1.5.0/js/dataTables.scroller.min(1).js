/*!
 Scroller 1.5.0
 ©2011-2018 SpryMedia Ltd - datatables.net/license
*/
(function(e){"function"===typeof define&&define.amd?define(["jquery","datatables.net"],function(h){return e(h,window,document)}):"object"===typeof exports?module.exports=function(h,i){h||(h=window);if(!i||!i.fn.dataTable)i=require("datatables.net")(h,i).$;return e(i,h,h.document)}:e(jQuery,window,document)})(function(e,h,i,l){var m=e.fn.dataTable,g=function(a,b){if(this instanceof g){b===l&&(b={});var c=e.fn.dataTable.Api(a);this.s={dt:c.settings()[0],dtApi:c,tableTop:0,tableBottom:0,redrawTop:0,
redrawBottom:0,autoHeight:!0,viewportRows:0,stateTO:null,drawTO:null,heights:{jump:null,page:null,virtual:null,scroll:null,row:null,viewport:null},topRowFloat:0,scrollDrawDiff:null,loaderVisible:!1,forceReposition:!1};this.s=e.extend(this.s,g.oDefaults,b);this.s.heights.row=this.s.rowHeight;this.dom={force:i.createElement("div"),scroller:null,table:null,loader:null};this.s.dt.oScroller||(this.s.dt.oScroller=this,this._fnConstruct())}else alert("Scroller warning: Scroller must be initialised with the 'new' keyword.")};
e.extend(g.prototype,{fnRowToPixels:function(a,b,c){a-=this.s.baseRowTop;c=c?this._domain("virtualToPhysical",this.s.baseScrollTop):this.s.baseScrollTop;c+=a*this.s.heights.row;return b||b===l?parseInt(c,10):c},fnPixelsToRow:function(a,b,c){a-=this.s.baseScrollTop;c=c?(this._domain("physicalToVirtual",this.s.baseScrollTop)+a)/this.s.heights.row:a/this.s.heights.row+this.s.baseRowTop;return b||b===l?parseInt(c,10):c},fnScrollToRow:function(a,b){var c=this,d=!1,f=this.fnRowToPixels(a),j=a-(this.s.displayBuffer-
1)/2*this.s.viewportRows;0>j&&(j=0);if((f>this.s.redrawBottom||f<this.s.redrawTop)&&this.s.dt._iDisplayStart!==j)d=!0,f=this._domain("virtualToPhysical",a*this.s.heights.row),this.s.redrawTop<f&&f<this.s.redrawBottom&&(this.s.forceReposition=!0,b=!1);"undefined"==typeof b||b?(this.s.ani=d,e(this.dom.scroller).animate({scrollTop:f},function(){setTimeout(function(){c.s.ani=!1},25)})):e(this.dom.scroller).scrollTop(f)},fnMeasure:function(a){this.s.autoHeight&&this._fnCalcRowHeight();var b=this.s.heights;
b.row&&(b.viewport=e.contains(i,this.dom.scroller)?e(this.dom.scroller).height():this._parseHeight(e(this.dom.scroller).css("height")),b.viewport||(b.viewport=this._parseHeight(e(this.dom.scroller).css("max-height"))),this.s.viewportRows=parseInt(b.viewport/b.row,10)+1,this.s.dt._iDisplayLength=this.s.viewportRows*this.s.displayBuffer);(a===l||a)&&this.s.dt.oInstance.fnDraw(!1)},fnPageInfo:function(){var a=this.dom.scroller.scrollTop,b=this.s.dt.fnRecordsDisplay(),c=Math.ceil(this.fnPixelsToRow(a+
this.s.heights.viewport,!1,this.s.ani));return{start:Math.floor(this.fnPixelsToRow(a,!1,this.s.ani)),end:b<c?b-1:c-1}},_fnConstruct:function(){var a=this,b=this.s.dtApi;if(this.s.dt.oFeatures.bPaginate){this.dom.force.style.position="relative";this.dom.force.style.top="0px";this.dom.force.style.left="0px";this.dom.force.style.width="1px";this.dom.scroller=e("div."+this.s.dt.oClasses.sScrollBody,this.s.dt.nTableWrapper)[0];this.dom.scroller.appendChild(this.dom.force);this.dom.scroller.style.position=
"relative";this.dom.table=e(">table",this.dom.scroller)[0];this.dom.table.style.position="absolute";this.dom.table.style.top="0px";this.dom.table.style.left="0px";e(b.table().container()).addClass("DTS");this.s.loadingIndicator&&(this.dom.loader=e('<div class="dataTables_processing DTS_Loading">'+this.s.dt.oLanguage.sLoadingRecords+"</div>").css("display","none"),e(this.dom.scroller.parentNode).css("position","relative").append(this.dom.loader));this.s.heights.row&&"auto"!=this.s.heights.row&&(this.s.autoHeight=
!1);this.fnMeasure(!1);this.s.ingnoreScroll=!0;this.s.stateSaveThrottle=this.s.dt.oApi._fnThrottle(function(){a.s.dtApi.state.save()},500);e(this.dom.scroller).on("scroll.dt-scroller",function(){a._fnScroll.call(a)});e(this.dom.scroller).on("touchstart.dt-scroller",function(){a._fnScroll.call(a)});e(h).on("resize.dt-scroller",function(){a.fnMeasure(false);a._fnInfo()});var c=!0,d=b.state.loaded();b.on("stateSaveParams.scroller",function(b,e,g){g.scroller={topRow:c&&d&&d.scroller?d.scroller.topRow:
a.s.topRowFloat,baseScrollTop:a.s.baseScrollTop,baseRowTop:a.s.baseRowTop};c=false});d&&d.scroller&&(this.s.topRowFloat=d.scroller.topRow,this.s.baseScrollTop=d.scroller.baseScrollTop,this.s.baseRowTop=d.scroller.baseRowTop);b.on("init.scroller",function(){a.fnMeasure(false);a._fnDrawCallback();b.on("draw.scroller",function(){a._fnDrawCallback()})});b.on("preDraw.dt.scroller",function(){a._fnScrollForce()});b.on("destroy.scroller",function(){e(h).off("resize.dt-scroller");e(a.dom.scroller).off(".dt-scroller");
e(a.s.dt.nTable).off(".scroller");e(a.s.dt.nTableWrapper).removeClass("DTS");e("div.DTS_Loading",a.dom.scroller.parentNode).remove();a.dom.table.style.position="";a.dom.table.style.top="";a.dom.table.style.left=""})}else this.s.dt.oApi._fnLog(this.s.dt,0,"Pagination must be enabled for Scroller")},_fnScroll:function(){var a=this,b=this.s.heights,c=this.dom.scroller.scrollTop,d;if(!this.s.skip&&!this.s.ingnoreScroll)if(this.s.dt.bFiltered||this.s.dt.bSorted)this.s.lastScrollTop=0;else{this._fnInfo();
clearTimeout(this.s.stateTO);this.s.stateTO=setTimeout(function(){a.s.dtApi.state.save()},250);if(this.s.forceReposition||c<this.s.redrawTop||c>this.s.redrawBottom){var f=Math.ceil((this.s.displayBuffer-1)/2*this.s.viewportRows);d=parseInt(this._domain("physicalToVirtual",c)/b.row,10)-f;this.s.topRowFloat=this._domain("physicalToVirtual",c)/b.row;this.s.forceReposition=!1;0>=d?d=0:d+this.s.dt._iDisplayLength>this.s.dt.fnRecordsDisplay()?(d=this.s.dt.fnRecordsDisplay()-this.s.dt._iDisplayLength,0>
d&&(d=0)):0!==d%2&&d++;if(d!=this.s.dt._iDisplayStart&&(this.s.tableTop=e(this.s.dt.nTable).offset().top,this.s.tableBottom=e(this.s.dt.nTable).height()+this.s.tableTop,b=function(){if(a.s.scrollDrawReq===null)a.s.scrollDrawReq=c;a.s.dt._iDisplayStart=d;a.s.dt.oApi._fnDraw(a.s.dt)},this.s.dt.oFeatures.bServerSide?(clearTimeout(this.s.drawTO),this.s.drawTO=setTimeout(b,this.s.serverWait)):b(),this.dom.loader&&!this.s.loaderVisible))this.dom.loader.css("display","block"),this.s.loaderVisible=!0}else this.s.topRowFloat=
this.fnPixelsToRow(c,!1,!0);this.s.lastScrollTop=c;this.s.stateSaveThrottle()}},_domain:function(a,b){var c=this.s.heights,d;if(c.virtual===c.scroll)return b;var e=(c.scroll-c.viewport)/2,j=(c.virtual-c.viewport)/2;d=j/(e*e);if("virtualToPhysical"===a){if(b<j)return Math.pow(b/d,0.5);b=2*j-b;return 0>b?c.scroll:2*e-Math.pow(b/d,0.5)}if("physicalToVirtual"===a){if(b<e)return b*b*d;b=2*e-b;return 0>b?c.virtual:2*j-b*b*d}},_parseHeight:function(a){var b,c=/^([+-]?(?:\d+(?:\.\d+)?|\.\d+))(px|em|rem|vh)$/.exec(a);
if(null===c)return 0;a=parseFloat(c[1]);c=c[2];"px"===c?b=a:"vh"===c?b=a/100*e(h).height():"rem"===c?b=a*parseFloat(e(":root").css("font-size")):"em"===c&&(b=a*parseFloat(e("body").css("font-size")));return b?b:0},_fnDrawCallback:function(){var a=this,b=this.s.heights,c=this.dom.scroller.scrollTop,d=e(this.s.dt.nTable).height(),f=this.s.dt._iDisplayStart,j=this.s.dt._iDisplayLength,g=this.s.dt.fnRecordsDisplay();this.s.skip=!0;if((this.s.dt.bSorted||this.s.dt.bFiltered)&&0===f)this.s.topRowFloat=
0;c=0===f?this.s.topRowFloat*b.row:f+j>=g?b.scroll-(g-this.s.topRowFloat)*b.row:this._domain("virtualToPhysical",this.s.topRowFloat*b.row);this.dom.scroller.scrollTop=c;this.s.baseScrollTop=c;this.s.baseRowTop=this.s.topRowFloat;var h=c-(this.s.topRowFloat-f)*b.row;0===f?h=0:f+j>=g&&(h=b.scroll-d);this.dom.table.style.top=h+"px";this.s.tableTop=h;this.s.tableBottom=d+this.s.tableTop;d=(c-this.s.tableTop)*this.s.boundaryScale;this.s.redrawTop=c-d;this.s.redrawBottom=c+d>b.scroll-b.viewport-b.row?b.scroll-
b.viewport-b.row:c+d;this.s.skip=!1;this.s.dt.oFeatures.bStateSave&&null!==this.s.dt.oLoadedState&&"undefined"!=typeof this.s.dt.oLoadedState.iScroller?((c=(this.s.dt.sAjaxSource||a.s.dt.ajax)&&!this.s.dt.oFeatures.bServerSide?!0:!1)&&2==this.s.dt.iDraw||!c&&1==this.s.dt.iDraw)&&setTimeout(function(){e(a.dom.scroller).scrollTop(a.s.dt.oLoadedState.iScroller);a.s.redrawTop=a.s.dt.oLoadedState.iScroller-b.viewport/2;setTimeout(function(){a.s.ingnoreScroll=!1},0)},0):a.s.ingnoreScroll=!1;this.s.dt.oFeatures.bInfo&&
setTimeout(function(){a._fnInfo.call(a)},0);this.dom.loader&&this.s.loaderVisible&&(this.dom.loader.css("display","none"),this.s.loaderVisible=!1)},_fnScrollForce:function(){var a=this.s.heights;a.virtual=a.row*this.s.dt.fnRecordsDisplay();a.scroll=a.virtual;1E6<a.scroll&&(a.scroll=1E6);this.dom.force.style.height=a.scroll>this.s.heights.row?a.scroll+"px":this.s.heights.row+"px"},_fnCalcRowHeight:function(){var a=this.s.dt,b=a.nTable,c=b.cloneNode(!1),d=e("<tbody/>").appendTo(c),f=e('<div class="'+
a.oClasses.sWrapper+' DTS"><div class="'+a.oClasses.sScrollWrapper+'"><div class="'+a.oClasses.sScrollBody+'"></div></div></div>');for(e("tbody tr:lt(4)",b).clone().appendTo(d);3>e("tr",d).length;)d.append("<tr><td>&nbsp;</td></tr>");e("div."+a.oClasses.sScrollBody,f).append(c);a=this.s.dt.nHolding||b.parentNode;e(a).is(":visible")||(a="body");f.appendTo(a);this.s.heights.row=e("tr",d).eq(1).outerHeight();f.remove()},_fnInfo:function(){if(this.s.dt.oFeatures.bInfo){var a=this.s.dt,b=a.oLanguage,c=
this.dom.scroller.scrollTop,d=Math.floor(this.fnPixelsToRow(c,!1,this.s.ani)+1),f=a.fnRecordsTotal(),g=a.fnRecordsDisplay(),c=Math.ceil(this.fnPixelsToRow(c+this.s.heights.viewport,!1,this.s.ani)),c=g<c?g:c,h=a.fnFormatNumber(d),i=a.fnFormatNumber(c),k=a.fnFormatNumber(f),l=a.fnFormatNumber(g),h=0===a.fnRecordsDisplay()&&a.fnRecordsDisplay()==a.fnRecordsTotal()?b.sInfoEmpty+b.sInfoPostFix:0===a.fnRecordsDisplay()?b.sInfoEmpty+" "+b.sInfoFiltered.replace("_MAX_",k)+b.sInfoPostFix:a.fnRecordsDisplay()==
a.fnRecordsTotal()?b.sInfo.replace("_START_",h).replace("_END_",i).replace("_MAX_",k).replace("_TOTAL_",l)+b.sInfoPostFix:b.sInfo.replace("_START_",h).replace("_END_",i).replace("_MAX_",k).replace("_TOTAL_",l)+" "+b.sInfoFiltered.replace("_MAX_",a.fnFormatNumber(a.fnRecordsTotal()))+b.sInfoPostFix;(b=b.fnInfoCallback)&&(h=b.call(a.oInstance,a,d,c,f,g,h));d=a.aanFeatures.i;if("undefined"!=typeof d){f=0;for(g=d.length;f<g;f++)e(d[f]).html(h)}e(a.nTable).triggerHandler("info.dt")}}});g.defaults={trace:!1,
rowHeight:"auto",serverWait:200,displayBuffer:9,boundaryScale:0.5,loadingIndicator:!1};g.oDefaults=g.defaults;g.version="1.5.0";"function"==typeof e.fn.dataTable&&"function"==typeof e.fn.dataTableExt.fnVersionCheck&&e.fn.dataTableExt.fnVersionCheck("1.10.0")?e.fn.dataTableExt.aoFeatures.push({fnInit:function(a){var b=a.oInit;new g(a,b.scroller||b.oScroller||{})},cFeature:"S",sFeature:"Scroller"}):alert("Warning: Scroller requires DataTables 1.10.0 or greater - www.datatables.net/download");e(i).on("preInit.dt.dtscroller",
function(a,b){if("dt"===a.namespace){var c=b.oInit.scroller,d=m.defaults.scroller;if(c||d)d=e.extend({},c,d),!1!==c&&new g(b,d)}});e.fn.dataTable.Scroller=g;e.fn.DataTable.Scroller=g;var k=e.fn.dataTable.Api;k.register("scroller()",function(){return this});k.register("scroller().rowToPixels()",function(a,b,c){var d=this.context;if(d.length&&d[0].oScroller)return d[0].oScroller.fnRowToPixels(a,b,c)});k.register("scroller().pixelsToRow()",function(a,b,c){var d=this.context;if(d.length&&d[0].oScroller)return d[0].oScroller.fnPixelsToRow(a,
b,c)});k.register(["scroller().scrollToRow()","scroller.toPosition()"],function(a,b){this.iterator("table",function(c){c.oScroller&&c.oScroller.fnScrollToRow(a,b)});return this});k.register("row().scrollTo()",function(a){var b=this;this.iterator("row",function(c,d){if(c.oScroller){var e=b.rows({order:"applied",search:"applied"}).indexes().indexOf(d);c.oScroller.fnScrollToRow(e,a)}});return this});k.register("scroller.measure()",function(a){this.iterator("table",function(b){b.oScroller&&b.oScroller.fnMeasure(a)});
return this});k.register("scroller.page()",function(){var a=this.context;if(a.length&&a[0].oScroller)return a[0].oScroller.fnPageInfo()});return g});
