/*!
 * Percent-Preloader JS - v1
 * @author JDM Digital - https://jdmdigital.co
 * Copyright (c) 2022
 */
var counting = setInterval(function () { var e = document.getElementById("percentage"), n = parseInt(e.innerHTML), t = 99 - n, i = document.getElementById("loader-progress"); e.innerHTML = ++n, n > 89 && (e.innerHTML = 90, window.jQuery && (e.innerHTML = 95, "interactive" == document.readyState && (e.innerHTML = 99), "complete" == document.readyState && (clearInterval(counting), e.innerHTML = 100, jQuery("body").toggleClass("page-loaded"), setTimeout(function () { jQuery("nav").css("visibility", "visible") }, 880)))), i.style.transition = "0.15s", i.style.width = t + "%" }, 20);