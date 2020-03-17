;(function(factory){var registeredInModuleLoader=false
if(typeof define==='function'&&define.amd){define(factory)
registeredInModuleLoader=true}
if(typeof exports==='object'){module.exports=factory()
registeredInModuleLoader=true}
if(!registeredInModuleLoader){window.ViewBigimg=factory()}})(function(){let ZOOM_CONSTANT=15
let MOUSE_WHEEL_COUNT=5;const preventDefaultCb=e=>e.preventDefault()
function easeOutQuart(t,b,c,d){t/=d
t--
return-c*(t*t*t*t-1)+b}
function isPassive(){var supportsPassiveOption=false
try{addEventListener('test',null,Object.defineProperty({},'passive',{get:function(){supportsPassiveOption=true}}))}catch(e){}
return supportsPassiveOption}
(function(){let lastTime=0
if(window.requestAnimationFrame){return}
let vendors=['ms','moz','webkit','o']
for(let x=0;x<vendors.length&&!window.requestAnimationFrame;++x){window.requestAnimationFrame=window[vendors[x]+'RequestAnimationFrame']
window.cancelAnimationFrame=window[vendors[x]+'CancelAnimationFrame']||window[vendors[x]+'CancelRequestAnimationFrame']}
if(!window.requestAnimationFrame)
window.requestAnimationFrame=function(callback){let currTime=new Date().getTime()
let timeToCall=Math.max(0,16-(currTime-lastTime))
let id=window.setTimeout(function(){callback(currTime+timeToCall)},timeToCall)
lastTime=currTime+timeToCall
return id;};if(!window.cancelAnimationFrame)
window.cancelAnimationFrame=function(id){clearTimeout(id);}}())
function imageLoaded(img){return img.complete&&(typeof img.naturalWidth==='undefined'||img.naturalWidth!==0);}
function TouchEvent(container,options){this.container=container
let noop=function(){}
this.onStart=options.onStart||noop
this.onMove=options.onMove||noop
this.onEnd=options.onEnd||noop
this.onMouseWheel=options.onMouseWheel||noop
this.onClick=options.onClick||noop
this.onPinch=options.onPinch||noop}
TouchEvent.prototype.init=function(){let self=this
this.startHandle=function startHandle(estart){estart.preventDefault()
let eventType=estart.type
let touchMove=eventType==='touchstart'?'touchmove':'mousemove'
let touchEnd=eventType==='touchstart'?'touchend':'mouseup'
let sx=estart.clientX||estart.touches[0].clientX
let sy=estart.clientY||estart.touches[0].clientY
let start=self.onStart(estart,{x:sx,y:sy})
if(start===false)return
if(eventType==='touchstart'&&estart.touches[1]){self.onPinch(estart)}
function moveListener(emove){emove.preventDefault()
let mx=emove.clientX||emove.touches[0].clientX
let my=emove.clientY||emove.touches[0].clientY
self.onMove(emove,{dx:mx-sx,dy:my-sy,mx:mx,my:my})}
function endListener(){document.removeEventListener(touchMove,moveListener)
document.removeEventListener(touchEnd,endListener)
self.onEnd()}
document.addEventListener(touchMove,moveListener,touchMove==='touchmove'&&isPassive()?{capture:false,passive:false}:false)
document.addEventListener(touchEnd,endListener)}
this.container.addEventListener('touchstart',this.startHandle,false)
this.container.addEventListener('mousedown',this.startHandle,false)
this.container.addEventListener('mousewheel',this.onMouseWheel,false)
this.container.addEventListener('click',this.onClick,false)
return this}
TouchEvent.prototype.destroy=function(){this.container.removeEventListener('touchstart',this.startHandle)
this.container.removeEventListener('mousedown',this.startHandle)
this.container.removeEventListener('mousewheel',this.onMouseWheel)
this.container.removeEventListener('click',this.onClick)}
function ImageViewer(container,options){this.container=container
this.options=Object.assign({},ImageViewer.defaults,options)
this.zoomValue=100
container.classList.add('iv-container');this.imageWrap=container.querySelector('.iv-image-wrap')
this.closeBtn=container.querySelector('.iv-close')}
ImageViewer.prototype={constructor:ImageViewer,_init(){let viewer=this
let options=viewer.options
let zooming=false
let container=viewer.container
let imageWrap=viewer.imageWrap
let changedDelta=0
var touchtime=0,point
viewer._imageSlider=new TouchEvent(imageWrap,{onStart(){if(!viewer.loaded)return false
if(zooming)return
var self=this
self.imgWidth=viewer.imageDim.w*viewer.zoomValue/100
self.imgHeight=viewer.imageDim.h*viewer.zoomValue/100
self.curImgLeft=parseFloat(viewer.currentImg.style.left)
self.curImgTop=parseFloat(viewer.currentImg.style.top)},onMove(e,position){if(zooming)return
this.currentPos=position
let newLeft=this.curImgLeft+position.dx
let newTop=this.curImgTop+position.dy
let baseLeft=Math.max((viewer.containerDim.w-this.imgWidth)/2,0),baseTop=Math.max((viewer.containerDim.h-this.imgHeight)/2,0),baseRight=viewer.containerDim.w-baseLeft,baseBottom=viewer.containerDim.h-baseTop
newLeft=Math.min(newLeft,baseLeft)
newTop=Math.min(newTop,baseTop)
if((newLeft+this.imgWidth)<baseRight){newLeft=baseRight-this.imgWidth}
if((newTop+this.imgHeight)<baseBottom){newTop=baseBottom-this.imgHeight}
viewer.currentImg.style.left=newLeft+'px'
viewer.currentImg.style.top=newTop+'px'},onEnd(){if(zooming)return},onMouseWheel(e){if(!options.zoomOnMouseWheel||!viewer.loaded){return}
let delta=Math.max(-1,Math.min(1,(e.wheelDelta))),zoomValue=viewer.zoomValue*(100+delta*ZOOM_CONSTANT)/100
if(!(zoomValue>=100&&zoomValue<=options.maxZoom)){changedDelta+=Math.abs(delta)}else{changedDelta=0}
if(changedDelta>MOUSE_WHEEL_COUNT)return;e.preventDefault();let x=e.pageX,y=e.pageY
viewer.zoom(zoomValue,{x:x,y:y})},onClick(e){if(touchtime==0){touchtime=Date.now()
point={x:e.pageX,y:e.pageY}}else{if((Date.now()-touchtime)<500&&Math.abs(e.pageX-point.x)<50&&Math.abs(e.pageY-point.y)<50){if(viewer.zoomValue==options.zoomValue){viewer.zoom(200)}else{viewer.resetZoom()}
touchtime=0}else{touchtime=0}}},onPinch(estart){if(!viewer.loaded)return
let touch0=estart.touches[0],touch1=estart.touches[1]
if(!(touch0&&touch1)){return}
zooming=true
let startdist=Math.sqrt(Math.pow(touch1.pageX-touch0.pageX,2)+Math.pow(touch1.pageY-touch0.pageY,2)),startZoom=viewer.zoomValue,center={x:((touch1.pageX+touch0.pageX)/2),y:((touch1.pageY+touch0.pageY)/2)}
let moveListener=function(emove){emove.preventDefault()
let touch0=emove.touches[0],touch1=emove.touches[1],newDist=Math.sqrt(Math.pow(touch1.pageX-touch0.pageX,2)+Math.pow(touch1.pageY-touch0.pageY,2)),zoomValue=startZoom+(newDist-startdist)/2
viewer.zoom(zoomValue,center)}
let endListener=function(){document.removeEventListener('touchmove',moveListener)
document.removeEventListener('touchend',endListener)
zooming=false}
document.addEventListener('touchmove',moveListener,isPassive()?{capture:false,passive:false}:false)
document.addEventListener('touchend',endListener)}}).init()
if(options.refreshOnResize){this._resizeHandler=this.refresh.bind(this)
window.addEventListener('resize',this._resizeHandler)}
container.addEventListener('touchmove',preventDefaultCb,isPassive()?{capture:false,passive:false}:false)
container.addEventListener('mousewheel',preventDefaultCb)
this._close=this.hide.bind(this)
this.closeBtn.addEventListener('click',this._close)},zoom(perc,point){let self=this,maxZoom=this.options.maxZoom,curPerc=this.zoomValue,curImg=this.currentImg,containerDim=this.containerDim,imageDim=this.imageDim,curLeft=parseFloat(curImg.style.left),curTop=parseFloat(curImg.style.top)
perc=Math.round(Math.max(100,perc))
perc=Math.min(maxZoom,perc)
point=point||{x:containerDim.w/2,y:containerDim.h/2}
self._clearFrames();let step=0
function _zoom(){step++
if(step<20){self._zoomFrame=requestAnimationFrame(_zoom)}
let tickZoom=easeOutQuart(step,curPerc,perc-curPerc,20)
let ratio=tickZoom/curPerc,imgWidth=imageDim.w*tickZoom/100,imgHeight=imageDim.h*tickZoom/100,newLeft=-((point.x-curLeft)*ratio-point.x),newTop=-((point.y-curTop)*ratio-point.y)
let baseLeft=Math.max((containerDim.w-imgWidth)/2,0),baseTop=Math.max((containerDim.h-imgHeight)/2,0),baseRight=containerDim.w-baseLeft,baseBottom=containerDim.h-baseTop
newLeft=Math.min(newLeft,baseLeft)
newTop=Math.min(newTop,baseTop)
if((newLeft+imgWidth)<baseRight){newLeft=baseRight-imgWidth}
if((newTop+imgHeight)<baseBottom){newTop=baseBottom-imgHeight}
curImg.style.width=imgWidth+'px'
curImg.style.height=imgHeight+'px'
curImg.style.left=newLeft+'px'
curImg.style.top=newTop+'px'
self.zoomValue=tickZoom}
_zoom()},_clearFrames(){cancelAnimationFrame(this._zoomFrame)},resetZoom(){this.zoom(this.options.zoomValue)},_calculateDimensions(){let self=this
let curImg=self.currentImg
let container=self.container
let imageWidth=curImg.getBoundingClientRect().width
let imageHeight=curImg.getBoundingClientRect().height
let contWidth=container.getBoundingClientRect().width
let contHeight=container.getBoundingClientRect().height
self.containerDim={w:contWidth,h:contHeight}
let imgWidth,imgHeight
let ratio=imageWidth/imageHeight
imgWidth=(imageWidth>imageHeight&&contHeight>=contWidth)||ratio*contHeight>contWidth?contWidth:ratio*contHeight
imgHeight=imgWidth/ratio
self.imageDim={w:imgWidth,h:imgHeight}
curImg.style.width=imgWidth+'px'
curImg.style.height=imgHeight+'px'
curImg.style.left=(contWidth-imgWidth)/2+'px'
curImg.style.top=(contHeight-imgHeight)/2+'px'
curImg.style.maxWidth='none'
curImg.style.maxHeight='none'},refresh(){if(!this.loaded)return
this._calculateDimensions()
this.resetZoom()},show(image){this.container.style.display='block'
if(image)this.load(image)},hide(){this.container.style.display='none'},destroy(){window.removeEventListener('resize',this._resizeHandler)
this._imageSlider.destroy()
this.closeBtn.removeEventListener('click',this._close)
this.container.parentNode.removeChild(this.container)
this.closeBtn=null
this.container=null
this.imageWrap=null
this.options=null
this._close=null
this._imageSlider=null
this._resizeHandler=null},load(image){let self=this
let container=this.container
let imageWrap=this.imageWrap
let beforeImg=imageWrap.querySelector('.iv-large-image')
if(beforeImg){imageWrap.removeChild(beforeImg)}
let img=document.createElement('img')
img.classList.add('iv-large-image')
img.src=image
this.currentImg=img
this.imageWrap.appendChild(img)
this.loaded=false
container.querySelector('.iv-loader').style.display='block'
img.style.display='none'
function refreshView(){self.loaded=true
self.zoomValue=100
img.style.display='block'
self.refresh()
container.querySelector('.iv-loader').style.display='none'}
if(imageLoaded(img)){refreshView()}else{img.onload=function(){refreshView()}}}}
ImageViewer.defaults={zoomValue:100,maxZoom:500,refreshOnResize:true,zoomOnMouseWheel:true}
function ViewBigimg(options){let imageViewHtml='<div class="iv-loader"></div><div class="iv-image-view"><div class="iv-image-wrap"></div><div class="iv-close"></div></div>'
let container=document.createElement('div')
container.id='iv-container'
container.innerHTML=imageViewHtml
document.body.appendChild(container)
var viewer=new ImageViewer(container,options)
viewer._init()
return viewer}
return ViewBigimg})