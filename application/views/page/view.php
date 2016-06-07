<h3><?php echo @$oPage->title;?></h3>
<div class="row">

        
        <?php $sClass = 'span' . (12/$oPage->show);?>
       
        <?php 
        //$sClass = 'content'.$oPage->show;
        for($i=1;$i<=$oPage->show;++$i){
        $sContent = 'content'.$i;
        ?>
            <div class="<?php echo $sClass;?>">
                <?php echo $oPage->$sContent;?>
            </div>
        <?php }?>
        
        
        
        
        
        <?php
        /*
        $sClass = 'content'.$oPage->show;
        for($i=1;$i<=3;++$i){
        $sContent = 'content'.$i;
        ?>
            <?php if ( $oPage->$sContent && $i <= $oPage->show):?>
                <?php if($i != 1):?><div class="spacer">&nbsp;</div><?php endif;?>
                <div class="<?php echo $sClass;?> col1"><?php echo $oPage->$sContent;?></div>
            <?php endif;?>
        <?php }
        */
        ?>
        
        
        
        
</div>
