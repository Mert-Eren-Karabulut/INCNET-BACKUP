<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 	<link rel="shortcut icon" href="favicon.ico" >
   <title>Welcome to the Matrix</title>
   <meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
   <meta name="robots" content="all" />
   <meta name="author" content="Jason Woods" />
   <meta name="description" content="Moo2u2 script - Matrix falling code in Javascript" />

   <script type="text/javascript">
      // ------------------------------------------------------------------------------------
      //
      //  Matrix Code v3.0
      //  By Moo2u2
      //  
      //  Feel free to use, copy, change the code but please mention me in your comments
      //  
      // ------------------------------------------------------------------------------------
   
      var theinHTML;
      var thelessstr;
      var ascSt=33; 
      var ascEnd=126;
      var numoflines = 20;
      var lines = new Array();
      var intervalID = new Array();
      var subIntervalID = new Array();
      var subIntervalID2 = new Array();
      var scH = screen.height-220;
      var scW = screen.width-50;
      
      window.onload = createlines;
      
      // -------------------------------------------------------------------------------------
      // Convert decimal to hex (for the colour)
      
      var hD="0123456789ABCDEF";
      function d2h(d) 
      {
         var h = hD.substr(d&15,1);
         while(d > 15) 
         { 
            d >>= 4; 
            h = hD.substr(d&15,1)+h;
         }
         return h;
      }
      
      // -------------------------------------------------------------------------------------
      // The line object
      
      function line(length, maxlength, chars, speed, x)
      {
         this.length = length;
         this.maxlength = maxlength;
         this.chars = chars;
         this.speed = speed;
         this.x = x;
      }
      
      // -------------------------------------------------------------------------------------
      // Creates the lines
      
      function createlines()
      {     
                     
         // create the lines as objects as defined above with length, characters, speed, x-value
      
         for(var eachline = 0; eachline < numoflines; eachline++)
         {
            lines[eachline] = new line(0, Math.round(Math.random()*15+5), String.fromCharCode(Math.round(Math.random()*(ascEnd-ascSt)+ascSt)), Math.round(Math.random()*400+100), eachline*45);
         }
      
         // write the lines
      
         for(var writelines = 0; writelines < numoflines; writelines++)
         {
            var newline = document.createElement("div");
            newline.id = "char" + writelines;
            newline.style.position = "absolute";
            newline.style.top = "5px";
            newline.style.left = lines[writelines].x + "px";
            
            var firstchar = document.createElement("div");
            var newcolor = d2h(Math.round(1/(lines[writelines].maxlength+1)*255));
            if(newcolor.length == 1)
               newcolor = "0" + newcolor;
            firstchar.style.color = "#00"+newcolor+"00"
            firstchar.innerHTML = lines[writelines].chars
            
            newline.appendChild(firstchar);
            
            document.body.appendChild(newline);
         }
      
         start();
      }
      
      // -------------------------------------------------------------------------------------
      // Starts it moving & changing
      
      function start() 
      {
         for(var pickastring = 0; pickastring < numoflines; pickastring++) 
         {
            intervalID[pickastring] = setInterval("addchars("+pickastring+")", lines[pickastring].speed);
         }
      }
      
      // -------------------------------------------------------------------------------------
      // Add random characters to the string (and a line break) 
      // and make sure the last one is light
      // once it gets to maxlength start moving down
      
      function addchars(theline) 
      {
         if(lines[theline].length >= lines[theline].maxlength) 
         {
            clearInterval(intervalID[theline]);
            subIntervalID[theline] = setInterval("movethestring("+theline+")", lines[theline].speed);
         }
         else
         {
            // Get a char (not " or ' or \ or it'll get confused)
            
            myRandomChar = String.fromCharCode(Math.round(Math.random()*(ascEnd-ascSt)+ascSt));
            while(myRandomChar == "'" || myRandomChar == '"' || myRandomChar == "\\")
               myRandomChar = String.fromCharCode(Math.round(Math.random()*(ascEnd-ascSt)+ascSt));

            // Make a new div for it (so we can change it's colour)
            
            var newchar = document.createElement("div");
            newchar.innerHTML = myRandomChar;
            document.getElementById("char"+theline).appendChild(newchar);
            
            // Colour it
            
            var i;
            for(i = 0; i <= lines[theline].length; i++)
            {
               var newcolor = d2h(Math.round((i+1)/(lines[theline].maxlength+1)*255));
               newcolor = "" + newcolor;
               if(newcolor.length == 1)
                  newcolor = "0" + newcolor;
               document.getElementById("char"+theline).childNodes[i].style.color = "#00" + newcolor + "00";
               document.getElementById("char"+theline).childNodes[i].style.fontWeight = "normal";
            }
            document.getElementById("char"+theline).childNodes[i].style.color = "#99FF99";
            document.getElementById("char"+theline).childNodes[i].style.fontWeight = "bold";
            
            // Increase length by one
            
            lines[theline].length++;
         }
      }
      
      
      // -------------------------------------------------------------------------------------
      // Moves the string (creates and destroys chars)
      
      function movethestring(theline)
      {
         var topstringnum = document.getElementById("char"+theline).offsetTop;
         
         if((topstringnum + (lines[theline].maxlength * 15)) >= scH) 
         {
            clearInterval(subIntervalID[theline]);
            subIntervalID2[theline] = setInterval("clearletters("+theline+")", lines[theline].speed);
         }
         else
         {
            // create
            
            myRandomChar = String.fromCharCode(Math.round(Math.random()*(ascEnd-ascSt)+ascSt));
            while(myRandomChar=="'" || myRandomChar=='"' || myRandomChar=="\\")
               myRandomChar = String.fromCharCode(Math.round(Math.random()*(ascEnd-ascSt)+ascSt));
            
            var newchar = document.createElement("div");
            newchar.innerHTML = myRandomChar;
            document.getElementById("char"+theline).appendChild(newchar);
            
            // delete
            
            document.getElementById("char"+theline).removeChild(document.getElementById("char"+theline).childNodes[0]);
            
            // re-colour
            
            var i;
            for(i = 0; i < lines[theline].length; i++)
            {
               var newcolor = d2h(Math.round((i+1)/(lines[theline].maxlength+1)*255));
               newcolor = "" + newcolor;
               if(newcolor.length == 1)
                  newcolor = "0" + newcolor;
               document.getElementById("char"+theline).childNodes[i].style.color = "#00" + newcolor + "00";
               document.getElementById("char"+theline).childNodes[i].style.fontWeight = "normal";
            }
            document.getElementById("char"+theline).childNodes[i].style.color = "#99FF99";
            document.getElementById("char"+theline).childNodes[i].style.fontWeight = "bold";
            
            // move
            
            document.getElementById("char"+theline).style.top = (topstringnum+15) + "px";
         }
      }
      
      // -------------------------------------------------------------------------------------
      // pretty much the opposite of addchars() 
      
      function clearletters(theline) 
      {
         if(lines[theline].length <= -1) 
         {
            clearInterval(subIntervalID2[theline]);
            document.getElementById("char"+theline).style.top = 0;
            intervalID[theline] = setInterval("addchars("+theline+")", lines[theline].speed);
         }
         else
         {
            // Remove the first character
            
            document.getElementById("char"+theline).removeChild(document.getElementById("char"+theline).childNodes[document.getElementById("char"+theline).childNodes.length-1]);
            
            // Move it down by 15px
            
            var topstringnum = document.getElementById("char"+theline).offsetTop;
            document.getElementById("char"+theline).style.top = topstringnum+15 + "px";
         
            // Decrease length by one
         
            lines[theline].length--;
         }
      }
   </script>
   
   <style type="text/css">
      body {
         font: normal normal normal 15px/15px symbol,verdana; 
         color:#00FF00;
         background-color:black;
         margin:0;
         padding:0;
      }
      body div {
         text-align: center;
      }
   </style>

</head>

<body>
   <p style="text-align:center"></p>
</body>
</html>
