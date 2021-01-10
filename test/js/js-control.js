// Начальное состояние:
var menu_select=0;
var update_state=0; //Стоп функции обновления сессий
//var update_test=0; //Стоп фунции обновления результатов тестирования
var test_on=false; // Меню Тесты не заполнено
var group_on=false; //Меню Группы не заполнено
var result_on=false; // Результаты тестов не выведены
var test_no='';
var group_no='';
var time_result=4000;
var time_session=4000;
var timerId=null;//Идентификатор таймера
$("#id_selectmenu_test").selectmenu();// Меню выбора теста
$("#id_selectmenu_group").selectmenu();// Меню выбора группы
$("#id_statistic").button();// Чекбокс включения статистики
// Выбор группы, статистика и запись в файл не доступны
$("#select_group, #check_statistic, #btn_save").hide();
var svg = d3.select("#statistic");//Область рисования
//Основная программа 
$(document).ready(function(){
//////////////////////////////////////////
//Функция обновления таблицы сессий
function update_sessions() {
  if(update_state==1) {
    $.ajax({
    url:"./php/ctrl-test.php?my_type=session",
	type:"POST",
	data:"null",
	dataType:"html",
 	beforeSend:function(){		    	
 	},           
	success:function(html) {
	  if(html) {
	    if(menu_select==2){
		  $("#id_result_3").empty().append().html(html);
//Четные строки таблицы - серые					
		  $("#id_result_3 tr:even").css("background-color","#ccc");
//Превая строка таблицы зеленая                    
          $("#id_result_3 tr:first").css("background-color","#ACDD4A");					
		  $("#id_result_3").show(); 
		}//END if(menu_select==2)	
        else{  
		  $("#id_result_3").empty().append().html(html);
//Четные строки таблицы - серые					
		  $("#id_result_3 tr:even").css("background-color","#ccc");
//Превая строка таблицы зеленая                    
          $("#id_result_3 tr:first").css("background-color","#ACDD4A");					
		  $("#id_result_3").hide(); 
		  update_state=0;  					
		}
	  }////END if (html)								
	  else $("#id_result_3").empty().show().append("Ошибка в выводе таблицы сессий!");
	},
	Error:function() {		
	  alert("Ошибка AJAX-запроса в выводе сессий!");
	}
	});
    setTimeout(update_sessions, time_session) ;		
  };//END if(update_state==1)
}
//Конец функции обновления таблицы сессий
//////////////////////////////////////////	
// Кнопка очистки таблицы сессий
$("#button").button().click(function(){
  $.ajax({
  url:"./php/ctrl-test.php?my_type=session",
  type:"POST",
  data:"my_data=null",
  dataType:"html",
  beforeSend:function(){
    $("#id_result_3").show(); 		    	
  }, 			
  success:function(html) {
	if(html){
	  $("#id_result_3").empty().append().html(html);
//Четные строки таблицы - серые					
	  $("#id_result_3 tr:even").css("background-color","#ccc");
//Превая строка таблицы зеленая 					
      $("#id_result_3 tr:first").css("background-color","#ACDD4A"); 
	}//END if(html)
	else $("#id_result_3").empty().show().append("Ошибка в файле вывода списков!");
	},
    Error:function() {		
	  alert("Ошибка AJAX-запроса очистка сессий!");
	}
  });//END $.ajax
});
// Конец Кнопка очистки таблицы сессий
//////////////////////////////////////////  
// Вывод списка доступных тестов
function show_tests(){
  $.ajax({
  url:"./php/ctrl-test.php?my_type=test",
  type:"POST",
  data:"my_data=null",
  dataType:"html",
  beforeSend:function(){
    $("#id_result_2").empty().show().append().text("Запрос серверу отправлен! Ждите...");	
	},	 	
//Если список тестов получен
  success:function(html) {
    if(html) {			
	  $("#id_result_2").empty().append().html(html);
//Call-back функция для каждой кнопки
//Первая строка зеленая
	  $("#id_result_2 tr:first").css("background-color","#ACDD4A");			
	  $("input[id^='check_test_']").each(function(){
//Отслеживаем изменение состояния кнопки
	    $("#"+this.id).button().change(function() { // this == domElement
		  var s=$("input[id='"+this.id+"']").next($(".ui-button-text")).text();   
          if (s=="+Включен"){
		    $("input[id='"+this.id+"']").next($(".ui-button-text")).text("-Отключен");
			$("#"+this.id).button("option","disabled",true);
		  }
		  else {
		    $("input[id='"+this.id+"']").next($(".ui-button-text")).text("+Включен");
			$("#"+this.id).button("option","disabled",true);
		  }	       
		  $.ajax({
		  url:"./php/ctrl-test.php?my_type=test_update",
		  type:"POST",
		  data:"my_data="+this.value,
		  dataType:"text",
//Если переключение прошло успешно
		  success:function(text) {       
		    if(text) {		    			    			      		
			  if (text=="Тест включен!"){
//Ничего не делаем
			  }
			  else {			  			  	
//Выведется ошибка						
			  }              
            }//END if(text)
          },      
//Изменения состояния теста не произошли
 		  Error:function() {		
		    alert("Ошибка создания Call-back функции для кнопок");
		  },
		  complete: show_tests
          
          });//END AJAX	      	
		});//END button().change(function())
	  });//END each(function())	 					
	  if(menu_select==1){
	    $("#id_result_2").show();
	  }
	  else{
	    $("#id_result_2").hide();	
	  }  		
	}//END IF(html)			
//Список тестов не получен
	else $("#id_result_2").empty().show().append("Ошибка в файле вывода списков!");
	      },
		  Error:function() {		
		    alert("Список тестов не получен!");
		  }			
  });//EMD AJAX		

}
// Конец функции show_tests()
//////////////////////////////////////////
// Функция показать/скрыть график
function view_stat(){
//Если включена статистика, то отключаем показ таблицы
  if($("#id_statistic").button("option","label")=="Включить"){
    $("#id_statistic").button({"label":"Отключить"});
	$("#id_result_5").hide();
	$("#chart").show();  	
  }
//Если отключена статистика, то отключаем показ диаграммы
  else {
    $("#id_statistic").button({"label":"Включить"});
	$("#id_result_5").show();
	$("#chart").hide(); 	
  }
}
// Конец функцииФункция показать/скрыть график
//////////////////////////////////////////
// Функция получения списка тестов в формате JSON get_json_test(test, group)
function get_json_test(test, result){
  $.ajax({
  url:"./php/ctrl-test.php?my_type=test_json",
  type:"POST",
  data:"my_data=null",
  dataType:"json",
//Перед отправкой запроса:
  beforeSend:function(){	  
    $("#id_result_5").empty().show().append().text("Подождите!Идет загрузка страницы...");
    $("#select_test").show();	  	
  },				
//Если запрос прошел успешно:
  success:function(json) {
    $("#id_result_5").empty();
	if(json) {
//Заполняем меню Тесты
      var test_disabled='<option selected="selected" disabled="disabled">Выберите тест</option>';
      $("#id_selectmenu_test").append(test_disabled);
      $.each(json, function(i,res){ 
        var sm="<option value='"+res.tbl+"'>"+res.desk+"</option>";     
        $("#id_selectmenu_test").append(sm);      
      });
      test_on=true; // Меню Тесты заполнено   
      $("#id_selectmenu_test").selectmenu("refresh");
      $("#id_selectmenu_test").selectmenu({
	    change:function(event,ui) {
          group_on=false;
          result_on=false;
		  group_no='';
		  if (timerId) clearInterval(timerId);//Очищаем таймер		 		  
		  $("#id_result_5, #chart").hide();
		  if(ui.item.value) {		  	
//Сначала очищаем меню Группы после предыдущего запроса
            $("#id_selectmenu_group").empty();                    
            get_json_group(ui.item.value+"_a");
		    $("#chart").hide();         
		  }
	    }//END change:function(event,ui)
      });//END $("#id_selectmenu_test").selectmenu
	};//END IF(JSON)
  },//END success:
//Если произошла ошибка
  Error: function(){			
  },						
  });//END AJAX
}
// Конец Функция получения списка тестов в формате JSON get_json_test(test, group)
//////////////////////////////////////////
// Функция получения списка групп, сдававших тест get_json_group(test)
//////////////////////////////////////////
function get_json_group(test){
  if (!test){   
    return;	
  }
  else {		
    $.ajax({
	url:"./php/ctrl-test.php?my_type=group_json",
	type:"POST",
	data:"my_data="+test,
	dataType:"json",
//Перед отправкой запроса:
	beforeSend:function(){     
      $("#id_result_5").empty().show().append().text("Запрос серверу отправлен! Ждите...");
      $("#select_group, #check_statistic, #btn_save").hide();
// 	  $("#select_group").show();
      $("#chart").hide();     	
	},			
//Если запрос прошел успешно:
	success:function(json) {	  
	  $("#select_group").show();
	  if(json) {
//Заполняем меню Группа
//Сначала очищаем после предыдущего запроса
        $("#id_selectmenu_group").empty();
        var group_disabled='<option selected="selected" disabled="disabled">Выберите группу</option>';
        $("#id_selectmenu_group").append(group_disabled);        
        $.each(json, function(i,res){ 
          var sm="<option value='"+res.group+"'>"+res.group+"</option>"; 
          $("#id_selectmenu_group").append(sm);      
        });   
	    group_on=true;//Меню Группа заполнено
	    $("#id_result_5").empty().hide(); 
        $("#id_selectmenu_group").selectmenu("refresh"); 
	  };//END if(json)
	},//END success:
//Если произошла ошибка
	Error: function(){  		
	  },						
	});//END AJAX
  }//END ELSE
}
// Конец Функция получения списка групп, сдававших тест get_json_group(test)
//////////////////////////////////////////
// Функция выбора меню Группы
//////////////////////////////////////////
$("#id_selectmenu_group").selectmenu({
  change:function(event,ui) {	  
    if(ui.item.value) {
      test_no=$("#id_selectmenu_test").val();
      group_no=ui.item.value;         
      view_stat;
      $("#id_result_5").empty().show().append().text("Запрос серверу отправлен! Ждите...");
      $("#chart").hide(); 
	  $("#id_statistic").button("disable");
	  $("#check_statistic, #btn_save").show();            
      if (timerId) clearInterval(timerId);//Если таймер был включен, то очищаем его 
//Выводим результат      
      timerId=setInterval(function(){show_result(test_no,group_no)}, time_result) ;
      $("#id_save").remove();
      var href_src='<a href="./php/ctrl-test.php?my_type=save_to_file&table_id='
          +$("#id_selectmenu_test").val()
          +'&group_id='+$("#id_selectmenu_group").val()
          +'"><button id="id_save">Сохранить</button></a>';
      $("#btn_save").append(href_src);
      $("#id_save").button();
      $("#id_save").button("disable");                    			
	}			     
  }//END change:function(event,ui)
});	    
// Конец Функция выбора меню Группы
//////////////////////////////////////////
// Блок функций построения 3D-диаграммы
//*************************************************************************
!function(){
  var Pie3D={};
  function pieTop(d, rx, ry, ir ){
    if(d.endAngle - d.startAngle == 0 ) return "M 0 0";
	  var sx = rx*Math.cos(d.startAngle),
	  sy = ry*Math.sin(d.startAngle),
	  ex = rx*Math.cos(d.endAngle),
	  ey = ry*Math.sin(d.endAngle);			
	  var ret =[];
	  ret.push("M",sx,sy,"A",rx,ry,"0",(d.endAngle-d.startAngle > Math.PI? 1: 0),"1",ex,ey,"L",ir*ex,ir*ey);
	  ret.push("A",ir*rx,ir*ry,"0",(d.endAngle-d.startAngle > Math.PI? 1: 0), "0",ir*sx,ir*sy,"z");
	  return ret.join(" ");
	}//END IF
  function pieOuter(d, rx, ry, h ){
	var startAngle = (d.startAngle > Math.PI ? Math.PI : d.startAngle);
	var endAngle = (d.endAngle > Math.PI ? Math.PI : d.endAngle);
	var sx = rx*Math.cos(startAngle),
	sy = ry*Math.sin(startAngle),
	ex = rx*Math.cos(endAngle),
	ey = ry*Math.sin(endAngle);		
	var ret =[];
	ret.push("M",sx,h+sy,"A",rx,ry,"0 0 1",ex,h+ey,"L",ex,ey,"A",rx,ry,"0 0 0",sx,sy,"z");
	return ret.join(" ");
  }
  function pieInner(d, rx, ry, h, ir ){
	var startAngle = (d.startAngle < Math.PI ? Math.PI : d.startAngle);
	var endAngle = (d.endAngle < Math.PI ? Math.PI : d.endAngle);
	var sx = ir*rx*Math.cos(startAngle),
	sy = ir*ry*Math.sin(startAngle),
	ex = ir*rx*Math.cos(endAngle),
	ey = ir*ry*Math.sin(endAngle);
	var ret =[];
	ret.push("M",sx, sy,"A",ir*rx,ir*ry,"0 0 1",ex,ey, "L",ex,h+ey,"A",ir*rx, ir*ry,"0 0 0",sx,h+sy,"z");
	return ret.join(" ");
  }
// Функция подписи процентов на секторах диаграммы
  function getPercent(d){
	return (d.endAngle-d.startAngle > 0.2 ? 
	d.data.label+'('+Math.round(1000*(d.endAngle-d.startAngle)/(Math.PI*2))/10+'%'+')': '');
  }		
  Pie3D.transition = function(id, data, rx, ry, h, ir){
	function arcTweenInner(a){
	  var i = d3.interpolate(this._current, a);
	  this._current = i(0);
	  return function(t){ return pieInner(i(t), rx+0.5, ry+0.5, h, ir);  };
	}
	function arcTweenTop(a){
	  var i = d3.interpolate(this._current, a);
	  this._current = i(0);
	  return function(t) { return pieTop(i(t), rx, ry, ir);  };
	}
	function arcTweenOuter(a) {
	  var i = d3.interpolate(this._current, a);
	  this._current = i(0);
	  return function(t){return pieOuter(i(t), rx-.5, ry-.5, h);  };
	}
	function textTweenX(a){
	  var i = d3.interpolate(this._current, a);
	  this._current = i(0);
	  return function(t){return 0.6*rx*Math.cos(0.5*(i(t).startAngle+i(t).endAngle));};
	}
	function textTweenY(a){
	  var i = d3.interpolate(this._current, a);
	  this._current = i(0);
	  return function(t){return 0.6*rx*Math.sin(0.5*(i(t).startAngle+i(t).endAngle));};
	}
	var _data = d3.layout.pie().sort(null).value(function(d){return d.value;})(data);		
	d3.select("#"+id).selectAll(".innerSlice").data(_data)
	  .transition().duration(750).attrTween("d", arcTweenInner); 			
	d3.select("#"+id).selectAll(".topSlice").data(_data)
	  .transition().duration(750).attrTween("d", arcTweenTop); 		
	d3.select("#"+id).selectAll(".outerSlice").data(_data)
	  .transition().duration(750).attrTween("d", arcTweenOuter); 			
	d3.select("#"+id).selectAll(".percent").data(_data).transition().duration(750)
	  .attrTween("x",textTweenX).attrTween("y",textTweenY).text(getPercent); 	
	}
// Функция рисования диаграммы	
  Pie3D.draw=function(id, data, x /*center x*/, y/*center y*/, 
	rx/*radius x*/, ry/*radius y*/, h/*height*/, ir/*inner radius*/){
	var _data = d3.layout.pie().sort(null).value(function(d) {return d.value;})(data);
	var slices = d3.select("#"+id).append("g").attr("transform", "translate(" + x + "," + y + ")")
			       .attr("class", "slices");
	slices.selectAll(".innerSlice").data(_data).enter().append("path").attr("class", "innerSlice")
		  .style("fill", function(d){return d3.hsl(d.data.color).darker(0.7); })
		  .attr("d",function(d){return pieInner(d, rx+0.5,ry+0.5, h, ir);})
		  .each(function(d){this._current=d;});	
	slices.selectAll(".topSlice").data(_data).enter().append("path").attr("class", "topSlice")
		  .style("fill", function(d) { return d.data.color; })
		  .style("stroke", function(d) { return d.data.color; })
		  .attr("d",function(d){ return pieTop(d, rx, ry, ir);})
		  .each(function(d){this._current=d;});
	slices.selectAll(".outerSlice").data(_data).enter().append("path").attr("class", "outerSlice")
		  .style("fill", function(d) { return d3.hsl(d.data.color).darker(0.7); })
		  .attr("d",function(d){ return pieOuter(d, rx-.5,ry-.5, h);})
		  .each(function(d){this._current=d;});
	slices.selectAll(".percent").data(_data).enter().append("text").attr("class", "percent")
		  .attr("x",function(d){ return 0.6*rx*Math.cos(0.5*(d.startAngle+d.endAngle));})
		  .attr("y",function(d){ return 0.6*ry*Math.sin(0.5*(d.startAngle+d.endAngle));})
		  .text(getPercent).each(function(d){this._current=d;});							
// Цвета легенды
	slices.selectAll(".rectS").data(_data).enter().append("rect").attr("class", "rectS")
          .attr("x", 345)
          .attr("y", function(d,i) { return -63+i*20;})
          .attr("width", 15)
          .attr("height", 15)
          .style("fill", function(d){return d.data.color;});
// Подписи легенды		
	slices.selectAll(".legendS").data(_data).enter().append("text").attr("class", "legendS")
		  .attr("x",430)
		  .attr("y",function(d,i) { return -50+i*20;})
		  .text(function(d){return d.data.label+" - ";});
// Данные легенды		
	slices.selectAll(".legendD").data(_data).enter().append("text").attr("class", "legendD")
		  .attr("x",460)
		  .attr("y",function(d,i) { return -50+i*20;})
		  .text(function(d){return d.data.value;});								
	}	
	this.Pie3D = Pie3D;
}();
// Конец Блок функций построения 3D-диаграммы
//////////////////////////////////////////
//Кнопка Показать статистику
//////////////////////////////////////////
$("#id_statistic").button().click(function(){
  view_stat();
});
//Конец Кнопка Показать статистику
//////////////////////////////////////////
//Кнопка отключить все тесты
//////////////////////////////////////////
$("#button_all").button().click(function(){
  $.ajax({
  url:"./php/ctrl-test.php?my_type=all_test_off",
  type:"POST",
  data:"my_data=null",
  dataType:"text",
  success:function(text) {
    if(text) {  
	  show_tests();
	}
	else alert("Не могу отключить все тесты!");
	},
	Error:function() {		
	  alert("Ошибка AJAX-запроса на отключение тестов!");
	}
  });//END AJAX
});
// Конец Кнопка отключить все тесты
//////////////////////////////////////////
// Функция вывода результатов сдачи тестов show_result(table_id,group_id)
//////////////////////////////////////////
function show_result(table_id,group_id){
  $.ajax({
  url:"./php/ctrl-test.php?my_type=get_result",
  type:"POST",
  data: {
  table_id:table_id,
  group_id:group_id
  },
  dataType:"json",					
  beforeSend:function(){
    if(!result_on){
      $("#chart").hide();                                               
	}   	
  },	
  success:function(json) { 
    if(json) {    
      $("#id_result_5").empty();
      var str_header =
          '<table border="1" width="80%" cellspacing="0">'+
            '<tr id=id_table_result>'
			  +'<td width="5%">'+'№ п/п'+' </td>'
			  +'<td width="20%">'+'Ф.И.О.'+' </td>'
			  +'<td width="5%">'+'Оценка'+' </td>'						
			  +'<td class=no_otv>'+'Неправильные ответы'+' </td>'						
			  +'</tr>';
      $("#id_result_5").append(str_header);	                  
      var i=0; // Счетчик сдававших
      $.each(json.table, function(i,res){
        i+=1;
        var str =
          '<tr>'
		    +'<td>'+i+'</td>'
			+'<td>'+res.login+'</td>'
			+'<td>'+res.mark+' </td>'				
			+'<td class=no_otv>'+res.no_otv+'</td>'			
			+'</tr>';						
        $("#id_result_5 tbody").append(str);
// Перенос строки для столбца "Неправильные ответы"                        
        $("#id_result_5 .no_otv").css("word-break","break-all");    
      }
    );//END $.each(json.table, function(i,res))            
// Четные строки таблицы серые
	$("#id_result_5 tr:not(:first):even").css("background-color","#ccc");
//Первая строка зеленая
    $("#id_result_5 tr:first").css({"background-color":"#ACDD4A", "text-align":"center"});
    if(!(test_on && group_on && result_on)){
      $("#id_result_5,#chart").hide();
	}									
// Рисование 3D-диаграммы
//////////////////////////////////////////
//****************************************
var w = 700;
var h = 400;
// Исходные данные для построения диаграммы
// Отл., Хор., Удов., Неуд.
var markData=[
	{label:"Отл.", color:"#DC3912", value:json.stat[0].m_5},
	{label:"Хор.", color:"#FF9900", value:json.stat[0].m_4},
	{label:"Удов.", color:"#109619", value:json.stat[0].m_3},
	{label:"Неуд.", color:"#3366CD", value:json.stat[0].m_2}];
// Данные для статистики
var markL=[{legend:"Лучший результат (10-ти б.):", result:json.stat[0].m_max},
           {legend:"Худший результат (10-ти б.):", result:json.stat[0].m_min},
           {legend:"Ср. бал (4-х б.):", result:json.stat[0].m_sr},
           {legend:"Всего сдавало чел.:", result:json.stat[0].m_all}];
//Подготавливаем данные
function setData(){
  return markData.map(function(d){ 
    return {label:d.label, value:d.value, color:d.color};
  });
}		
// Очищаем область рисования
svg.selectAll("*").remove();
Pie3D.draw("statistic", setData(), 200, 150, 200, 150, 50, 0.4);
// Добаляем статистику:
svg.selectAll(".legendSt").data(markL).enter().append("text")
   .attr("class", "legendSt")
   .attr("x",630)
   .attr("y",function(d,i) {return 20+20*i;})
   .text(function(d) {return d.legend;});				
svg.selectAll(".legendStD").data(markL).enter().append("text")
   .attr("class", "legendStD")
   .attr("x",660)
   .attr("y",function(d,i) {return 20+20*i;})
   .text(function(d) {return d.result;});						
//****************************************
//////////////////////////////////////////
// Конец Рисование 3D-диаграммы					        
result_on=true;//Результат получен
// Включаем кнопки Статистика и Записать в файл
$("#id_statistic, #id_save").button("enable");        
  if(menu_select==4){
//Если отключена статистика, то включаем показ таблицы
    if($("#id_statistic").button("option","label")=="Включить"){
	  $("#id_result_5").show();
	  $("#chart").hide();          		  	
    }
//Если включена статистика, то включаем показ диаграммы
	else{
	  $("#id_result_5").hide();
	  $("#chart").show()		  	
	}			
  }//END if(menu_select==4)
  else{
    $("#id_result_5, #chart").hide();
  }            
        } //END IF(json)
      },//END SUCCSESS 					
	  Error:function() {		
	    alert("Ошибка вывода результатов теста!");
	  }             
      });//END AJAX					
}
// Конец Функция вывода результатов сдачи тестов show_result(table_id,group_id)
//////////////////////////////////////////
// Боковое меню
$("#accordion").accordion({
  heightStyle: "content",
});
$("#accordion").accordion().css({
  padding: "0",
  width: "17%"
});
//////////////////////////////////////////
// Cкрыть все панели, показать панель Списки учебных групп
$("#mycontent div:not(#id_result_1)").hide();
$("#id_result_1, #id_group").show();
//////////////////////////////////////////
// Выбор панели
$("#accordion").accordion().click(function() {
  switch ($("#accordion").accordion("option","active")) {
//////////////////////////////////////////
//Списки учебных групп		
  case 0:
	menu_select=0;
	update_state=0;
	if (timerId) clearInterval(timerId);//Если таймер включен то очищаем его
	$("#mycontent div:not(#id_result_1)").hide();
	$("#id_result_1, #id_group").show();
	break;
//////////////////////////////////////////
// Доступные тесты
  case 1: 
	menu_select=1;
	update_test=0;
	if (timerId) clearInterval(timerId);//Если таймер включен то очищаем его
	$("#mycontent div:not(#id_result_2)").hide();
	$("#id_result_2").show();
	$("#id_button_test").show();			
	show_tests();			
	break;		
// Конец выбора Доступные тесты
//////////////////////////////////////////			
// Таблица сессий
  case 2:
	menu_select=2;
	update_state=1;
	if (timerId) clearInterval(timerId);//Если таймер включен то очищаем его
	$("#mycontent div:not(#id_result_3)").hide();
	$("#id_result_3").empty().show().append().text("Подождите!Идет загрузка страницы...");
	$("#id_button_session").show();
	update_sessions();
	break;
// Конец выбора Таблица сессий
//////////////////////////////////////////			
// Файл ошибок						
  case 3:
	menu_select=3;
	update_state=0;
	if (timerId) clearInterval(timerId);//Если таймер включен то очищаем его		
	$("#mycontent div:not(#id_result_4)").hide();
	$("#id_result_4").show();			
	break;
// Конец Файл ошибок			
//////////////////////////////////////////			
// Результаты тестов
  case 4:
	menu_select=4;
	update_state=0;
//Если результаты тестов уже выводились
	if(test_on && group_on && result_on){ 
	  $("#mycontent div:not(#id_result_5").hide();	
      $("#select_test,#select_group,#check_statistic,#btn_save").show();
      $("#id_result_5").empty().show().append().text("Обновляю страницу. Ждите...");
//Выводим результат             
      timerId=setInterval(function(){show_result(test_no,group_no)}, time_result);			
	}
//Если тест выбран, но группа не выбрана
	else if(test_on && group_on && !result_on){ 
	  $("#id_result_5").empty();
	  $("#mycontent div:not(#id_result_5)").hide();
	  $("#select_test, #select_group").show();
    }			
//Если Список тестов заполнен, но тест не выбран
	else if(test_on && !group_on && !result_on){
	  $("#id_result_5").empty();
	  $("#mycontent div:not(#id_result_5)").hide();
	  $("#select_test").show();			    			  	
	}
//При первом выборе раздела Результаты сдачи тестов			  			  
    else if(!test_on && !result_on){
	  $("#mycontent div:not(#id_result_5)").hide();
      get_json_test(test_on, result_on);				  	
	} 			    			
    break;
// Конец Результаты тестов			
	}//END switch
  });//END $("#accordion").accordion().click(function() 	
// Конец функции выбора панели
//////////////////////////////////////////
// Вывод списка учебных групп
// Создание списка учебных групп при загрузке страницы
$("#id_selectmenu").selectmenu({
  create: function( event, ui ){
    $.ajax({
	url:"./php/ctrl-test.php?my_type=group",
	type:"POST",
	data:"my_data=update",
	dataType:"html",
	beforeSend:function(){		
	  $("#id_group").empty().show().append().text("Подождите!Идет загрузка страницы...");	
	},
	success:function(html) {
//Если не дождались загрузки          
      if(menu_select!=0){
	    if(html) { 
		  $("#id_group").empty().hide().append().html(html);
//Действие при выборе группы-1
          $("#id_selectmenu").selectmenu({
	        select:function(event,ui) {
		      if(ui.item.value) {
		        $.ajax({
			    url:"./php/ctrl-test.php?my_type=group",
			    type:"POST",
			    data:"my_data=" + ui.item.value,
			    dataType:"html",
		        beforeSend:function(){
			      $("#id_result_1").empty().show().append().text("5.Запрос серверу отправлен! Ждите...");
		        },	
			    success:function(html) {
		          if(menu_select!==0){
			        if(html) {
				      $("#id_result_1").empty().hide().append().html(html);
// Четные строки таблицы серые
				      $("#id_result_1 tr:even").css("background-color","#ccc");
// Первая строка таблицы зеленая
                      $("#id_result_1 tr:first").css("background-color","#ACDD4A");
				    }//END IF html
			      }//END if(menu_select!==0)
			      else {
			        if(html) {
				      $("#id_result_1").empty().show().append().html(html);
// Четные строки таблицы серые
				      $("#id_result_1 tr:even").css("background-color","#ccc");
// Первая строка таблицы зеленая
                      $("#id_result_1 tr:first").css("background-color","#ACDD4A");
				    }//END IF html
				    else $("#id_result_1").empty().show().append("Ошибка в файле вывода списков!");
				  }//END else				  
			    },
		        Error:function() {		
		          alert("Ошибка!");
			    }
		        });//END AJAX
		      }//END if(ui.item.value) 
	        }//END change
    });//END $("#id_selectmenu").selectmenu
//Конец Действие при выборе меню
  }//END IF(html)
  else $("#id_selectmenu").empty().show().append("Ошибка в файле вывода списков!");		  	
  }// END if(menu_select!=0)
else{  
  if(html){           	
	$("#id_group").empty().show().append().html(html);				 
    $("#id_selectmenu").selectmenu({
	select:function(event,ui) {
	  if(ui.item.value) {
		$.ajax({
		url:"./php/ctrl-test.php?my_type=group",
		type:"POST",
		data:"my_data=" + ui.item.value,
		dataType:"html",
		beforeSend:function(){
		  $("#id_result_1").empty().show().append().text("Запрос серверу отправлен! Ждите...");	
		},	
		success:function(html) {
		  if(menu_select!==0){
			if(html) {
			  $("#id_result_1").empty().hide().append().html(html);
// Четные строки таблицы серые
			  $("#id_result_1 tr:even").css("background-color","#ccc");
// Первая строка таблицы зеленая
              $("#id_result_1 tr:first").css("background-color","#ACDD4A");
		    }//END IF html
		  }//END if(menu_select!==0)
		  else{
		    if(html) {
			  $("#id_result_1").empty().show().append().html(html);
// Четные строки таблицы серые
			  $("#id_result_1 tr:even").css("background-color","#ccc");
// Первая строка таблицы зеленая
              $("#id_result_1 tr:first").css("background-color","#ACDD4A");
			}//END IF html
			else $("#id_result_1").empty().show().append("Ошибка в файле вывода списков!");
	      }//END IF menu_select				  
		},
		Error:function() {		
		  alert("Ошибка!");
		}
		});//END AJAX-2
	  }//END if(ui.item.value)
	}//END select:function(event,ui) $("#id_selectmenu").selectmenu
  });// END $("#id_selectmenu").selectmenu
//Конец Действие при выборе меню
}//END IF(html)
  else $("#id_selectmenu").empty().show().append("Ошибка в файле вывода списков!");		  	
  }// END else (menu_select-1)
	},
	Error:function() {		
	  alert("Ошибка!");
	}
	});//END AJAX-1
  }//END if(ui.item.value)
// Конец Создание списка учебных групп при загрузке страницы			
});
// Конец вывода списка учебных групп
//////////////////////////////////////////
});