(self.webpackChunkphpreel_org=self.webpackChunkphpreel_org||[]).push([[563],{3905:function(e,t,n){"use strict";n.d(t,{Zo:function(){return u},kt:function(){return h}});var r=n(7294);function i(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function a(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function o(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?a(Object(n),!0).forEach((function(t){i(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):a(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function s(e,t){if(null==e)return{};var n,r,i=function(e,t){if(null==e)return{};var n,r,i={},a=Object.keys(e);for(r=0;r<a.length;r++)n=a[r],t.indexOf(n)>=0||(i[n]=e[n]);return i}(e,t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);for(r=0;r<a.length;r++)n=a[r],t.indexOf(n)>=0||Object.prototype.propertyIsEnumerable.call(e,n)&&(i[n]=e[n])}return i}var l=r.createContext({}),c=function(e){var t=r.useContext(l),n=t;return e&&(n="function"==typeof e?e(t):o(o({},t),e)),n},u=function(e){var t=c(e.components);return r.createElement(l.Provider,{value:t},e.children)},p={inlineCode:"code",wrapper:function(e){var t=e.children;return r.createElement(r.Fragment,{},t)}},d=r.forwardRef((function(e,t){var n=e.components,i=e.mdxType,a=e.originalType,l=e.parentName,u=s(e,["components","mdxType","originalType","parentName"]),d=c(n),h=i,f=d["".concat(l,".").concat(h)]||d[h]||p[h]||a;return n?r.createElement(f,o(o({ref:t},u),{},{components:n})):r.createElement(f,o({ref:t},u))}));function h(e,t){var n=arguments,i=t&&t.mdxType;if("string"==typeof e||i){var a=n.length,o=new Array(a);o[0]=d;var s={};for(var l in t)hasOwnProperty.call(t,l)&&(s[l]=t[l]);s.originalType=e,s.mdxType="string"==typeof e?e:i,o[1]=s;for(var c=2;c<a;c++)o[c]=n[c];return r.createElement.apply(null,o)}return r.createElement.apply(null,n)}d.displayName="MDXCreateElement"},5203:function(e,t,n){"use strict";n.r(t),n.d(t,{frontMatter:function(){return s},contentTitle:function(){return l},metadata:function(){return c},toc:function(){return u},default:function(){return d}});var r=n(2122),i=n(9756),a=(n(7294),n(3905)),o=["components"],s={sidebar_position:3},l="Blade views",c={unversionedId:"themes/blade-views",id:"themes/blade-views",isDocsHomePage:!1,title:"Blade views",description:"What is Blade?",source:"@site/docs/themes/blade-views.md",sourceDirName:"themes",slug:"/themes/blade-views",permalink:"/themes/blade-views",editUrl:"https://github.com/phpreel/developer.phpreel.org/tree/main/docs/themes/blade-views.md",version:"current",sidebarPosition:3,frontMatter:{sidebar_position:3},sidebar:"tutorialSidebar",previous:{title:"File structure",permalink:"/themes/file-structure"},next:{title:"Getting started with themes",permalink:"/themes/getting-started-with-themes"}},u=[{value:"What is Blade?",id:"what-is-blade",children:[]},{value:".blade.php file extension",id:"bladephp-file-extension",children:[]},{value:"Accessing a view",id:"accessing-a-view",children:[]}],p={toc:u};function d(e){var t=e.components,n=(0,i.Z)(e,o);return(0,a.kt)("wrapper",(0,r.Z)({},p,n,{components:t,mdxType:"MDXLayout"}),(0,a.kt)("h1",{id:"blade-views"},"Blade views"),(0,a.kt)("h2",{id:"what-is-blade"},"What is Blade?"),(0,a.kt)("p",null,"Blade is a template engine that ships with Laravel and it's also what phpReel uses to render it's pages. If Blade is not familiar to you we recommend to check out it's documentation available on the Laravel website, you can find it ",(0,a.kt)("a",{parentName:"p",href:"https://laravel.com/docs/master/blade"},"here"),"."),(0,a.kt)("h2",{id:"bladephp-file-extension"},".blade.php file extension"),(0,a.kt)("p",null,"Every file that contains the design of a specific page is called a view and it must have the .blade.php extension. This let's Blade know that the view should be compiled and cached into plain PHP code so it can be later rendered to the user. "),(0,a.kt)("h2",{id:"accessing-a-view"},"Accessing a view"),(0,a.kt)("p",null,'Although all the views must have the .blade.php extension note that when you will refer to them inside the components you don\'t include the extension. Furthermore if a view is situated inside a directory you can get access to it using a dot (ie if the view "content.blade.php" is situated in a directory named "basicDirectory", you can refer to it like this: "basicDirectory.content "). You can nest as many directories as you want and access them the same way.'))}d.isMDXComponent=!0}}]);