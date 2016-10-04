$(document).on('change', 'input[type="file"]', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});
$(document).ready( function() {
    $(':file').on('fileselect', function(event, numFiles, label) {
        document.getElementById('select_file_name').innerHTML = label;
        console.log(numFiles);
        console.log(label); 
    });                         
});                                 
