function createBlock(id, name =''){
  let template = document.getElementById('block');
  let clone = template.content.cloneNode(true);
  clone.querySelector('.block').id = 'block' + id;  
  clone.querySelector('.block-name').id = 'block-name' + id;  
  clone.querySelector('.block-name').name = 'Block-Name' + id;  
  clone.querySelector('.block-name').value = name;  
  clone.querySelector('.add-item').name = 'Add-Item' + id;
  clone.querySelector('.delete-block').name = 'Delete-Block' + id;  
  clone.querySelector('.clone-block').name = 'Clone-Block' + id; 
  document.getElementById('item-list').appendChild(clone);
}

function createItem(block, id, name = '', price = 0, img = '.', description = ''){
  let template = document.getElementById('item');
  let clone = template.content.cloneNode(true);
  clone.querySelector('.item').id = 'item' + id;  
  clone.querySelector('.delete-item').name = 'Delete-Item' + id;  
  clone.querySelector('.item-id').name = 'Item-Id' + id;  
  clone.querySelector('.item-id').value = id;   
  clone.querySelector('.item-name').name = 'Item-Name' + id;  
  clone.querySelector('.item-name').value = name;   
  clone.querySelector('.item-price').name = 'Item-Price' + id;  
  clone.querySelector('.item-price').value = price; 
  clone.querySelector('.item-image').id = 'item-image' + id;  
  clone.querySelector('.item-image').name = 'Item-Image' + id;  
  clone.querySelector('.item-image').value = img;
  clone.querySelector('.item-description').name = 'Item-Descr' + id;  
  clone.querySelector('.item-description').value = description;  
  document.getElementById(block).appendChild(clone);
}

$(document).on('click', '.add-block', function(){
  createBlock(getRandomInt());
});

$(document).on('click', '.add-item', function(e){
  e.preventDefault();
  let parent = $(this).closest('.block').attr('id');
  createItem(parent,'_'+getRandomInt());
});

$(document).on('click', '.delete-block', function(e){
  if(!confirm('Confirmer la suppression?')) e.preventDefault();
  else $(this).closest('.block').remove();
});  

$(document).on('click', '.delete-item', function(e){
  if(!confirm('Confirmer la suppression?')) e.preventDefault();
  else $(this).closest('.item').remove();
});

$(document).on('click', '.clone-block', function(e){
  e.preventDefault();
  let id = $(this).closest('.block').attr('id');
  let clone = document.getElementById(id).cloneNode(true);
  let ref = [];
  clone.id = "block" + getRandomInt();
  clone.querySelectorAll('.block-name').forEach(function(elem, i){elem.id = 'block-name'+getRandomInt(); elem.name = 'Block-Name'+getRandomInt(); elem.value += '_'+getRandomInt();});
  clone.querySelectorAll('.item').forEach(function(elem, i){ref.push('_'+getRandomInt()); elem.id = 'item'+ref[i];});
  clone.querySelectorAll('.item-name').forEach(function(elem, i){elem.name = 'Item-Name'+ref[i];});
  clone.querySelectorAll('.item-price').forEach(function(elem, i){elem.name = 'Item-Price'+ref[i];});
  clone.querySelectorAll('.item-image').forEach(function(elem, i){
    elem.value = document.getElementById(elem.id).options[document.getElementById(elem.id).selectedIndex].value;
    elem.name = 'Item-Image'+ref[i];
    elem.id = 'item-image'+ref[i];
  });
  clone.querySelectorAll('.item-id').forEach(function(elem, i){elem.name = 'Item-Id'+ref[i]; elem.value = '_'+ref[i];});
  clone.querySelectorAll('.item-description').forEach(function(elem, i){elem.name = 'Item-Description'+ref[i];});
  document.getElementById('item-list').appendChild(clone);
});

$(document).on('change', '.item-price', function(){
  $(this).val(($(this).val() / 100).toFixed(2));
}); 

$(document).on('keydown', 'form', function(event) { 
    return event.key != "Enter";
});

function getRandomInt() {
  return Math.floor(Math.random() * 1000000000000);
}


          