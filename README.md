>.
Cервис, выдающий текущий курс валюты (USD)  и историю изменения курса через HTTP REST API, с доступом только для авторизованных пользователей.

upload list data
```
 php init.php 
```
upload everyday courses 
```
0 1 * * * php init_course.php >> /var/log/init_course.log
```

add user
```
php add_user.php test pas
```
sql dump - /var/sql/dump.sql

GET TOKEN
```
POST http://127.0.0.1/api/auth
Accept: */*
Cache-Control: no-cache
Content-Type: application/json

{"name":"test","pass":"pas"}
```

GET LIST currencies:
```
GET http://localhost/api/currencies
Accept: */*
Cache-Control: no-cache
Content-Type: application/json
Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLWFwaS5vcmciLCJuYW1lIjoidGVzdCIsImV4cCI6MTU2NTQyMjQ3Mn0.5vDV8rCoO-fwEX6PfrqsiEAN28gAc79YZZWWf1VcgLQ
```
RESPONSE:
```
 {
         "id": "1",
         "code": "BCHEUR"
     },
     {
         "id": "2",
         "code": "BCHEUR"
     },
     {
         "id": "3",
         "code": "BCHEUR"
    },
     {
         "id": "4",
         "code": "BCHEUR"
     },
...```
```

GET history currency id 1 (date from 2019.08.09 to 2019.08.10 -options, default 360 last day:
```
GET http://localhost/api/currency/1?d_from=2019.08.09&d_to=2019.08.10
Accept: */*
Cache-Control: no-cache
Content-Type: application/json
Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLWFwaS5vcmciLCJuYW1lIjoidGVzdCIsImV4cCI6MTU2NTQyMjQ3Mn0.5vDV8rCoO-fwEX6PfrqsiEAN28gAc79YZZWWf1VcgLQ
```

 
```
[
       {
           "course": "285.30",
           "date": "2019-08-10 13:03:11"
       },
       {
           "course": "283.80",
           "date": "2019-08-09 17:41:45"
       }
   ]
   ```