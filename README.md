## Flow of data processing
```sh
/post 
/post/{id}
/create-post
/update-post/{id}
/delete-post/{id}
```
### /post
```sh
parameters passed: offset, limit
note: offset, limit may be empty
ps: Get a list post
method: POST
```
### /post/{id}
```sh
parameters passed:
ps: Get a post follow id
method: GET
```
### /create-post
```sh
parameters passed: post_content, post_image, post_status, post_comment_status
note: post_status, post_comment_status may be empty
method: POST
```
### /update-post/{id}
```sh
parameters passed: post_content, post_image, post_status, post_comment_status
note: post_status, post_comment_status may be empty
method: POST
```
### /delete-post/{id}
```sh
parameters passed:
method: POST
```

### Thank you &#x1F49B;