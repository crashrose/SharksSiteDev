<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!-- Suport IE8: media query, html5 -->
<?php if($yt->ieversion()==8) { ?>
	<script src="<?php echo $yt->templateurl().'js/modernizr.min.js' ?>" type="text/javascript"></script>
<?php } ?>

<!--[ if lt IE 9]>
<script src="<?php echo $yt->templateurl().'js/respond.min.js' ?>" type="text/javascript"></script>
<script src="<?php echo $yt->templateurl().'js/modernizr.min.js' ?>" type="text/javascript"></script>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"> </ script>
<[endif] -->

<?php
if($yt->getParam('enableGoogleAnalytics')=='1' && $yt->getParam('googleAnalyticsTrackingID')!='' ){ ?>
	<!--For param enableGoogleAnalytics-->
	<script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(["_setAccount", "<?php echo $yt->getParam('googleAnalyticsTrackingID')?>"]);
        _gaq.push(["_trackPageview"]);
        (function() {
        var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
        ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
<?php
} ?>