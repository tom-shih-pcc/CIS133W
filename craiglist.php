<?php

	if(isset($_POST['searchText']))
	{
		$html= file_get_contents('https://portland.craigslist.org/search/sss?query='.$_POST['searchText']);
		$html = mb_convert_encoding($html,'HTML-ENTITIES','UTF-8');
		$PHP_contents = base64_encode($html);
		
	}

	//echo $html;

?>

<html>
<head>
<style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 180px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.desc {
  padding: 15px;
  text-align: center;
}
</style>
</head>
<body>

<form action="craiglist.php" method="POST">
Search: <br>
<input type="text" name="searchText" value="">
<br><br>
<input type="submit" value="Submit">
</form>

</body>
</html>

<script>
	var PAGE="<?php echo $PHP_contents?>";
</script>

<script>
	if(PAGE)
	{
		var parser=new DOMParser();
		var contents = parser.parseFromString(atob(PAGE),'text/html');
	//	console.log(contents);
		var results = contents.getElementsByClassName("result-info");
		for(var i=0;i<results.length;i++)
		{
			var element=results[i];
			//console.log(element);
			
			for(var j=0;j<element.childNodes.length;j++)
			{
			//	console.log(j+" "+element.childNodes[j].nodeType);
			//	console.log(j+" "+element.childNodes[j].innerHTML);		
			}
			
			var dateStr=element.childNodes[3].innerHTML;
			console.log('Date:'+dateStr);
			var titleStr=element.childNodes[5].innerHTML;
			console.log('Title:'+titleStr);

			var element7= element.childNodes[7];
			var element7Child0=element7.getElementsByClassName("result-price")[0];
			
			if(element7Child0)
			{
				console.log(element7Child0.innerHTML);
				var priceStr = element7Child0.innerHTML;
			
				var divGallery= document.createElement('div');
				divGallery.className='gallery';
				
				var divDesc= document.createElement('div');
				divDesc.className='desc';
				
				var p1 =document.createElement('p');
				p1.innerHTML=dateStr;
				var p2 =document.createElement('p');
				p2.innerHTML=titleStr;
				var p3 =document.createElement('p');
				p3.innerHTML=priceStr;
				
				divDesc.appendChild(p1);
				divDesc.appendChild(p2);
				divDesc.appendChild(p3);
				
				divGallery.appendChild(divDesc);
				document.body.appendChild(divGallery);
			
			}

		}
	}
</script>