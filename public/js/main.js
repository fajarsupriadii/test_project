function notification(type, title, body, autohide = false, delay = 1500)
{
    if (title == '') {
        if (type == 'success') {
            title = 'Proses Berhasil';
        } else if (type == 'danger') {
            title = 'Proses Gagal';
        }
    }
    
    $(document).Toasts('create', {
        class: 'bg-' + type,
        title: title,
        autohide: autohide,
        delay: delay,
        body: body
    });
}

function filterTable(table, formFilter) 
{
    var wrapper = `#${table}_wrapper`;
    var wrapperForm = `#advanced-filter-${table}`;
    var filterSection = `#filter-section-${table}`;
    var dateRange = false;
    var tableElement = `#${table}`;
    var url = $(tableElement).DataTable().ajax.url();

    $(wrapper).parent().prepend(
        `<div class="advanced-filter" id="advanced-filter-${table}"></div>`
    );
    $(wrapperForm).append(`
        <div class="flex-container filter-label-btn">
            <div class="col-md-2 mb-3">
                <button id="btn-search-${table}" type="button" data-table-id="${table}" data-table-url="${url}" class="btn btn-success btn-sm btn-search-datatable">
                    <i class="fa fa-search"></i>
                    Search
                </button>
            </div>
            <div class="flex-filter">
                <div class="col-md-12" id="filter-section-${table}"></div>
            </div>
            <div class="flex-1">
                <div class="col-md-12 text-center">
                    <a id="collapse-${table}">
                        <div class="more-filter">
                            <p class="no-margin"> Show Filter <i id="morefilter-${table}" class="fa fa-chevron-up"></i></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    `);
    $(filterSection).append(`<div class="row"></div>`);

    formFilter.map((form, indexOption) => {
        var itemOption = form;
        var type =
            typeof itemOption.type != 'undefined'
                ? typeof itemOption.type.name != 'undefined'
                ? itemOption.type.name
                : itemOption.type
                : 'text';

        if (typeof form != 'object') {
            itemOption = {
                fieldName: form,
            };
        }
        var label = `${typeof itemOption.label != 'undefined'
            ? itemOption.label
            : ucWords(itemOption.fieldName.replace(/_/g, ' '))
            } :`;
        elementAppend = `
                <div class="col-sm-3" id="${itemOption.fieldName}--filter">
                    <div class="form-group">
                        <label for="${itemOption.fieldName}">${label}</label>`;
        switch (type) {
            case 'text':
                elementAppend += `<input id="${table}-${itemOption.fieldName}-form" name="${itemOption.fieldName}" class="form-control input-xs">`;
                break;
            case 'dateRange':
                elementAppend += `<input id="${table}-${itemOption.fieldName}-form" name="${itemOption.fieldName}" type="text" class="form-control input-xs daterange">`;
                dateRange = true;
                break;
            default:
                break;
        }
        elementAppend += `
                </div>
            </div>`;
        $(filterSection).find('.row').last().append(elementAppend);

        if ((indexOption + 1) % 4 == 0 &&
            formFilter.length > 4 &&
            indexOption + 1 <= formFilter.length)
        {
            $(filterSection).append(`<div class="row row__hidden"></div>`);
        }
    });
    $(filterSection).wrap(`<form id="form-filter_${table}" action="#"></form>`);

    $(`#collapse-${table}`).bind('click', ({ currentTarget }) => {
        $(filterSection).find('.row__hidden').slideToggle(300);
        $(currentTarget).find('i.fa').toggleClass('fa-chevron-down');
        $(currentTarget).find('i.fa').toggleClass('fa-chevron-up');
    });
    $(`#collapse-${table}`).trigger('click');
    if (dateRange == true) {
        $('.daterange').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    }
}

const serializeFormToParam = (formElement) => {
    const data = $(formElement).serializeArray();
    let result = '';
    data.map((eachForm) => {
        result += `&advanced-filter[${eachForm.name}]=${eachForm.value}`;
    });
    return result;
};
  
$(document).on('click', '.btn-search-datatable', ({ currentTarget }) => {
    var tableId = $(currentTarget).data('table-id');
    var formWrapper = $(`#form-filter_${tableId}`);
    var table = `#${tableId}`;
    var tableElement = $(table).DataTable();
    if ($(currentTarget).data('table-url').indexOf("?") != -1) {
        var url = `${$(currentTarget).data('table-url')}&${serializeFormToParam(formWrapper).substring(1)}`;
    } else {
        var url = `${$(currentTarget).data('table-url')}?${serializeFormToParam(formWrapper).substring(1)}`;
    }
    tableElement.ajax.url(url);
    tableElement.ajax.reload();
});
  
  