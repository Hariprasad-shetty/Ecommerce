  let mainImg=document.getElementById('mainImg');

  let smallImg=document.getElementsByClassName('small-img');



for(let i=0;i<4;i++){
smallImg[i].onclick=function(){
  
  mainImg.src=smallImg[i].src;
  

}
}