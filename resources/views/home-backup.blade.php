<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-5">Pencarian Data</h1>

        <form action="/" method="GET">
            <div class="row">
                <div class="col">
                    <label for="jenis_pemilihan" class="form-label">Jenis Pemilihan</label>
                    <select type="text" class="form-control" id="jenis_pemilihan" name="jenis_pemilihan">
                        <option value="">Pilih Jenis Pemilihan</option>
                        <option value="pdpr">Pemilihan DPR RI</option>
                        <option value="pdprd1">Pemilihan DPRD Provinsi</option>
                        <option value="pdprd2">Pemilihan DPRD Kabupaten/Kota</option>
                    </select>
                </div>
                <div class="col">
                    <label for="dapil" class="form-label">Dapil</label>
                    <input type="text" class="form-control" id="dapil" name="dapil" value="">
                </div>
                <div class="col">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <input list="provinsi-list" type="text" class="form-control" id="provinsi" name="provinsi" value="">
                    <datalist id="provinsi-list"></datalist>
                </div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col">
                    <label for="kabupaten_kota" class="form-label">Kabupaten</label>
                    <input type="text" list="kabupaten-list" class="form-control" id="kabupaten_kota" name="kabupaten_kota" value="">
                    <datalist id="kabupaten-list"></datalist>
                </div>
                <div class="col">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <input type="text" class="form-control" list="kecamatan-list" id="kecamatan" name="kecamatan" value="">
                    <datalist id="kecamatan-list"></datalist>
                </div>
                <div class="col">
                    <label for="kelurahan_desa" class="form-label">Kelurahan / Desa</label>
                    <input type="text" class="form-control" id="kelurahan_desa" list="kelurahan-list" name="kelurahan_desa" value="">
                    <datalist id="kelurahan-list"></datalist>
                </div>
            </div>
            <button type="submit" name="action" class="btn btn-primary h-20">Search</button>
            <button type="submit" name="action" target="_blank" class="btn btn-success w-full">
                Convert To Excel</button>
            <a href="/" class="btn btn-danger h-20">Reset</a>
        </form>
        <div class="mt-2">
            <span>Jumlah Data : 0</span>
        </div>

        <div class="table-responsive my-4">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th scope="col" class="align-middle">#</th>
                        <th scope="col" class="align-middle" style="min-width: 300px;">Nama Calon</th>

                        @for ($i = 1; $i <= $length; $i++)
                        <th scope="col" class="align-middle" style="min-width: 30px;">TPS {{ $i}}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($allUser as $user)
                    <tr class="text-center">
                        <td scope="col" class="align-middle">{{$loop->iteration}}</td>
                        <td scope="col" class="align-middle">{{$user['nama']}}</td>
                        @for ($i = 1; $i <= $length; $i++)
                            <td scope="col" class="align-middle">{{$user[$i]}}</td>
                        @endfor
                    </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

    <script defer>


        const provinsiUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/provinces.json'
        const kabupatenUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/regencies/'
        const kecamatanUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/districts/'
        const kelurahanUrl = 'http://www.emsifa.com/api-wilayah-indonesia/api/villages/'
        // const provinsiUrl = 'http://dev.farizdotid.com/api/daerahindonesia/provinsi'
        // const kabupatenUrl = 'http://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi='
        // const kecamatanUrl = 'http://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota='
        // const kelurahanUrl = 'http://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan='

        const provinsiList = document.querySelector('#provinsi-list')
        const kabupatenList = document.querySelector('#kabupaten-list')
        const kecamatanList = document.querySelector('#kecamatan-list')
        const kelurahanList = document.querySelector('#kelurahan-list')

        const allInput = [kabupatenInput, kecamatanInput, kelurahanInput]

        getProvinsi()

        kecamatanInput.addEventListener('input', async function() {
            const id = getDataValue(kecamatanList, this.value) || 0
            removeValue(2)
            if (id === 0) return
            const data = await fetching(kelurahanUrl, id)
            kelurahanList.innerHTML = ''
            for (const kel of data) {
                const option = document.createElement('option')
                option.value = kel.name
                option.dataset.id = kel.id
                kelurahanList.append(option)
            }
        })

        kabupatenInput.addEventListener('input', async function() {
            const id = getDataValue(kabupatenList, this.value) || 0
            removeValue(1)
            if (id === 0) return
            const data = await fetching(kecamatanUrl, id)
            kecamatanList.innerHTML = ''
            for (const kec of data) {
                const option = document.createElement('option')
                option.value = kec.name
                option.dataset.id = kec.id
                kecamatanList.append(option)
            }
        })

        provinsiInput.addEventListener('input', async function() {
            const id = getDataValue(provinsiList, this.value) || 0
            removeValue(0)
            if (id === 0) return
            const data = await fetching(kabupatenUrl, id)
            kabupatenList.innerHTML = ''
            for (const kab of data) {
                const option = document.createElement('option')
                option.value = kab.name.split(' ')[0] === 'KABUPATEN' ? kab.name.split(' ').slice(1).join(' ') : kab.name
                option.dataset.id = kab.id
                kabupatenList.append(option)
            }
        })

        async function getProvinsi() {
            const data = await fetching(provinsiUrl)
            for (const provinsi of data) {
                const option = document.createElement('option')
                option.value = provinsi.name
                option.dataset.id = provinsi.id
                provinsiList.append(option)
            }
        }

        async function fetching(url, params = '') {
            if (params !== '') params += '.json'
            const response = await fetch(url + params)
            const data = await response.json()
            return data
        }

        function getDataValue(from, value) {
            return from.querySelector(`[value="${value}"]`)?.dataset.id
        }

        function removeValue(index) {
            for (let i = index; i < allInput.length; i++) {
                allInput[i].value = ''
            }
        }
    </script>
</body>

</html>