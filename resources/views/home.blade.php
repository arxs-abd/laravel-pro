<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <style>
        .sticky {
            position: sticky;
            left: 0;
            background-color: rgb(242, 242, 242) !important;
            z-index: 998;
        }

        .table [data-sort="asc"]::after {
            content: "\25b4";
            opacity: .7;
            float: right;
        }

        .table [data-sort="desc"]::after {
            content: "\25be";
            opacity: .7;
            float: right;

        }

        .table thead th:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="position-fixed top-0 left-0 vw-100 vh-100 bg-dark d-flex align-items-center flex-column justify-content-center d-none" id="spinner" style="--bs-bg-opacity: .8; z-index: 999;">
        <div class="spinner-border mb-3 text-white" style="width: 5rem; height: 5rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="container">
        <h1 class="my-5">Pencarian Data</h1>
        <form action="/" method="GET" id="search-form" class="mb-3">
            <div class="row" id="first-row">
                <div class="col">
                    <label for="jenis_pemilihan" class="form-label">Jenis Pemilihan</label>
                    <select type="text" class="form-control" id="jenis_pemilihan" name="jenis_pemilihan">
                        <option value="">Pilih Jenis Pemilihan</option>
                        <option value="pdpr">Pemilihan DPR RI</option>
                        <option value="pdprd1">Pemilihan DPRD Provinsi</option>
                        <option value="pdprd2">Pemilihan DPRD Kabupaten/Kota</option>
                    </select>
                </div>
            </div>
            <div class="row my-2" id="second-row"></div>
            <button type="submit" name="action" class="btn btn-primary h-20 mt-2" id="search">Search</button>
            <!-- <button type="submit" name="action" target="_blank" class="btn btn-success w-full">
                Convert To Excel</button>
            <a href="/" class="btn btn-danger h-20">Reset</a> -->
        </form>
        <!-- <div class="mt-2">
            <span>Jumlah Data : 0</span>
        </div> -->
        <div class="alert alert-warning mt-3 border border-warning border-5 border-top-0 border-end-0 border-bottom-0" role="alert" id="warning">
            Silahkan <strong>Search</strong> Terlebih Dahulu
        </div>
        <div class="table-loading d-none rounded p-2" style="z-index: -1 !important; background-color: rgb(230, 230, 230);">
            <p class="placeholder-glow">
                <span class="placeholder my-2 col-8"></span>
                <span class="placeholder my-2 col-12"></span>
                <span class="placeholder my-2 col-12"></span>
                <span class="placeholder my-2 col-12"></span>
                <span class="placeholder my-2 col-12"></span>
                <span class="placeholder my-2 col-12"></span>
            </p>
        </div>
        <div class="table-responsive my-4">
            <table class="table table-bordered table-hover">
                <thead>
                    <!-- <tr class="text-center">
                        <th data-sort="asc" data-coloumn="#" scope="col" class="align-middle" onclick="sortTable(0)">#
                        </th>
                        <th data-sort="asc" data-coloumn="nama" scope="col" class="align-middle" style="min-width: 300px;" onclick="sortTable('nama', 1, false)">NAMA CALON</th>
                        <th data-sort="desc" data-coloumn="tps_1" scope="col" class="align-middle" style="min-width: 30px;" onclick="sortTable('tps_1', 2)">TPS 1</th>
                        <th data-sort="asc" data-coloumn="tps_2" scope="col" class="align-middle" style="min-width: 30px;" onclick="sortTable('tps_2', 3)">TPS 2</th>
                        <th data-sort="asc" data-coloumn="tps_3" scope="col" class="align-middle" style="min-width: 30px;" onclick="sortTable('tps_3', 4)">TPS 3</th>
                    </tr> -->
                    <!-- <tr class="text-center">
                        <th scope="col" class="align-middle">#</th>
                        <th scope="col" class="align-middle" style="min-width: 300px;">Nama Calon</th>

                        @for ($i = 1; $i <= $length; $i++) <th scope="col" class="align-middle" style="min-width: 30px;">TPS {{ $i}}</th>
                            @endfor
                    </tr> -->
                </thead>
                <tbody>
                    <!-- <tr class="text-center">
                        <td scope="col" class="align-middle" data-value="1">1</td>
                        <td scope="col" class="align-middle">Aris Abdillah</td>
                        <td scope="col" class="align-middle" data-value="5">5</td>
                        <td scope="col" class="align-middle" data-value="8">8</td>
                        <td scope="col" class="align-middle" data-value="2">2</td>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td scope="col" class="align-middle" data-value="2">2</td>
                        <td scope="col" class="align-middle">Sergio Abdillah</td>
                        <td scope="col" class="align-middle" data-value="42">42</td>
                        <td scope="col" class="align-middle" data-value="9">9</td>
                        <td scope="col" class="align-middle" data-value="12">12</td>
                        </td>
                    </tr>
                    <tr class="text-center">
                        <td scope="col" class="align-middle" data-value="3">3</td>
                        <td scope="col" class="align-middle">Reza Abdillah</td>
                        <td scope="col" class="align-middle" data-value="25">25</td>
                        <td scope="col" class="align-middle" data-value="81">81</td>
                        <td scope="col" class="align-middle" data-value="23">23</td>
                        </td>
                    </tr> -->
                    <!-- @foreach($allUser as $user)
                    <tr class="text-center">
                        <td scope="col" class="align-middle">{{$loop->iteration}}</td>
                        <td scope="col" class="align-middle">{{$user['nama']}}</td>
                        @for ($i = 1; $i <= $length; $i++) <td scope="col" class="align-middle">{{$user[$i]}}</td>
                            @endfor
                            </td>
                    </tr>
                    @endforeach -->

                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

    <script defer>
        // Form
        const searchForm = document.querySelector('#search-form')
        const buttonSearch = document.querySelector('#search')
        const loading = document.querySelector('#spinner')
        const loadingTable = document.querySelector('.table-loading')
        const warningMessage = document.querySelector('#warning')
        localStorage.clear()

        searchForm.addEventListener('submit', async function(e) {
            e.preventDefault()
            localStorage.clear()
            // loadingTable.classList.toggle('d-none')
            loading.classList.toggle('d-none')
            const data = {}
            if (document.querySelector('#jenis_pemilihan')?.value !== '') data['jenis_pemilihan'] = document.querySelector('#jenis_pemilihan').value
            if (document.querySelector('#kabupaten_kota')?.value !== '') data['kabupaten_kota'] = document.querySelector('#kabupaten_kota').value
            if (document.querySelector('#kecamatan')?.value !== '') data['kecamatan'] = document.querySelector('#kecamatan').value
            if (document.querySelector('#kelurahan_desa')?.value !== '') data['kelurahan_desa'] = document.querySelector('#kelurahan_desa').value
            if (document.querySelector('#dapil')?.value !== '') data['dapil'] = document.querySelector('#dapil').value
            if (data.jenis_pemilihan !== 'pdpr') data['provinsi'] = document.querySelector('#provinsi').value
            const result = await fetching('/api/search', '', {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            const table = document.querySelector('.table')
            // Create row
            const coloumn = table.querySelector('thead')
            coloumn.innerHTML = ''
            const newBody = table.querySelector('tbody')
            newBody.innerHTML = ''
            const newRow = document.createElement('tr')
            // return console.log(result)
            if (result.user === 'ERROR') {
                loading.classList.toggle('d-none')
                if (warningMessage.classList.contains('d-none')) warningMessage.classList.toggle('d-none')
                warningMessage.innerHTML = `<strong>Data</strong> Tidak Ditemukan`
                return console.log(result)
            }
            // console.log(result)
            let i = 0
            newRow.classList.add('text-center')
            const noColoumn = document.createElement('th')
            noColoumn.classList.add('align-middle', 'sticky')
            noColoumn.setAttribute('scope', 'col')
            noColoumn.textContent = '#'
            noColoumn.setAttribute('onclick', `sortTable('no', ${i})`)
            noColoumn.dataset.coloumn = 'no'
            noColoumn.dataset.sort = 'asc'
            i++
            newRow.appendChild(noColoumn)
            for (const col of result.coloumn) {
                const noColoumn = document.createElement('th')
                noColoumn.classList.add('align-middle')
                noColoumn.setAttribute('scope', 'col')
                noColoumn.textContent = changToRow(col)
                noColoumn.dataset.sort = 'asc'
                if (col.includes('tps')) {
                    noColoumn.style.minWidth = '30px'
                    noColoumn.setAttribute('onclick', `sortTable('${changToRow(col)}', ${i})`)
                    noColoumn.dataset.coloumn = changToRow(col)
                } else if (col.includes('nama')) {
                    noColoumn.style.minWidth = '300px'
                    noColoumn.classList.add('sticky')
                    noColoumn.dataset.coloumn = 'nama'
                    noColoumn.setAttribute('onclick', `sortTable('nama', ${i}, false)`)
                } else {
                    noColoumn.style.minWidth = '60px'
                    noColoumn.dataset.coloumn = col
                    noColoumn.setAttribute('onclick', `sortTable('${col}', ${i})`)
                }
                noColoumn.dataset.sort = 'asc'
                i++
                newRow.appendChild(noColoumn)
            }
            coloumn.appendChild(newRow)


            for (const data in result.data) {
                const row = document.createElement('tr')
                const field = document.createElement('td')
                field.classList.add('align-middle', 'text-center', 'sticky')
                field.setAttribute('scope', 'col')
                field.textContent = data
                field.dataset.value = data
                row.appendChild(field)
                for (const col of result.coloumn) {
                    const field = document.createElement('td')
                    if (!col.includes('nama')) field.classList.add('text-center')
                    else field.classList.add('sticky')
                    field.setAttribute('scope', 'col')
                    field.textContent = result.data[data][col]?.toLocaleString('en-US') || '-'
                    field.dataset.value = result.data[data][col] || -1
                    row.appendChild(field)
                }
                newBody.appendChild(row)
                // console.log(data)
            }
            warningMessage.classList.add('d-none')
            // loadingTable.classList.toggle('d-none')
            loading.classList.toggle('d-none')
        })

        function changToRow(text) {
            const newText = text.toUpperCase()
            return newText.split('-').join(' ')
        }

        const firstRow = document.querySelector('#first-row')
        const secondRow = document.querySelector('#second-row')
        const jenisPemilihan = document.querySelector('#jenis_pemilihan')
        let input = ''

        jenisPemilihan.addEventListener('change', async (e) => {
            const provinsiInput = createInput('provinsi', 'Provinsi')
            const kabupatenInput = createInput('kabupaten_kota', 'Kabupaten / Kota')
            const kecamatanInput = createInput('kecamatan', 'Kecamatan')
            const kelurahanInput = createInput('kelurahan_desa', 'Kelurahan / Desa')
            const dapilInput = createInput('dapil', 'Dapil')
            let field = [provinsiInput, kabupatenInput, kecamatanInput, kelurahanInput]
            let fieldText = ['provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan_desa']
            const allField = document.querySelectorAll('.added')
            allField.forEach(element => {
                element.remove()
            })
            input = jenisPemilihan.value
            if (input === 'pdpr') {
                field = [dapilInput, kabupatenInput, kecamatanInput, kelurahanInput]
                fieldText = ['dapil', 'kabupaten_kota', 'kecamatan', 'kelurahan_desa']
            } else if (input === 'pdprd1') {
                insertAt(field, 1, dapilInput)
                insertAt(fieldText, 1, 'dapil')
            } else if (input === 'pdprd2') {
                insertAt(field, 2, dapilInput)
                insertAt(fieldText, 2, 'dapil')
            }


            let i = 2
            for (const input of field) {
                if (i <= 3) firstRow.append(input)
                else secondRow.append(input)
                i++
            }

            for (const f of field) {
                f.children[1].value = ''
                f.children[2].innerHTML = ''
            }

            for (let i = 0; i < field.length - 1; i++) {
                if (input === 'pdpr') {
                    if (i === 0) {
                        loading.classList.toggle('d-none')
                        const data = await fetching(getUrl(fieldText[i]))
                        const dapilDatalist = dapilInput.children[2]
                        dapilDatalist.innerHTML = ''
                        for (const dapil of data) {
                            const option = document.createElement('option')
                            option.value = dapil.dapil.trim()
                            option.dataset.id = dapil.id
                            dapilDatalist.appendChild(option)
                        }
                        loading.classList.toggle('d-none')
                        field[i].children[1].addEventListener('input', async function() {
                            removeValue(field, i + 1)
                            const id = getDataValue(field[i].children[2], this.value) || 0
                            if (id === 0) return
                            loading.classList.toggle('d-none')
                            const nextDatalist = field[i + 1].children[2]
                            const url = getUrlx(input, fieldText[i + 1])
                            const data = await fetching(url, id)
                            // const data = await fetching('/api_v2/kabupaten-kota?pdpr_dapil=', id)
                            nextDatalist.innerHTML = ''
                            for (const d of data) {
                                const option = document.createElement('option')
                                option.dataset.id = d.id
                                option.value = d.kabupaten_kota
                                nextDatalist.append(option)
                            }
                            loading.classList.toggle('d-none')
                        })
                    } else {
                        field[i].children[1].addEventListener('input', async function() {
                            removeValue(field, i + 1)
                            const url = getUrlx(input, fieldText[i + 1])
                            // const url = getUrl(fieldText[i + 1])
                            let list = this.nextSibling
                            let nextList = field[i + 1].children[2]
                            let value = getDataValue(list, this.value) || 0
                            console.log(value)
                            if (value === 0) return
                            loading.classList.toggle('d-none')

                            const data = await fetching(url, value)
                            for (const d of data) {
                                const option = document.createElement('option')
                                option.value = d[fieldText[i + 1]]
                                if (fieldText[i] === 'dapil') option.dataset.id = d[`id_${input}`]
                                else option.dataset.id = d.id
                                nextList.appendChild(option)
                            }
                            loading.classList.toggle('d-none')
                        })
                    }
                } else if (input === 'pdprd1') {
                    if (i === 0) {
                        loading.classList.toggle('d-none')
                        const provinsiList = document.querySelector('#provinsi-list')
                        const data = await fetching('/api/provinsi')
                        provinsiList.innerHTML = ''
                        for (const provinsi of data) {
                            const option = document.createElement('option')
                            option.value = provinsi.provinsi.trim()
                            option.dataset.id = provinsi.id
                            provinsiList.append(option)
                        }
                        loading.classList.toggle('d-none')
                        field[i].children[1].addEventListener('input', async function() {
                            removeValue(field, i + 1)
                            const nextDatalist = field[i + 1].children[2]
                            const url = getUrl(fieldText[i + 1])
                            const id = getDataValue(this.nextSibling, this.value) || 0
                            if (id === 0) return
                            loading.classList.toggle('d-none')
                            const data = await fetching(url, id)
                            for (const d of data) {
                                const option = document.createElement('option')
                                option.value = d.dapil
                                // option.dataset.id = d.id_pdprd1
                                option.dataset.id = d.id
                                nextDatalist.appendChild(option)
                            }
                            loading.classList.toggle('d-none')
                        })
                    } else {
                        field[i].children[1].addEventListener('input', async function() {
                            removeValue(field, i + 1)
                            // let url = ''
                            // if (i === 1) url = '/api_v2/kabupaten-kota?pdprd1_dapil='
                            // else url = getUrl(fieldText[i + 1])
                            const url = getUrlx(input, fieldText[i + 1])
                            let list = this.nextSibling
                            let nextList = field[i + 1].children[2]
                            let value = getDataValue(list, this.value) || 0
                            if (value === 0) return
                            // console.log(value)
                            loading.classList.toggle('d-none')
                            const data = await fetching(url, value)
                            nextList.innerHTML = ''
                            for (const d of data) {
                                const option = document.createElement('option')
                                option.value = d[fieldText[i + 1]]
                                option.dataset.id = d.id
                                nextList.appendChild(option)
                            }
                            loading.classList.toggle('d-none')
                        })
                    }
                } else if (input === 'pdprd2') {
                    if (i === 0) {
                        loading.classList.toggle('d-none')
                        const provinsiList = document.querySelector('#provinsi-list')
                        const data = await fetching('/api/provinsi')
                        provinsiList.innerHTML = ''
                        for (const provinsi of data) {
                            const option = document.createElement('option')
                            option.value = provinsi.provinsi.trim()
                            option.dataset.id = provinsi.id
                            provinsiList.append(option)
                        }
                        loading.classList.toggle('d-none')
                        field[i].children[1].addEventListener('input', async function() {
                            removeValue(field, i + 1)
                            const nextDatalist = field[i + 1].children[2]
                            const url = getUrlx(input, fieldText[i + 1])
                            const id = getDataValue(this.nextSibling, this.value) || 0
                            if (id === 0) return
                            loading.classList.toggle('d-none')
                            const data = await fetching(url, id)
                            for (const d of data) {
                                const option = document.createElement('option')
                                option.value = d[fieldText[i + 1]]
                                option.dataset.id = d.id
                                nextDatalist.appendChild(option)
                            }
                            loading.classList.toggle('d-none')
                        })
                    } else {
                        field[i].children[1].addEventListener('input', async function() {
                            removeValue(field, i + 1)
                            const url = getUrlx(input, fieldText[i + 1])
                            // const url = getUrl(fieldText[i + 1])
                            let list = this.nextSibling
                            let nextList = field[i + 1].children[2]
                            let value = getDataValue(list, this.value) || 0
                            if (value === 0) return
                            console.log(value)
                            loading.classList.toggle('d-none')
                            const data = await fetching(url, value)
                            nextList.innerHTML = ''
                            for (const d of data) {
                                const option = document.createElement('option')
                                option.value = d[fieldText[i + 1]]
                                if (fieldText[i + 1] === 'dapil') option.dataset.id = d.id
                                else option.dataset.id = d.id
                                nextList.appendChild(option)
                            }
                            loading.classList.toggle('d-none')
                        })
                    }
                }
            }
        })

        function createInput(inputName, inputText) {
            const row = document.createElement('div')
            row.classList.add('col')
            row.classList.add('added')

            const label = document.createElement('label')
            label.classList.add('form-label')
            label.textContent = inputText
            row.appendChild(label)

            const input = document.createElement('input')
            input.classList.add('form-control')
            input.setAttribute('for', inputName)
            input.setAttribute('id', inputName)
            input.setAttribute('name', inputName)
            input.setAttribute('type', 'search')
            input.setAttribute('list', inputName.split('_')[0] + '-list')
            row.appendChild(input)

            const datalist = document.createElement('datalist')
            datalist.setAttribute('id', inputName.split('_')[0] + '-list')
            row.appendChild(datalist)

            return row
        }

        async function getProvinsi() {
            const provinsiList = document.querySelector('#provinsi-list')
            const data = await fetching('/api/provinsi')
            provinsiList.innerHTML = ''
            for (const provinsi of data) {
                const option = document.createElement('option')
                option.value = provinsi.provinsi.trim()
                option.dataset.id = provinsi.id
                provinsiList.append(option)
            }
        }

        function getUrlx(jenis, field) {
            const url = {
                pdpr: {
                    kabupaten_kota: '/api/kabupaten-kota?pdpr_dapil=',
                    kecamatan: '/api/kecamatan?pdpr_dapil=',
                    kelurahan_desa: '/api/kelurahan-desa?pdpr_dapil='
                },
                pdprd1: {
                    dapil: '/api/dapil-pdprd1/',
                    kabupaten_kota: '/api/kabupaten-kota?pdprd1_dapil=',
                    kecamatan: '/api/kecamatan?pdprd1_dapil=',
                    kelurahan_desa: '/api/kelurahan-desa?pdprd1_dapil='
                },
                pdprd2: {
                    kabupaten_kota: '/api/kabupaten-kota?provinsi=',
                    dapil: '/api/dapil-pdprd2/',
                    kecamatan: '/api/kecamatan?pdprd2_dapil=',
                    kelurahan_desa: '/api/kelurahan-desa?pdprd2_dapil='
                }
            }

            return url[jenis][field]
        }

        function getUrl(location) {
            const url = {
                provinsi: '/api/provinsi',
                kabupaten_kota: '/api/kabupaten-kota?provinsi=',
                kecamatan: '/api/kecamatan?kabupaten_kota=',
                kelurahan_desa: '/api/kelurahan-desa?kecamatan='
            }


            if (location === 'dapil') {
                const dapil = {
                    pdpr: '/api/dapil-pdpr',
                    pdprd1: '/api/dapil-pdprd1/',
                    pdprd2: '/api/dapil-pdprd2/',
                }

                return dapil[input]
            }

            return url[location]
        }



        // const provinsiUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/provinces.json'
        // const kabupatenUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/regencies/'
        // const kecamatanUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/districts/'
        // const kelurahanUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/villages/'
        // // const provinsiUrl = 'http://dev.farizdotid.com/api/daerahindonesia/provinsi'
        // // const kabupatenUrl = 'http://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi='
        // // const kecamatanUrl = 'http://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota='
        // // const kelurahanUrl = 'http://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan='

        // const provinsiList = document.querySelector('#provinsi-list')
        // const kabupatenList = document.querySelector('#kabupaten-list')
        // const kecamatanList = document.querySelector('#kecamatan-list')
        // const kelurahanList = document.querySelector('#kelurahan-list')

        // const allInput = [kabupatenInput, kecamatanInput, kelurahanInput]

        // getProvinsi()

        // kecamatanInput.addEventListener('input', async function() {
        //     const id = getDataValue(kecamatanList, this.value) || 0
        //     removeValue(2)
        //     if (id === 0) return
        //     const data = await fetching(kelurahanUrl, id)
        //     kelurahanList.innerHTML = ''
        //     for (const kel of data) {
        //         const option = document.createElement('option')
        //         option.value = kel.name
        //         option.dataset.id = kel.id
        //         kelurahanList.append(option)
        //     }
        // })

        // kabupatenInput.addEventListener('input', async function() {
        //     const id = getDataValue(kabupatenList, this.value) || 0
        //     removeValue(1)
        //     if (id === 0) return
        //     const data = await fetching(kecamatanUrl, id)
        //     kecamatanList.innerHTML = ''
        //     for (const kec of data) {
        //         const option = document.createElement('option')
        //         option.value = kec.name
        //         option.dataset.id = kec.id
        //         kecamatanList.append(option)
        //     }
        // })

        // provinsiInput.addEventListener('input', async function() {
        //     const id = getDataValue(provinsiList, this.value) || 0
        //     removeValue(0)
        //     if (id === 0) return
        //     const data = await fetching(kabupatenUrl, id)
        //     kabupatenList.innerHTML = ''
        //     for (const kab of data) {
        //         const option = document.createElement('option')
        //         option.value = kab.name.split(' ')[0] === 'KABUPATEN' ? kab.name.split(' ').slice(1).join(' ') : kab.name
        //         option.dataset.id = kab.id
        //         kabupatenList.append(option)
        //     }
        // })

        // async function getProvinsi() {
        //     const data = await fetching(provinsiUrl)
        //     for (const provinsi of data) {
        //         const option = document.createElement('option')
        //         option.value = provinsi.name
        //         option.dataset.id = provinsi.id
        //         provinsiList.append(option)
        //     }
        // }


        const debounce = (callback, wait = 500) => {
            let timeoutId = null;
            return (...args) => {
                window.clearTimeout(timeoutId);
                timeoutId = window.setTimeout(() => {
                    callback.apply(null, args);
                }, wait)
            }
        }

        async function fetching(url, params = '', obj = {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        }) {
            // if (params !== '') params += '.json'
            const response = await fetch(url + params, obj)
            const data = await response.json()
            return data
        }

        function getDataValue(from, value) {
            return from.querySelector(`[value="${value}"]`)?.dataset.id
        }

        function removeValue(field, index) {
            // console.log('MAsuk')
            for (let i = index; i < field.length; i++) {
                field[i].children[1].value = ''
                field[i].children[2].innerHTML = ''
            }
        }

        function insertAt(array, index, ...elementsArray) {
            array.splice(index, 0, ...elementsArray);
        }

        async function fetchingDapil(jenis) {
            const response = await fetch('/dapil', {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    jenis_pemilihan: jenis
                })
            })
            const data = await response.json()
            return data
        }

        function sortTable(col, n, isNumber = true) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0
            table = document.querySelector('.table')
            switching = true
            console.log(col)
            if (localStorage.getItem('data-coloumn') == null) {
                const data = {}
                data[col] = 'desc'
                localStorage.setItem('data-coloumn', JSON.stringify(data))
                dir = 'desc'
            } else {
                const data = JSON.parse(localStorage.getItem('data-coloumn'))
                if (data[col] == null) {
                    data[col] = 'desc'
                    dir = 'desc'
                } else {
                    const result = data[col] === 'asc' ? 'desc' : 'asc'
                    data[col] = result
                    dir = result
                }
                localStorage.setItem('data-coloumn', JSON.stringify(data))
            }
            // console.log(localStorage.getItem('data-coloumn'))
            const coloumn = table.rows[0].querySelector(`[data-coloumn="${col}"]`)
            coloumn.dataset.sort = dir
            // console.log(table.rows[0].querySelector(`[data-coloumn="${col}"]`))  
            while (switching) {
                switching = false
                rows = table.rows
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false

                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];

                    if (dir == "asc") {
                        // console.log(x.textContent.toLowerCase(), y.textContent.toLowerCase())
                        if (isNumber) {
                            if (Number(x.dataset.value) > Number(y.dataset.value)) {
                                shouldSwitch = true;
                                break
                            }
                        } else {
                            if (x.textContent.toLowerCase() > y.textContent.toLowerCase()) {
                                shouldSwitch = true;
                                break
                            }
                        }
                    } else if (dir == "desc") {
                        // console.log(x.textContent.toLowerCase(), y.textContent.toLowerCase())
                        if (isNumber) {
                            if (Number(x.dataset.value) < Number(y.dataset.value)) {
                                shouldSwitch = true;
                                break
                            }
                        } else {
                            if (x.textContent.toLowerCase() < y.textContent.toLowerCase()) {
                                shouldSwitch = true;
                                break
                            }
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>

</html>