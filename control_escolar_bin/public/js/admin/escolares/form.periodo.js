!function(e){var r={};function o(i){if(r[i])return r[i].exports;var n=r[i]={i:i,l:!1,exports:{}};return e[i].call(n.exports,n,n.exports,o),n.l=!0,n.exports}o.m=e,o.c=r,o.d=function(e,r,i){o.o(e,r)||Object.defineProperty(e,r,{configurable:!1,enumerable:!0,get:i})},o.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(r,"a",r),r},o.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},o.p="/",o(o.s=20)}({20:function(e,r,o){e.exports=o(21)},21:function(e,r){$.validator.setDefaults({errorClass:"invalid",validClass:"valid",errorPlacement:function(e,r){$(r).closest("form").find("label[for='"+r.attr("id")+"']").attr("data-error",e.text())}});$("#form_periodo").validate({rules:{anio:{required:!0,digits:!0,min:2e3},periodo:{required:!0},reconocimiento_oficial:{required:!0},dges:{required:!0},fecha_reconocimiento:{required:!0}},messages:{anio:{required:"El año es requerido",digits:"El año tiene que ser un número entero",min:"El año tiene que ser mínimo 2000"},periodo:{required:"El período es requerido"},reconocimiento_oficial:{required:"El reconocimiento oficial es requerido"},dges:{required:"El DGES es requerido"},fecha_reconocimiento:{required:"La fecha de reconocimiento es requerida"}}})}});