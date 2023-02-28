$(document).ready(function(){

  const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
  const h_bar = document.getElementById('title-bar').clientHeight;
  const rg_avatar = document.getElementById('user-avatar').getBoundingClientRect().right;

  document.getElementById('user-menu').style["top"] = "60px";
  document.getElementById('user-menu').style["right"] = (vw - rg_avatar)+"px";
   
  let collection = document.getElementsByClassName('pinned');
  
  for(let i = 0, len = collection.length; i < len; i++)
  {
    collection[i].style["top"] = h_bar+"px";
  }
  
});