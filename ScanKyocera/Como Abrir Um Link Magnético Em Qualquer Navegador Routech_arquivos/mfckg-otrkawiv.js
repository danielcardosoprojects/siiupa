ezoicSiteSpeed(document,String(/domContentLoaded/).substring(1).slice(0,-1),String(/dom-content-loaded-listener/).substring(1).slice(0,-1),function(){let mcnszrqyjbxahtlug={style:'compact',timeout:'1000',closeable:'off',title:`⚠️ It Looks Like You Have AdBlocker Enabled ⚠️`,content:`<p class="LC20lb DKV0Md">🛑 Please disable AdBlock and reload the page to read the content.</p>
Ads are our one and only way of maintenance for this website :(`,bg_color:'rgba(255, 0, 0, 0.75)',modal_color:'rgba(255, 255, 255, 1)',text_color:'rgba(35, 40, 45, 1)',blur:'on',prefix:'jtmgnrbs-ocyn',};adsBlocked(function(blocked){if(blocked){showModal();}else if(!document.getElementById('mdp-deblocker-ads')){showModal();}});function disableTextSelection(e){if(typeof e.onselectstart!=='undefined'){e.onselectstart=function(){return false;};}else if(typeof e.style.MozUserSelect!='undefined'){e.style.MozUserSelect='none';}else if(typeof e.style.webkitUserSelect!='undefined'){e.style.webkitUserSelect='none';}else{e.onmousedown=function(){return false;};}
e.style.cursor='default';}
function enableSelection(e){if(typeof e.onselectstart!='undefined'){e.onselectstart=function(){return true;};}else if(typeof e.style.MozUserSelect!='undefined'){e.style.MozUserSelect='text';}else if(typeof e.style.webkitUserSelect!='undefined'){e.style.webkitUserSelect='text';}else{e.onmousedown=function(){return true;};}
e.style.cursor='auto';}
function disableContextMenu(){document.oncontextmenu=function(e){let t=e||window.event;let n=t.target||t.srcElement;if(n.nodeName!='A'){return false;}};document.body.oncontextmenu=function(){return false;};document.ondragstart=function(){return false;};}
function enableContextMenu(){document.oncontextmenu=null;document.body.oncontextmenu=null;document.ondragstart=null;}
let h_win_disableHotKeys;let h_mac_disableHotKeys;function disableHotKeys(){h_win_disableHotKeys=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==70||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){e.preventDefault();}};window.addEventListener('keydown',h_win_disableHotKeys);document.keypress=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==70||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){return false;}};h_mac_disableHotKeys=function(e){if(e.metaKey&&(e.which==65||e.which==66||e.which==67||e.which==70||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){e.preventDefault();}};window.addEventListener('keydown',h_mac_disableHotKeys);document.keypress=function(e){if(e.metaKey&&(e.which==65||e.which==66||e.which==70||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){return false;}};document.onkeydown=function(e){if(e.keyCode==123||((e.ctrlKey||e.metaKey)&&e.shiftKey&&e.keyCode==73)){e.preventDefault();}};}
function disableDeveloperTools(){window.addEventListener('keydown',function(e){if(e.keyCode===123||((e.ctrlKey||e.metaKey)&&e.shiftKey&&e.keyCode===73)){e.preventDefault();}});let checkStatus;let element=new Image();Object.defineProperty(element,'id',{get:function(){checkStatus='on';throw new Error('Dev tools checker');}});requestAnimationFrame(function check(){checkStatus='off';console.dir(element);if('on'===checkStatus){document.body.parentNode.removeChild(document.body);document.head.parentNode.removeChild(document.head);setTimeout(function(){while(true){eval("debugger");}},100);}else{requestAnimationFrame(check);}});}
function enableHotKeys(){window.removeEventListener('keydown',h_win_disableHotKeys);document.keypress=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==70||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){return true;}};window.removeEventListener('keydown',h_mac_disableHotKeys);document.keypress=function(e){if(e.metaKey&&(e.which==65||e.which==66||e.which==70||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){return true;}};document.onkeydown=function(e){e=e||window.event;if(e.keyCode==123||e.keyCode==18||(e.ctrlKey&&e.shiftKey&&e.keyCode==73)){return true;}};}
function addStyles(){let prefix=mcnszrqyjbxahtlug.prefix;let style=document.createElement('style');style.innerHTML=`
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-blackout,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-blackout,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-blackout,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-blackout,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-blackout,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-blackout {
                position: fixed;
                z-index: 9997;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                display: none;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-blackout.active,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-blackout.active,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-blackout.active,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-blackout.active,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-blackout.active,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-blackout.active {
                display: block;
                -webkit-animation: deblocker-appear;
                animation: deblocker-appear;
                -webkit-animation-duration: .2s;
                animation-duration: .2s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-wrapper,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-wrapper,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-wrapper,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-wrapper,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-wrapper,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9998;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-modal,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-modal,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-modal,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-modal,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal {
                height: auto;
                width: auto;
                position: relative;
                max-width: 40%;
                padding: 4rem;
                opacity: 0;
                z-index: 9999;
                transition: all 0.5s ease-in-out;
                border-radius: 1rem;
                margin: 1rem;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal.active,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-modal.active,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-modal.active,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-modal.active,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-modal.active,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal.active {
                opacity: 1;
                -webkit-animation: deblocker-appear;
                animation: deblocker-appear;
                -webkit-animation-delay: .1s;
                animation-delay: .1s;
                -webkit-animation-duration: .5s;
                animation-duration: .5s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal h4,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-modal h4,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-modal h4,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-modal h4,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-modal h4,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal h4 {
                margin: 0 0 1rem 0;
                padding-right: .8rem;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal p,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-modal p,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-modal p,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-modal p,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-modal p,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal p {
                margin: 0;
            }

            @media only screen and (max-width: 1140px) {
                .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal {
                    min-width: 60%;
                }
            }

            @media only screen and (max-width: 768px) {
                .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal {
                    min-width: 80%;
                }
            }

            @media only screen and (max-width: 420px) {
                .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-modal,
                .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-modal {
                    min-width: 90%;
                }
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-close,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-close,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-close,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-close,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close {
                position: absolute;
                right: 1rem;
                top: 1rem;
                display: inline-block;
                cursor: pointer;
                opacity: .3;
                width: 32px;
                height: 32px;
                -webkit-animation: deblocker-close-appear;
                animation: deblocker-close-appear;
                -webkit-animation-delay: 1s;
                animation-delay: 1s;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:hover,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-close:hover,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-close:hover,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-close:hover,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-close:hover,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:hover {
                opacity: 1;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:after {
                position: absolute;
                left: 15px;
                content: ' ';
                height: 33px;
                width: 2px;
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:before {
                transform: rotate(45deg);
            }

            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-close:after,
            .jtmgnrbs-ocyn-style-compact .jtmgnrbs-ocyn-close:after {
                transform: rotate(-45deg);
            }

            .jtmgnrbs-ocyn-style-compact-right-top .jtmgnrbs-ocyn-wrapper {
                justify-content: flex-end;
                align-items: flex-start;
            }

            .jtmgnrbs-ocyn-style-compact-left-top .jtmgnrbs-ocyn-wrapper {
                justify-content: flex-start;
                align-items: flex-start;
            }

            .jtmgnrbs-ocyn-style-compact-right-bottom .jtmgnrbs-ocyn-wrapper {
                justify-content: flex-end;
                align-items: flex-end;
            }

            .jtmgnrbs-ocyn-style-compact-left-bottom .jtmgnrbs-ocyn-wrapper {
                justify-content: flex-start;
                align-items: flex-end;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-blackout {
                position: fixed;
                z-index: 9998;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                display: none;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-blackout.active {
                display: block;
                -webkit-animation: deblocker-appear;
                animation: deblocker-appear;
                -webkit-animation-delay: .4s;
                animation-delay: .4s;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-modal {
                height: 100%;
                width: 100%;
                max-width: 100%;
                max-height: 100%;
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                padding: 45px;
                opacity: 0;
                z-index: 9999;
                transition: all 0.5s ease-in-out;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-modal.active {
                opacity: 1;
                -webkit-animation: mdp-deblocker-appear;
                animation: mdp-deblocker-appear;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-modal h4 {
                margin: 0 0 1rem 0;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-modal p {
                margin: 0;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-close {
                position: absolute;
                right: 10px;
                top: 10px;
                width: 32px;
                height: 32px;
                display: inline-block;
                cursor: pointer;
                opacity: .3;
                -webkit-animation: mdp-deblocker-close-appear;
                animation: mdp-deblocker-close-appear;
                -webkit-animation-delay: 1s;
                animation-delay: 1s;
                -webkit-animation-duration: .4s;
                animation-duration: .4s;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-close:hover {
                opacity: 1;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-close:before,
            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-close:after {
                position: absolute;
                left: 15px;
                content: ' ';
                height: 33px;
                width: 2px;
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-close:before {
                transform: rotate(45deg);
            }

            .jtmgnrbs-ocyn-style-full .jtmgnrbs-ocyn-close:after {
                transform: rotate(-45deg);
            }

            @-webkit-keyframes mdp-deblocker-appear {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes mdp-deblocker-appear {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @-webkit-keyframes mdp-deblocker-close-appear {
                from {
                    opacity: 0;
                    transform: scale(0.2);
                }
                to {
                    opacity: .3;
                    transform: scale(1);
                }
            }

            @keyframes mdp-deblocker-close-appear {
                from {
                    opacity: 0;
                    transform: scale(0.2);
                }
                to {
                    opacity: .3;
                    transform: scale(1);
                }
            }

            body.jtmgnrbs-ocyn-blur { 
                -webkit-backface-visibility: none;
            }

            body.jtmgnrbs-ocyn-blur > *:not(#wpadminbar):not(.jtmgnrbs-ocyn-modal):not(.jtmgnrbs-ocyn-wrapper):not(.jtmgnrbs-ocyn-blackout) {
                -webkit-filter: blur(5px);
                filter: blur(5px);
            }
        `;let ref=document.querySelectorAll('script');let rand=ref[Math.floor(Math.random()*ref.length)];rand.parentNode.insertBefore(style,rand);}
function showModal(){setTimeout(function(){let prefix=mcnszrqyjbxahtlug.prefix;addStyles();if(document.body.classList.contains(`jtmgnrbs-ocyn-style-`+mcnszrqyjbxahtlug.style)){return}
document.body.classList.add(`jtmgnrbs-ocyn-style-`+mcnszrqyjbxahtlug.style);if(mcnszrqyjbxahtlug.blur==='on'){document.body.classList.add(`jtmgnrbs-ocyn-blur`);}
let overlay=document.createElement('div');overlay.classList.add(`jtmgnrbs-ocyn-blackout`);overlay.style.backgroundColor=mcnszrqyjbxahtlug.bg_color;overlay.classList.add('active');document.body.appendChild(overlay);let modalWrapper=document.createElement('div');modalWrapper.classList.add(`jtmgnrbs-ocyn-wrapper`);document.body.appendChild(modalWrapper);let modal=document.createElement('div');modal.classList.add(`jtmgnrbs-ocyn-modal`);modal.style.backgroundColor=mcnszrqyjbxahtlug.modal_color;modal.classList.add('active');modalWrapper.appendChild(modal);if(mcnszrqyjbxahtlug.closeable==='on'){let close=document.createElement('span');close.classList.add(`jtmgnrbs-ocyn-close`);close.innerHTML='&nbsp;';close.setAttribute('href','#');let style=document.createElement('style');style.type='text/css';style.innerHTML=`.jtmgnrbs-ocyn-close:after,`+
`.jtmgnrbs-ocyn-close:before {`+
'background-color: '+mcnszrqyjbxahtlug.text_color+';'+
'}';let head=document.head||document.getElementsByTagName('head')[0];head.appendChild(style);close.addEventListener('click',function(e){e.preventDefault();let elem=document.querySelector(`.jtmgnrbs-ocyn-modal`);elem.parentNode.removeChild(elem);elem=document.querySelector(`.jtmgnrbs-ocyn-wrapper`);elem.parentNode.removeChild(elem);elem=document.querySelector(`.jtmgnrbs-ocyn-blackout`);elem.parentNode.removeChild(elem);document.body.classList.remove(`jtmgnrbs-ocyn-blur`);enableSelection(document.body);enableContextMenu();enableHotKeys();});modal.appendChild(close);}
let title=document.createElement('h4');title.innerHTML=mcnszrqyjbxahtlug.title;title.style.color=mcnszrqyjbxahtlug.text_color;modal.appendChild(title);let content=document.createElement('div');content.classList.add(`jtmgnrbs-ocyn-content`);content.innerHTML=mcnszrqyjbxahtlug.content;content.style.color=mcnszrqyjbxahtlug.text_color;modal.appendChild(content);disableTextSelection(document.body);disableContextMenu();disableHotKeys();disableDeveloperTools();},(mcnszrqyjbxahtlug.timeout));}
function isFairAdBlocker(){let stndzStyle=document.getElementById('stndz-style');return null!==stndzStyle;}
function adsBlocked(callback){let adsSrc='https://googleads.g.doubleclick.net/pagead/id';let isChromium=window.chrome;let isOpera=window.navigator.userAgent.indexOf('OPR')>-1||window.navigator.userAgent.indexOf('Opera')>-1;if(isFairAdBlocker()){callback(true);}else if(isChromium!==null&&isOpera==true){let RequestSettings={method:'HEAD',mode:'no-cors'};let DeBlockerRequest=new Request(adsSrc,RequestSettings);fetch(DeBlockerRequest).then(function(response){return response;}).then(function(response){callback(false);}).catch(function(e){callback(true);});}else{adsSrc='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';let head=document.getElementsByTagName('head')[0];let script=document.createElement('script');let done=false;script.setAttribute('src',adsSrc);script.setAttribute('type','text/javascript');script.setAttribute('charset','utf-8');script.onload=script.onreadstatechange=function(){if(!done&&(!this.readyState||this.readyState==='loaded'||this.readyState==='complete')){done=true;script.onload=script.onreadystatechange=null;if('undefined'===typeof window.adsbygoogle){callback(true);}else{callback(false);}
script.parentNode.removeChild(script);}};script.onerror=function(){callback(true);};let callbacked=false;const request=new XMLHttpRequest();request.open('GET',adsSrc,true);request.onreadystatechange=()=>{if(!callbacked){callback(request.responseURL!==adsSrc);callbacked=true;}};request.send();head.insertBefore(script,head.firstChild);}}},false);