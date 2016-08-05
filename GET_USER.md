# Get User
----

* **URL**

  `/users/:id`

* **Method:**
  
  `GET`
  
* **Success Response:**

  * **Code:** 200
    * **Content:** 
        ```json
        {
            "username": "username1", 
            "email": "user1@email.com", 
            "mobile": "123-123-1234", 
            "birthday": "1970-01-02"
        }
        ```

* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
    * **Content:** `{ error : "Not logged in" }`

  * **Code:** 422 UNPROCESSABLE ENTRY
    * **Content:** `{ error : "Invalid user ID" }`

* **Sample Call:**

    ```
    curl -X "POST" "http://api.example.com/user/1" \
    	-H "Content-Type: application/json; charset=utf-8" \
    	-H "Cache-Control: no-cache" \
    	-H "Authorization: Basic YWRtaW46MHJ0cjBuMWNz" \
    	-H "Accept: application/json" \
    ```