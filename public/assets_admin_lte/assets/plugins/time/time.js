function addZero(i) {
	if (i < 10) {
		i = "0" + i;
	}
	return i;
}
function addSatu(i) {
	i = i + 1 ;
	return i ;
}
function waktu() {
	setTimeout("waktu()",1000); 
	
	var d = new Date();
	var x = document.getElementById("jam");
	var h = addZero(d.getHours());
	var m = addZero(d.getMinutes());
	var s = addZero(d.getSeconds());
	var y = d.getFullYear();
	var t = d.getDate();
	var M = d.getMonth();
	var bulan ;
	var ampm ;
	
	if (h>=00 && h <= 11)
	{
		ampm = "AM";
	}
	else
	{
		ampm = "PM";
	}
	
	if (M == 0)
	{
		bulan = "January";
	}
	else if(M == 1)
	{
		bulan = "Febuary";
	}
	else if (M == 2)
	{
		bulan = "March";
	}
	else if (M == 3)
	{
		bulan = "April";
	}
	else if (M == 4)
	{
		bulan = "May";
	}
	else if (M == 5)
	{
		bulan = "June";
	}
	else if (M == 6)
	{
		bulan = "July";
	}
	else if (M == 7)
	{
		bulan = "August";
	}
	else if (M == 8)
	{
		bulan = "September";
	}
	else if (M == 9)
	{
		bulan = "October";
	}
	else if (M == 10)
	{
		bulan = "November";
	}
	else if (M == 11)
	{
		bulan = "December";
	}
	x.innerHTML = bulan +", "+ t +" - "+ y +" | "+ h +":"+ m +":"+ s +" "+ ampm; 
} 
waktu();