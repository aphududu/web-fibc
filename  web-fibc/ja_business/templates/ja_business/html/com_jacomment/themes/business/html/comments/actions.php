<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
	<?php if($isSpecialUser){ ?>
		<span class="status-btn"><?php if($type==1) echo "Approved";else if($type==2) echo "Spam";else echo "Unapproved";?></span>
	<?php }?>
	<?php if($isAllowEditComment){?>	
	<div class="comment-menu" id="edit-delete-<?php echo $itemID?>">
		<a href="#" onclick="return false;" class="admin-btn menu-btn"><?php echo JText::_("Admin");?></a>
		<div class="admin-actions menu-content">
			<ul>
				<?php
					if($isSpecialUser){
						$treeTypes = $helper->getListTreeStatus($type, $parentType);										 
						foreach ( $treeTypes as $key => $value ) {?>
							<li>
								<a onclick="changeTypeOfComment('<?php echo $key ;?>','<?php echo $itemID ;?>','<?php echo $type;?>');return false;" href="#"><?php echo $value;?></a>																																         
							</li>
				<?php  }//end for	
					}//end if																					
				?>
				<li><a href="javascript:editComment(<?php echo $itemID?>,'<?php echo JText::_("Reply")?>')" title="<?php echo JText::_("Edit comment"); ?>"><?php echo JText::_(" Edit ");?></a></li>
				<li><a href="javascript:deleteComment(<?php echo $itemID?>)" title="<?php echo JText::_("Delete comment");?>"><?php echo JText::_("Delete");?></a></li>
			</ul>
		</div>
	</div>	
	<?php } ?>