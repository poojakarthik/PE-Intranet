<?php
include("../auth/restrict_inner.php");
?>
<style>
div#users-contain table { margin: 1em 0; border-collapse: collapse; background:none; }
div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
div#users-contain table td { border: 1px solid #eee; padding: .6em 5px; text-align: left; }
div#users-contain table tbody tr:hover { background: #eee; }
.book {
	background-image:url('/images/book_icon.png'); background-repeat:no-repeat; background-color:transparent;
	border:none; height:16px; width:16px; cursor:pointer;
}
.cancel {
	background-image:url('/images/delete_icon.png'); background-repeat:no-repeat; background-color:transparent;
	border:none; height:16px; width:16px; cursor:pointer;
}
.cancel:disabled {
	opacity: 0.4;
	cursor: default;
}
</style>
<script>
var room = "boardroom";

$(function() {
	$( "#datepicker" ).datepicker({
		numberOfMonths: 2,
		dateFormat: "yy-mm-dd",
		minDate: "<?php echo date("Y-m-d"); ?>",
		maxDate: "<?php echo date("Y-m-d", strtotime("+1 year")); ?>",
		onSelect: function(dateText, inst) {
			P_Loading_Start();
			$( "#display2" ).load("/pages/booking.php?room=" + room + "&date=" + dateText, function() {
				P_Loading_End();
			});
		}
	});
});

function Book(time)
{
	P_Loading_Start();
	$.post("/pages/booking_process.php", { action: "book", room: room, date: $( "#datepicker" ).val(), time: time, bookee: "<?php echo $ac["user"]; ?>" }, function (data) {
		$( "#display2" ).load("/pages/booking.php?room=" + room + "&date=" + $( "#datepicker" ).val());
		P_Loading_End();
	});
}

function Cancel(time)
{
	P_Loading_Start();
	$.post("/pages/booking_process.php", { action: "cancel", room: room, date: $( "#datepicker" ).val(), time: time }, function (data) {
		$( "#display2" ).load("/pages/booking.php?room=" + room + "&date=" + $( "#datepicker" ).val());
		P_Loading_End();
	});
}
</script>
<!-- Main -->
<div id="main">
	<table width="100%" style="margin-bottom: 10px;">
    <tr>
    <td><h2>Boardroom Booking Calendar</h2></td>
    <td align="right"><input type="text" readonly="readonly" id="datepicker" size="10" style="text-align: center;" value="<?php echo date("Y-m-d"); ?>" /></td>
    </tr>
    </table>
    <div id="display2" style="width: 100%;">
    	<script>
		$( "#display2" ).load("/pages/booking.php?room=" + room + "&date=<?php echo date("Y-m-d"); ?>");
		</script>
    </div>
</div>
<!-- END Main -->