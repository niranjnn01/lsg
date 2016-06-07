
<div class="row">
    
    <div class="col-md-6">
        
        <h4>Address</h4>
        
        <div class="form-group">
            <label for="address_line1_">Address line 1</label>
            <input type="text" id="address_line1_" name="address_line1_"
                   class="form-control"
                   value="<?php echo set_value('address_line1_') ? set_value('address_line1_') : $oAddressItemForEdit->address_details->address_line1;?>"/>
        </div>
        
        <div class="form-group">
            <label for="address_line2_">Address line 2</label>
            <input type="text" id="address_line2_" name="address_line2_"
                   value="<?php echo set_value('address_line2_') ? set_value('address_line2_') : $oAddressItemForEdit->address_details->address_line2;?>"
                   class="form-control"/>
        </div>
        
        
        <?php if( $address_form_settings__bShowState ):?>
            
            <?php if( ! $address_form_settings__bIsStateEditable ):?>
                
                <div class="form-group">
                    <label for="address_city_">State</label>
                    <?php echo $aStates[$address_form_settings__iDefaultState]?>
                </div>
            <?php endif;?>
            
        <?php endif;?>
        
        <div class="form-group">
            <label for="address_city_">City</label>
            <?php $iDefault = set_value('address_city_') ? set_value('address_city_') : $oAddressItemForEdit->address_details->city;?>
            <?php echo form_dropdown('address_city_', $aCities, $iDefault, 'id="address_city_" class="form-control"');?>
        </div>
        
        <div class="form-group">
            <label for="address_pincode_">Pincode</label>
            <input type="text" id="address_pincode_" name="address_pincode_"
                   value="<?php echo set_value('address_pincode_') ? set_value('address_pincode_') : $oAddressItemForEdit->address_details->pincode;?>" class="form-control"/>
        </div>
        
        
        
    </div>
    
    <div class="col-md-6">
        
        <h4>Contact Numbers</h4>
        
        <div class="form-group">
            <label>Give atleast one contact number</label>
        </div>
        
        <div class="form-group">
            <label for="address_mobile1_">Mobile 1</label>
            <input type="text" id="address_mobile1_" name="address_mobile1_"
                       value="<?php echo set_value('address_mobile1_') ? set_value('address_mobile1_') : $oAddressItemForEdit->phone_details->mobile1;?>" class="form-control"/>
                
        </div>
        
        <div class="form-group">
            <label for="address_mobile2_">Mobile 2</label>
            <input type="text" id="address_mobile2_" name="address_mobile2_"
                           value="<?php echo set_value('address_mobile2_') ? set_value('address_mobile2_') : $oAddressItemForEdit->phone_details->mobile2;?>" class="form-control"/>
        </div>
        
        <div class="form-group">
            <label for="address_landline1_">Land line 1</label>
            <input type="text" id="address_landline1_" name="address_landline1_"
                   value="<?php echo set_value('address_landline1_') ? set_value('address_landline1_') : $oAddressItemForEdit->phone_details->landline1?>" class="form-control"/>
        </div>
        
        <div class="form-group">
            <label for="address_landline2_">Land line 2</label>
            <input type="text" id="address_landline2_" name="address_landline2_"
                   value="<?php echo set_value('address_landline2_') ? set_value('address_landline2_') : $oAddressItemForEdit->phone_details->landline2;?>" class="form-control"/>
        </div>
        
    </div>
    
</div>
