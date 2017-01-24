// classList polyfill
if("document"in self){if(!("classList"in document.createElement("_"))||document.createElementNS&&!("classList"in document.createElementNS("http://www.w3.org/2000/svg","g"))){(function(t){"use strict";if(!("Element"in t))return;var e="classList",i="prototype",n=t.Element[i],s=Object,r=String[i].trim||function(){return this.replace(/^\s+|\s+$/g,"")},a=Array[i].indexOf||function(t){var e=0,i=this.length;for(;e<i;e++){if(e in this&&this[e]===t){return e}}return-1},o=function(t,e){this.name=t;this.code=DOMException[t];this.message=e},l=function(t,e){if(e===""){throw new o("SYNTAX_ERR","An invalid or illegal string was specified")}if(/\s/.test(e)){throw new o("INVALID_CHARACTER_ERR","String contains an invalid character")}return a.call(t,e)},c=function(t){var e=r.call(t.getAttribute("class")||""),i=e?e.split(/\s+/):[],n=0,s=i.length;for(;n<s;n++){this.push(i[n])}this._updateClassName=function(){t.setAttribute("class",this.toString())}},u=c[i]=[],f=function(){return new c(this)};o[i]=Error[i];u.item=function(t){return this[t]||null};u.contains=function(t){t+="";return l(this,t)!==-1};u.add=function(){var t=arguments,e=0,i=t.length,n,s=false;do{n=t[e]+"";if(l(this,n)===-1){this.push(n);s=true}}while(++e<i);if(s){this._updateClassName()}};u.remove=function(){var t=arguments,e=0,i=t.length,n,s=false,r;do{n=t[e]+"";r=l(this,n);while(r!==-1){this.splice(r,1);s=true;r=l(this,n)}}while(++e<i);if(s){this._updateClassName()}};u.toggle=function(t,e){t+="";var i=this.contains(t),n=i?e!==true&&"remove":e!==false&&"add";if(n){this[n](t)}if(e===true||e===false){return e}else{return!i}};u.toString=function(){return this.join(" ")};if(s.defineProperty){var h={get:f,enumerable:true,configurable:true};try{s.defineProperty(n,e,h)}catch(d){if(d.number===-2146823252){h.enumerable=false;s.defineProperty(n,e,h)}}}else if(s[i].__defineGetter__){n.__defineGetter__(e,f)}})(self)}else{(function(){"use strict";var t=document.createElement("_");t.classList.add("c1","c2");if(!t.classList.contains("c2")){var e=function(t){var e=DOMTokenList.prototype[t];DOMTokenList.prototype[t]=function(t){var i,n=arguments.length;for(i=0;i<n;i++){t=arguments[i];e.call(this,t)}}};e("add");e("remove")}t.classList.toggle("c3",false);if(t.classList.contains("c3")){var i=DOMTokenList.prototype.toggle;DOMTokenList.prototype.toggle=function(t,e){if(1 in arguments&&!this.contains(t)===!e){return e}else{return i.call(this,t)}}}t=null})()}}
// closest polyfill
(function(ElementProto){if(typeof ElementProto.matches!=="function"){ElementProto.matches=ElementProto.msMatchesSelector||ElementProto.mozMatchesSelector||ElementProto.webkitMatchesSelector||function matches(selector){var element=this;var elements=(element.document||element.ownerDocument).querySelectorAll(selector);var index=0;while(elements[index]&&elements[index]!==element){++index;}return Boolean(elements[index]);};}if(typeof ElementProto.closest!=="function"){ElementProto.closest=function closest(selector){var element=this;while(element&&element.nodeType===1){if(element.matches(selector)){return element;}element=element.parentNode;}return null;};}})(window.Element.prototype);
// foreach polyfill
if(typeof NodeList.prototype.forEach==="undefined"){NodeList.prototype.forEach=Array.prototype.forEach}

document.body.innerHTML += '<div id="tooltip_elm"></div>';

var zones = document.querySelectorAll(".svg_zone [id^='zone-']");
var tooltip_elm = document.getElementById("tooltip_elm");
var tooltip_text;
var svg_zone;
var position;


// Active zone
var activeZone = function (id) {

    zones.forEach(function (item) {
        item.style.fill = '';
    });

    if (id !== undefined) {
        var zoneHover =  document.querySelector('#zone-' + id);

        zoneHover.style.fill = "#" + zoneHover.closest('svg').getAttribute('data-hover');
    }
};

// hover Zones
zones.forEach(function (path) {

    path.addEventListener('mouseenter', function (e) {

        var id = this.id.replace('zone-', '');
        tooltip_text = this.getAttribute('title');
        svg_zone = this.closest('.svg_zone');
        activeZone(id)

    });
    path.addEventListener('mousemove', function (e) {

        if (tooltip_text) {
            tooltip_elm.style.display = 'block';
            tooltip_elm.innerHTML = tooltip_text;
            tooltip_elm.style.left = e.pageX + 15 + 'px';
            tooltip_elm.style.top = e.pageY + 15 + 'px';
        }

    });
    path.addEventListener('mouseleave', function (e) {
        activeZone();
        tooltip_elm.style.display = 'none';
    });
});