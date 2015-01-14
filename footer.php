<div class="clear"></div><?php require TEMPLATEPATH . '/footer-widgets.php'; ?>

</div><!-- #content -->

</div><!-- #primary -->

</div><!-- #main -->

<footer class="row" id="footer"><div class="col_12"><p><?php if ( get_option('smartestb_footer_text')) { echo get_option('smartestb_footer_text');} else { _e( 'Copyright &copy; ', 'storefront' ); echo ' ' . date('Y'); ?>&nbsp;<a href="<?php bloginfo('url');?>" title="<?php bloginfo('name');?>"><?php bloginfo('name');?>.</a> &nbsp;&nbsp; <span id="termsofuse"><a href="<?php bloginfo('url'); ?>/legal/terms-of-use/" title="Terms of Use">Terms of Use.</a> &nbsp;&nbsp; <a href="<?php bloginfo('url'); ?>/legal/privacy/" title="Privacy Policy">Privacy.</a> &nbsp;&nbsp; <a href="<?php bloginfo('url'); ?>/legal/terms-of-use/#code-license" title="Code License">Code License</a></span><?php } ?></p></div><p><span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=AzctciHKbSOQWkOTVOLeB01MkYSCW1T9XywH1flvn3BnfIcdjC4"></script></span></p>
</footer>

</div><!-- .container pad20vertical -->

<?php wp_footer();
if( is_single()) { ?><script type="text/javascript">jQuery(document).ready(function() {jQuery(".fancybox").fancybox({helpers : {title: {type: 'outside'}}});});</script><?php } ?></body></html>