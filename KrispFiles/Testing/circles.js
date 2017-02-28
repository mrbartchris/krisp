function template (){
	var a = 0;
	var turnCounter = 0;
	var turn = document.createTextNode("Red Turn");
	var turnPar = document.createElement("P");
	turnPar.id = "turnPar";
	var divbod = document.getElementById('jscb');
	turnPar.appendChild(turn);
	divbod.appendChild(turnPar);
	divbod.appendChild(document.createElement("br"));
	for (var x = 0; x < 8; x++){
		for (var y = 0; y < 8; y++){
			
			var img = new Image();
			img.src = 'Testing/square.png';
			img.width = '91';
			img.height = '73';
			img.id = a;
			img.border = "0";
			
			divbod.append(img);
			//document.write(a);
			a++;
						
			img.onmouseover = function(){
				var img1 = document.getElementById(this.id);
				img1.style = "border: 1px solid blue;";
			};
			img.onmouseout = function(){
				var img1 = document.getElementById(this.id);
				img1.style = "border:0px";
			}
				
			img.onclick = function change(){
				var img1 = document.getElementById(this.id);
				var rootID = img1.id;
				while (rootID>7){
					rootID -= 8;
				}
				
				var tmp;
				function fill(){
					if (turnCounter%2 == 0){
						tmp.src = "Testing/squarefillR.png";
						turn.nodeValue = "Yellow Turn";
					}
					else {
						tmp.src = "Testing/squarefillY.png";
						turn.nodeValue = "Red Turn";
					}
				}
				
				for(var b = 0; b<8; b++){
					tmp = document.getElementById(+rootID+(8*b));
					if(tmp.id > 63){
						break;
					}
					else if(tmp.src.match("squarefillR.png") || tmp.src.match("squarefillY.png")){
						var tmp = document.getElementById(+rootID+(8*(b-1)));
						fill();
						break;
					}
					else if(tmp.id > 55) {
						fill();
					}
				}
				turnCounter = winCheck(turnCounter);
			};
		}
		document.write("<BR>");
	}
	
	
	
}
template();


function winCheck(turnCounter){
	//Horizontal 	= n, n+1, n+2, n+3
	//Vertical 		= n, n+8, n+16, n+24
	//Diagonal (\)	= n, n+9, n+18, n+27
	//Diagonal (/)	= n, n+7, n+14, n+21
	
	var end = false;
	
	for(var i=0; i<8; i++){ //horizontal
		for (var nx = 0; nx<5; nx++){
			var rc = 0, yc = 0;
			for (var n = 0; n<4; n++){
				var elemId = (8*i)+n+nx;
				var imgx = document.getElementById (elemId);
				if (imgx.src.match("squarefillR.png")) {rc++;}
				else if (imgx.src.match("squarefillY.png")) {yc++;}
			}	
			if (rc == 4) {end = true; alert("Red Wins!");break;}
			else if (yc ==4) {end = true; alert("Yellow Wins!");break;}
		}
	}
	for(var i=0; i<40; i++){ //vertical	
		var rc = 0, yc = 0;
		for (var n = 0; n<4; n++){
			var elemId = i+(8*n);
			var imgx = document.getElementById (elemId);
			if (imgx.src.match("squarefillR.png")) {rc++;}
			else if (imgx.src.match("squarefillY.png")) {yc++;}
		}	
		if (rc == 4) {end = true; alert("Red Wins!");break;}
		else if (yc ==4) {end = true; alert("Yellow Wins!");break;}
	}
	for(var i=0; i<5; i++){ //diagonal(\)
		for (var n = 0; n<5; n++){
			var rc = 0, yc = 0;
			for(var inner=0; inner<4; inner++){
				var elemId = i+(8*n)+(9*inner);
				var imgx = document.getElementById (elemId);
				if (imgx.src.match("squarefillR.png")) {rc++;}
				else if (imgx.src.match("squarefillY.png")) {yc++;}
			}	
			if (rc == 4) {end = true; alert("Red Wins!");break;}
			else if (yc ==4) {end = true; alert("Yellow Wins!");break;}
		}
	}
	
	for(var i=3; i<8; i++){ //diagonal(/)
		for (var n = 0; n<5; n++){
			var rc = 0, yc = 0;
			for(var inner=0; inner<4; inner++){
				var elemId = i+(8*n)+(7*inner);
				var imgx = document.getElementById (elemId);
				if (imgx.src.match("squarefillR.png")) {rc++;}
				else if (imgx.src.match("squarefillY.png")) {yc++;}
			}
			if (rc == 4) {end = true; alert("Red Wins!");break;}
			else if (yc ==4) {end = true; alert("Yellow Wins!");break;}			
		}
	}
	
	turnCounter++;
	if(turnCounter>63 && end==false){
		alert("Draw!");	
		end = true;
	}
	
	if(end==true) {
		alert("Resetting!");
		document.getElementById('turnPar').innerHTML = "Red Turn";
		turnCounter = 0;
		for(var i=0; i<64; i++){
			document.getElementById(i).src = 'Testing/square.png';
		}
	}
	return turnCounter;
}