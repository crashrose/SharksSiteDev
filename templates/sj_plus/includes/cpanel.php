<?php 
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2012 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="cpanel_wrapper" style="direction:ltr">
    <div class="accordion row-fluid" id="ytcpanel_accordion">
        <div class="cpanel-head">Template Settings</div>
    	<!--Body-->
        <div class="accordion-group cpnel-theme">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_1">Theme <i class="icon-chevron-down"></i></a>
				
            </div>
            <div id="ytitem_1" class="accordion-theme collapse in">
                <div class="accordion-inner clearfix">
                    <!-- Color -->
                    <h4 class="clear" style="padding:0;"><span>Color</span></h4>
                    <div class="fs-desc">For each color, the params below will give default values</div>
                    <div class="cpanel-theme-color">
                        <div class="inner clearfix">
                            <span title="Blue"    class="theme-color blue<?php echo ($templateColor=='blue')?' active':'';?>">Blue</span>
                            <span title="Red"     class="theme-color red<?php echo ($templateColor=='red')?' active':'';?>">Red</span>
                            <span title="Oranges" class="theme-color oranges<?php echo ($templateColor=='oranges')?' active':'';?>">Oranges</span>
			    <span title="Green"   class="theme-color green<?php echo ($templateColor=='green')?' active':'';?>">Green</span>
			    <span title="Purple"  class="theme-color purple<?php echo ($templateColor=='purple')?' active':'';?>">Purple</span>
			    <span title="Pink"  class="theme-color pink<?php echo ($templateColor=='pink')?' active':'';?>">Pink</span>
                        </div>
                    </div>
                    <!-- Body -->
                    <h4 class="clear"><span>Body</span></h4>
                    <div class="span4 first cp-item body-backgroud-color">
                        <span>Background Color</span>
                        <div class="inner">
                        	<input type="text" value="<?php echo $yt->getParam('bgcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_bgcolor" maxlength="7">
                        </div>
                    </div>
                    <div class="span4 cp-item link-color">
                        <span>Link Color</span>
                        <div class="inner">
                        	<input type="text" value="<?php echo $yt->getParam('linkcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_linkcolor" maxlength="7">
                        </div>
                    </div>
                    <div class="span4 cp-item text-color">
                        <span>Text Color</span>
                        <div class="inner">
                        	<input type="text" value="<?php echo $yt->getParam('textcolor'); ?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_textcolor" maxlength="7">
                        </div>
                    </div>
                    <!-- Header -->
                    <h4 class="clear"><span>Header</span></h4>
                    <div class="span4 first cp-item header-backgroud-color">
                        <span>Background Color</span>
                        <div class="inner">
                            <input type="text" value="<?php echo $yt->getParam('header-bgcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_header-bgcolor" maxlength="7">
                        </div>
                    </div>
                    <div class="span8 cp-item header-backgroud-image">
                        <span>Background Image</span>
                        <div class="inner">
                            <?php
                            $path = JPATH_ROOT.'/templates/'.$yt->template.'/images/pattern/header';
                            $files = JFolder::files($path, '.png'); 
                            foreach($files as $file) {
                                $file = JFile::stripExt($file); ?>
                                <a href="#yt_header" title="<?php echo $file; ?>" class="pattern <?php echo $file; ?><?php echo ($yt->getParam('header-bgimage')==$file)?' active':''?>"><?php echo $file; ?></a>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="ytcpanel_header-bgimage" value="<?php echo $yt->getParam('header-bgimage'); ?>"/>
                        </div>
                    </div>
                   <div class="row-fluid clear">
						<!-- Footer -->
						<h4 class="clear"><span>Footer</span></h4>
						<div class="span4 first">
							<div class="cp-item footer-backgroud-color">
								<span>Background Color</span>
								<div class="inner">
									 <input type="text" value="<?php echo $yt->getParam('footer-bgcolor');?>" autocomplete="off" size="7" class="color-picker miniColors" name="ytcpanel_footer-bgcolor" maxlength="7">
								</div>
							</div>
						</div>
						 
						<div class="span8 cp-item footer-backgroud-image">
							<span>Background Image</span>
							<div class="inner">
								<?php
								$path = JPATH_ROOT.'/templates/'.$yt->template.'/images/pattern/footer';
								$files = JFolder::files($path, '.png'); 
								foreach($files as $file) {
									$file = JFile::stripExt($file); ?>
									<a href="#yt_footer" title="<?php echo $file; ?>" class="pattern <?php echo $file; ?><?php echo ($yt->getParam('footer-bgimage')==$file)?' active':''?>"><?php echo $file; ?></a>
									<?php
								}
								?>
								<input type="hidden" name="ytcpanel_footer-bgimage" value="<?php echo $yt->getParam('footer-bgimage'); ?>"/>
							</div>
						</div>
						
					</div> 
				</div>
            </div>
        </div>
        
        <!-- Layouts -->
        <div class="accordion-group cpanel-layout">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_2">
                Layout <i class="icon-chevron-down"></i>
                </a>
            </div>
            <div id="ytitem_2" class="accordion-body collapse">
                <div class="accordion-inner clearfix">
                	
                    <div class="span6 first cp-item footer-backgroud-color">
                        <span>Select layout</span>
                        <div class="inner">
                        	<select onchange="javascript: onCPApply();" name="ytcpanel_templateLayout" class="cp_select">
                            	<?php 
								$path = JPATH_ROOT.'/templates/'.$yt->template.'/layouts';
								$files = JFolder::files($path, '', false, false, array('variations.xml')); 
								foreach($files as $file) {
									$file = JFile::stripExt($file); ?>
                                    <option value="<?php echo $file; ?>"<?php echo ($layout==$file)?' selected="selected"':'';?>><?php echo $file; ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<!-- Features -->
        <div class="accordion-group cpanel-features">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_3">
                Menu <i class="icon-chevron-down"></i>
                </a>
            </div>
            <div id="ytitem_3" class="accordion-body collapse">
                <div class="accordion-inner clearfix">
                    <!-- Mainmenu -->
                    <div class="span6 first cp-item body-fontfamily">
                        <span>Select menu </span>
                        <div class="inner">
                            <select onchange="javascript: onCPApply();" name="ytcpanel_menustyle" class="cp_select">
                                <option value="mega"<?php echo ($menustyle=='mega')?' selected="selected"':'';?>>Mega Menu</option>
                                <option value="moo"<?php echo ($menustyle=='moo')?' selected="selected"':'';?>>Moo Menu</option>
                                <option value="basic"<?php echo ($menustyle=='basic')?' selected="selected"':'';?>>CSS Menu</option>
                                <option value="dropline"<?php echo ($menustyle=='dropline')?' selected="selected"':'';?>>Dropline Menu</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <!-- Typography -->
        <div class="accordion-group cpanel-typography">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#ytcpanel_accordion" href="#ytitem_4">
                Typography <i class="icon-chevron-down"></i>
                </a>
            </div>
            <div id="ytitem_4" class="accordion-typo collapse">
                <div class="accordion-inner clearfix">
                	<!-- Google font -->
                    <div class="span6 first cp-item">
                        <span>Google Font</span>
                        <div class="inner">
                        	<?php 
							$googleFont = array(
										'None'=>'none',
										'Titillium Web'=>'Titillium Web',
										'Anton'=>'Anton',
										'Open Sans'=>'Open Sans',
										'BenchNine'=>'BenchNine',
										'Droid Sans'=>'Droid Sans',
										'Droid Serif'=>'Droid Serif',
										'PT Sans'=>'PT Sans',
										'Vollkorn'=>'Vollkorn',
										'Ubuntu'=>'Ubuntu',
										'Neucha'=>'Neucha',
										'Cuprum'=>'Cuprum',
										'Archivo Narrow'=>'Archivo Narrow'
							);
							?>
                            <select onchange="javascript: onCPApply();" name="ytcpanel_googleWebFont" class="cp_select">
							<?php foreach($googleFont as $k=>$v):?>
                                <option value="<?php echo $v; ?>"<?php echo ($googleWebFont==$v)?' selected="selected"':'';?>><?php echo $k; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Body font-size -->
                    <div class="span6 cp-item">
                        <span>Body Font-size</span>
                        <div class="inner">
                            <?php 
							$fontfamily = array(
										 '10px'=>'10px',
										 '11px'=>'11px',
										 '12px'=>'12px',
										 '13px'=>'13px',
										 'Default'=>'14px',
										 '15px'=>'15px',
										 '16px'=>'16px',
										 '17px'=>'17px',
										 '18px'=>'18px'
							);
							?>
                            <select onchange="javascript: onCPApply();" name="ytcpanel_fontSize" class="cp_select">
							<?php foreach($fontfamily as $k=>$v):?>
                                <option value="<?php echo $v; ?>"<?php echo ($fontSize==$v)?' selected="selected"':'';?>><?php echo $k; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Body font-family -->
                    <div class="span6 first cp-item body-fontfamily">
                        <span>Body Font-family</span>
                        <div class="inner">
                        <?php 
						$fontfamily = array(
									 'Arial'=>'arial',
									 'Arial Black'=>'arial-black',
									 'Courier New'=>'courier',
									 'Georgia'=>'georgia',
									 'Impact'=>'impact',
									 'Lucida Console'=>'lucida-console',
									 'Lucida Grande'=>'lucida-grande',
									 'Palatino'=>'palatino',
									 'Tahoma'=>'tahoma',
									 'Times New Roman'=>'times',
									 'Trebuchet'=>'trebuchet',
									 'Verdana'=>'verdana'
						);
						?>
                            <select onchange="javascript: onCPApply();" name="ytcpanel_fontName" class="cp_select">
							<?php foreach($fontfamily as $k=>$v):?>
                                <option value="<?php echo $v; ?>"<?php echo ($fontName==$v)?' selected="selected"':'';?>><?php echo $k; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Direction -->
                    <div class="span6 cp-item body-fontfamily">
                        <span>Direction</span>
                        <div class="inner">
                            <select onchange="javascript: onCPApply();" name="ytcpanel_direction" class="cp_select">
                                <option value="ltr"<?php echo ($direction=='ltr')?' selected="selected"':'';?>>LTR Language</option>
                                <option value="rtl"<?php echo ($direction=='rtl')?' selected="selected"':'';?>>RTL Language</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Action button -->
    <div class="cpanel-reset">
    	<a class="btn btn-info" href="#" onclick="javascript: onCPResetDefault(TMPL_COOKIE);" >Reset</a>
    </div>
    <div id="cpanel_btn" class="normal">
        <i class="icon-hand-left"></i>
    </div>
</div>