$('#corps_modele').summernote({
    placeholder: '',
    tabsize: 2,
    height: 300,
    toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'underline', 'clear']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    //['insert', ['link', 'picture', 'video']],
    ['view', ['codeview']]
    ]
});


function getCode()
{
    var previewCode = document.querySelector('.btn-codeview');
    previewCode.click();
    previewCode.click();

    var textareaElement = document.querySelector('.note-codable');
    var codeHtml = textareaElement.value;
    codeHtml = codeHtml.replace(/’/g, "'");

    //console.log(codeHtml);

    var codeHidden = document.querySelector('.corps_code');
    codeHidden.value = btoa(codeHtml);

    var createTemplateForm = document.getElementById('templateForm');
    var submitBouton = document.getElementById('submitTemplate');

    submitBouton.disabled = false;

    // Désactiver temporairement le contenu de la zone de texte
    var corpsModeleTextarea = $('#corps_modele');
    var corpsModeleValue = corpsModeleTextarea.val();
    corpsModeleTextarea.val('');

    createTemplateForm.submit();

    // Rétablir la valeur de la zone de texte après la soumission
    corpsModeleTextarea.val(corpsModeleValue);
}

function copyContent(element, content) {
    
    // Créer un élément textarea temporaire pour stocker le contenu
    var tempTextArea = document.createElement("textarea");
    tempTextArea.value = content;
    // Ajouter l'élément textarea à la page
    document.body.appendChild(tempTextArea);
    // Sélectionner le contenu du textarea
    tempTextArea.select();
    tempTextArea.setSelectionRange(0, 99999); /* For mobile devices */
    // Copier le contenu dans le presse-papiers
    document.execCommand("copy");


    // Retirer l'élément textarea temporaire de la page
    document.body.removeChild(tempTextArea);
    // Ajouter la classe "clicked" à l'élément cliqué
    element.classList.add("clicked");

    // Retirer la classe "clicked" des autres éléments
    var allVariables = document.querySelectorAll('.variable');
    allVariables.forEach(function(variable) {
        if (variable !== element) {
            variable.classList.remove("clicked");
        }
    });
};