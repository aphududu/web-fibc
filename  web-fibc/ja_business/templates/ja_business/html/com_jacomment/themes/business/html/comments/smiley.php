<?php
	defined ( '_JEXEC' ) or die ( 'Restricted access' );     
?>
<ul onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";' onmouseout='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="none";' style="display: none;" id="jacSmileys-<?php echo $this->id;?>" class="smileys">
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":)");' class="smiley"><span style="background-position: 0px 0px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:)</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":D");' class="smiley"><span style="background-position: -12px 0px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:D</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>("xD");' class="smiley"><span style="background-position: -24px 0px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>xD</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(";)");' class="smiley"><span style="background-position: -36px 0px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>;)</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":p");' class="smiley"><span style="background-position: -48px 0px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:p</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>("^_^");' class="smiley"><span style="background-position: 0px -12px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>^_^</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":$");' class="smiley"><span style="background-position: -12px -12px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:$</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>("B)");' class="smiley"><span style="background-position: -24px -12px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>B)</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":*");' class="smiley"><span style="background-position: -36px -12px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:*</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>("(3");' class="smiley"><span style="background-position: -48px -12px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>(3</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":S");' class="smiley"><span style="background-position: 0px -24px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:S</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":|");' class="smiley"><span style="background-position: -12px -24px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:|</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>("=/");' class="smiley"><span style="background-position: -24px -24px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>=/</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":x");' class="smiley"><span style="background-position: -36px -24px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:x</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>("o.0");' class="smiley"><span style="background-position: -48px -24px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>o.0</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":o");' class="smiley"><span style="background-position: 0px -36px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:o</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":(");' class="smiley"><span style="background-position: -12px -36px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:(</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":@");' class="smiley"><span style="background-position: -24px -36px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:@</span></span></a></li>
	<li><a href='javascript:<?php echo $this->fucSmiley;?>(":&#39;(");' class="smiley"><span style="background-position: -36px -36px;" onmouseover='document.getElementById("jacSmileys-<?php echo $this->id;?>").style.display="block";'><span>:&#39;(</span></span></a></li>
</ul>
<a href="javascript:void(0);" class="act-smiley" onclick='javascript:jacChangeDisplay("jacSmileys-<?php echo $this->id;?>", "block", "smiley")' title="<?php echo JText::_("Add a smiley");?>"><span><?php echo JText::_("Add a smiley");?></span></a>