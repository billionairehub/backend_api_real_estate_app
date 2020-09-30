## Flow of data processing
```sh
/comment
/recomment
/add-comment
/update-comment
/delete-comment/{id}
```
### /comment
```sh
parameters passed: offset, limit
note: offset, limit may be empty
method: POST
```
### /recomment
```sh
parameters passed: offset, limit
note: offset, limit may be empty
method: POST
```
### /add-comment
```sh
parameters passed: post_id, comment_content, comment_id
note: comment_id my be empty if reply comment then required comment_id
method: POST
```
### /update-comment
```sh
parameters passed: post_id, id_comment
method: POST
```
### /delete-comment/{id}
```sh
parameters passed: 
method: POST
```

### Thank you &#x1F49B;