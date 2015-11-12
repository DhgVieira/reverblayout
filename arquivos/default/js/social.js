// LOAD SOCIAL FILES JS ASYNC
// FACEBOOK
(function(d, s, id) {
            	var js, fjs = d.getElementsByTagName(s)[0];
            	if (d.getElementById(id)) return;
            	js = d.createElement(s); js.id = id;
            	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=237745386316222";
            	fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));


(function() {
      	var _fbq = window._fbq || (window._fbq = []);
      	if (!_fbq.loaded) {
      		var fbds = document.createElement('script');
      		fbds.async = true;
      		fbds.src = '//connect.facebook.net/en_US/fbds.js';
      		var s = document.getElementsByTagName('script')[0];
      		s.parentNode.insertBefore(fbds, s);
      		_fbq.loaded = true;
      	}
      	_fbq.push(['addPixelId', '533464170121834']);
      })();
      window._fbq = window._fbq || [];
      window._fbq.push(['track', 'PixelInitialized', {}]);
