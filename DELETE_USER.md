# Delete User
---
* **URL**

  `/users`

* **Method:**
  
  `DELETE`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

    ```json
    {
        "username": "username12",
        "password": "1234password"
    }
    ```

* **Success Response:**
 
  * **Code:** 202
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED
    * **Content:** `{ error : "Incorrect login" }`

* **Sample Call:**

    ```
    curl -X "DELETE" "http://api.example.com/users/1" \
    	-H "Content-Type: application/json; charset=utf-8" \
    	-H "Cache-Control: no-cache" \
    	-H "Authorization: Basic YWRtaW46MHJ0cjBuMWNz" \
    	-H "Accept: application/json" \
    	-d $'{
    	"username": "username1",
    	"password": "password1"
    	}'
    ```
