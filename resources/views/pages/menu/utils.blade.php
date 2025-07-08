<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("[name=is_active]").forEach(checkbox => {
            updateCheckboxLabel(checkbox);

            checkbox.addEventListener("change", function() {
                updateCheckboxLabel(checkbox);
            });
        });
    });

    function updateCheckboxLabel(checkbox) {
        if (!checkbox) return;

        let label = checkbox.nextElementSibling;
        if (!label) return;

        label.textContent = checkbox.checked ? "Aktif" : "Tidak Aktif";
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".tree ul").forEach(subMenu => {
            subMenu.style.display = "none";
        });
        document.querySelector("#menu-structure").addEventListener("click", function(event) {
            let target = event.target.closest(".toggle");
            if (!target) return;

            let subMenu = target.nextElementSibling;

            if (subMenu && subMenu.tagName === "UL") {
                let isVisible = subMenu.style.display === "block";
                subMenu.style.display = isVisible ? "none" : "block";
                target.classList.toggle("expanded", !isVisible);
            }
        });
        document.querySelectorAll(".toggle").forEach(toggle => {
            toggle.innerHTML = '<span class="toggle-icon">▶</span> ' + toggle.innerHTML;
        });
    });

    let modal = '#MenuModal';
    let tableId = '{{ $dataTable->getTableId() }}';

    $(modal).on("hidden.bs.modal", function() {
        let checkbox = document.querySelector("[name=is_active]");
        if (checkbox) {
            checkbox.checked = false; // Reset ke default (Tidak Aktif)
            updateCheckboxLabel("[name=is_active]"); // Perbarui label
        }
    });

    function reloadDataTable(tableId) {
        const dataTable = $(`#${tableId}`).DataTable();
        dataTable.ajax.reload();
    }

    function addForm(route, title) {
        $(modal).modal('show');
        $(`${modal} .modal-title`).text(title);
        $(`${modal} form`)[0].reset();
        $(`${modal} form`).attr('action', route);
        $(`${modal} form [name=_method]`).val('post');
        resetInput(`${modal} form`);
        getMenus();

        // Reset checkbox ke default (Tidak Aktif) dan perbarui label
        let checkbox = document.querySelector("[name=is_active]");
        if (checkbox) {
            checkbox.checked = false;
            updateCheckboxLabel("[name=is_active]");
        }
    }

    function submitForm(originalForm) {
        $.post({
                url: $(originalForm).attr('action'),
                data: new FormData(originalForm),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false
            })
            .done(response => {
                $(modal).modal('hide');
                showAlert(response.message, 'success');
                reloadDataTable(tableId);
            })
            .fail(errors => {
                var message = 'Data gagal disimpan.'
                if (errors.status == 422) {
                    showAlert(message, 'gagal');
                    loopErrors(errors.responseJSON.errors);
                    return;
                }

                showAlert(message, 'gagal');
            })
    }

    function editForm(url, title, data) {
        $(modal).modal('show');
        $(`${modal} .modal-title`).text(title);
        $(`${modal} form`).attr('action', url);
        $(`${modal} [name=_method]`).val('put');

        resetInput(`${modal} form`);

        // Ambil data menu sebelum mengisi form
        getMenus(data.parent_id);

        // Beri sedikit delay agar menu terisi sebelum form diisi
        setTimeout(() => {
            loopForm(data);
        }, 300);
    }


    function deleteData(url) {
        Swal.fire({
            title: 'Peringatan!',
            text: "Anda yakin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            // confirmButtonColor: '#87adbd ',
            // cancelButtonColor: '#f27474',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',

        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        showAlert(response.message, 'success');
                        reloadDataTable(tableId);
                    })
                    .fail((errors) => {
                        var message = 'Data gagal dihapus'
                        showAlert(message, 'gagal')
                    })
            }
        })
    }

    function loopErrors(errors, message = true) {
        $('.invalid-feedback').remove();

        if (errors == undefined) {
            return;
        }

        for (error in errors) {
            $(`[name=${error}]`).addClass('is-invalid');

            if ($(`[name=${error}]`).hasClass('select2')) {
                $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                    .insertAfter($(`[name=${error}]`).next());
            } else if ($(`[name=${error}]`).hasClass('summernote')) {
                $('.note-editor').addClass('is-invalid');
                $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                    .insertAfter($(`[name=${error}]`).next());
            } else if ($(`[name=${error}]`).hasClass('custom-control-input')) {
                $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                    .insertAfter($(`[name=${error}]`).next());
            } else {
                if ($(`[name=${error}]`).length == 0) {
                    $(`[name="${error}[]"]`).addClass('is-invalid');
                    $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                        .insertAfter($(`[name="${error}[]"]`).next());
                } else {
                    $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                        .insertAfter($(`[name=${error}]`));
                }
            }
        }
    }

    function resetInput(selector) {
        $('.form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .custom-radio, .select_2, .note-editor')
            .removeClass('is-invalid');
    }

    function loopForm(originalForm) {
        for (field in originalForm) {
            if ($(`[name=${field}]`).attr('type') != 'file') {
                if ($(`[name=${field}]`).hasClass('summernote')) {
                    $(`[name=${field}]`).summernote('code', originalForm[field])
                } else if ($(`[name=${field}]`).attr('type') == 'radio') {
                    $(`[name=${field}]`).filter(`[value="${originalForm[field]}"]`).prop('checked', true);
                } else if ($(`[name=${field}]`).attr('type') == 'checkbox') {
                    let isChecked = originalForm[field] == 1 || originalForm[field] === true || originalForm[field] == 'on';
                    let checkbox = document.querySelector(`[name=${field}]`);

                    if (checkbox) {
                        checkbox.checked = isChecked;
                        updateCheckboxLabel(checkbox);
                    }
                } else {
                    $(`[name=${field}]`).val(originalForm[field]);
                }
                $('select').trigger('change');
            } else {
                $(`.preview-${field}`).attr('src', '/storage/' + originalForm[field]).show();
            }
        }
    }

    function timeOut() {
        setTimeout(function() {
            location.reload();
        }, 2500);
    }

    function showAlert(message, type) {
        Swal.fire({
            icon: type === 'success' ? 'success' : 'error',
            title: type === 'success' ? 'Berhasil' : 'Gagal',
            text: message,
        });
    }

    function getMenus(parentId = null) {
        $.get({
            url: "{{ route('menu.get-data-all') }}",
            success: function(response) {
                if (response.status == 'success') {
                    let data = response.data;
                    let parentSelect = $('#parent_id');

                    if (parentSelect.length === 0) return;

                    let html = '<option value="">- Pilih -</option>';
                    data.forEach(menu => {
                        let selected = (parentId == menu.id) ? "selected" : "";
                        html += `<option value="${menu.id}" ${selected}>${menu.name}</option>`;
                    });

                    parentSelect.html(html);
                }
            }
        }).fail(function(xhr, status, error) {
            console.error("Error fetching menus:", error);
            showAlert("Gagal mengambil data menu!", "error");
        });
    }

</script>
