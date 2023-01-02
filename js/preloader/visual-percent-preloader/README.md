# Percent-Preloader
A simple, light-weight page preloader showing percent complete as the page loads.

## Why? 
Page preloaders give your users a few seconds to understand that the page IS loading, but will take just a moment.  As web nerds, there are tons of choices in preloaders but so many slow the page down by trying to get too fancy. You can learn more about why we wanted to create this in this post on JDM Digital's "Insights" blog: https://jdmdigital.co/news/codex/page-preloader/

"Precent Preloader" uses no graphics at all and relies on CSS3 for the transition effects.  We're making the assumnption you are using jQuery in your project, so it won't complete the count to 100% until jQuery is a function and all (above the fold) assets have been loaded and the page is interactive.

## How to Use it?
Download the latest release and simply include both the CSS and the JS in your project. 

```html
<link rel="stylesheet" href="percent-preloader.min.css">
<script src="percent-preloader.min.js"></script>
```
If you want, you could also inline the CSS and the JS.  Totally up to you.

Then, paste the preloading HTML just inside your `body` tag.
```html
<div class="preloader">
	<div class="inner">
		<span class="percentage"><span id="percentage">15</span>%</span>
	</div>
	<div class="loader-progress" id="loader-progress"> </div>
</div>
<div class="transition-overlay"></div>
```

## Demo
Want to see it in action?  Check out the demo at: https://demo.jdmdigital.co/percent-preloader/

![Percent Preload Demo](demo/Precent-Preloader.gif)

You may need to throttle your browser if it's loading too fast.  What a great problem that is to have. ;)

## To Do
We'll still get a ding from Page Speed testers because we're loading the JS in the head here.  Thinking about a way around that.  For now, it'll visually queue your users that the page is loading and to just give it a moment--rather than relying on the browser's nearly invisible loading bar or icon.
