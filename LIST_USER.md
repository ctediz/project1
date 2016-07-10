# List Users 

----

* **URL**

    `/users`

* **Method:**

    `GET`

*  **URL Params**

    **Optional:**
 
    `fields=[username, email, name]`
    
    `limit=[integer]`
    
    `sort=[asc|desc]`
    
    `sort_by=[id|name|birthdate|username|email]`
    
    `group_by=[name|username]`
  
* **Success Response:**
    * **Code:** 200
 
* **Error Response:**

    * **Code:** 401 UNAUTHORIZED

    * **Code:** 503 SERVICE UNAVAILABLE 
      * **Content:** `{ "error": "Unavailable storage" }`

* **Sample Call:**

    ```
    curl -X "GET" "http://api.example.com/users" \
    	-H "Content-Type: application/json; charset=utf-8" \
    	-H "Cache-Control: no-cache" \
    	-H "Authorization: Basic YWRtaW46MHJ0cjBuMWNz" \
    	-H "Accept: application/json"
    ```

* **Notes:**

    * The `sort` parameter defaults to `name`
    * The `sort_by` parameter defaults to `asc`
    * Response body:
        ```json
        {
    	    "count": 2,
    	    "users": [
    		    {"username00", "user0@user.com", "User Zero"},
    		    {"username01", "user1@user.com", "User One"}
    	    ]
        }
        ```
