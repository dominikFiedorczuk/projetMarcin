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
    $('#add_images_images').change(function(k){
        let fileName = k.target.files[0].name;
        let target = $(k.target).attr('id');
        $('#'+target).next('.custom-file-label').html(fileName);
    })
}