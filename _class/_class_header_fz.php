<?php
class header
	{
	var $charcod = "UTF-8";
	/* var $charcod = "ISO-8859-1"; */
	var $title = '';
	var $google_id = ''; /* Ex: UA-12712904-10 */
	var $login_api = '';	
	
	function head()
		{
		global $LANG, $http, $style_add;
		$cr = chr(13).chr(10);
		$pth = $this->path;
		
		header ('Content-type: text/html; charset='.$this->charcod);
	
		$sx .= '<head>'.$cr;
    	$sx .= '<META HTTP-EQUIV=Refresh CONTENT="3600; URL='.$http.'logout.php">'.$cr;
		$sx .= '<meta http-equiv="Content-Type" content="text/html; charset='.$this->charcod.'" />';
		$sx .= '<meta name="google-site-verification" content="VZpzNVBfl5kOEtr9Upjmed96smfsO9p4N79DZT38toA" />'.$cr;		
        $sx .= '<meta name="description" content="">'.$cr;
        $sx .= '<link rel="shortcut icon" type="image/x-icon" href="'.$http.'favicon.ico" />'.$cr;
		$sx .= '<link rel="stylesheet" href="'.$http.'css/style_cabecalho.css">'.$cr;

		/* Style */
		$style = array('fz_style.css','fz_style_roboto.css','fz_style_menus.css');
		for ($r=0;$r < count($style);$r++)
				{ $sx .= '<link rel="STYLESHEET" type="text/css" href="'.$http.'css/'.$style[$r].'">'.$cr; }

		/* Style Additional */
		if (isset($style_add)) {
		for ($r=0;$r < count($style_add);$r++)
				{ $sx .= '<link rel="STYLESHEET" type="text/css" href="'.$http.'css/'.$style_add[$r].'">'.$cr; }
		}

		/* Java script */
		$js = array('jquery.js'); 
		for ($r=0;$r < count($js);$r++)
			{ $sx .= '<script type="text/javascript" src="js/'.$js[$r].'"></script>'.$cr; }


		/* Icone */
		$sx .= '<link rel="shortcut icon" href="http://www.brapci.inf.br/favicon.png" />'.$cr;
			
		$sx .= '<script language="JavaScript" type="text/javascript" src="'.$http.'js/jquery-1.7.1.js"></script>'.$cr;
    	$sx .= '<script language="JavaScript" type="text/javascript" src="'.$http.'js/jquery.maskedinput.js"></script>'.$cr;
    	$sx .= '<title>'.$this->title.'</title>'.$cr;
		$sx .= '</head>';
		
		$sx .= "
		<script>
  			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			  ga('create', '".$this->google_id."', 'pucpr.br');
  			ga('send', 'pageview');
		</script>		
		";
		
		$LANG='pt_BR';
		return($sx);
		}
	function cab()
		{
			$sx = $this->head();
			$sx .= $this->api_google;
			return($sx);
		}
		
	/* Necessita de um site que gere RSS (ex. Flick)
	 * */	
	function banner($url_rss='',$width=200,$height=200)
	{
		$sx = '
		<script src="//www.google.com/jsapi" type="text/javascript"></script>
    	<script src="//www.google.com/uds/solutions/slideshow/gfslideshow.js"
            type="text/javascript"></script>
		
		<script>
		
		 google.load("feeds", "1");
	    
		    function OnLoad() {
		      var feed  = "'.$url_rss.'";
		      var options = {
		        displayTime:500,
		        transistionTime:200,
		        scaleImages:true,
		        fullControlPanel : true
		      };
		      var ss = new GFslideShow(feed, "picasaSlideshow", options);
		    }
		    
		    google.setOnLoadCallback(OnLoad);
			</script>
	';
		$sx .= '<div id="picasaSlideshow" class="gslideshow" style=" width:  '.$width.'px;
        height: '.$height.'px;"><div class="feed-loading">Loading...</div></div>';
		return($sx);
	}	
	}
?>