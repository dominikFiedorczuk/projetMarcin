$(document).ready(function(){
    $("select").imagepicker()
})

function pickAndDelete(csrf){
    let idImages = [];
    $("select option:selected").each(function(){
        idImages.push($(this).val());
    });

    if(idImages.length === 0){
        alert("Nie wybrano zadnych zdjec")
    }
    
    else {
        $.ajax({
            url: "/deleteImages",
            method: "POST",
            data: {
                token: csrf,
                id: idImages
            }
        });

        window.location.reload();
    }
}

