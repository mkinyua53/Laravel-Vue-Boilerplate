"use strict";var precacheConfig=[["/","7c2405bf088450a37776180284657541"],["/css/app.css","7e5f919d1243881c3d22b395f830fcdf"],["/js/manifest.js","41f053ba9a94d81b39f82277264c0669"],["/js/vendor.js","10db3f8aca38803cfef1a1979cf38cb3"],["fonts/Grenze-Regular.ttf","eee37fb63123c0f1a391b76060fee19a"],["fonts/MaterialIcons-Regular.eot","60344265b77448dbf4c84282b2dfdb43"],["fonts/MaterialIcons-Regular.ttf","1f5a40f74b2f99906eb203837f257eac"],["fonts/MaterialIcons-Regular.woff","506d840d292e37eb27336ff9cc4a9352"],["fonts/MaterialIcons-Regular.woff2","2284f262ff98f4ca32c8caeb042e3246"],["fonts/Philosopher-Regular.ttf","3dc5466c13793b65e973fd6ff05a0da8"],["fonts/Raleway-Regular.ttf","ad80b41bdb7b845695f0b6d101d802c8"],["fonts/fontawesome-webfont.eot","296770faf390201129bbb8a64a2277d0"],["fonts/fontawesome-webfont.svg","3ad46c29fd6fb18dcb1e868835e73f85"],["fonts/fontawesome-webfont.ttf","1bb74be0b4ef1a67f4fea856152c194f"],["fonts/fontawesome-webfont.woff","ce29ad9daf3def7f6f15b2cb4e039e70"],["fonts/fontawesome-webfont.woff2","bb99dc998e96d47bdf0359ad9fb3877d"]],cacheName="sw-precache-v3-amate-"+(self.registration?self.registration.scope:""),addDirectoryIndex=function(e,t){var n=new URL(e);return"/"===n.pathname.slice(-1)&&(n.pathname+=t),n.toString()},cleanResponse=function(e){return e.redirected?("body"in e?Promise.resolve(e.body):e.blob()).then(function(t){return new Response(t,{headers:e.headers,status:e.status,statusText:e.statusText})}):Promise.resolve(e)},createCacheKey=function(e,t,n,a){var r=new URL(e);return a&&r.pathname.match(a)||(r.search+=(r.search?"&":"")+encodeURIComponent(t)+"="+encodeURIComponent(n)),r.toString()},isPathWhitelisted=function(e,t){if(0===e.length)return!0;var n=new URL(t).pathname;return e.some(function(e){return n.match(e)})},stripIgnoredUrlParameters=function(e,t){var n=new URL(e);return n.hash="",n.search=n.search.slice(1).split("&").map(function(e){return e.split("=")}).filter(function(e){return t.every(function(t){return!t.test(e[0])})}).map(function(e){return e.join("=")}).join("&"),n.toString()},hashParamName="_sw-precache",urlsToCacheKeys=new Map(precacheConfig.map(function(e){var t=e[0],n=e[1],a=new URL(t,self.location),r=createCacheKey(a,hashParamName,n,!1);return[a.toString(),r]}));function setOfCachedUrls(e){return e.keys().then(function(e){return e.map(function(e){return e.url})}).then(function(e){return new Set(e)})}self.addEventListener("install",function(e){e.waitUntil(caches.open(cacheName).then(function(e){return setOfCachedUrls(e).then(function(t){return Promise.all(Array.from(urlsToCacheKeys.values()).map(function(n){if(!t.has(n)){var a=new Request(n,{credentials:"same-origin"});return fetch(a).then(function(t){if(!t.ok)throw new Error("Request for "+n+" returned a response with status "+t.status);return cleanResponse(t).then(function(t){return e.put(n,t)})})}}))})}).then(function(){return self.skipWaiting()}))}),self.addEventListener("activate",function(e){var t=new Set(urlsToCacheKeys.values());e.waitUntil(caches.open(cacheName).then(function(e){return e.keys().then(function(n){return Promise.all(n.map(function(n){if(!t.has(n.url))return e.delete(n)}))})}).then(function(){return self.clients.claim()}))});