$(document).ready(function(){
    addImages();
    getFileName();
})

function addImages(){
    var index = 0;
    $('#addImages').click(function(){
        index++;
        const form = $('#add_images_images').data('prototype').replace(/__name__/g, index);

        $('#add_images_images').append(form);
        deleteRow(); 
    }); 
} 

function deleteRow(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();

    });
}

function getFileName(){
    $('input[type="file"]').click(function(e){
        var fileName = e.target.files[0].name;
        alert('The file "' + fileName +  '" has been selected.');
    });
}