<?php
include("../auth/restrict_inner.php");
?>
<style>
div#users-contain table { margin: 1em 0; border-collapse: collapse; background:none; }
div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
div#users-contain table td { border: 1px solid #eee; padding: .6em 5px; text-align: left; }
div#users-contain table tbody tr:hover { background: #eee; }
div#users-contain table tbody tr.detail-row:hover { background: none; }
div#users-contain #user-detail tbody tr td { border: #none; }
.close{
	cursor:pointer;	
}
</style>
<!-- Main -->
<div id="main">
	<table width="100%" style="margin-bottom: 10px;">
    <tr>
    <td colspan="2"><h2>Staff Directory</h2></td>
    </tr>
    <tr>
    <td align="left" id="department_list">
    	
    </td>
    
    <td align="right">
    	Filter By Keyword: &nbsp;&nbsp;&nbsp;<input name="keyword" id="keyword" value="" placeholder="Enter Search Key Here" />
    </td>
    <td>
    	
    </td>	
    </tr>
    </table>
    <div id="display2" style="width: 100%;">
    <script>
		
		$(function() {
			$.ajax({
			  url: "../pages/department_list.php"
			}).done(function(data) {
			  $('#department_list').html(data);
			  $( "#display2" ).load("/pages/staffdirectory.php?department="+$('#department').val()+"&keyword="+$('#keyword').val());
			  $('#department').on('change',function(){ 
				$( "#display2" ).load("/pages/staffdirectory.php?department="+$('#department').val()+"&keyword="+$('#keyword').val());
			});
			});
		});
		
		$('#keyword').on('keypress',function(e) {
			if(e.which == 13) {
				$( "#display2" ).load("/pages/staffdirectory.php?department="+$('#department').val()+"&keyword="+$('#keyword').val());
			}
		});
	</script>
    </div>
</div>
<!-- END Main -->