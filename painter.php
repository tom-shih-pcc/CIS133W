<?php

	$jsonShapes= urldecode($_POST['shapes']);
	echo $jsonShapes;
	
	$shapes=json_decode($jsonShapes);
	foreach($shapes as $element)
	{
		echo $element->shape.'<br>';
		echo $element->x.'<br>';
		echo $element->y.'<br>';
		echo $element->color.'<br>';
		
	}

?>


<html>
<head>
</head>
<body>

	<div style="margin-bottom:20px;">
		<canvas id="myCanvas" width="600" height="400" style="border:2px solid gray" /> 
	</div>
	
	<select id="shapeSelect">
		<option value=""></option>
		<option value="circle">circle</option>
		<option value="rectangle">rectangle</option>
	</select>
	<select id="colorSelect">
		<option value="black"></option>
		<option value="blue">blue</option>
		<option value="red">red</option>
	</select>
	<button id="cleanBtn">Clean</button>
	<button id="reloadBtn">Reload</button>
	<button id="exportJson">Json</button>

</body>
</html>

<script>

var Rectangle,Circle;
(function(){
	var myCanvas = document.getElementById("myCanvas");
	var cleanBtn = document.getElementById("cleanBtn");
	//var colorSelect = document.getElementById("colorSelect");
	var ctx = myCanvas.getContext("2d");
	
	var mouse_x=0;
	var mouse_y=0;
	var shapes=[];
	
	myCanvas.onmouseup=function(e){
		mouse_x=e.clientX;
		mouse_y=e.clientY;
		
		var selectedShape=document.getElementById('shapeSelect');
		var selectedShapeVal= selectedShape.options[selectedShape.selectedIndex].value;
		
		var selectedColor=document.getElementById('colorSelect');
		var selectedColorVal= selectedColor.options[selectedColor.selectedIndex].value;

		console.log(mouse_x+" "+mouse_y+" "+selectedShapeVal+" "+selectedColorVal);
		
		if(selectedShapeVal=='circle')
		{
			var cir1=new Circle(selectedColorVal,mouse_x,mouse_y);
			//cir1.move(50,60);
			cir1.draw();		
			shapes.push(cir1);
		}
		else if(selectedShapeVal=='rectangle')
		{			
			var rec1=new Rectangle(selectedColorVal,mouse_x,mouse_y);
			rec1.draw();
			shapes.push(rec1);
		}
	}
	
	cleanBtn.onclick=function(){
		console.log('clean');
		ctx.clearRect(0,0,myCanvas.width,myCanvas.height);	
	}

	reloadBtn.onclick=function(){
		shapes.forEach(function(element){
			element.draw();
		});
	}
	
	exportJson.onclick=function(){
		var shapesJson=JSON.stringify(shapes);
		console.log(shapesJson);
		
		var form=document.createElement('form');
		form.method='POST';
		form.action='painter.php';
		form.innerHTML='<input type="hidden" name="shapes" value="'+ encodeURIComponent(shapesJson)+'">';
		document.getElementsByTagName('body')[0].appendChild(form);
		form.submit();
	}
	
	function Shape(color,x,y,shape)
	{
		this.color=color;
		this.x=x;
		this.y=y;
		this.shape=shape;
	}

	Shape.prototype.move=function(x,y){
		this.x+=x;
		this.y+=y;
		console.log("shape moved");
	}

	Rectangle=function(color,x,y){
		Shape.call(this,color,x,y,'rectangle');
	}

	Rectangle.prototype=Object.create(Shape.prototype);

	Rectangle.prototype.draw =function(){
		ctx.fillStyle=this.color;
		ctx.fillRect(this.x, this.y, 150, 100);
	}

	Circle=function(color,x,y){
		Shape.call(this,color,x,y,'circle');
	}

	Circle.prototype=Object.create(Shape.prototype);

	Circle.prototype.draw =function(){
		ctx.fillStyle=this.color;
		ctx.beginPath();
		ctx.arc(this.x, this.y, 50, 0, 2 * Math.PI);
		ctx.fill();
	}
})();





/*

*/

</script>