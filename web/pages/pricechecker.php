
<?php  
include("../auth/restrict_inner.php");
$mysqli = new mysqli('localhost','pen','18450be');

$code1 = $_GET['code1'];
$code2 = $_GET['code2'];
$code3 = $_GET['code3'];

if($code1!="" && $code2=="" && $code3=="")
{
  $NTC1="(NTC='".$mysqli->real_escape_string($code1)."')";
}
if($code1!="" && $code2!="" && $code3=="")
{ 
  $NTC2="(NTC='".$mysqli->real_escape_string($code1)."+".$mysqli->real_escape_string($code2)."')";
  
}
if($code2!="" && $code3!="" && $code1=="")
{
  $NTC3="(NTC='".$mysqli->real_escape_string($code2)."+".$mysqli->real_escape_string($code3)."')";
}
if($code1!="" && $code3!="")
{
  $NTC4="(NTC='".$mysqli->real_escape_string($code1)."+".$mysqli->real_escape_string($code3)."')";
}
if($code1!="" && $code2!="" && $code3!="")
{
  $NTC5="(NTC='".$mysqli->real_escape_string($code1)."+".$mysqli->real_escape_string($code2)."+".$mysqli->real_escape_string($code3)."')";
}

$query="SELECT * from `pen`.`vwPricing` where chgSupply!=0";
if($code1!="" && $code2=="" && $code3=="")
  $query.=" and ".$NTC1." ";
if($code1!="" && $code2!="" && $code3=="")
	$query.=" and ".$NTC2." ";
if($code2!="" && $code3!="" && $code1=="")
	$query.=" and ".$NTC3." ";
if($code1!="" && $code3!="" && $code2=="")
	$query.=" and ".$NTC4." ";
if($code1!="" && $code2!="" && $code3!="")
	$query.=" and ".$NTC5." ";

$q = $mysqli->query($query) or die($mysqli->error);
$charges = $q->fetch_assoc();   

if($code1=="" && $code2=="" && $code3=="")
{
  $charges="none";
}

$query1="SELECT * from `pen`.`vwPricing` where chgSupply=0";
if($code1!="" && $code2=="" && $code3=="")
	$query1.=" and ".$NTC1." ";
if($code1!="" && $code2!="" && $code3=="")
	$query1.=" and ".$NTC2." ";
if($code2!="" && $code3!="" && $code1=="")
	$query1.=" and ".$NTC3." ";
if($code1!="" && $code3!="" && $code2=="")
	$query1.=" and ".$NTC4." ";
if($code1!="" && $code2!="" && $code3!="")
	$query1.=" and ".$NTC5." ";
$q1 = $mysqli->query($query1) or die($mysqli->error);
	$charge = $q1->fetch_assoc();
?>
<link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />

<script>

// user validation

function pricechecker() 
{
	if(document.input.code1.value=="" && document.input.code2.value=="" && document.input.code3.value=="")
   {
      alert('Please enter atleast one field.');
      document.input.code1.focus();
      return false;
   }
   return true;
}
	
</script>
<body style="background-image:none;background-color:#fff;">
 <div id="pricechecker">
    <h2 class="usertitle">Price Checker </h2>
    <form name="input" id="input" action="pricechecker.php" method="GET" onsubmit="return pricechecker();">
      <dl class="networkcode">
        <dt>Network Code:</dt>
        <dd>
          <input type="text" name="code1" class="code1" value="<?php echo $_GET["code1"]?>" placeholder="Enter Network code1" autocomplete="off"/>
          <span style="font-weight: bold;">+</span>
          <input type="text" name="code2" class="code2" value="<?php echo $_GET["code2"]?>" placeholder="Enter Network code2" autocomplete="off"/>
          <span style="font-weight: bold;">+</span>
          <input type="text" name="code3" class="code3" value="<?php echo $_GET["code3"]?>" placeholder="Enter Network code3" autocomplete="off"/>
          <input type="submit" value="Search" class="searchnc"/>
        </dd>
      </dl>
      <div class="viewallcharges">
        <?php  if($charges != "") { 
	  if (preg_match("/\bResidential\b/i",$charges['Description'])) 
	  { 
       ?>
        <p>You Searched For :
          <?php  echo $charges['NTC']?>
        </p>
        <p>* Peak time from 7 am to 11 pm AEST Monday to Friday</p>
        <table width="100%" class="viewsearchcontent" cellspacing="0">
          <tr class="viewchargeshead">
            <td style="width:15%;color:#562577;">Usage Charges</td>
            <td style="width:10%;">Unit</td>
            <td style="width:10%;">GST ex</td>
            <td style="width:10%;">GST inc</td>
          </tr>
          <?php if($charges['PeakCap'] == NULL)
			{ ?>
          <tr class="chargeslist">
            <td><?php echo $charges['Description'];?></td>
            <td>Cents/day</td>
            <td><?php echo $charges['chgPeak'];?></td>
            <td><?php $c=$charges['chgPeak'];
                $s=$c*1.1;
                echo $s; ?></td>
          </tr>
          <?php  } 
			 else
			{ ?>
          <tr class="chargeslist">
            <td><?php echo $charges['Description'];?>- Step1</td>
            <td>Cents/day</td>
            <td><?php echo $charges['chgWithinCap'];?></td>
            <td><?php $c=$charges['chgWithinCap'];
                $s=$c*1.1;
                echo $s; ?></td>
          </tr>
          <tr class="chargeslist">
            <td><?php echo $charges['Description'];?>- Step2</td>
            <td>Cents/day</td>
            <td><?php echo $charges['chgAboveCap'];?></td>
            <td><?php $c=$charges['chgAboveCap'];
                $s=$c*1.1;
                echo $s; ?></td>
          </tr>
          <?php }?>
          
          <!-- displaying hotwater-->
          <?php 
		
		  if($charge != "" && preg_match("/\bHotwater\b/i",$charge['Description'])) { ?>
          <tr class="chargeslist">
            <td><?php echo $charge['Description'];?></td>
            <td>Cents/day</td>
            <td><?php echo $charge['chgOffPeak'];?></td>
            <td><?php $c=$charge['chgOffPeak'];
                $s=$c*1.1;
                echo $s; ?></td>
          </tr>
          <?php }?>
          
          <!-- displaying offpeak-->
          <tr class="chargeslist">
            <td>Off Peak</td>
            <td>Cents/day</td>
            <?php if($charges['chgOffPeak'] == NULL) {?>
            <td>0</td>
            <td>0</td>
            <?php } 
		 elseif($charges['chgOffPeak'] != NULL) { ?>
            <td><?php echo $charges['chgOffPeak'];?></td>
            <td><?php $c=$charges['chgOffPeak'];
                $s=$c*1.1;
                echo $s; ?></td>
            <?php } ?>
          </tr>
        </table>
        
        <!-- table 2 supply charges-->
        
        <table width="100%" class="viewsearchcontent" cellspacing="0">
          <tr class="viewchargeshead">
            <td style="width:15%;color:#562577;">Supply Charges</td>
            <td style="width:10%;">Unit</td>
            <td style="width:10%;">GST ex</td>
            <td style="width:10%;">GST inc</td>
          </tr>
          <tr class="chargeslist">
            <td><?php echo $charges['Description'];?></td>
            <td>Cents/day</td>
            <td><?php echo $charges['chgSupply'];?></td>
            <td><?php $c=$charges['chgSupply'];
			$s=$c*1.1;
			echo $s; ?></td>
          </tr>
        </table>
        
        <!-- table 3 solar-->
        
        <?php 
		
		  if($charge != "" && preg_match("/\bSolar\b/i",$charge['Description'])) {?>
        <table width="100%" class="viewsearchcontent" cellspacing="0">
          <tr class="viewchargeshead">
            <td style="width:15%;color:#562577;">Solar</td>
            <td style="width:10%;">Unit</td>
            <td style="width:10%;">GST ex</td>
          </tr>
          <tr class="chargeslist">
            <td><?php echo $charge['Description'];?></td>
            <td>Cents/day</td>
            <td><?php echo $charge['chgPeak'];?></td>
          </tr>
        </table>
        <?php } ?>
        <!-- table 4-->
        
        <?php if($charges['chgOffPeak'] != NULL)
			{ ?>
        <table width="100%" class="viewsearchcontent" cellspacing="0">
          <h3>Usage Charge Details</h3>
          <tr class="viewchargeshead">
            <td style="width:15%;color:#562577;">Tariff Type</td>
            <td style="width:10%;">First Peak Consumption<br>
              (KWh/day)</td>
            <td style="width:10%;">Balance Consumption<br>
              (KWh/day)</td>
          </tr>
          <tr class="chargeslist">
            <td><?php echo $charges['Description'];?></td>
            <td><?php echo $charges['chgOffPeak'];?></td>
            <td>-</td>
          </tr>
        </table>
        <?php } 
		?>
        <?php } 
	  elseif(preg_match("/\bBusiness\b/i",$charges['Description'])) { ?>
        <div class="nocobinations">You have searched the buisness domain which is currently unavailable.Please review your inputs and try again!!</div>
        <?php }
	  } 
	  elseif(($charges == "")) {  ?>
        <div class="nocobinations">Unfortunately we don't recognize any of these combinations.Please check your inputs and retry.</div>
        <?php }?>
      </div>
    </form>
</div>
</body>


