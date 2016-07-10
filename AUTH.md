# Auth

----

* **URL**

  `/auth`

* **Method:**

    `POST`

* **Data Params**

    ```json
    {
	    "username": "username1"
    }
    ```

* **Success Response:**
  
  * **Code:** 201
    * **Content:** `{"verification": "YWRtaW46MHJ0cjBuMWNz"}`
 
* **Error Response:**

  * **Code:** 422 UNPROCESSABLE ENTRY
    * **Content:** `{ error : "Invalid username" }`
	
  * **Code:** 503 SERVICE UNAVAILABLE
    * **Content:** `{ error : "Unavailable storage" }`

* **After Successful Response:**
```
	Every call to the API should contain the a header 'authorization' with your verification token.
```
	
	
* **Sample Call:**

    ```
    curl -X "POST" "http://api.example.com/auth" \
    	-H "Content-Type: application/json; charset=utf-8" \
    	-H "Cache-Control: no-cache" \
    	-H "Authorization: Basic YWRtaW46MHJ0cjBuMWNz" \
    	-H "Accept: application/json" \
    	-d $'{
    	"username": "username1",
    }'
    ```
