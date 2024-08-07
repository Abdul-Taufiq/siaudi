// Data tables
$(document).ready(function () {
    loadtable();
});

function loadtable(min, max, cari) {
    $(document).ready(function () {
        // Mendapatkan nilai kode dari URL (jika ada)
        let urlParams = new URLSearchParams(window.location.search);
        let kode = urlParams.get("kode");

        // kondisi memunculkan button export
        let level = $("#user").val();
        let buttons = ["colvis"];
        let show;
        if (level == "SUPER USER" || level == "DIREKTUR") {
            show = true;
        } else {
            show = false;
        }

        if (show) {
            buttons.push([
                {
                    extend: "copyHtml5",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
                {
                    extend: "excelHtml5",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
                {
                    extend: "pdfHtml5",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
            ]);
        }
        // End kondisi memunculkan button export

        $("#table_index").DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            // scrollX: true,

            processing: true,
            serverSide: true,
            ajax: {
                // type: "post",
                url: "data-lkhp",
                data: {
                    min: min,
                    max: max,
                    kode: kode,
                    cari: cari,
                },
            },
            columns: [
                {
                    data: null,
                    sortable: false,
                    orderColumn: false,
                    ordering: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "cabang",
                    name: "cabang",
                },
                {
                    data: "no_lkhp_bayangan",
                    name: "no_lkhp_bayangan",
                },
                {
                    data: "nama_creator",
                    name: "nama_creator",
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.created_at)
                            .locale("id")
                            .format("DD MMM YYYY");
                    },
                },
                {
                    data: "objek_pemeriksaan",
                    name: "objek_pemeriksaan",
                },

                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.created_at)
                            .locale("id")
                            .format("DD MMM YYYY, HH:mm");
                    },
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return moment(data.updated_at)
                            .locale("id")
                            .format("DD MMM YYYY, HH:mm");
                    },
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                },
            ],

            columnDefs: [
                {
                    targets: [6, 7],
                    visible: false,
                    searchable: false,
                },
            ],

            dom:
                "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
            buttons: buttons,
            lengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, "Semua"],
            ],
        });
    });
}

$(document).on("click", "#btn-filter", function () {
    let min = $("#min").val();
    let max = $("#max").val();
    $("#table_index").DataTable().destroy();
    loadtable(min, max);
});

$(document).on("click", "#btn-refresh", function () {
    $("#table_index").DataTable().destroy();
    loadtable();
});
// end datatables
