if (document.getElementById('redirecturl-list')) {
    if (document.getElementById('delete_dialog_form')) {
        const deleteLinks = document.getElementById('redirecturl-list').getElementsByClassName('btn-danger');

        Array.from(deleteLinks)
            .forEach((deleteLink => {
                deleteLink.addEventListener('click', (e) => {
                    document.getElementById('delete_dialog_form')
                        .querySelector('input[name="theliaredirecturl_id"]')
                        .value = e.currentTarget.dataset.id
                    ;
                });
            }))
        ;
    }

    if (document.getElementById('update_dialog_form')) {
        const editLinks = document.getElementById('redirecturl-list').getElementsByClassName('btn-info');

        Array.from(editLinks)
            .forEach((editLink => {
                editLink.addEventListener('click', (e) => {
                    const editRowElements = e.currentTarget
                        .parentElement // div.btn-group
                        .parentElement // td
                        .parentElement // tr
                        .children // tds
                    ;
                    document.getElementById('update_dialog_form')
                        .querySelector('input[name="redirect_url_update[id]"]')
                        .value = editRowElements[0].innerText
                    ;
                    document.getElementById('redirect-update-url').value = editRowElements[1].innerText;
                    document.getElementById('redirect-update-temp_redirect').value = editRowElements[2].innerText;
                    document.getElementById('redirect-update-redirect').value = editRowElements[3].innerText;
                });
            }))
        ;
    }
}
