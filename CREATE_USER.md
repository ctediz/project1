# Create User

----

* **URL**

    `/users`

* **Method:**

    `POST`
  
* **Data Params**

    ```json
    {
        "mobile": "123-123-1234",
        "name": "user's full name",
        "email": "user@user.com",
        "birthdate": "1970-01-02",
        "username": "username12",
        "password": "1234password"
    }
    ```

* **Success Response:**
    * **Code:** 201
 
* **Error Response:**

    * **Code:** 401 UNAUTHORIZED

    * **Code:** 422 UNPROCESSABLE ENTRY
      * **Content:** `{ "error": "Invalid email" }`

    * **Code:** 503 SERVICE UNAVAILABLE 
      * **Content:** `{ "error": "Unavailable storage" }`

* **Sample Call:**

    ```
    curl -X "POST" "http://api.example.com/users" \
    	-H "Content-Type: application/json; charset=utf-8" \
    	-H "Cache-Control: no-cache" \
    	-H "Authorization: Basic YWRtaW46MHJ0cjBuMWNz" \
    	-H "Accept: application/json" \
    	-d $'{
        "mobile": "123-123-1234",
        "name": "user's full name",
        "email": "user@user.com",
        "birthdate": "1970-01-02",
        "username": "username12",
        "password": "1234password"
    }'
    ```