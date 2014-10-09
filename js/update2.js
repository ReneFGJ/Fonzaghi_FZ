$('html').removeClass('no-js');

var windowHeight = parseInt($(window).height()),
	stickNav = parseInt(windowHeight - 250)
	body = $('body'),
	pageWidth = $(window).width(),
	fadeOut = $('.fade-out'),
	whiteBg = $('.white-bg');

if ($(window).width() < 768) {
	var mobileJS = true;
} else if ($(window).width() < 1024){
	var tabletJS = true;
} else if($(window).width() < 1300){
	var laptopJS = true;
}

if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1){
	$('html').addClass('safari').addClass('page-loaded');
}

$('#home_video').ready(function(){
	$('html').addClass('page-loaded');
});

// More Projects Button

var moreProjectsBtn = $('#more-projects'),
	moreProjects = $('#loaded-more-projects'),
	moreProjectsCount = moreProjects.children().length;
	
	if(moreProjectsCount > 6){
		moreProjects.addClass('more-than-6');
	} else if(moreProjectsCount > 3){
		moreProjects.addClass('more-than-3');
	}

moreProjectsBtn.click(function(ev){
	ev = ev || window.event;
    ev.preventDefault();
    moreProjects.addClass('opening');
    setTimeout(function(){
    moreProjects.addClass('active');
    }, 100)
});

// Live Push

$(".live-push").each(function(){
	$(this).submit(function(ev){
		ev.preventDefault();
		var	formRoot = $(this),
			dataString = formRoot.serialize(),
			formAction = formRoot.attr("action"),
			response = formRoot.children("div").children(".response");
	  $(formRoot).removeClass("form-fail, form-sent").addClass("form-sending");
	  response.html("sending");
		$.ajax({
			type: "POST",
			url: formAction,
			data: dataString,
	    success: function(){
	        formRoot.removeClass("form-sending").addClass("form-sent");
	        response.html("Thank you for signing up!");
	    },
        error: function(){
            formRoot.removeClass("form-sending").addClass("form-failed");
            response.html("Failed. Try Again.");
        }
		});
	});
});

// Auto Clear

$('.auto-clear').each(function(){
	var defaultText = $(this).val();
	$(this).val(defaultText);
	$(this).attr('placeholder', '');
		$(this).focus(function(){
			if($(this).val() === defaultText || $(this).val() === ''){
					$(this).val('');
			} else{
			}
		});
		$(this).blur(function(){
			if($(this).val() === ''){
					$(this).val(defaultText);
			} else{
			}
		});
});

// Stuck navigation
	
	$(window).scroll(function() {
		var scrollPos = $(window).scrollTop();
		
		if(scrollPos > 1){
			body.addClass("stuck-nav");
		} else{
			body.removeClass("stuck-nav");
		}
	});
	
// Open Project

$(document).ready(function(){
	var hash = window.location.hash,
		pageID = hash.replace('#', ''),
		siteURL = '/case_study/',
		projectsURL = '/case_study/view/',
		projectLinks = $('.project-link'),
		yScroll = null;
	
	function preventDefault(ev){
		ev = ev || window.event;
	    ev.preventDefault();
	}
	function closingWork(yScroll){
	    body.addClass('work-closing');
		setTimeout(function(){
			body.removeClass('work-loaded');
			body.removeClass('work-loading');
			body.removeClass('work-actived');
			$('html').removeClass('work-actived');
			body.removeClass('work-actived-mobile');
			body.removeClass('work-closing');
			$('html').removeClass('work-actived');
		}, 600);
		$(document).attr('title', 'The Charles - Full service creative and digital agency - NYC, SoHo');
		window.location.hash = '0';
	}
		
	projectLinks.each(function(){
		var projectLink = $(this),
			URL = projectLink.attr('href'),
			URL = URL.replace(siteURL, projectsURL),
			ID = URL.replace(projectsURL, ''),
			title = projectLink.children('.project-text').children('.title').html(),
			loadingAni = '<div class="loading-animation"><div class="loader9"></div></div>';
		
		console.log(URL);
		console.log(ID);
		
		if(pageID === ID){
			body.addClass('work-actived');
			$('html').addClass('work-actived');
			$('html').addClass('work-actived');
			if(mobileJS == true){
				body.addClass('work-actived-mobile');
			}
			$("#page-display").html(loadingAni);
			setTimeout(function(){
				body.addClass('work-loading');
			}, 100);
			$("#page-display").load(URL, function() {
				$(document).attr('title', title+' - The Charles - Full service creative and digital agency - NYC, SoHo');
				if(mobileJS == true){}
				else{$('.cycle-slideshow').cycle();}
				body.addClass('work-loaded');
				var xOut = $('.x-out');
				$('.x-out').click(closingWork);
			});
		}
			
		projectLink.click(function(ev){
			ev = ev || window.event;
			ev.preventDefault();
			
			var yScroll = $(window).scrollTop();
			
			window.location.hash = ID;
			window.scrollTo = yScroll;
			body.addClass('work-actived');
			$('html').addClass('work-actived');
			document.body.scrollTop= yScroll;
			
			if(mobileJS == true){
				body.addClass('work-actived-mobile');
			}
			$("#page-display").html(loadingAni);
			setTimeout(function(){
				body.addClass('work-loading');
			}, 100);
			$("#page-display").load(URL, function() {
				$(document).attr('title', title+' - The Charles - Full service creative and digital agency - NYC, SoHo');
				if(mobileJS == true){}
				else{$('.cycle-slideshow').cycle();}
				body.addClass('work-loaded');
				var xOut = $('.x-out');
				xOut.click(function(ev){
					ev = ev || window.event;
				    ev.preventDefault();
					closingWork();
				});
			});
		});
	});
});

// Mobile Navigation

var mobileNav = $('#mobile-navigation'),
	mobileClick = mobileNav.children('#hamburger-helper').children('.menu-btn'),
	mobileNavLink = mobileNav.children('.mobile-menu').children('a');

mobileClick.click(function(){
	mobileNav.toggleClass('active');
});
mobileNavLink.click(function(){
	mobileNav.toggleClass('active');
});



//Type Kit

	(function(d) {
		var config = {
		  kitId: 'tod3yws',
		  scriptTimeout: 3000
		},
	h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
	})(document);
  
//Instafeed
  
	var userFeed = new Instafeed({
	    get: 'user',
	    userId: 227974459,
	    resolution: 'standard_resolution',
	    limit: 12,
	    accessToken: '227974459.467ede5.b53d0453a7d04029850af67d064abc4d',
	    template: '<a href="{{link}}" style="background: url({{image}});" target="_blank"></a>'
	});
	
	userFeed.run();
	
