<?php $totalPrice = 0; ?>
<?php
$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
$paypal_id='gaurav-facilitator@infranix.com'; // Business email ID
?>
<div id="container">
<!--<div id="header"></div>-->

<div id="content">

<div class="my_account">
<div class="booktrip">
<h2><span>Cart Detail</span></h2>


<form action="<?php echo $paypal_url; ?>" method="post" id="itpdonate-form-paypal">
       
<div class="scedule">
<fieldset class="bookField">

<legend>Trip Pricing</legend>

<table width="100%" cellpadding="0" cellspacing="0">
<tr class="cart_font">
<th class="cart_bob" width="45%"><strong>#Items</strong></th>
<th class="cart_bob" width="20%"><strong>Qty</strong></th>
<th class="cart_bob" align="center"><strong>Price</strong></th>
</tr>
<?php foreach($equipments as $equipment) { ?>
<tr>
<td class="cart_bob"><strong><?php echo $equipment['equipment'];?></strong></td>
<td class="cart_bob">
<select class="qty" disabled="disabled">
<?php for($i=0;$i<20;$i++) { ?>
<option value="<?php echo $i;?>" <?php echo ($i==$equipment['no_of_equipment'])?("selected=selected"):("");?>><?php echo $i;?></option>
<?php } ?>
</select>
<?php $totalPrice += $equipment['eq_prices'];?>
</td>
<td class="cart_bob price" align="right"><strong style="color:#f00;"><?php echo $equipment['eq_prices']*$_SESSION['value'];?> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php } ?>
<?php foreach($cabins as $cabin) { ?>
<tr>
<td class="cart_bob"><strong><?php echo $cabin['cabin'];?></strong></td>
<td class="cart_bob">
<select class="qty" disabled="disabled">
<?php for($i=0;$i<20;$i++) { ?>
<option value="<?php echo $i;?>" <?php echo ($i==$cabin['no_of_cabin'])?("selected=selected"):("");?>><?php echo $i;?></option>
<?php } ?>
</select>
</td>
<td class="cart_bob price" align="right"><strong style="color:#f00;"><?php echo $cabin['cabin_price']*$_SESSION['value'];?> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php $totalPrice += $cabin['cabin_price'];?>
<?php } ?>
<?php foreach($foods as $food) { ?>
<tr>
<td class="cart_bob"><strong><?php echo $food['food'];?></strong></td>
<td class="cart_bob">
<select class="qty" disabled="disabled">
<?php for($i=0;$i<20;$i++) { ?>
<option value="<?php echo $i;?>" <?php echo ($i==$food['no_of_qty'])?("selected=selected"):("");?>><?php echo $i;?></option>
<?php } ?>
</select>
</td>
<td class="cart_bob price" align="right"><strong style="color:#f00;"><?php echo $food['food_price']*$_SESSION['value'];?> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php $totalPrice += $food['food_price'];?>
<?php } ?>
<?php foreach($beverages as $beverage) { ?>
<tr>
<td class="cart_bob"><strong><?php echo $beverage['beverage'];?></strong></td>
<td class="cart_bob">
<select class="qty" disabled="disabled">
<?php for($i=0;$i<20;$i++) { ?>
<option value="<?php echo $i;?>" <?php echo ($i==$beverage['no_of_qty'])?("selected=selected"):("");?>><?php echo $i;?></option>
<?php } ?>
</select>
</td>
<td class="cart_bob price" align="right"><strong style="color:#f00;"><?php echo $beverage['beverage_price']*$_SESSION['value'];?> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php $totalPrice += $beverage['beverage_price'];?>
<?php } ?>

<?php foreach($persons as $person) { ?>
<tr>
<td class="cart_bob"><strong>Adults</strong></td>
<td class="cart_bob">
<select class="qty" disabled="disabled">
<?php for($i=0;$i<20;$i++) { ?>
<option value="<?php echo $i;?>" <?php echo ($i==$person['no_of_person'])?("selected=selected"):("");?>><?php echo $i;?></option>
<?php } ?>
</select>
</td>
<td class="cart_bob price" align="right"><strong  style="color:#f00;"><?php echo ($person['no_of_person']*$tripPrice*$_SESSION['value']);?> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php $totalPrice += ($person['no_of_person']*$tripPrice);?>
<?php } ?>

<tr>
<td class="cart_bob"><strong>Childs</strong></td>
<td class="cart_bob">
<select class="qty" disabled="disabled">
<?php for($i=0;$i<20;$i++) { ?>
<option value="<?php echo $i;?>" <?php echo ($i==$totalChildren)?("selected=selected"):("");?>><?php echo $i;?></option>
<?php } ?>
</select>
</td>
<td class="cart_bob price" align="right"><strong style="color:#f00;"><?php echo ($childPriceAfterDiscount*$_SESSION['value']);?> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php $totalPrice += $childPriceAfterDiscount;?>

<tr>
<td colspan="2" align="right" class="cart_bob cart_font"><strong>Total :</strong></td>
<td width="16%" class="cart_bob price" align="right"><strong style="color:#f00;"><?php echo $totalPrice*$_SESSION['value'];?> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
</table>
</fieldset>

<script type="text/javascript">
function getCouponDiscount(id,discount,coupon_code){
	document.getElementById("closepop").className = "darkbase_bg";
	document.getElementById("ajax_loader").style.display="block";
	var totalAmount = <?php echo $totalPrice;?>//$('#updateTotal').html();
	var dis;
	if($('#coupon_id_'+id).attr("checked")=='checked'){
		$('#disamt_'+id).html(discount * <?php echo $_SESSION['value'] ?>);
		dis = 'sub';
	}else{
		dis = 'add';
		$('#disamt_'+id).html("0");
	}
	
	$.ajax({
	url: 'ajax.php?control=checkout&task=updatePayment&perform='+dis+'&totalPrice='+totalAmount+'&discount='+discount+'&booking_id='+<?php echo $bookingId; ?>+'&tax='+<?php echo $serviceTax;?>+'&coupon_id='+id+'&tripId=<?php echo $tripId ?>&scheduleId=<?php echo $scheduleId ?>&coupon_code='+coupon_code,
		success: function (data) {
			$('#updateTotal').html(data*<?php echo $_SESSION['value'] ?>);
			var Stax = (<?php echo $serviceTax;?> * data) / 100;
			var GrandT = parseFloat(data) + parseFloat(Stax.toFixed(2));
			$('#tax').html((Stax * <?php echo $_SESSION['value'] ?>).toFixed(2));
			$('#grand').html((GrandT * <?php echo $_SESSION['value'] ?>).toFixed(2));
			setTimeout("closeLoader()",2000);
			//$('#updateAmt').html(data);
			
						/*( $('#getMember').stop(true, true).fadeOut( 600 ), $('#stptwoli').removeClass( 'st-open' ).stop().animate({
							height	: $('#stptwoli').data( 'originalHeight' )
						}, 600, 'easeInOutExpo' ) )
						
			
						( $('#getSchedule').stop(true, true).fadeIn( 600 ), $('#stponeli').addClass( 'st-open' ).stop().animate({
							height	: $('#stponeli').data( 'originalHeight' ) + $('#stponeli').find('div.st-content').outerHeight( true )
						}, 600, 'easeInOutExpo' ), $('html, body').stop().animate({
						scrollTop	: ( true ) ? $('#stponeli').data( 'offsetTop' ) : $('#stponeli').offset().top
						}, 900, 'easeInOutExpo' ) )*/	
			
					 }});
}
</script>
<fieldset class="bookField">
<legend>Use Coupons</legend>

<table width="100%" cellpadding="0" cellspacing="0">
<tr class="cart_font">
<th class="cart_bob" width="16%"><input type="checkbox" disabled="disabled" /></th>
<th class="cart_bob" width="35%"><strong>#Coupon Code</strong></th>
<th class="cart_bob" width="20%"><strong>Description</strong></th>
<th class="cart_bob" align="center"><strong>Discount</strong></th>
<th class="cart_bob" align="center"><strong>Amount Get</strong></th>
</tr>
<?php 
if($couponLists){
$totalDiscount = 0;
 foreach($couponLists as $coupon) { ?>

<?php $disCountAmt = ($totalPrice * $coupon->discount) / 100;
if($coupon->coupon_status == 3)
$totalDiscount =  $totalDiscount + $coupon->discount;
?>

<tr>
<td class="cart_bob"><input type="checkbox" <?php echo ($coupon->coupon_status == 3)?"checked":""; ?> name="coupon_id_<?php echo $coupon->coupon_id;?>" id="coupon_id_<?php echo $coupon->coupon_id;?>" onclick="getCouponDiscount('<?php echo $coupon->coupon_id;?>','<?php echo $disCountAmt ?>','<?php echo $coupon->coupon_code;?>')"/></td>
<td class="cart_bob"><strong><?php echo $coupon->coupon_code;?></strong></td>
<td class="cart_bob">
<?php echo $coupon->title;?>

</td>
<td class="cart_bob price" align="center"><strong style="color:#f00;"><?php echo $coupon->discount;?> %</strong></td>
<td class="cart_bob price" align="center"><strong style="color:#f00;" id="disamt_<?php echo $coupon->coupon_id;?>"><?php echo ($coupon->coupon_status == 3)?$disCountAmt*$_SESSION['value']:"0";?></strong> 
<strong style="color:#f00;"><?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php } ?>
<?php }else{ ?>
<tr>
<td colspan="5" align="center">No coupons found</td>
</tr>
<?php } ?>
</table>
</fieldset>

<fieldset class="bookField">
<script type="text/javascript">
  function chkUsePoint(tval,id){
	  var numericExpression = /^[0-9]+$/;
  		for(i=0;i<tval.length;i++){
			if(!isNaN(tval.substring(1,tval.length)) && !isNaN(tval) && tval.match(numericExpression)){
			}else{
			//document.getElementById(id).value = val.substring(0,val.length-1);
			alert('Oops! you entered bad text.');
			$('#'+id).val('');
			$('#amtofpoint').html(0);
			break;
			}
		}		
		
				var userAvailPoint = $('#userTotalPoint').html();
					if(Number(tval) > Number(userAvailPoint) && $('#'+id).attr('readonly')!='readonly'){
						alert('You can not use points more than you have.');
						$('#'+id).val('');
						$('#amtofpoint').html(0);
					}
	
  }
  
   function useUpoint(tval,id,buttonId){
	  var numericExpression = /^[0-9]+$/;
  		for(i=0;i<tval.length;i++){
			if(!isNaN(tval.substring(1,tval.length)) && !isNaN(tval) && tval.match(numericExpression)){
			}else{
			//document.getElementById(id).value = val.substring(0,val.length-1);
			alert('Oops! you entered bad text.');
			$('#'+id).val('');
			$('#amtofpoint').html(0);
			break;
			}
		}		
			if(tval!='')	{
				if(Number(tval) < <?php echo $this->getConfic('minimum_used_point') ?>){
					alert('You can not use less than 500 points. ');
					$('#'+id).val('');
					$('#amtofpoint').html(0);
					
				}else {
						
						document.getElementById("closepop").className = "darkbase_bg";
						document.getElementById("ajax_loader").style.display="block";
						$.ajax({
						url: 'ajax.php?control=checkout&task=getUserAvailPointAndChkValidation',
							success: function (output) {
								var userAvailPoint = Number(output);
								
									
									if((Number(tval) > Number(userAvailPoint)) && buttonId!='pcancel'){
										alert('You can not use points more than you have.');
										$('#'+id).val('');
										$('#amtofpoint').html(0);
									}else{
							
										
							
										var pointTask;
										if(buttonId=='puse'){
											pointTask = 'sub';
											$.ajax({
												url: 'ajax.php?control=checkout&task=updateUserPoints&perform='+pointTask+'&totalPrice=<?php echo $totalPrice;?>&discount='+tval+'&booking_id='+<?php echo $bookingId; ?>+'&tax='+<?php echo $serviceTax;?>+'&scheduleId=<?php echo $scheduleId ?>',
												success: function (output) {
												$('#updateTotal').html(output*<?php echo $_SESSION['value'] ?>);
												$('#userTotalPoint').html(parseInt(Number(userAvailPoint)) - parseInt(Number(tval)));
												var Stax = (<?php echo $serviceTax;?> * output) / 100;
												var GrandT = parseFloat(output) + parseFloat(Stax.toFixed(2));
												$('#tax').html((Stax*<?php echo $_SESSION['value'] ?>).toFixed(2));
												$('#grand').html((GrandT *<?php echo $_SESSION['value'] ?>).toFixed(2));
											 }});
								
											$('#'+buttonId).html('Cancel');
											$('#'+buttonId).attr('id','pcancel');
											$('#'+id).attr('readonly',true);
											$('#amtofpoint').html(((($('#'+id).val()*<?php echo $this->getConfic('price_per_100_point') ?>)/100) * <?php echo $_SESSION['value'] ?>).toFixed(2) );
								
										}else{
								
											pointTask = 'add';
											$.ajax({
												url: 'ajax.php?control=checkout&task=updateUserPoints&perform='+pointTask+'&totalPrice=<?php echo $totalPrice;?>&discount='+tval+'&booking_id='+<?php echo $bookingId; ?>+'&tax='+<?php echo $serviceTax;?>+'&scheduleId=<?php echo $scheduleId ?>',
												success: function (output) {
												$('#updateTotal').html((output*<?php echo $_SESSION['value'] ?>).toFixed(2));
												$('#userTotalPoint').html(parseInt(Number(userAvailPoint)) + parseInt(Number(tval)));
												var Stax = (<?php echo $serviceTax;?> * output) / 100;
												var GrandT = parseFloat(output) + parseFloat(Stax.toFixed(2));
												$('#tax').html((Stax * <?php echo $_SESSION['value'] ?>).toFixed(2));
												$('#grand').html((GrandT*<?php echo $_SESSION['value'] ?>).toFixed(2));
											}});
											
											$('#'+buttonId).html('Use');
											$('#'+buttonId).attr('id','puse');
											$('#'+id).val('');
											$('#'+id).attr('readonly',false);
											$('#amtofpoint').html(0);
										}
						
					
									}
							
									setTimeout("closeLoader()",2000);
							 }});
							 
							 
					
				}
			}else{
			alert('Please enter point to use.');
			}
	
  }
  

 	function closeLoader(){
	document.getElementById('closepop').className = "clspop";
	}
		
  </script>
<legend>User Points</legend>

<table width="100%" cellpadding="0" cellspacing="0">
<tr class="cart_font">
<th class="cart_bob" width="45%"><strong>#Your Points (You must have minimum <?php echo $this->getConfic('minimum_used_point') ?> points to use.)</strong></th>
<th class="cart_bob" align="center"><strong>Use Points</strong></th>
<th class="cart_bob" align="center"><strong>Price Per 100 Point</strong></th>
<th class="cart_bob" align="center"><strong>Amount Get</strong></th>
</tr>

<tr>
<td class="cart_bob"><strong id="userTotalPoint"><?php echo $points[0]->point ?></strong></td>

<td class="cart_bob price"  align="center">
<input  type="text" style="width:40px;" id="usepoint" onkeyup="chkUsePoint(this.value,this.id)" value="<?php echo ($usedPoints[0]->point)?$usedPoints[0]->point:""; ?>" <?php echo ($usedPoints[0]->point)?"readonly":""; ?>/>
&nbsp;&nbsp;&nbsp;
<button type="button" class="bookField" id="<?php echo ($usedPoints[0]->point)?"pcancel":"puse"; ?>" onclick="useUpoint(usepoint.value,'usepoint',this.id)"><?php echo ($usedPoints[0]->point)?"Cancel":"Use"; ?></button></td>
<td class="cart_bob price"  align="center"><strong style="color:#f00;"><?php echo ($this->getConfic('price_per_100_point') * $_SESSION['value']) ?> <?php echo $_SESSION['symbol'] ?></strong></td>
<td class="cart_bob price"  align="center">
<strong style="color:#f00;" id="amtofpoint"><?php echo ($usedPoints[0]->point)?((($usedPoints[0]->point * $this->getConfic('price_per_100_point')) / 100) * $_SESSION['value']):"0"; ?></strong>
<strong style="color:#f00;"> <?php echo $_SESSION['symbol'] ?></strong></td>
</tr>
<?php $totalPrice = $totalPrice - (($totalPrice * $totalDiscount) / 100);  ?>
<?php if($usedPoints[0]->point){
	$totalPrice = $totalPrice - (($usedPoints[0]->point * $this->getConfic('price_per_100_point')) / 100);  
      }
	?>
</table>
</fieldset>


	<div id="updateAmt">
                
            <fieldset class="bookField">
    
    <legend>Paymen Details</legend>
    
    <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
    <td colspan="2" align="right" class="cart_bob cart_font"><strong>Total :</strong></td>
    <td width="16%" class="cart_bob price" align="right"><strong style="color:#f00;" id="updateTotal"><?php echo round($totalPrice,2) * $_SESSION['value'];?></strong> <strong style="color:#f00;"><?php echo $_SESSION['symbol'] ?></strong></td>
    </tr>
    <tr>
    <td align="right" colspan="2" class="cart_bob"><strong>Service Tax <?php echo $serviceTax;?>&nbsp;% :</strong></td>
    
    <td class="cart_bob price" align="right"><strong style="color:#f00;" id="tax"><?php echo round(((($serviceTax*$totalPrice)/100) *$_SESSION['value']),2) ;?></strong><strong style="color:#f00;"> <?php echo $_SESSION['symbol'] ?></strong></td>
    </tr>
    <?php $totalPrice += (($serviceTax*$totalPrice)/100);
    $this->Query("UPDATE bookings SET grand_total = '".$totalPrice."' WHERE id = '".$bookingId."'");
    $this->Execute();
    ?>
    <tr>
    <td colspan="2" align="right" class="cart_bob cart_font"><strong>Grand Total :</strong></td>
    <td class="cart_bob price" align="right"><strong style="color:#f00;" id="grand"><?php echo round($totalPrice*$_SESSION['value'],2);?></strong><strong style="color:#f00;"> <?php echo $_SESSION['symbol'] ?></strong></td>
    </tr>
    <tr>
    <td align="left" class="cart_font" colspan="3"><strong>Payment Method :</strong></td>
    </tr>
    <tr>
    
    <td class="cart_bob price"  colspan="3" align="left">
    
    			
              <input type="radio" name="payment_method" id="payment_method" value="1" checked="checked" />
              <label for="payment_method"><strong>Paypal</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="payment_method" id="payment_method2" value="2" />
              <label for="payment_method2"><strong>Credit Card</strong></label>
    
    </td>
    </tr>
    
    <tr>
    <td colspan="3" align="center" valign="bottom">
    
    <!--PAY PAL CODE START HERE-->
                <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="item_name" value="iDive Trip">
        <input type="hidden" name="item_number" value="<?php echo $bookingId; ?>">
        <input type="hidden" name="amount" value="<?php echo $totalPrice;?>">
        <input type="hidden" name="cpp_header_image" value="http://infranix.net/idive/template/idive_tmp/images/logo.png">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="currency_code" value="THB">
        <input type="hidden" name="handling" value="0">
       <!-- <input type="hidden" name="cancel_return" value="http://infranix.net/idive/mobile.php?control=api&task=paypalCancel&userId=<?php echo $userId ?>&tripId=<?php echo $tripId; ?>">
        <input type="hidden" name="return" value="http://infranix.net/idive/mobile.php?control=api&task=paypalSuccess&userId=<?php echo $userId ?>&tripId=<?php echo $tripId; ?>">
        <input type="hidden" name="notify_url" value="http://infranix.net/idive/mobile.php?control=api&task=ipnNotify">-->
        
    <input type="hidden" name="cancel_return" value="http://infranix.net/idive/index.php?control=checkout&task=paypalAbandon&trip_id=<?php echo $tripId; ?>&scheduleId=<?php echo  $scheduleId; ?>">
        <input type="hidden" name="return" value="http://infranix.net/idive/index.php?control=checkout&task=paypalComplete&trip_id=<?php echo $tripId; ?>&scheduleId=<?php echo  $scheduleId; ?>">
        <input type="hidden" name="notify_url" value="http://infranix.net/idive/index.php?control=checkout&task=paypalNotify">
        
        
        
        <!--<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">-->
    
           <!--PAY PAL CODE END HERE-->
           
         
           
           </td>
    </tr>
    </table>
    </fieldset>
    
    </div>

</div>
			
        <div class="accord_sep">&nbsp;</div>
                        <table class="privacy_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left" valign="middle">
                            <a style="cursor:pointer;" class="get_quotes_btn" onclick="goToStepThree()">Previous >></a>
                            </td>
                            <td align="right" valign="middle">
                            <button class="lang_button"><strong>Proceed to Checkout</strong></button>
                           <!-- <a class="get_quotes_btn" onclick="saveOption()">Continue >></a>-->
                            </td>
                          </tr>
                        </table>    
            
        </form>

</div>
</div>

</div>
</div>

<script>
function goBack()
  {
 // 	  history.goBack();
 window.history.back();
//history.go(-1);
  }
</script>