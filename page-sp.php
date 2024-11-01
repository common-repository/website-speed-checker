<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if( is_admin() ) 
{
	if(isset($_POST['pf_submit'])) 	{
		if (isset( $_POST['pf_added'] ) && wp_verify_nonce($_POST['pf_added'], 'add-item') ) {
			function checkPageSpeed($url) { 
				if (function_exists('file_get_contents')) 
				{    
					$result = @file_get_contents($url);
				}    
				  if ($result == '') 
				  {    
					  $ch = curl_init();    
					  $timeout = 2400;    
					  curl_setopt($ch, CURLOPT_URL, $url);    
					  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
					  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
					  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
					  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
					  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);    
					  $result = curl_exec($ch);    
					  curl_close($ch);    
					}  
					return $result;    
				}  

				$myKEY = "AIzaSyAb3Rv-nzJ0unBKmIeRVfryEvp_n8_U6HU";  
				$url = esc_url($_POST['txt_url']);
				$stategy	= sanitize_text_field($_POST['selct_strategy']);
				$url_req = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url='.$url.'&screenshot=true&&strategy='.$stategy.'&key='.$myKEY;  
				$results = checkPageSpeed($url_req);  				
				$Result_Data =	json_decode($results,true);  
				?>
		<?php }
		else
		{
			wp_die('Our Site is protected!!');
		}
		
	}
	?>

	<div class="wrap">
	<h2>Enter URL to Check Speed </h2>
		<form method="post" action="">
			 <?php wp_nonce_field('add-item','pf_added'); ?>
			<table class="form-table" style="width: 100%">
				<tr valign="top">
					<th scope="row">Enter URL</th>
					<td>
						<input name="txt_url" class="text" type="text" placeholder="URL" style="width:50%!important;" 
						VALUE="<?php if(isset($Result_Data)) { echo  $Result_Data['id']; } else {echo site_url(); }?>">
						
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Strategy</th>
					<td>
						<select name="selct_strategy">
							<option value="desktop">Desktop</option>
							<option value="mobile">Mobile</option>
						</select>
						
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"></th>
					<td>
						<input type="submit" name="pf_submit" id="submit" class="button button-primary" value="Check Now" >
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	
	
	<?php if(isset($Result_Data)) { ?>
					<?php if($Result_Data[responseCode] == 200){?>
					<p style="font-weight: bold;font-size: 16px;" class="score value warning">
						Page Score :<span class="hilight-nub"> <?php echo $Result_Data['ruleGroups']['SPEED']['score']; ?> / 100</span>
					</p>
					 <div class="clearfix"></div>
					<div class="score-button">
						<?php if(isset($Result_Data['pageStats']['numberResources'])) {?>
							<li class="hvr-wobble-vertical">Number Resources <?php echo $Result_Data['pageStats']['numberResources'] ; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['numberHosts'])) {?>
							<li class="hvr-wobble-vertical">Number Hosts <?php echo $Result_Data['pageStats']['numberHosts']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['totalRequestBytes'])) {?>
							<li class="hvr-wobble-vertical">Total Request Bytes <?php echo $Result_Data['pageStats']['totalRequestBytes']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['numberStaticResources'])) {?>
							<li class="hvr-wobble-vertical">Number Static Resources <?php echo $Result_Data['pageStats']['numberStaticResources']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['htmlResponseBytes'])) {?>
						<li class="hvr-wobble-vertical">HTML Response Bytes <?php echo $Result_Data['pageStats']['htmlResponseBytes']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['textResponseBytes'])) {?>
						<li class="hvr-wobble-vertical">Text Response Bytes <?php echo $Result_Data['pageStats']['textResponseBytes']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['cssResponseBytes'])) {?>
						<li class="hvr-wobble-vertical">CSS Response Bytes <?php echo $Result_Data['pageStats']['cssResponseBytes']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['imageResponseBytes'])) {?>
						<li class="hvr-wobble-vertical">Image Response Bytes <?php echo $Result_Data['pageStats']['imageResponseBytes']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['javascriptResponseBytes'])) {?>
						<li class="hvr-wobble-vertical">Javascript Response Bytes <?php echo $Result_Data['pageStats']['javascriptResponseBytes']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['otherResponseBytes'])) {?>
						<li class="hvr-wobble-vertical">Other Response Bytes <?php echo $Result_Data['pageStats']['otherResponseBytes']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['numberJsResources'])) {?>
						<li class="hvr-wobble-vertical">Number Js Resources <?php echo $Result_Data['pageStats']['numberJsResources']; ?></li>
						<?php } ?>
						
						<?php if(isset($Result_Data['pageStats']['numberCssResources'])) {?>
						<li class="hvr-wobble-vertical">Number Css Resources <?php echo $Result_Data['pageStats']['numberCssResources']; ?></li>
						<?php } ?>
						
					</div>
					
				
					
				  <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn">GIZIP Compression</button>
					<div id="id01" class="w3-modal">
					<div class="w3-modal-content">
					  <div class="w3-container">
						<span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn">&times;</span>
						
							<h1 class="title-popup">Enable Compression For Apache</h1>
							<div class="content-popup">
										<p>Please Add Below Code in your .htaccess file on your wordpress root directory.</p>
										<p>Note: Before Add this script on .htaccess file please take your .htaccess backup first.</p>
									   
											<p>&lt;IfModule mod_deflate.c&gt;</br>
											  # Compress HTML, CSS, JavaScript, Text, XML and fonts</br>
											  AddOutputFilterByType DEFLATE application/javascript</br>
											  AddOutputFilterByType DEFLATE application/rss+xml</br>
											  AddOutputFilterByType DEFLATE application/vnd.ms-fontobject</br>
											  AddOutputFilterByType DEFLATE application/x-font</br>
											  AddOutputFilterByType DEFLATE application/x-font-opentype</br>
											  AddOutputFilterByType DEFLATE application/x-font-otf</br>
											  AddOutputFilterByType DEFLATE application/x-font-truetype</br>
											  AddOutputFilterByType DEFLATE application/x-font-ttf</br>
											  AddOutputFilterByType DEFLATE application/x-javascript</br>
											  AddOutputFilterByType DEFLATE application/xhtml+xml</br>
											  AddOutputFilterByType DEFLATE application/xml</br>
											  AddOutputFilterByType DEFLATE font/opentype</br>
											  AddOutputFilterByType DEFLATE font/otf</br>
											  AddOutputFilterByType DEFLATE font/ttf</br>
											  AddOutputFilterByType DEFLATE image/svg+xml</br>
											  AddOutputFilterByType DEFLATE image/x-icon</br>
											  AddOutputFilterByType DEFLATE text/css</br>
											  AddOutputFilterByType DEFLATE text/html</br>
											  AddOutputFilterByType DEFLATE text/javascript</br>
											  AddOutputFilterByType DEFLATE text/plain</br>
											  AddOutputFilterByType DEFLATE text/xml</br>
												</br>
											  # Remove browser bugs (only needed for really old browsers)</br>
											  BrowserMatch ^Mozilla/4 gzip-only-text/html</br>
											  BrowserMatch ^Mozilla/4\.0[678] no-gzip</br>
											  BrowserMatch \bMSIE !no-gzip !gzip-only-text/html</br>
											  Header append Vary User-Agent</br>
											  &lt;/IfModule&gt;	</p>
											  
											  
										
										<h1 class="title-popup">Enable compression on NGINX Webservers</h1>
										
										<p>To enable compression in NGINX you will need to add the following code to your config file</p>
										<p>gzip on;</br>
											gzip_comp_level 2;</br>
											gzip_http_version 1.0;</br>
											gzip_proxied any;</br>
											gzip_min_length 1100;</br>
											gzip_buffers 16 8k;</br>
											gzip_types text/plain text/html text/css application/x-javascript text/xml application/xml application/xml+rss text/javascript;</br>
											# Disable for IE < 6 because there are some known problems</br>
											gzip_disable "MSIE [1-6].(?!.*SV1)";</br>
											# Add a vary header for downstream proxies to avoid sending cached gzipped files to IE6</br>
											gzip_vary on;</br>
											Enable co</br>
										</p>
										</div>
						
					  </div>
					</div>
				  </div>
					
								  
				  <button onclick="document.getElementById('id02').style.display='block'" class="w3-btn">Leverage Browser Caching</button>
					  <div id="id02" class="w3-modal">
						<div class="w3-modal-content">
						  <div class="w3-container">
							<span onclick="document.getElementById('id02').style.display='none'" class="w3-closebtn">&times;</span>
							<h1 class="title-popup">Enable Leverage Browser Caching</h1>
													<div class="content-popup-2">
													<p>To enable browser caching you need to add expiry HTTP headers using below cahing parameter.</p>
													<p>
														## EXPIRES CACHING ##</br>
														<IfModule mod_expires.c></br>
														ExpiresActive On</br>
														ExpiresByType image/jpg "access plus 1 year"</br>
														ExpiresByType image/jpeg "access plus 1 year"</br>
														ExpiresByType image/gif "access plus 1 year"</br>
														ExpiresByType image/png "access plus 1 year"</br>
														ExpiresByType text/css "access plus 1 month"</br>
														ExpiresByType application/pdf "access plus 1 month"</br>
														ExpiresByType text/x-javascript "access plus 1 month"</br>
														ExpiresByType application/x-shockwave-flash "access plus 1 month"</br>
														ExpiresByType image/x-icon "access plus 1 year"</br>
														ExpiresDefault "access plus 2 days"</br>
														</IfModule></br>
														## EXPIRES CACHING ##</br>
														</p>
						  </div>
						</div>
					  </div>
				  </div>
				  
				  <button onclick="document.getElementById('id03').style.display='block'" class="w3-btn">Remove Query String</button>
				  <div id="id03" class="w3-modal">
					<div class="w3-modal-content">
					  <div class="w3-container">
						<span onclick="document.getElementById('id03').style.display='none'" class="w3-closebtn">&times;</span>
						<h1 class="title-popup">Remove Query String from Static Resources</h1>
							<div class="content-popup-2">
							<p>Please copy below code in your themes function.php file.</p>
							<p>
								/*** Remove Query String from Static Resources ***/</br>
								function remove_cssjs_ver( $src ) {</br>
								 if( strpos( $src, '?ver=' ) )</br>
								 $src = remove_query_arg( 'ver', $src );</br>
								 return $src;</br>
								}</br>
								add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );</br>
								add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );</br>

								function _remove_script_version( $src ){</br>
									$parts = explode( '?ver', $src );</br>
										return $parts[0];</br>
								}</br>
								add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );</br>
								add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );</br>
							</p>	
					  </div>
						</div>
					  </div>
				  </div>
				  
				  <button onclick="document.getElementById('id03').style.display='block'" class="w3-btn">Defer Javascripts</button>
				  <div id="id03" class="w3-modal">
					<div class="w3-modal-content">
					  <div class="w3-container">
						<span onclick="document.getElementById('id03').style.display='none'" class="w3-closebtn">&times;</span>
						<h1 class="title-popup"> How to make Defer Javascripts </h1>
											<div class="content-popup-2">
												<p>Add below function in your function.php file, replace the javascript name with your javascript file.</p>
												<p>function defer_js_async($tag){</br>
												$scripts_to_defer = array('js_composer_front.js','jquerymin.js');</br>
												foreach($scripts_to_defer as $defer_script){</br>
													if(true == strpos($tag, $defer_script ) )</br>
													return str_replace( ' src', ' defer="defer" src', $tag );	</br>
												}</br>
												return $tag;</br>
												}</br>
												add_filter( 'script_loader_tag', 'defer_js_async', 10 ); </br>
											</p>
											</div>
								</div>
						</div>
					</div>
				  
					
					
						


						
						
							
					 
					<div class="wpaer-content">	
					<div class="accordion-content">
						
						<button class="accordion">
							<?php if($Result_Data['formattedResults']['ruleResults']['EnableGzipCompression']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
							<?php } ?>
							<?php echo $Result_Data['formattedResults']['ruleResults']['EnableGzipCompression']['localizedRuleName'];?>
							
						</button>
						
						<div class="panel">
						<?php 
						@$Enable_Com_title	=	$Result_Data['formattedResults']['ruleResults']['EnableGzipCompression'] ['summary']['format']['urlBlocks'][0]['header']['format'];
						@$Enable_Com_Link = $Result_Data['formattedResults']['ruleResults']['EnableGzipCompression'] ['summary']['format']['urlBlocks'][0]['header']['format']['args'][0]['value'];
						@$Enable_Com_size	= $Result_Data['formattedResults']['ruleResults']['EnableGzipCompression'] ['summary']['format']['urlBlocks'][0]['header'
						  ]['format']['args'][1]['value'];
						@$Enable_Com_per	= $Result_Data['formattedResults']['ruleResults']['EnableGzipCompression'] ['summary']['format']['urlBlocks'][0]['header']['format']['args'][2]['value']; ?>
						  
						  
						<?php if($Result_Data['formattedResults']['ruleResults']['EnableGzipCompression']['ruleImpact'] > 0 ) { ?> 
						
						<p class=""><b><?php echo $Result_Data['formattedResults']['ruleResults']['EnableGzipCompression'] ['summary']['format'];?></b></p>
						<?php $urlsite_20 = "https://developers.google.com/speed/docs/insights/EnableCompression";?> 
						  <p><a href="<?php echo esc_url( $urlsite_20 ); ?>" target="_blank">Enable compression </a> for the following resources to reduce their transfer size by <?php echo $Enable_Com_size;?> (<?php echo $Enable_Com_per;?> reduction).</p>
						  
						  <?php 
						  $Enable_Url_Array	=	$Result_Data['formattedResults']['ruleResults']['EnableGzipCompression']['urlBlocks'][0]['urls'];
						  if(isset($Enable_Url_Array))
						  {
							  foreach($Enable_Url_Array as $k=>$v)
							  {
								  $EnableURL	=		$v['result']['args'][0]['value'] ;
								  $EnableSize	=		$v['result']['args'][1]['value'] ;
								  $EnablePercentage	=		$v['result']['args'][2]['value'] ;
								  echo "<p>Compressing ".$EnableURL." could save ".$EnableSize." (".$EnablePercentage." reduction).</p>" ;	
							  }
						  }		
						 ?>
						
						<?php } else 
						{
							$urlsite_1 = "https://developers.google.com/speed/docs/insights/EnableCompression";?> 
						
							<p><b>You have compression enabled. Learn more about <a href="<?php echo esc_url( $urlsite_1 );?>" target="_blank">enabling compression.</a></b></p>
							
						<?php } ?>
						</div>

						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['LeverageBrowserCaching']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
							
							<?php echo @$Result_Data['formattedResults']['ruleResults']['LeverageBrowserCaching']['localizedRuleName'];?>
						</button>
						<div class="panel">
						
						<?php if($Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['ruleImpact'] > 0 ) { ?> 
						
						  <p><b><?php echo @$Result_Data['formattedResults']['ruleResults']['LeverageBrowserCaching']['summary']['format'];?></b></p>
						  <?php 
						  $urlsite_2 = "https://developers.google.com/speed/docs/insights/LeverageBrowserCaching";
						  ?> 
						  <p><a href="<?php echo esc_url( $urlsite_2 ); ?>" target="_blank">Leverage browser caching </a> for the following cacheable resources:
						  <?php 
						  $Leverage_Array	=	@$Result_Data['formattedResults']['ruleResults']['LeverageBrowserCaching']['urlBlocks'][0]['urls'];
						  if(isset($Leverage_Array))
						  {
						  foreach($Leverage_Array as $k=>$v)
						  {
							  $EnableURL	=		$v['result']['args'][0]['value'] ;
							  echo "<p>".$EnableURL."(expiration not specified)</p>" ;	
						  } }?>
						 
						<?php } else { 
						$urlsite_3 = "https://developers.google.com/speed/docs/insights/LeverageBrowserCaching";
						?>
						<p><b>You have enabled browser caching. Learn more about <a href="<?php echo esc_url( $urlsite_3 ); ?>" target="_blank">browser caching recommendations.</a></b></p>
						<?php } ?>
						</div>

						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['ruleImpact'] <= 0 ) { ?> 
						<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
							<?php echo @$Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['localizedRuleName'];?>
						</button>
						<div class="panel">
						<?php if($Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['ruleImpact'] > 0 ) { ?> 
						
						<?php 
							$BlockJs	=	$Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['summary']['args'][0]['value'];
							$BlockCSS	=	$Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['summary']['args'][1]['value'];
						?>
						  <p><b>Your page has <?php echo $BlockJs;?> blocking script resources and <?php echo $BlockCSS;?> blocking CSS resources. This causes a delay in rendering your page.</b></p>
						  
						  <p>
						  <?php echo @$Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['urlBlocks'][0]['header']['format'];?>
						  </p>
						  
						  <p><b>Remove render-blocking JavaScript</b></p>
						  
						  <?php 
						  
						  $BlockArray 	=	$Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['urlBlocks'];
						  $JScript_Dil	=	$Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['urlBlocks'][1]['urls'];
						  $CSS_Dil	=	$Result_Data['formattedResults']['ruleResults']['MinimizeRenderBlockingResources']['urlBlocks'][2]['urls'];
						  
						  if(isset($JScript_Dil))
						  {
							  foreach($JScript_Dil as $k=>$v)
							  {
									
									 $jvaribanle	=	$v['result']['args'][0]['value'];
									echo '<p>' .$jvaribanle . '</p>';
									
							  }
						  }
						  ?>
						  
						  <p><b>Optimize CSS Delivery of the following:</b> </p>
						  
						  <?php 
						  if(isset($CSS_Dil))
						  {
							  foreach($CSS_Dil as $k=>$v)
							  {
									$CSSvaribale	=	$v['result']['args'][0]['value'];
									echo '<p>' .$CSSvaribale . '</p>';
							  }
						  }
						  ?>
						  
						<?php } else { 
						$urlsite_4 = "https://developers.google.com/speed/docs/insights/BlockingJS";
						?>
							<p><b>You have no render-blocking resources. Learn more about <a href="<?php echo esc_url( $urlsite_4 ); ?>" target="_blank">removing render-blocking resources </a>.</b></p>
						<?php } ?>
						</div>
						
						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['OptimizeImages']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
							<?php echo @$Result_Data['formattedResults']['ruleResults']['OptimizeImages']['localizedRuleName'];?>
						</button>
						<div class="panel">
						
						<?php if($Result_Data['formattedResults']['ruleResults']['OptimizeImages']['ruleImpact'] > 0 ) { ?> 
						
							<p><b><?php echo @$Result_Data['formattedResults']['ruleResults']['OptimizeImages']['summary']['format'];?></b></p>
							
							<?php 
							$opt_link =	$Result_Data['formattedResults']['ruleResults']['OptimizeImages']['urlBlocks'][0]['header']['args'][0]['value'];
							$opt_size =	$Result_Data['formattedResults']['ruleResults']['OptimizeImages']['urlBlocks'][0]['header']['args'][1]['value'];
							$opt_per =	$Result_Data['formattedResults']['ruleResults']['OptimizeImages']['urlBlocks'][0]['header']['args'][2]['value'];
								
							?>
							
							<p><a href="<?php echo $opt_link;?>">Optimize the following images </a> to reduce their size by <?php echo $opt_size;?> (
							<?php echo $opt_per;?> reduction)</p>
							
							
							<?php 
							
							$optimize_array = @$Result_Data['formattedResults']['ruleResults']['OptimizeImages']['urlBlocks'][0]['urls'];
							if(isset($optimize_array))
							{
								foreach($optimize_array as $k=>$v)
								{
									
									 $CSS_Dil	=	$v['result']['args'][0]['value'];
									echo '<p>' .$CSS_Dil . '</p>';
									
							  }
							}
						  
						  ?>
						<?php } else {
						$urlsite_5 = "https://developers.google.com/speed/docs/insights/OptimizeImages";	
						?>
						
						<p><b> Your images are optimized. Learn more about <a href="<?php echo esc_url( $urlsite_5 ); ?>" target="_blank">optimizing images</a></b>.</p>
						
						<?php }	 ?>
							
						</div>
						
						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['MainResourceServerResponseTime']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
							<?php echo @$Result_Data['formattedResults']['ruleResults']['MainResourceServerResponseTime']['localizedRuleName'];?>
						</button>
						<div class="panel">
						
						<?php if($Result_Data['formattedResults']['ruleResults']['MainResourceServerResponseTime']['ruleImpact'] > 0 ) { ?> 
						
						<?php 
						$respo_time	=	$Result_Data['formattedResults']['ruleResults']['MainResourceServerResponseTime']['urlBlocks'][0]['header']['args'][0]['value'];
						$urlsite_6 = "https://developers.google.com/speed/docs/insights/Server";	
						?>
						<p>In our test, your server responded in <?php echo $respo_time;?>. There are many factors that can slow down your server response time. <a href="<?php echo esc_url( $urlsite_6 ); ?>" target="_blank">Please read our recommendations</a> to learn how you can monitor and measure where your server is spending the most time.</p>
						
						<?php } else {
							$urlsite_7 = "https://developers.google.com/speed/docs/insights/Server";
							?>

						<p><b>Your server responded quickly. Learn more about <a href="<?php echo esc_url( $urlsite_7 ); ?>" target="_blank">server response time optimization.</a></b></p>
						
						<?php } ?>
						
						</div>
						
						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['MinifyCss']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
								<?php echo @$Result_Data['formattedResults']['ruleResults']['MinifyCss']['localizedRuleName'];?>
						</button>
						<div class="panel">
						
						<?php if($Result_Data['formattedResults']['ruleResults']['MinifyCss']['ruleImpact'] > 0 ) { ?> 
						
						<p><b><?php echo $Result_Data['formattedResults']['ruleResults']['MinifyCss']['summary']['format'];?></b></p>
						
						<?php 
						$Minify_size	=	$Result_Data['formattedResults']['ruleResults']['MinifyCss']['urlBlocks'][0]['header']['args'][1]['value'];
						$Minify_per	=	$Result_Data['formattedResults']['ruleResults']['MinifyCss']['urlBlocks'][0]['header']['args'][2]['value'];
						
						$urlsite_8 = "https://developers.google.com/speed/docs/insights/MinifyResources";
						
						?>
						<p><a href="<?php echo esc_url( $urlsite_8 ); ?>" target="_blank">Minify CSS</a> for the following resources to reduce their size by <?php echo $Minify_size;?> (<?php echo $Minify_per;?> reduction).</p>
						
						<?php 
						$minify_array = @$Result_Data['formattedResults']['ruleResults']['MinifyCss']['urlBlocks'][0]['urls'];
						if(isset($minify_array))
							{
								foreach($minify_array as $k=>$v)
								{
									
									$CSS_URL	=	$v['result']['args'][0]['value'];
									$CSS_s	=	$v['result']['args'][1]['value'];
									$CSS_per	=	$v['result']['args'][1]['value'];
									 
									echo '<p>Minifying '.$CSS_URL.' could save '.$CSS_s.' ('.$CSS_per.' reduction)</p>';
									
								}
							}	
						?>
						
						<?php } else { 
						$urlsite_9 = "https://developers.google.com/speed/docs/insights/MinifyResources";
						?>
						<p><b>Your CSS is minified. Learn more about <a href="<?php echo esc_url( $urlsite_9 ); ?>" target="_blank">minifying CSS</a>.</b></p>
							
						<?php } ?>
						
						</div>
						
						
						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['MinifyHTML']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
								<?php echo @$Result_Data['formattedResults']['ruleResults']['MinifyHTML']['localizedRuleName'];?>
						</button>
						
						<div class="panel">
						
						<?php if($Result_Data['formattedResults']['ruleResults']['MinifyHTML']['ruleImpact'] > 0 ) { ?> 
						
						<p><b><?php echo $Result_Data['formattedResults']['ruleResults']['MinifyHTML']['summary']['format'];?></b></p>
						
						<?php 
						$HTMinify_size	=	$Result_Data['formattedResults']['ruleResults']['MinifyHTML']['urlBlocks'][0]['header']['args'][1]['value'];
						$HTMinify_per	=	$Result_Data['formattedResults']['ruleResults']['MinifyHTML']['urlBlocks'][0]['header']['args'][2]['value'];
						$urlsite_10 = "https://developers.google.com/speed/docs/insights/MinifyResources";
						?>
						
						<p><a href="<?php echo esc_url( $urlsite_10 ); ?>" target="_blank">Minify HTML </a> for the following resources to reduce their size by <?php echo $HTMinify_size;?> (<?php echo $HTMinify_per;?> reduction).</p>
						
						<?php 
						$minifyC_array = @$Result_Data['formattedResults']['ruleResults']['MinifyHTML']['urlBlocks'][0]['urls'];
						if(isset($minifyC_array))
						{
							foreach($minifyC_array as $k=>$v)
							{
								
								$HTML_URL	=	$v['result']['args'][0]['value'];
								$HTML_s	=	$v['result']['args'][1]['value'];
								$HTML_per	=	$v['result']['args'][1]['value'];
								 
								echo '<p>Minifying '.$HTML_URL.' could save '.$HTML_s.' ('.$HTML_per.' reduction)</p>';
								
							}
						}
						?>
						
						<?php } else { 
						$urlsite_11 = "https://developers.google.com/speed/docs/insights/MinifyResources";
						?>
						
							<p><b>Your HTML is minified. Learn more about <a href="<?php echo esc_url( $urlsite_11 ); ?>" target="_blank">minifying HTML</a>.</b></p>
							
						<?php } ?>
						
						
						</div>
						
						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['AvoidLandingPageRedirects']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
								<?php echo @$Result_Data['formattedResults']['ruleResults']['AvoidLandingPageRedirects']['localizedRuleName'];?>
						</button>
						
						<div class="panel">
						
						<?php if($Result_Data['formattedResults']['ruleResults']['AvoidLandingPageRedirects']['ruleImpact'] > 0 ) { ?> 
						
						<?php $Total_Redi	=	$Result_Data['formattedResults']['ruleResults']['AvoidLandingPageRedirects']['summary']['args'][0]['value'];?>
						
						<p><b>Your page has <?php echo $Total_Redi; ?> redirects. Redirects introduce additional delays before the page can be loaded.</b></p>
						
						<p>Avoid landing page redirects for the following chain of redirected URLs.</p>
						
						<?php 
						$re_array = @$Result_Data['formattedResults']['ruleResults']['AvoidLandingPageRedirects']['urlBlocks'][0]['urls'];
						if(isset($re_array))
						{
							foreach($re_array as $k=>$v)
							{
								
								$Reds_URL	=	$v['result']['args'][0]['value'];
								echo '<p>'.$Reds_URL.'</p>';
								
							}
						}
						?>
						
						
						<?php } else { ?>
						<?php $urlsite_17 = "https://developers.google.com/speed/docs/insights/AvoidRedirects"; ?>
						<p><b>Your page has no redirects. Learn more about <a href="<?php echo esc_url( $urlsite_17 ); ?>" target="_blank">avoiding landing page redirects </a>.</b></p>
						<?php } ?>
						</div>
						
						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['MinifyJavaScript']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
								<?php echo @$Result_Data['formattedResults']['ruleResults']['MinifyJavaScript']['localizedRuleName'];?>
						</button>
						
						<div class="panel">
						<?php $urlsite_13 = "https://developers.google.com/speed/docs/insights/MinifyResources"; ?>
						<p><b>Your JavaScript content is minified. Learn more about <a href="<?php echo esc_url( $urlsite_13 ); ?>" target="_blank">minifying JavaScript</a>.</b></p>
						
						</div>
						
						<button class="accordion">
						<?php if($Result_Data['formattedResults']['ruleResults']['PrioritizeVisibleContent']['ruleImpact'] <= 0 ) { ?> 
							<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'/assets/check-mark-2-xxl.png'); ?> ">
						<?php } ?>
								<?php echo @$Result_Data['formattedResults']['ruleResults']['PrioritizeVisibleContent']['localizedRuleName'];?>
						</button>
						
						<div class="panel">
						<?php $urlsite_12 = "https://developers.google.com/speed/docs/insights/PrioritizeVisibleContent"; ?>
						<p><b>You have the above-the-fold content properly prioritized. Learn more about <a href="<?php echo esc_url( $urlsite_12 ); ?>
						" target="_blank">prioritizing visible content</b></a>.</p>
						
						</div>
						</div>
						
						
					   <div class="screenshot desktop">
						   <?php $data_img	=	 str_replace ("_", "/", $Result_Data['screenshot']['data']);
								$GetImage = str_replace("-", "+", $data_img);
								echo '<img src="data:image/jpeg;base64,'.$GetImage.'" />';?>
						</div> 
					</div>
					
					
					<script>
						var acc = document.getElementsByClassName("accordion");
						var i;
						for (i = 0; i < acc.length; i++) {
							acc[i].onclick = function(){
								this.classList.toggle("active");
								this.nextElementSibling.classList.toggle("show");
							}
						}
					</script>
					<?php }	else { echo '<p style="font-weight: bold;font-size: 16px;" class="score value warning">Error : '.$Result_Data['error']['message'].'</p>'; } ?>
<?php } } else {?> 
	<h3>You don't have permission only Admin have right to use this plugin.</h3>
<?php } ?>	