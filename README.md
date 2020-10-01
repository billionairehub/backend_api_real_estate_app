## Flow of data processing
```sh
Examples: /post/result?highest-price=true&district=Mo Cay&lowest-price=true&provincials=Ben Tre
```
### /post/result
```sh
parameters not Body and Header: highest-price, lowest-price, district, provincials, offset, limit
note: offset, limit may be empty
ps:  highest-price, lowest-price can only pass in one of two keywords at the same time
method: GET
```
### Thank you &#x1F49B;