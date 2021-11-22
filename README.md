# Uniqie Project

## Cara pasang

1. buka terminal
2. `cd {directori}`
3. `git clone https://github.com/abunaum/uniqie.git`
4. `cd uniqie`
5. `php spark serve`
6. copy url localhost yang diberikan spark

## Konfigurasi

1. ubah nama file env jadi .env
2. edit

```
# app.baseURL = ''
```

    menjadi:

```
app.baseURL = '{url localhost yang diberikan spark}'
```

3. edit

```
    # database.default.hostname = localhost
    # database.default.database = ci4
    # database.default.username = root
    # database.default.password = root
    # database.default.DBDriver = MySQLi
    # database.default.DBPrefix =
```

    menjadi :

```
   database.default.hostname = localhost
   database.default.database = {namadb}
   database.default.username = {usernamedb}
   database.default.password = {passworddb}
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
```

4. buka terminal baru dan jalankan perintah

```
cd {directori}
php spark migrate
```

## Masih dalam tahap pengembangan
