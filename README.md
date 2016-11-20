# php-restful-framework
PHP RESTful based framework with requests and responses in JSON format.

---

### Examples
The following examples use headers for demonstration purposes. For real world examples look at **tests.php**.
Requests and responses are both JSON formatted.

###### OPTIONS
Check which verbs are allowed.
```
OPTIONS /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate

HTTP/1.1 200 OK
Date: Sun, 20 Nov 2016 03:58:12 GMT
Server: Apache/2.4.18 (Ubuntu)
Allow: GET,PUT,POST,DELETE,OPTIONS,HEAD
Content-Length: 0
Content-Type: application/json; charset=UTF-8
```

###### HEAD
This will perform the same action as GET but without any body content.
```
HEAD /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate

HTTP/1.1 200 OK
Date: Sun, 20 Nov 2016 03:58:12 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Type: application/json; charset=UTF-8
```

###### GET
Get the specified record(s).
```
GET /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate

HTTP/1.1 200 OK
Date: Sun, 20 Nov 2016 03:58:12 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Length: 1311
Content-Type: application/json; charset=UTF-8

{
    "status": "success",
    "code": 0,
    "message": "Retrieved example.",
    "results": {
        "files": [
            {
                "name": "Example-DHrN3I.txt",
                "type": "txt",
                "size": 117,
                "modified": 1479612648,
                "file": "New file content: mL3mV0ZB0NDCx83PNtzs7kM3TUQ82fSo0WLVXKxYxaA5iEU68uzfOljHfaQhpJGpFrlDcSBJ2cPlRKrZe0e2lyKBIAT7jzxZ1SD"
            },
            {
                "name": "Example-M5QG6C.txt",
                "type": "txt",
                "size": 44,
                "modified": 1479612627,
                "file": "New file content: mhmlBj6ljwuMUPClHq9PVySACg"
            },
            {
                "name": "Example-apktvG.txt",
                "type": "txt",
                "size": 103,
                "modified": 1479612648,
                "file": "New file content: SLUjxVDlBkboQ7Ehns0dELFeCjKWtmAm8uFFpj00Dbpti4LGxLUbwAp9Ta6nwGJEapjAIkBmv1PO6BuDnpOUZ"
            },
            {
                "name": "Example.txt",
                "type": "txt",
                "size": 116,
                "modified": 1479612648,
                "file": "Updated text: rN7ixzhMAwOV4zxN9qVt0st2k6g4keRL1Z4zyll8Ra4WJBKT2Fm27P4sVlxgzo2Bn6bWsx5jH9grL0kNGGQNvVgrgNIQbKrzRDwjaB"
            }
        ]
    }
}
```

###### PUT
Insert new record if it does not already exist, otherwise update existing record.

```
PUT /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate
Content-Length: 79
Content-Type: application/json; charset=UTF-8

HTTP/1.1 200 OK
Date: Sun, 20 Nov 2016 03:58:12 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Length: 101
Content-Type: application/json; charset=UTF-8

{
    "status": "success",
    "code": 0,
    "message": "Updated file.",
    "results": 1479612648
}
```

###### POST
Insert new record every time.

```
POST /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate
Content-Length: 126
Content-Type: application/json; charset=UTF-8

HTTP/1.1 200 OK
Date: Sun, 20 Nov 2016 03:58:12 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Length: 111
Content-Type: application/json; charset=UTF-8

{
    "status": "success",
    "code": 0,
    "message": "Created file.",
    "results": "Example-0ecmHC.txt"
}

```

###### DELETE
Delete the specified record.

```
DELETE /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate
Content-Length: 43
Content-Type: application/json; charset=UTF-8

HTTP/1.1 200 OK
Date: Sun, 20 Nov 2016 03:58:12 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Length: 95
Content-Type: application/json; charset=UTF-8

{
    "status": "success",
    "code": 0,
    "message": "Deleted file.",
    "results": true
}
```

---

### Response Codes
All responses will contain the appropriate HTTP code.

###### Success
If a method is successful a 200 OK response code will be returned.

```
OPTIONS /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate

HTTP/1.1 200 OK
Date: Sun, 20 Nov 2016 03:58:12 GMT
Server: Apache/2.4.18 (Ubuntu)
Allow: GET,PUT,POST,DELETE,OPTIONS,HEAD
Content-Length: 0
Content-Type: application/json; charset=UTF-8
```

###### Method not found
If a method is not found a 404 not found response code will be returned.

```
OPTIONS /api/examplenotfound HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate

HTTP/1.1 404 Not Found
Date: Sun, 20 Nov 2016 04:11:22 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Length: 121
Content-Type: application/json; charset=UTF-8

{
    "status": "error",
    "code": 1001,
    "message": "Unknown method. Expected {method}"
}
```

###### Verb not allowed
If a verb is not allowed a 403 forbidden response code will be returned.

```
PUT /api/example HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate
Content-Length: 113
Content-Type: application/json; charset=UTF-8

HTTP/1.1 403 Forbidden
Date: Sun, 20 Nov 2016 04:15:24 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Length: 95
Content-Type: application/json; charset=UTF-8

{
    "status": "error",
    "code": 1003,
    "message": "Request Method not allowed: {PUT}"
}
```

###### Authentication failed
If authentication fails a 401 unauthorized response code will be returned.

```
GET /api/exampletwo HTTP/1.1
Host: localhost
Accept: */*
Accept-Encoding: gzip, deflate
Authenticates: abc

HTTP/1.1 401 Unauthorized
Date: Sun, 20 Nov 2016 04:17:15 GMT
Server: Apache/2.4.18 (Ubuntu)
Content-Length: 130
Content-Type: application/json; charset=UTF-8

{
    "status": "error",
    "code": 1002,
    "message": "Missing parameters. Expected {authkey}"
}
```
