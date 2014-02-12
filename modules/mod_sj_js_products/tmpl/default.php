<?php
/**
 * @package Sj Products for JoomShopping
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

$instance	= rand().time();
if(!empty($items)){
    ImageHelper::setDefault($params);
    $options=$params->toObject();?>
	<div id="products_wrap_<?php echo $instance;?>" class="products-wrap <?php echo $options->deviceclass_sfx;?>">
    	<?php if(!empty($options->pretext)){?>
    		<div class="intro_text"><?php echo $options->pretext; ?></div>
    	<?php }?>	
	<?php $i = 0; foreach($items as $i => $curr){$i++;?>
	    <div class="content-box">
            <?php if ($curr->label_id && $options->show_label){?>
                <div class="item_label">
                    <?php if ($curr->_label_image){?>
                        <img src="<?php echo $curr->_label_image?>" alt="<?php echo htmlspecialchars($curr->_label_name)?>" />
                    <?php }else {?>
                        <span class="label_name"><?php echo $curr->_label_name;?></span>
                    <?php }?>
                </div>
            <?php }?> 
            <?php if( $options->show_image ){?>   
		        <div class="item_image">
		            <a href="<?php echo $curr->link?>" <?php echo SjProducts::parseTarget($options->target);?>> 
		            <?php $img = SjProducts::getAImage($curr, $params);
	    				  echo SjProducts::imageTag($img);
	    			?>              
		            </a>
		        </div>
	        <?php }?>
	        <?php if( $options->show_title ){?>
		        <div class="item_title">
		            <a href="<?php echo $curr->link?>" <?php echo SjProducts::parseTarget($options->target);?>><?php echo $curr->name?></a>
		            <!-- span class="jshop_code_prod">(<?php //echo _JSHOP_EAN?>: <span><?php //echo $curr->product_ean;?></span>)</span-->
		        </div>	
	        <?php }?>
	        <?php if( $options->show_review ){?>
	        	<table class="review_mark"><tr><td><?php echo showMarkStar($curr->average_rating);?></td></tr></table>
	        <?php }?>
	        <?php if( $options->show_comments ){?>
		        <div class="count_commentar">
		        	<?php $curr->reviews_count = (int)$curr->reviews_count;
		        		if( $curr->reviews_count > 1 ){
		        			echo "Comments (".$curr->reviews_count.")";
		        		}else{
		        			echo "Comment (".$curr->reviews_count.")";
		        		}
		        	?>
		        </div> 
	        <?php }?>
	        <?php if( $options->show_hits ){?> 
		        <div class="item_hits">
		        <?php $curr->hits = (int)$curr->hits;?>
		            <?php if( $curr->hits > 1 ){echo "Hits : ". $curr->hits;}else{
		            	echo "Hit : ". $curr->hits;
		            }?>
		        </div> 
	        <?php }?>
	        <?php if( $options->show_date ){?>
		        <div class="item_date">
		            <?php echo "Date : ".date("d F Y", strtotime($curr->date_modify));?>
		        </div>  
	        <?php }?> 
	        <?php if( $options->show_manufacturer ) {?> 
		        <div class="item_manufacturer">
		        	<?php echo "Manufacturer : ". $curr->manufacturer->name;?>
		        </div>
	        <?php }?>
	        <?php if( $options->show_desc ){?>
		        <div class="item_description">
		        	<?php echo $curr->short_description;?>
		        </div>		        
	        <?php }?>
	        <?php if ( $curr->_display_price && $options->show_price ){?>
	            <div class = "item_price">
	                <?php if ($curr->show_price_from) echo _JSHOP_FROM." ";?>
	                <span><?php echo "Price: ".formatprice($curr->product_price);?></span>
	            </div>
	        <?php }?>
            <!--span class="taxinfo"><?php //echo productTaxInfo($curr->tax);?></span-->
            <!-- div class="productweight"><?php //echo _JSHOP_WEIGHT?>: <span><?php //echo formatweight($curr->product_weight)?></span></div-->
	        <?php if ($curr->delivery_time != ''){?>
	            <div class="deliverytime"><?php echo _JSHOP_DELIVERY_TIME?>: <span><?php echo $curr->delivery_time?></span></div>
	        <?php }?>
	        <?php if (is_array($curr->extra_field)){?>
	            <div class="extra_fields">
	            <?php foreach($curr->extra_field as $extra_field){?>
	                <div><?php echo $extra_field['name'];?>: <?php echo $extra_field['value']; ?></div>
	            <?php }?>
	            </div>
	        <?php }?>
	        <?php if( $options->show_read_more ){?>
		        <div class="item_detail">
		            <a href="<?php echo $curr->link?>" <?php echo SjProducts::parseTarget($options->target);?>><?php echo $options->read_more_text;?></a>
		        </div>
	        <?php }?>
	    </div>  
    	<?php
    		$clear = 'clr1';
    		if ($i % 2 == 0) $clear .= ' clr2';
    		if ($i % 3 == 0) $clear .= ' clr3';
    		if ($i % 4 == 0) $clear .= ' clr4';
    		if ($i % 5 == 0) $clear .= ' clr5';
    		if ($i % 6 == 0) $clear .= ' clr6';
    	?>
    	<div class="<?php echo $clear; ?>"></div>    
	<?php } ?>
        <?php if(!empty($options->posttext)){?>
        	<div class="footer_text"><?php echo $options->posttext; ?></div>
   		<?php }?>	
	</div>
<?php } else { echo JText::_('Has no content to show!');}?>

