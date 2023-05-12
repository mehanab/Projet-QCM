$(document).ready(function() {

// chronomètre
var p = document.getElementById('temps');
var h=$('#heure').text()
var min=$('#minute').text()
var sec=$('#seconde').text()
var dse=0;

heure= parseInt(h)
min= parseInt(min)
sec= parseInt(sec)

var tmp=((((heure*60)+min)*60)+sec)*10+dse;
 
var chrono=setInterval(function (){
	 heure= Math.floor((tmp/600)/60)
     min=Math.floor((tmp/600)-heure*60);
     sec=Math.floor((tmp-((heure*60)*600)-min*600)/10);
     dse=tmp-((min*60)+sec)*10;

     if (heure==0 || (heure < 10)) { heure='0'+heure}
     if (min==0 || (min < 10)) { min='0'+min}
     if (sec==0 || (sec < 10)) { sec='0'+sec}

     	if (heure==0 && min ==0 && sec==0) 
     	{
     		clearInterval(chrono)
        $('#form').submit(); 
      }

     p.innerHTML=heure+':'+min+':'+sec;
     tmp--;  

},100);

     var offset=$('#chrono').offset()
     var chrono= offset.top
     $(window).scroll(function(){
          
          var scroll=window.scrollY
          var media = window.matchMedia("(min-width: 992px)");
         
          if (media.matches) 
          {
               if (scroll >= chrono) {
                   $('#chrono').css({
                         position: 'fixed',
                         top: 0,
                         width: '17.4rem'
                     })
                }else{

                    $('#chrono').css({
                         position: 'static',
                      
                   })

               }
               
          } else{

           
                   $('#chrono').css({
                         position: 'fixed',
                         top: '60%',
                         width: '40%', 
                         height: '30rem',
                         left: '60%'

                         
                     })
                

          }

         
     })


})

