// Data tables
$(document).ready(function () {
    loadtable();
    // $("#table_index").DataTable({
    //     paging: true,
    //     searching: true,
    //     ordering: true,
    //     info: true,
    //     autoWidth: false,
    //     responsive: true,
    //     oLanguage: {
    //         sEmptyTable:
    //             "Secara Default Data Kosong, Silahkan Lakukan Filter Agar bisa memuat data!",
    //     },
    // });
});

function loadtotal(min, max, objek_pemeriksaan, id_cabang) {
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: "/lkhp-rekap-all",
            data: {
                min: min,
                max: max,
                objek_pemeriksaan: objek_pemeriksaan,
                id_cabang: id_cabang,
            },
            success: function (response) {
                console.log(response.data);
            },
        });
    });
}

function loadtable(min, max, objek_pemeriksaan, id_cabang) {
    $(document).ready(function () {
        // Mendapatkan nilai kode dari URL (jika ada)
        // let urlParams = new URLSearchParams(window.location.search);
        // let kode = urlParams.get("kode");

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
            oLanguage: {
                sEmptyTable: "Tidak Ada Data Yang Ditemukan!",
            },
            ajax: {
                // type: "post",
                url: "lkhp-rekap",
                data: {
                    min: min,
                    max: max,
                    objek_pemeriksaan: objek_pemeriksaan,
                    id_cabang: id_cabang,
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
                    data: "no_lkhp",
                    name: "no_lkhp",
                },
                {
                    data: "risk_event",
                    name: "risk_event",
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return (
                            moment(data.tgl_awal).locale("id").format("DD") +
                            " s/d " +
                            moment(data.tgl_akhir)
                                .locale("id")
                                .format("DD MMM YYYY")
                        );
                    },
                },
                {
                    data: "objek_pemeriksaan",
                    name: "objek_pemeriksaan",
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
                    targets: [6, 7, 8],
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
    let objek_pemeriksaan = $("#objek_pemeriksaan").val();
    let id_cabang = $("#id_cabang").val();

    // console.log("Min: ", min);
    // console.log("Max: ", max);
    if (id_cabang == null) {
        alert("Filter Kantor Cabang Tidak Boleh Kosong!");
    } else if (objek_pemeriksaan == null) {
        alert("Filter Objek Pemeriksaan Tidak Boleh Kosong!");
    } else {
        $("#table_index").DataTable().destroy();
        loadtable(min, max, objek_pemeriksaan, id_cabang);
        loadtotal(min, max, objek_pemeriksaan, id_cabang);
    }
});

$(document).on("click", "#btn-refresh", function () {
    $("#table_index").DataTable().destroy();
    loadtable();
    loadtotal();
});
// end datatables
