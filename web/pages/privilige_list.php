<?php
include("../auth/restrict_inner.php");
$rst=$mysqli->query("Select * from `pen`.`default_priviliges` where user='".$ac['user']."'") or die($mysqli->error);
if($rst->num_rows==0)
{
	$rst=$mysqli->query("Select * from `pen`.`shared_privilige` where user='".$ac['user']."'") or die($mysqli->error);
	if($rst->num_rows==0)
	{
		$mysqli->close();
		header('HTTP/1.1 403 Forbidden');
		exit;
	}
}
$pv=$rst->fetch_assoc();

$pgroup = $_GET["pgroup"];

?>
<script>
<?php
if(isset($_GET['mode']))
{
	if($_GET['mode']=="Saved")
	{
		?>
		
			$.blockUI({ 
			message: '<div class="loading_message"><b>"Privilege Sharing Saved..."</b></div>',
			overlayCSS: {
				cursor: 'default'
			},
			css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'border-radius': '10px', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff',
				cursor: 'default'
				}
			});
			setTimeout($.unblockUI, 2000);
        <?php	
	}
}
?>
		$('.share').click(function() {
			var user=$(this).attr("id");
			$.post("../pages/staff_list.php",{"user":user,"id":"<?php echo $pgroup;?>"},function(data){
				$('#box').closest('tr').remove();
				$('#users > tbody > tr').eq($('#'+user).closest('tr').index()).after('<tr class="detail-row"><td colspan=5><div style="float:right"><img src="../images/close.png" alt="close" class="close"></div><div style="clear:both;text-align:center;">'+data+'</div></td></tr>');
				$('.close').click(function(){
					$('.close').closest('tr').remove();
				});
			});
		
		});
		
</script>
<div id="users-contain" class="ui-widget">
<?php
		$rst=$mysqli->query("Select * from `pen`.`default_priviliges` where user='".$ac['user']."'") or die($mysqli->error);
		if($rst->num_rows>0)
		{
		
		?>
<table id="users" width="100%" class="ui-widget ui-widget-content" cellspacing="0">
	<thead>
	<tr class="ui-widget-header " style="padding:5px;">
    	<td style="padding:5px;" colspan="2">Default Privilege</td>
    </tr>
    </thead>
    <tbody>
    	<tr style="border-bottom:1px solid #666;">
        	<td style="padding:5px;" width="70%">
				<?php 
					if ($pgroup=="E")
					{
						echo "Executive Privilege";
					}
					else if ($pgroup=="M")
					{
						echo "Manager Privilege";
					}
					else if ($pgroup=="T")
					{
						echo "Team Leader Privilege";
					}
				?>
           	</td>
            <td style="padding:5px;">
				<a href='javascript:;' class="share" id="<?php echo $ac['user'];?>">
                	Share Privilige With
                </a>
            </td>
            
        </tr>
    <?php
$q->free();
		}
?>
	</tbody>
</table>
<table id="users" width="100%" class="ui-widget ui-widget-content" cellspacing="0">
	<thead>
	<tr class="ui-widget-header " style="padding:5px;">
    	<td style="padding:5px;" colspan="2">Shared Privileges</td>
    </tr>
    </thead>
    <tbody>
	<?php
		$rst=$mysqli->query("Select privilige_group,name from `pen`.`shared_privilige` sp,`pen`.`users` u where u.user=sp.shared_by and sp.user='".$ac['user']."' ") or die($mysqli->error);
		while($shared=$rst->fetch_assoc())
		{			
	?>    
    	<tr style="border-bottom:1px solid #666;">
        	<td style="padding:5px;" width="50%">
				<?php 
					if ($shared['privilige_group']=="E")
					{
						echo "Executive Privilege";
					}
					else if ($shared['privilige_group']=="M")
					{
						echo "Manager Privilege";
					}
					else if ($shared['privilige_group']=="T")
					{
						echo "Team Leader Privilege";
					}
				?>
           	</td>
            <td style="padding:5px;">
				Shared By <?php echo $shared['name'];?>
            </td>
            
        </tr>
    <?php
		}
$q->free();
?>
	</tbody>
</table>
</div>