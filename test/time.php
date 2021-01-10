<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Таймер</title>
<script language="JavaScript">
// Таймер
var m_timer,m_clock,s;
m_timer="<?php echo $_GET['t']; ?>"-1;
if (m_timer>=0)
{
	s=60;
}
else
{
	s=0;
	m_clock=0;
}
function gettimer()
{
if (m_timer>=0) //Время тестирования ограничено, таймер обратного отсчета
{
	document.getElementById("time-clock").innerHTML="<em><strong>До конца тестирования осталось:</strong></em>"
if (m_timer==0 & s==0)
  {

	parent.mainFrame.document.location.href="login.php?time_out=1";

	return false;
  }
else  
  {
 	if (s > 0)
      {
	    s=s-1;
	    if (s < 10)
   	      {
	        s = "0" + s;
	      }
		document.clockform.timer.value =m_timer+ "  мин.  " + s+"  сек.";
        setTimeout("gettimer()", 1000);
        return false;
	  }
    else
      {
	    if (m_timer>0)
	      {
		    m_timer=m_timer-1;
			s=59;
	        document.clockform.timer.value =m_timer+ "  мин.  " + s+"  сек.";
            setTimeout("gettimer()", 1000);
            return false;
		  }
		else
		  {
			document.clockform.timer.value =m_timer+ "  мин.  " + s+"  сек.";
            setTimeout("gettimer()", 1000);
            return false;
		  }
		s=s-1;		
	  }
   }
}
else //Время тестирования неограничено, таймер прямого отсчета
	{
document.getElementById("time-clock").innerHTML="<em><strong>Время выполнения теста:	</strong></em>"
 	if (s < 59)
      {
	    s=Number(s)+1;
	    if (s < 10)
   	      {
	        s = "0" + s;
	      }
		document.clockform.timer.value = m_clock + "  мин.  " + s+"  сек.";
        setTimeout("gettimer()", 1000);
        return false;
	  }
    else
      {
	    m_clock=Number(m_clock)+1;
		s=0;
        document.clockform.timer.value = m_clock + "  мин.  " + s+"  сек.";
        setTimeout("gettimer()", 1000);
        return false;
		s=s+1;		
	  }
	}
}
function stoptimer()
{
	alert("Вы не выполнили тест вовремя! Ваша оценка 'неудовлетворительно'!");	
}
</script>
<?php $k=$_GET['kol_vo']; ?>
<style type="text/css">
body {
	background-color: #CFF;
}
</style>
<body onLoad = "gettimer()">
<div>
<form name = "clockform">
<span id="time-clock">&nbsp;&nbsp;</span>
<input name="timer" type="text" value="">
<span id="number">В тесте &nbsp;<strong><?php echo $k; ?></strong>&nbsp;&nbsp;вопрос(а)ов</span>
</form>
</div>

</body> 