
$("#folder").on('change', function () {
    var str = '';
    str = $("#folder option:selected").val();
    console.log(str);
})
function wrapText(elementID, openTag, closeTag) {
    var textArea = document.getElementById(elementID);

    if (typeof(textArea.selectionStart) != "undefined") {
        var begin = textArea.value.substr(0, textArea.selectionStart);
        var selection = textArea.value.substr(textArea.selectionStart, textArea.selectionEnd - textArea.selectionStart);
        var end = textArea.value.substr(textArea.selectionEnd);
        textArea.value = begin + openTag + selection + closeTag + end;
    }
}

var $text = $('#sel');
$(document).on('click', '#mod', function (dialog) {
    dialog.preventDefault();

    BootstrapDialog.show({
        title: 'Нова папка',
        message: $text,
        buttons: [{
            label: 'Създай',
            cssClass: 'btn-primary',
            action: function (dialog) {
                var $button = this; // 'this' here is a jQuery object that wrapping the <button> DOM element.

                if (($('#newFolderName').val().length) > 0) {
                    $button.disable();
                    $button.spin();
                    dialog.setClosable(false);
                    $.ajax({
                        method: 'post',
                        url: 'new-folder',
                        data: {
                            name: $('#newFolderName').val(),
                            parent: $('#perentFolder').val(),
                            new_sort_number: $('#sort_number_new_folder').find(":selected").val()
                        }
                    }).done(function (data) {
                        console.log(data);
                        if (data !== 'success') {
                            BootstrapDialog.alert({
                                type: BootstrapDialog.TYPE_WARNING,
                                title: 'Внимание',
                                message: 'Възникна проблем с Вашата заявка!'
                            });
                            $button.enable();
                            $button.stopSpin();
                            dialog.setClosable(true);
                            dialog.close();
                        } else {
                            BootstrapDialog.alert({
                                type: BootstrapDialog.TYPE_SUCCESS,
                                title: 'Успех',
                                message: 'Успешно създадохте нова папка!',
                                onhide: function(dialogRef){
                                    //window.location.reload(true);
                                }
                            });
                            $button.enable();
                            $button.stopSpin();
                            dialog.setClosable(true);
                            dialog.close();
                        }
                    })

                } else {
                    BootstrapDialog.alert({
                        type: BootstrapDialog.TYPE_WARNING,
                        title: 'Внимание',
                        message: 'Не сте въвели име на новата папка!'
                    });
                }
            }
        }, {
            label: 'Отказ',
            action: function (dialogItself) {
                dialogItself.close();

            }
        }],
        onhide: function() {
            $('#newFolderName').val('');

            $('#sort_number').html('');
            $.ajax({
                url: 'get_sort_numbers',
                type: 'POST',
                data: {parent: $('#perentFolders option:selected').val()}
            }).done(function (data) {
                data++;

                var i;
                for (i = 1; i <= data; i++) {
                    $('#sort_number').append('<option value="' + i + '">' + i + '</option>');
                }

                $('#sort_number').val(data).prop('selected');

            });
                $.ajax({
                    url: 'ajax-get-folders',
                    type: 'POST'
                }).done(function(data){
                    $('#folder').html('');
                    $.each(data, function (k, v) {
                        $('#folder').append('<option value="'+ v['category_id'] +'">'+ v['name'] +'</option>')
                    })
                })

        }
    })
})

$(document).on('click', '#createFolder', function () {
    if (($('#newFolderName').val().length) > 0) {
        $.ajax({
            method: 'post',
            url: 'folders',
            data: {
                name: $('#newFolderName').val(),
                parent: $('#perentFolder').val()
            }
        })
            .done(function (data) {
                console.log('seccess');
                $('#myModal').modal('hide');
                BootstrapDialog.alert({
                    title: 'Браво',
                    message: $text
                });
            })
    } else {
        BootstrapDialog.alert({
            type: BootstrapDialog.TYPE_WARNING,
            title: 'Внимание',
            message: 'Не сте въвели име на новата папка!'
        });
    }

})

$(document).on('click', 'span.glyphicon-remove', function () {
    var removed_file_name = $(this).parent('div').find('.file_name_txt').text();
    var removed_file = $(this).parent('div').find('input.attached_files_id').val();
    $(this).parent('div').html('<input type="hidden" name="removed_file_id[]" value="'+ removed_file +'" /><input type="hidden" name="removed_file_name[]" value="'+ removed_file_name +'" />');
   // $('#attachedFiles').html('<input type="hidden" name="removed_file_id[]" value="'+ removed_file +'" />');
})
$(document).on('click', '#addAnotherFile', function () {
    $('#attachedFiles').append('<div class="form-inline"><input style="display:inline" class="uploaded_file" name="userfile[]" type="file" /><span style="margin-left:5px;">Описание на файла:<span style="color: red">*</span> </span><input style="width: 50%;" class="form-control file_name" type="text" required name="label[]" /><span class="glyphicon glyphicon-remove"></span> <br /></div>');
});
$(document).on('click', '#view_post', function (e) {
    e.preventDefault();
    if (($('#text').val().length) > 0) {
        $.ajax({
            method: 'POST',
            url: 'http://localhost/intranet_test/view-post',
            data: {
                text: $('#text').val(),
                type: 'show post'
            }
        })
            .done(function (data) {
                if (data.length > 0) {
                    $('#view_parsed_text').show().html(data);
                }

            })
    } else {
        BootstrapDialog.alert({
            type: BootstrapDialog.TYPE_WARNING,
            title: 'Внимание',
            message: 'Не сте въвели нищо в полето!'
        });
    }

});

window.URL = window.URL || window.webkitURL;

var fileSelect = document.getElementById("fileSelect"),
    fileElem = document.getElementById("fileElem"),
    fileList = document.getElementById("fileSelect"),
    fileUl = document.getElementById("attached");

function handleFiles(files) {
    $("#fileSelect").appendTo('#fileList');

    $('#fileList').show();
    console.log(files);
    if (!files.length) {
        fileUl.innerHTML = "<p>No files selected!</p>";
    } else {

        for (var i = 0; i < files.length; i++) {
            var li = document.createElement("li");
            fileUl.appendChild(li);

            var img = document.createElement("img");
            img.src = window.URL.createObjectURL(files[i]);
            img.height = 60;
            img.onload = function () {
                window.URL.revokeObjectURL(this.src);
            }
            li.appendChild(img);
            var info = document.createElement("span");
            info.innerHTML = files[i].name + ": " + files[i].size + " bytes ";
            li.appendChild(info);

            var label = document.createElement('input');
            label.setAttribute("placeholder", 'Описание на файла');
            label.setAttribute("name", 'label[]');
            label.setAttribute("multiple", 'multiple');
            li.appendChild(label);

            var remove_span = document.createElement('span');

            remove_span.setAttribute('class', 'glyphicon glyphicon-remove');
            //   remove_button.appendChild(remove_span);
            li.appendChild(remove_span);

            remove_span.addEventListener("click", function (e) {
                $(this).parents('li').remove();
                //console.log('TEST');
                if ($('#fileList li').length === 0) {
                    $('#fileList').hide();
                }

            })

        }
    }

}


