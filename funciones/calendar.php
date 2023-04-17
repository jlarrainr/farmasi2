	<script>
	var cal1, cal2, mCal, mDCal, newStyleSheet;

	var dateFrom = null;
	var dateTo = null;
	
	window.onload = function () {
		cal1 = new dhtmlxCalendarObject('calendar1');
		cal1.setOnClickHandler(selectDate1);
		cal2 = new dhtmlxCalendarObject('calendar2');
		cal2.setOnClickHandler(selectDate2);
		cal3 = new dhtmlxCalendarObject('calendar3');
		cal3.setOnClickHandler(selectDate3);
		
		mCal = new dhtmlxCalendarObject('dhtmlxCalendar', false, {isYearEditable: true});
		mCal.setYearsRange(2000, 2500);
		mCal.draw();
	}
	
	function setFrom() {
		dateFrom = new Date(cal1.date);
		mCal.setSensitive(dateFrom, dateTo);
		return true;
	}

	function selectDate1(date) {
		document.getElementById('calInput1').value = cal1.getFormatedDate(null,date);
		document.getElementById('calendar1').style.display = 'none';
		dateFrom = new Date(date);
		mCal.setSensitive(dateFrom, dateTo);
		return true;
	}
	function selectDate2(date) {
		document.getElementById('calInput2').value = cal2.getFormatedDate(null,date);
		document.getElementById('calendar2').style.display = 'none';
		dateTo = new Date(date);
		mCal.setSensitive(dateFrom, dateTo);
		return true;
	}
	function selectDate3(date) {
		document.getElementById('calInput3').value = cal2.getFormatedDate(null,date);
		document.getElementById('calendar3').style.display = 'none';
		dateTo = new Date(date);
		mCal.setSensitive(dateFrom, dateTo);
		return true;
	}
	
	

	function showCalendar(k) {
		document.getElementById('calendar'+k).style.display = 'block';
	}
	
	

	</script>