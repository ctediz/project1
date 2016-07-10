# Login
----

* **URL**

   `/login`

* **Method:**
  
  `POST`
  
* **Data Params**

    ```json
    {
    	"username": "username1",
    	"password": "password1"
    }  
    ```

* **Success Response:**
  
  * **Code:** 201	
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
    * **Content:** `{ error : "Incorrect login information" }`

  * **Code:** 503 SERVICE UNAVAILABLE 
	* **Content:** `{ error: "Unavailable storage" }`

* **Sample Call:**

    ```
    curl -X "POST" "http://api.example.com/login" \
    	-H "Content-Type: application/json; charset=utf-8" \
    	-H "Cache-Control: no-cache" \
    	-H "Authorization: Basic YWRtaW46MHJ0cjBuMWNz" \
    	-H "Accept: application/json" \
    	-d $'{
    	"username": "username1",
    	"password": "password1",
    	"verifcation": "verification-code"
    }'
    ```