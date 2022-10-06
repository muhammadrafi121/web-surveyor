<!DOCTYPE html>
<html lang="en">

<head>
    <!-- html2pdf CDN-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"
        type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet" />
    <link href="/css/style.css" rel="stylesheet" />
    <link href="/css/pdf.css" rel="stylesheet" />
    <style>
        * {
            /* border: 1px solid red; */
        }
    </style>
    <title>PDF LAHAN</title>
</head>

<body>
    <div class="container">
        <!-- A4 Paper -->
        <div class="m-auto border-info bg-light" size="A4">
            <div class="row mx-5">
                <!-- header -->
                <div class="col-12">
                    <!-- logo -->
                    <div class="col-12 d-flex justify-content-between">
                        <div class="d-flex">
                            <img src="/img/Logo_PLN.png" alt="" srcset="" width="50px" />
                            <span class="ms-1">
                                <p class="m-0">PT.PLN (Persero)</p>
                                <p class="m-0">INDUK PEMBANGUNAN SUMATERA BAGIAN SELANTAN</p>
                                <p class="m-0">UNIT PELAKSANA PROYEK SUMATERA BAGIAN SELATAN 1</p>
                            </span>
                        </div>
                        <img src="/img/logo_ptsi.png" alt="" srcset="" height="50px" width="200px" />
                    </div>
                    <!-- tittle -->
                    <div class="col-12 d-flex mt-2">
                        <span class="mx-auto text-center">
                            <h6 class="m-0">DAFTAR INVENTARISASI TAPAK TOWER</h6>
                            <h6 class="m-0">JALUR
                                {{ $land->row ? strtoupper($land->row->location->name) : strtoupper($land->tower->location->name) }}
                            </h6>
                        </span>
                    </div>
                    <div class="col-12 d-flex mt-2">
                        <div class="col-5 p-0 d-flex">
                            <div class="col-6 d-flex flex-column p-0">
                                <span>TANGGAL</span>
                                <span>NAMA PEMILIK </span>
                                <span>ALAMAT </span>
                            </div>
                            <div class="col-6 d-flex flex-column">
                                <span> : {{ $land->updated_at->format('d M Y') }} </span>
                                <span> : {{ $land->owner->name }} </span>
                                <span> : ... </span>
                            </div>
                        </div>
                        <div class="col-5 p-0 d-flex">
                            <div class="col-6 d-flex flex-column p-0">
                                <span>DESA / KELURAHAN </span>
                                <span>KECAMATAN </span>
                                <span>KABUPATEN </span>
                            </div>
                            <div class="col-6 d-flex flex-column">
                                <span> : {{ $land->owner->village }} </span>
                                <span> : {{ $land->owner->district }} </span>
                                <span> : {{ $land->owner->regency }} </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- table -->
                <div class="col-12 mt-4">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td rowspan="2">NO</td>
                                <td rowspan="2">TOWER</td>
                                <td colspan="2">TANAH</td>
                                <td colspan="5">TANAM TUMBUH</td>
                                <td rowspan="2">KETERANGAN</td>
                            </tr>
                            <tr>
                                <td>Jenis Tanah</td>
                                <td>Luas (m<sup>2</sup>)</td>
                                <td>Nama Tanaman</td>
                                <td>Umur</td>
                                <td>Tinggi</td>
                                <td>Diameter</td>
                                <td>Jumlah</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($land->plants as $plant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $land->tower ? $land->tower->no : $land->row->firsttower->no . '-' . $land->row->secondtower->no }}
                                    </td>
                                    <td>{{ $land->type }}</td>
                                    <td>{{ $land->area }}</td>
                                    <td>{{ $plant->name }}</td>
                                    <td>{{ $plant->age }}</td>
                                    <td>{{ $plant->height }}</td>
                                    <td>{{ $plant->diameter }}</td>
                                    <td>{{ $plant->total }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($land->tower)
                    <!-- coordinate -->
                    <div class="col-12 mt-4 d-flex flex-row">
                        <div class="col-4">img</div>
                        <div class="col-5 d-flex flex-column">
                            <span>TOWER TYPE &nbsp; &nbsp; &nbsp; &nbsp; : &nbsp; {{ $land->tower->type }}</span>
                            <span>KOORDINAT &nbsp;&nbsp; &nbsp; X &nbsp; : &nbsp; {{ $land->tower->lat }}</span>
                            <span><u class="opacity-0">KOORDINAT</u> &nbsp;&nbsp; &nbsp; Y &nbsp; : &nbsp;
                                {{ $land->tower->long }}</span>
                        </div>
                    </div>
                @endif
                <!-- signature -->
                <div class="col-12 my-5 m-0 p-0 d-flex flex-row">
                    <div class="col-6">
                        <p class="text-center m-0 p-0">PETUGAS INVENTARISASI</p>
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>NO</td>
                                    <td>NAMA</td>
                                    <td>INSTANSI</td>
                                    <td>TANDA TANGAN</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <div class="col-12 d-flex flex-row">
                            <div class="col-6">
                                <span>KEPALA DESA / LURAH</span>
                            </div>
                            <div class="col-6"></div>
                        </div>
                        <div class="col-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var button = document.getElementById("button");
        var makepdf = document.getElementById("makepdf");

        button.addEventListener("click", function() {
            var mywindow = window.open("", "PRINT", "height=400,width=600");

            mywindow.document.write(makepdf.innerHTML);

            mywindow.document.close();
            mywindow.focus();

            mywindow.print();
            //   mywindow.close();

            return true;
        });
    </script>
</body>

</html>
